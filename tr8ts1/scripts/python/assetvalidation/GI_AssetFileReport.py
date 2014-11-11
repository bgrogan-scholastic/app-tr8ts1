##############################################
# Author: Todd A. Reisel
# Date: 10/29/2003
# Class: GI_AssetFileReport
# Extends: GI_Report
# Purpose: get statistics for an asset and
#    its supplemental files
###############################################

from GI_Report import *;
from common.utils.GI_GetAuids import GI_GetAuids;
from common.utils.GI_Environment import GI_Environment;

import urllib;
import httplib;

class GI_AssetFileReport(GI_Report):
	def __init__(self, assetObject, envID = None):
		if envID == None:
			self.__environmentID = GI_Environment().variable('environmentid');
		else:
			self.__environmentID = envID;

		self.__iAssetCount = 0;
		self.__iMissingFileCount = 0;
		self.__iZeroByteFileCount = 0;
		self.__assetObject = assetObject;
	
		#get the auids from authentication. we will need this to access the assetvalidation
		# 	client application on the product server
		self.__auids = GI_GetAuids().getAuids();

		#report contents
		self.__reportContents = "";
		
		#get the report statistics.
		self.__getReportContents();
		self._buildStatistics();

	def _buildStatistics(self):
		startpos = self.__reportContents.find("Assets Scanned:");
		endpos = self.__reportContents.find("\n", startpos);

		assetsScanned = self.__reportContents[startpos+16:endpos];
		self.__iAssetCount = assetsScanned;

		startpos = self.__reportContents.find("# of Missing");
		endpos = self.__reportContents.find("\n", startpos);

		missingFilesCount = 0;
		while startpos != -1:
			missingFilesCount += int( (self.__reportContents[startpos+20:endpos]).strip() );
			startpos = self.__reportContents.find("# of Missing", endpos + 1);
			endpos = self.__reportContents.find("\n", startpos);
			
			self.__iMissingFileCount = missingFilesCount;


		while startpos != -1:			
			startpos = self.__reportContents.find("# of Zero");
			endpos = self.__reportContents.find("\n", startpos);
			zeroByteFileCount = 0;
			while startpos != -1:
				zeroByteFileCount += int( (self.__reportContents[startpos+21:endpos]).strip() );
				startpos = self.__reportContents.find("# of Zero", endpos + 1);
				endpos = self.__reportContents.find("\n", startpos);
				
				self.__iZeroByteFileCount = zeroByteFileCount;
			
	def getReport(self):
		return self.__reportContents;

	def getAssetCount(self):
		return self.__iAssetCount;
	
	def getMissingFileCount(self):
		return self.__iMissingFileCount;
	
	def getZeroByteFileCount(self):
		return self.__iZeroByteFileCount;



	def __getReportContents(self):
		assetFileList = self.__assetObject.getFileList();
		
		if assetFileList == []:
			print "No Files have been setup for validation";
		else:
			myUrl = "";
			
			myParams = {};
			
			for x in range(0, len(assetFileList)):
				myParams["path" + str(x+1)] = assetFileList[x].getDir();
				myParams["hashing" + str(x+1)] = assetFileList[x].getHashing();
				myParams["filename" + str(x+1)] = assetFileList[x].getFileName();
				myParams["tablename" + str(x+1)] = self.__assetObject.getTableName();
				myParams["selectfield" + str(x+1)] = self.__assetObject.getSelectFields();
				myParams["conditional" + str(x+1)] = self.__assetObject.getConditional();
				
			myUrl = urllib.urlencode(myParams);	

			myUrl = "/cgi-bin/assetvalidation?templatename=/assetvalidation/assetvalidation.html&" + myUrl;
			
			self.__environmentID = self.__environmentID.replace("http://", "");
			
			myObject = httplib.HTTP(self.__environmentID);
			myObject.putrequest('GET', myUrl);
			myObject.putheader('Accept', 'text/html');
			myObject.putheader('Cookie', 'auth-pass=true; ' + self.__auids);
			myObject.endheaders();
			errcode, errmesssage, header = myObject.getreply();
			
			f = myObject.getfile();
			myContent =  f.read();

			self.__reportContents = myContent;


if __name__ == "__main__":
	from GI_Product import *;
	p = GI_Product('gme3');

	for x in p.getAssets():
		asset = p.getAsset(x.getName());
		print "------------------------------------------------";
		print "Asset Name: " + asset.getName();
		print "Description: " + asset.getDescription();
		print "Select Fields: " + asset.getSelectFields();
		print "Table Name: " + asset.getTableName();
		print "Conditional: " + asset.getConditional();
		
		#get the report data
		af = GI_AssetFileReport(asset, "http://linuxstage.grolier.com:1100");
		print "Asset Count:" + str(af.getAssetCount());
		print "Missing File Count:" + str(af.getMissingFileCount());
		print "Zero Byte File File Count:" + str(af.getZeroByteFileCount());
		print "------------------------------------------------\n\n";
	
