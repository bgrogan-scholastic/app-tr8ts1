
#file Product.py

import sys
sys.path.append("/home/qadevWS/python/radtools")

import os
from BaseClasses.fileutils import *
from BaseClasses.searchandreplace import *
from BaseClasses.xpath import *
import DataCloud
import Log
import FileLog

#------------------------------------------------------
# Name:        Product
# Author:      Diane Langlois
# Date:        2-07-2003
# Description: This class is responsible for setting
# up a new product.  Delivery directories, product
# directories, web server, tablespaces & tables, and
# anything else needed for the initial setup of a new
# product are created.
#------------------------------------------------------
class Product:
        def __init__(self,pcode):
		self.__pcode = pcode
                self.__searchAndReplace = SearchAndReplace("\#\#PCODE\#\#", self._pcode)
		#self.__xmlData = XPath("/data/rad/supertemplates/xml/productsetup.xml")
		self.__xmlData = XPath("/data/rad/supertemplates/xml/testsetup.xml")
		self._log = Log.instance()

        #------------------------------------------------------
        # All of these action functions really do the same thing.
        # I'm just providing an interface that indicates what's
        # happening behind the scenes.  Such as "create" a
        # product, "remove" a product and so on.
        #------------------------------------------------------
	def processSteps(self,xmlDirectory):
		self._fullXMLPath = "/product" + xmlDirectory + "/steps/"
		print self._fullXMLPath
		for x in self.__xmlData.query(self._fullXMLPath+"*"):
			#get type
			type = str(x.getAttribute("type"))
			print "type: " + type
			#get accompanying message
			message = self._transformPath(str(x.getAttribute("message")))
			if (message != None) and (message != ""):
				self._log.add(message)
			#process each record based on its type
			if type == "ReplaceCommand":
				#get text, and replaceAndIssueCommand
				self._replaceAndIssueCommand(str(x.getAttribute("command")))
			elif type == "ReplaceSave":
				#read, replace and save file
				outfilepath = self._transformPath(str(x.getAttribute("output")))
				self._replaceAndSave(str(x.getAttribute("input")),outfilepath)
   			elif type == "CommandFile":
				#get filename and execute contents
				infilepath = self._transformPath(str(x.getAttribute("filepath")))
				self._issueCommandFromFile(infilepath)
			elif type == "FTP":
		        	#get all necessary information to perform the ftp command
		        	fromFile = self._transformPath(str(x.getAttribute("input")))
		        	toFile = self._transformPath(str(x.getAttribute("output")))
		        	hostname = self._transformPath(str(x.getAttribute("hostname")))
		       		username = self._transformPath(str(x.getAttribute("username")))
			        password = self._transformPath(str(x.getAttribute("password")))
			        self._ftpFile(fromFile,toFile,hostname,username,password)
			elif type == "Telnet":
				hostname = self._transformPath(str(x.getAttribute("hostname")))
				username = self._transformPath(str(x.getAttribute("username")))
			        password = self._transformPath(str(x.getAttribute("password")))
				self._telnet(hostname,username,password,x)
			        pass

        #------------------------------------------------------
        # This function simply reads a file as a list and
        # executes each line as a shell command the os can
        # process.
        #------------------------------------------------------
        def _replaceAndIssueCommand(self,command):
		self.__searchAndReplace.setContents(command)
                os.system(self.__searchAndReplace.getContents())
	def _replaceAndSave(self,filetoreplace,newfilename):
		f = FileIOString(filetoreplace)
		self.__searchAndReplace.setContents(f.getString())
		newcontents = self.__searchAndReplace.getContents()
		f.setString(newcontents)
		#create new file
		print "creating file: " + newfilename
		f.write(newfilename)
	def _issueCommandFromFile(self,commandFile):
                f = FileIOList(commandFile)
                self._setupCommands = f.getList()
                for line in self._setupCommands:
                        os.system(line)
	def _ftpFile(self,fromFile,toFile,hostname,username,password):
        	###ftp the plweb scripts to QADEV.
	        #get functionality from the releasetool.
	        import sys
	        sys.path.append("/home/qadevWS/releasetool/")
	        import utilities
	        import ftplib

	        try:
	            #store this username and password in non resident memory.
	            myFtpClient = utilities.giFtp(hostname, username, password)
		    mymessage = str(myFtpClient.binary_put(fromFile, toFile))
		    if mymessage.find("226") > -1:
			    self._log.add("Transfer complete")
		    else:
			    self._log.add(str(mymessage))
	            myFtpClient.close()
	        except ftplib.error_perm, message:
	            Log.instance().add("The Ftp to qadev failed for source file: " + fromFile + " going to destination " + toFile, Log.instance().bitMaskCriticalAll())
	        pass
	def _telnet(self,hostname,username,password,step):
		import sys;
		sys.path.append("/home/qadevWS/releasetool/")
		import utilities
		import telnetlib
		myXMLPath = self._fullXMLPath + '/step[@key="'+str(step.getAttribute("key"))+'"]/commands/'
		myTelnetClient = None

		try:
			myTelnetClient = utilities.giTelnet(hostname,username,password)
			returnValue = None
			#loop through the commands.
			for cmd in self.__xmlData.query(myXMLPath+"*"):
				mymessage = self._transformPath(str(cmd.getAttribute("message")))
				if (mymessage != None) and (message != ""):
					self._log.add(mymessage)
				instruction = self._transformPath(str(cmd.getAttribute("instruction")))
				if instruction == "su -":
					newpassword = str(cmd.getAttribute("password"))
					returnValue = myTelnetClient.suroot(newpassword)
					print returnValue
					self._log.add(str(returnValue))
				else:
					returnValue = myTelnetClient.command(instruction,3)
					print returnValue
					self._log.add(str(returnValue))

		except Exception:
			Log.instance().add("Telnet to "+hostname+" failed",
					   Log.instance().bitMaskCriticalAll())
		myTelnetClient.close()
		pass
	def _pcode(self,tagname):
		return self.__pcode
	def _transformPath(self, path):
		#transform any ##tag## to their value equivalents
		self.__searchAndReplace.setContents(path);
		return self.__searchAndReplace.getContents();


def main():
	DataCloud.instance().add("pcode","eastest")
        p = Product(DataCloud.instance().value("pcode"))

	# Delete an existing product
#	p.processSteps("/productremove")

	# Add a new product
	p.processSteps("/productsetup")


# should we run the test harness?
if __name__ == "__main__":
	main()




