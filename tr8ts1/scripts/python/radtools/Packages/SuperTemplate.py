##########################################################################################################################################################
# Class: SuperTemplate
# Author: Todd A. Reisel
# Date: 2/19/2003
# Purpose: Encompass the reading and writing of supertemplate files
# Base Class implementations:
#            string __handleReplace(self, tagName) - this function will transform basic ##tag## in the input or output paths with their tag value
#            string getContents(self) - return the contents of the file.
#            int setContents(self, string) - set the SuperTemplate's internal contents to the new contents
#            int write() - using the _getOutputFilePath virtual function open up the file and write the internal contents to this file.
#            string _transFormPath(self, path) - given the path in question, transform it for pcode tags, etc.
#            string _getInputFilePath(self) - returns the file path that should be used to retrieve the file's contents - dervied class implements.
#            string _getOutputFilePath(self) - returns the file path that should be used to write the file with the internal contents - derived class implements.
##########################################################################################################################################################

from BaseClasses.fileutils import FileIOString;
from BaseClasses.searchandreplace import *;
import DataCloud;

class SuperTemplate:
	def __init__(self, fileName, args = []):
		self._sFileName = fileName;
		self.__searchandreplace = SearchAndReplace("##[A-Za-z0-9]*##", self.__handleReplace);
		self.__args = args;   #args is a python list which can be used to pass along anything to the dervied class to use.
		
	def __handleReplace(self, tagName):
		if tagName == "##pcode##" or tagName == "##PCODE##":
			return DataCloud.instance().value("pcode");
		else:
			#didn't find the value , so return nothing
			return "";

	def getContents(self):
		#open up the file using the inputfilepath function and then performing substitutions for pcode, etc.
		try:
			filePath = self._transFormPath(self._getInputFilePath());

			#use only for debugging
			#Log.instance().add("App SuperTemplate: Opening file: " + filePath);
			
			self._sContents = FileIOString(filePath).getString();
			return self._sContents;
		except IOError, message:
			print message;
			return "";
		
	def setContents(self, contents):
		self._sContents = contents;
		return 1;

	def write(self):
		#write the file.
		myFile = FileIOString();
		myFile.setString(self._sContents);
		myFile.write(self._transFormPath(self._getOutputFilePath()));
		
		return 1;

	def _transFormPath(self, path):
		#transform any ##tag## to their value equivalents
		self.__searchandreplace.setContents(path);
		return self.__searchandreplace.getContents();

	#do not implement these in this BaseClass..
	def _getInputFilePath(self):
		pass

	def _getOutputFilePath(self):
		pass

