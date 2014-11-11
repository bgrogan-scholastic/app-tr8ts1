#########################################################
# Author: Todd A. Reisel
# Date: 3/13/2003
# Class: FeatureTemplateShells
# Purpose: This class will allow you to pass along a feature
#          name, it will look in the canned directories and
#          delivered directories for template shells you may
#          wish to use.
#########################################################

import os;
import DataCloud;
import Log;
from BaseClasses.fileutils import *

class FeatureTemplateShells:
    def __init__(self, featureName):
	self.__sfeatureName = featureName;

    def getList(self):
	cannedFileList = os.listdir("/data/rad/supertemplates/app/graphical/html");

        self.pcodeValue = DataCloud.instance().value("pcode");

	if self.pcodeValue == None:
            return {};

        targetDirectory = "/home/" + self.pcodeValue + "/delivery/templates/graphical/html";

        if (os.path.exists(targetDirectory)):
            deliveredFileList = os.listdir(targetDirectory);
        else:
            deliveredFileList = [];
            Log.instance().add("Directory " + targetDirectory + " does not exist.", Log.instance().bitMaskWarningScreen());
            

	myList = {};

	for x in cannedFileList:
		if ( x.find(self.__sfeatureName + ".") == 0 or x.find(self.__sfeatureName + "_") == 0) and x.find(".html") == len(x) - 5:

			myList[x] = self.getFileDescription(os.path.join("/data/rad/supertemplates/app/graphical/html", x));

	for x in deliveredFileList:
		if ( x.find(self.__sfeatureName + "_") == 0 or x.find(self.__sfeatureName + ".") == 0) and x.find(".html") == len(x) - 5:
			myList[x] = fileDescription( os.path.join("/home/" + self.pcodeValue + "/delivery/templates/graphical/html", x));

	return myList;

    def getFileDescription(self, filePath):
	myFile = FileIOList(filePath);
	fileDescription = myFile.getList()[0];
	if fileDescription.find("<!--") == 0:
		startposition = fileDescription.find("***") + 3;
		endposition = fileDescription.find("***", startposition);

		fileDescription = fileDescription[startposition:endposition];
		fileDescription = fileDescription.strip();
	else:
		fileDescription = "Unknown Description";

	return fileDescription;

if __name__ == "__main__":
	DataCloud.instance().load("radtest");
	myShells = FeatureTemplateShells("article");
	print myShells.getList();

