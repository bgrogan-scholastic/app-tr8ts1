##############################################
# Author: Todd A. Reisel
# Date: 10/29/2003
# Class: GI_Asset
# Purpose: encapsulate a product's asset
##############################################

from common.utils.GI_List import *;

class GI_Asset:
	def __init__(self, name):
		self.__assetName = name;
		self.__tablename = '';
		self.__description = '';
		self.__selectFields = '';
		self.__conditional = '';

		#a list of files to check for
		self.__assetFileList = [];

	def getFileList(self):
		return self.__assetFileList;
	
	def getName(self):
		return self.__assetName;

	def getTableName(self):
		return self.__tablename;

	def getDescription(self):
		return self.__description;

	def getSelectFields(self):
		return self.__selectFields;

	def getConditional(self):
		return self.__conditional;

	def setFileList(self, list):
		self.__assetFileList = list;
		
	def setName(self, name):
		self.__assetName = name;

	def setTableName(self, tname):
		self.__tablename = tname;

	def setDescription(self, description):
		self.__description = description;

	def setSelectFields(self, selectfields):
		self.__selectFields = selectfields;

	def setConditional(self, conditional):
		self.__conditional = conditional;

if __name__ == "__main__":
	g = GI_Asset('articles');
	print g.getName();
	g.setName('biblios');
	print g.getName();


