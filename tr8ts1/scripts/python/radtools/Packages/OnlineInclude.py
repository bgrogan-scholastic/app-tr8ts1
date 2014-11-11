##########################################################################################################################################################
# Class: OnlineInclude
# Author: Todd A. Reisel
# Date: 2/21/2003
# Purpose: Encompass the process of online include files.  This will return an online include tag and also recurse into the TemplateGenerator to
#          generate this file.
##########################################################################################################################################################

import os;
import TemplateGenerator;
import DataCloud;

class OnlineInclude:
    def __init__(self, args):
        self.__sDataValue = args[0];
        self.__sproductType = args[1];
        self.__ilevelid = args[2];
        self.__sViewMode = args[3];

    def process(self):
        #By default process this template
        processTemplate = 1;   #true

        #how do we identify this template in the "templates already processed" list, ada/graphical_filenameoftemplate
        templatesProcessedList_CurrentDataKey = self.__sproductType + "_" + self.__sDataValue;

        #get the list of processed templates from the datacloud.
        templatesProcessedList = DataCloud.instance().valueNS("templatesprocessed");

        #loop through the processed templates list
        for x in templatesProcessedList:
            if x == templatesProcessedList_CurrentDataKey:
                #found this template was already in the list, set the processTemplate flag to false, so this template
                #  will not get re-generated
                processTemplate = 0;   #false

        #template can be processed as it was not in the list.
        if processTemplate == 1:
            #this template is being processed, so add it to the list so it won't get processed for this feature again.
            templatesProcessedList.append(templatesProcessedList_CurrentDataKey);

            #save the new template list back into the datacloud.
            DataCloud.instance().addNS("templatesprocessed", templatesProcessedList);

            
            #take the filename passed along and process that as a SuperTemplate as well, in case it has tagging.  
            myTG = TemplateGenerator.TemplateGenerator(self.__sproductType, self.__sDataValue, self.__ilevelid + 1, self.__sViewMode);
            myTG.processSuperTags();  #process $$tags$$
            myTG.processImageTags();  #clean up any image tags that may be broken
            myTG.output();


        #always return the online include, even if the template was not parsed.
        #return an online include tag, the splitext function will take a filename and return .html or .obj, so get only html, or obj
        return "<!-- ##INCLUDE#templateName=/" + os.path.join(os.path.splitext(self.__sDataValue)[1][1:], self.__sDataValue) + "# -->";
