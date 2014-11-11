#file fileutils.py

import os
import copy
import distutils.file_util
#------------------------------------------------------
# Name:        FileInstructions
# Author:      Diane Langlois
# Date:        1-29-2003
# Description: This class saves file copy instructions
# and then performs the copy when explicitly asked to.  
#------------------------------------------------------
class FileInstructions(object):
	"""This is the FileInstructions object which provides access to 
	directories in the system.
	"""
	def __init__(self):
		self.copies = []
		pass
		
	#--------------------------------------------------
	# Name:        add
	# Description: This method adds a copy instruction 
	# to the member list
	# Returns:     none
	# Parameters:  string copyfrom filepath, string
	# copyto filepath
	#--------------------------------------------------
	def add(self, copyfrom, copyto):
		instruction = []
		instruction.append(copyfrom)
		instruction.append(copyto)
		self.copies.append(instruction)
	#--------------------------------------------------
	# Name:        copy
	# Description: This method executes all copy instructions
	# found in the member list "copies"
	# Returns:     none
	# Parameters:  string copyfrom filepath, string
	# copyto filepath
	#--------------------------------------------------
	def copy(self):
		for eachinstruction in self.copies:
			print "copying from " + eachinstruction[0] + " to " + eachinstruction[1]
			distutils.file_util.copy_file(eachinstruction[0],eachinstruction[1])
		print "Successful"

#------------------------------------------------------
# Name:        FileIOString
# Author:      Doug Farrell
# Date:        1-29-2003
# Description: This class encapsulates file IO utilities
#------------------------------------------------------
class FileIOString(object):
	"""This object provides an interface to a file and provides that file
	as a string to the user. This allows the user program to mess with
	the file as a string, oblivious to the file nature
	"""
	def __init__(self, filepath = ""):
		self.__filepath = filepath
		self.__buffer   = ""

		if len(self.__filepath) != 0:
			f = open(self.__filepath, 'r')
			self.__buffer = f.read()
			f.close()

	def getString(self):
		return self.__buffer

	def setListAsString(self, mylist=[]):
		self.__buffer = "";
		for line in mylist:
			self.__buffer += copy.deepcopy(str(line));
			self.__buffer += "\n";
		return self.__buffer;

	def setString(self, string = ""):
		self.__buffer = copy.deepcopy(string)
		return self.__buffer

	def read(self, filepath = ""):
		# test the paramter
		if len(filepath) != 0:
			self.__filepath = filepath

		# do we have a valid filepath
		if len(self.__filepath) != 0:
			f = open(self.__filepath, "r")
			self.__buffer = f.read()
			f.close()
		else:
			# throw exception here
			pass

	def write(self, filepath = ""):
		# test the paramter
		if len(filepath) != 0:
			self.__filepath = filepath

		# do we have a valid filepath
		if len(self.__filepath) != 0:
			f = open(self.__filepath, "w")
			f.write(self.__buffer)
			f.close()
		else:
			# throw exception here
			pass


#------------------------------------------------------
# Name:        FileIOList
# Author:      Doug Farrell
# Date:        1-29-2003
# Description: This class encapsulates file IO utilities
# however the file is read and manuipulated as a list
# instead of a string.
#------------------------------------------------------
class FileIOList(object):
	"""This object provides an interface to a file and provides that file
	as a Python list to the user. This allows the user program to mess with
	the file as a list, oblivious to the file nature
	"""
	def __init__(self, filepath = ""):
		self.__filepath = filepath
		self.__list   = []

		if len(self.__filepath) != 0:
			f = open(self.__filepath, 'r')
			self.__list = f.readlines()
			f.close()

	def getList(self):
		return self.__list

	def setList(self, list):
		self.__list = copy.deepcopy(list)
		return self.__list

	def read(self, filepath = ""):
		# test the paramter
		if len(filepath) != 0:
			self.__filepath = filepath

			# do we have a valid filepath
			if len(self.__filepath) != 0:
				f = open(filepath, "w")
				self.__list = f.readlines()
				f.close()
			else:
				# throw exception here
				pass

	def write(self, filepath = ""):
		# test the paramter
		if len(filepath) != 0:
			self.__filepath = filepath

			# do we have a valid filepath
			if len(self.__filepath) != 0:
				f = open(filepath, "w")
				f.writelines(self.__list)
				f.close()
			else:
				# throw exception here
				pass


#------------------------------------------
#Testing 1, 2, 3
#------------------------------------------
# this is the main() function called by the test harness code
def main():
	try:
		print "** test FileInstructions() **"
		fi = FileInstructions()
		print "Adding two copy Instructions"
		fi.add("./fileutils.py","./fileutils.py.new")
		fi.add("./directory.py","./directory.py.new")
		fi.copy()

		print "** test FileIOString() **"
		myFile = FileIOString()
		print "I'm now deleting the two new files.  If they did not exist, you would get an lstat error"
		os.remove("./fileutils.py.new")
		os.remove("./directory.py.new")

		text = """This is some text I want to write to a file
so get it in there will you!
Don't make me come over there!
	"""
		myFile.setString(text)
		myFile.write("./temp.txt")

		newFile = FileIOString("./temp.txt")
		print newFile.getString()

		print "** test FileIOList() **"
		myList = FileIOList("./temp.txt")
		for row in myList.getList():
			print row

			os.remove("./temp.txt")
	except IOError, message:
		print "caught file IOError"
		print message
			
	except:
		print "caught some unknown error"

# should we run the test harness?
if __name__ == "__main__":
	main()
