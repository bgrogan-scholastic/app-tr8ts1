##############################################
# Author: Todd A. Reisel
# Date: 10/29/2003
# Class: GI_Product
# Purpose: encapsulate the list functionality
#   of python
##############################################

#import the gi_list for storing a list of assets
from common.utils.GI_List import *;
from common.utils.GI_XPath import *;
from GI_Asset import GI_Asset;
from GI_AssetFile import GI_AssetFile;

class GI_Product:
	def __init__(self, name):
		self.__listOfAssets = GI_List();
		self.__listOfEnvironments = GI_List();

		self.__productName = name;
		self.__productDescription = '';
		
		self._xmlData = GI_XPath("/data/loadtools/config/assetvalidation/" + self.__productName + ".xml");

		self.__loadEnvironments();	
		self.__loadAssets();

	def getName(self):
		return self.__productName;

	def getDescription(self):
		return self.__productDescription;
	
	def getAssets(self):
		return self.__listOfAssets.getAllSorted();

	def getEnvironments(self):
		return self.__listOfEnvironments.getAllSorted();

	def getAsset(self, key):
		return self.__listOfAssets.get(key);

	def __loadEnvironments(self):
		xmlQuery = '/assetvalidation/product[@name="' + self.__productName + '"]/urls/*';
		xmlResults = self._xmlData.query(xmlQuery);

		for x in xmlResults:
			self.__listOfEnvironments.insert(x.getAttribute('location'), x.getAttribute('location'));
	
	def __loadAssets(self):
		#get all of the assets for this product
		xmlQuery = '/assetvalidation/product[@name="' + self.__productName + '"]/assets/*';
		xmlResults = self._xmlData.query(xmlQuery);

		#loop through each asset found in xml
		for x in xmlResults:
			assetObject = GI_Asset(x.getAttribute('name'));
			assetObject.setDescription(x.getAttribute('description'));
			assetObject.setTableName(x.getAttribute('tablename'));
			assetObject.setSelectFields(x.getAttribute('selectfields'));
			assetObject.setConditional(x.getAttribute('conditional'));
			
			#load the assets files matching patterns/hashes.
			xmlFileQuery = '/assetvalidation/product[@name="' + self.__productName + '"]/assets/asset[@name="' + assetObject.getName() + '"]/files/*';
			xmlFileResults = self._xmlData.query(xmlFileQuery);

			myList = [];
			#loop through the file matches to check for
			for y in xmlFileResults:
				assetFileObject = GI_AssetFile();
				assetFileObject.setDir(y.getAttribute("dir"));
				assetFileObject.setHashing(y.getAttribute("hashing"));
				assetFileObject.setFileName(y.getAttribute("filename"));
				
				myList.append(assetFileObject);

			#give the asset object a list of patterns/files to look for
			assetObject.setFileList(myList);
			
			#add this asset object into the list
			self.__listOfAssets.insert(x.getAttribute('name'), assetObject);

if __name__ == "__main__":
	g = GI_Product('nbk3');
	print g.getName();
	print g.getDescription();
	
	for x in g.getAssets():
		print "\n------My Asset : " + x.getName() + "---------------------------------------------------";
		for x in x.getFileList():
			print "\tFile (dir): " + x.getDir() + "   , (hashing): " + x.getHashing() + "    , (filename): " + x.getFileName();
	
	print "\n-----------------------------------My Environments----------------------------------"
	for x in g.getEnvironments():
		print x;
	print "\n------------------------------------------------------------------------------------"
