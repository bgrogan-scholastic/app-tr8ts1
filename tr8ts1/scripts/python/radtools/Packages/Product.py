
#file Product.py

import sys
sys.path.append("/home/qadevWS/radtools/python")

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
        def __init__(self,window,pcode):
		self._window = window
		self.__pcode = pcode
                self.__searchAndReplace = SearchAndReplace("##[A-Z_]*##", self.__handleTag)
		#self.__xmlData = XPath("/data/rad/supertemplates/xml/productsetup.xml")
		self.__xmlData = XPath("/data/rad/supertemplates/xml/productsetup.xml")
		self._log = Log.instance()
		FileLog.instance(os.path.join("/data/rad/logs","radapp-" + self.__pcode + ".log"))

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
				password = self._window.getPassword(hostname, username)
				print "Password: " + password
#			        password = self._transformPath(str(x.getAttribute("password")))
			        self._ftpFile(fromFile,toFile,hostname,username,password)
			elif type == "Telnet":
				hostname = self._transformPath(str(x.getAttribute("hostname")))
				username = self._transformPath(str(x.getAttribute("username")))
				password = self._window.getPassword(hostname, username)
				print "Password: " + password
#			        password = self._transformPath(str(x.getAttribute("password")))
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
			returnValue = None;
			#loop through the commands.
			for cmd in self.__xmlData.query(myXMLPath+"*"):
				mymessage = self._transformPath(str(cmd.getAttribute("message")))
				print mymessage;
				instruction = self._transformPath(str(cmd.getAttribute("instruction")))

				if instruction == "su -":
					newpassword = self._window.getPassword(hostname)
					returnValue = str(myTelnetClient.suroot(newpassword))
					if returnValue == "":
						continue
					else:
						err = "ERROR Occurred connecting to " + hostname + " Unable to Continue"
						print err
						break
					#self._log.add(err)
				else:
					until = str(cmd.getAttribute("wait"))
					if until != "":
						returnValue = str(myTelnetClient.commandUntil(instruction,until))
					else:
						returnValue = str(myTelnetClient.command(instruction))

					if returnValue != "['$ ']":
						print self._transformPath(str(cmd.getAttribute("errmessage")))
						if self._transformPath(str(cmd.getAttribute("onerror"))) == "stop":
							break

					print returnValue
					#self._log.add(str(returnValue))

		except Exception:
			Log.instance().add("Telnet to "+hostname+" failed",
					   Log.instance().bitMaskCriticalAll())
		myTelnetClient.close()
		pass

	def __handleTag(self,tagname):
		#tagText = tagname.replace("##", "")
		tagText = tagname
		if tagText == "##PCODE##":
		    return self.__pcode
		elif tagText == "##UPPERPCODE##":
		    return self.__pcode.upper();
		elif tagText == "##PORT##":
		    return DataCloud.instance().value("portnumber")
		elif tagText == "##PTITLE##":
		    return DataCloud.instance().value("ptitle")
		elif tagText == "##TITLE##":
		    return DataCloud.instance().value("ptitle")
		elif tagText == "##SERVERNAME##":
		    return self.__pcode + ".grolier.com";
		elif tagText == "##IP##":
		    return ''
		elif tagText == "##PAUTH##":
		    return DataCloud.instance().value("pauth")
		elif tagText == "##DBA##":
		    return DataCloud.instance().value("dba")
		elif tagText == "##ALTPRODUCT##":
		    return "stress1"
		elif tagText == "##ALT_ADA_PRODUCT##":
		    return "stress1-ada"
		elif tagText == "##PRODUCT_SERVER##":
		    return "stress1.grolier.com:" + DataCloud.instance().value("portnumber")
		elif tagText == "##PRODUCT_ADA_SERVER##":
		    return "stress1-ada.grolier.com" + DataCloud.instance().value("portnumber")
		elif tagText == "##GO_SERVER##":
		    return "qadev.grolier.com:2004"
		
	def _transformPath(self, path):
		#transform any ##tag## to their value equivalents
		self.__searchAndReplace.setContents(path);
		return self.__searchAndReplace.getContents();


def main():
	DataCloud.instance().add("pcode","eastest")
        p = Product(None, DataCloud.instance().value("pcode"))

	# Delete an existing product
#	p.processSteps("/productremove")

	# Add a new product
	p.processSteps("/productsetup")


# should we run the test harness?
if __name__ == "__main__":
	main()




