##########################################################################################################################################################
# Class: AppTemplateData
# Author: Todd A. Reisel
# Date: 2/21/2003
# Purpose: Encompass the gathering of data for the template generator.  This will look in the xml file and in the datacloud for all the data needs.
##########################################################################################################################################################

import DataCloud;
from BaseClasses.queryexception import *;
import Log

class AppTemplateData:
    def __init__(self, args):
        self.__xmlData = args[0];
        self.__sTagName = args[1].replace("$$", "");
        self.__sFeatureName = args[2];
        
    def getData(self):
        #please remember to always return a 2 item list or none.

        #first element - actionType
        #second element - data value

	if self.__sTagName == "pcode":
            return ["datareplace", DataCloud.instance().value("pcode")];
        elif self.__sTagName == "PCODE":
            return ["datareplace", DataCloud.instance().value("pcode")].upper();
	elif self.__sTagName == "ptitle":
            return ["datareplace", DataCloud.instance().value("ptitle")];
        elif self.__sTagName == "pauth":
            return ["datareplace", DataCloud.instance().value("pauth")];
        else:
            #find the tag within the xml definition based on featurename and tagname.
            xmlQuery = '/rad/apptemplates/template[@id="' + self.__sFeatureName + '"]/supported_tags/tag[@name="' + self.__sTagName + '"]';
            xmlValue = None;
            
            try:
                xmlValue = self.__xmlData.query(xmlQuery);
            except QueryException, message:
                Log.instance().add("Tag: " + self.__sTagName + " could not be located in the xml ruleset for feature: " + self.__sFeatureName + " will be replaced with nothing", Log.instance().bitMaskWarningAll());
                return None;


            #find out what type of action to perform.
            actionType = xmlValue[0].getAttribute("type");
            fileAttribute = xmlValue[0].getAttribute("file");
            if len(fileAttribute) == 0:
                fileAttribute = None;

            dataValue = None;

            #always check to make sure the data comes from the datacloud first, if it is not present use the file attribute from the xml file.
            try:
                dataValue = DataCloud.instance().getFeature(self.__sFeatureName).get(self.__sTagName);
            except KeyError, message:
                pass;

            if dataValue == None or len(dataValue) == 0:
                try:
                    dataValue = DataCloud.instance().getFeature("common").get(self.__sTagName);
                except KeyError, message:
                    pass;
            
            if dataValue == None:
                dataValue = fileAttribute;

        #return the actionType from the xml file and the actual datavalue found through the various lookups.
        return [actionType, dataValue];
    
