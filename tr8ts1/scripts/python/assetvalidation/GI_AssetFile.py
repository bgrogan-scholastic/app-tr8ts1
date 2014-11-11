##############################################
# Author: Todd A. Reisel
# Date: 10/29/2003
# Class: GI_AssetFile
# Purpose: encapsulate an asset's files
##############################################

from common.utils.GI_List import *;

class GI_AssetFile:
	def __init__(self):
		self.__dir = '';
		self.__hashing = '';
		self.__filename = '';

	def setDir(self, dir):
		self.__dir = dir;

	def setHashing(self, hashing):
		self.__hashing = hashing;

	def setFileName(self, filename):
		self.__filename = filename;
	
	def getDir(self):
		return self.__dir;

	def getHashing(self):
		return self.__hashing;

	def getFileName(self):
		return self.__filename;
	
if __name__ == "__main__":
	g = GI_AssetFile();
	print g.getName();
	g.setName('biblios');
	print g.getName();


