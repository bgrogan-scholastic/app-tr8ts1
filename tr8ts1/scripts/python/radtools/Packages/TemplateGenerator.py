###############################################################################
# Author: Todd A. Reisel
# Class: TemplateGenerator
# Date: 1/24/2003
#
# Methods:
#        TemplateGenerator(templateFileName)   -constructor
#        processSuperTags();                   - find/hand off $$tags$$
#        handleTag(tagName);                   - handle this $$tag$$
#        output();                             - write the online template file
###############################################################################

#os specific imports
import os;
import os.path;

#XPath class to handle xml data transactions.
from BaseClasses.xpath import *;

#import the Search And Replace class.
from BaseClasses.searchandreplace import *;

from AppSuperTemplate import *;
from OnlineInclude import *;
from AppTemplateData import *;
import Log;

class TemplateGenerator:
    """TemplateGenerator class:
    This class is responsible for taking canned SuperTemplates and performing tag substitutions

    Here are a list of available methods:

    TemplateGenerator(filename) - constructor - filename of the template, example: article.html
    bool processSuperTags() - process all the $$tags$$ in the template.
    bool output() - output the template
    
    """
    
    #constructor
    def __init__(self, productType, templateFileName, levelid = 0, viewMode = None):

        #what product type are we?
        self.__sproductType = productType;

        #is this is a regular template or a preview template
        self.__sViewMode = viewMode;
        
	#used to determine what level of recursion this code is in.
        self.__ilevelid = levelid;

        #the xml data object for app templates.
        self.__xmlData = XPath(os.path.join(os.getcwd(), "/data/rad/supertemplates/xml/apptemplates.xml"));

        #create the appsupertemplate class which will handle inputting and outputting our template.
	self.__appSuperTemplate = AppSuperTemplate(templateFileName, [productType, self.__xmlData, self.__sViewMode]);

        #print a status message
        if self.__sViewMode == "preview":
            self.__printMessage("Processing Preview Template (" + self.__sproductType + "): " + templateFileName);
        else:
            self.__printMessage("Processing (" + self.__sproductType + "): " + templateFileName);
            

        #this class wil handle the searching and replacing of $$tags$$.
	self.__searchAndReplace = SearchAndReplace("\$\$[0-9a-zA-Z\-\_]*\$\$", self.__handleTag);
    
    #---------------------------------------------------------------------------
    # Method: processSuperTags
    # Scope: public function
    # Parameters: self
    #            as usual self is a reference to this instance of the class.
    # Purpose: find all the $$tag$$ tags in the template and hand those off to __handleTag
    # Return Value: No return.get, just actions to internal member variables.
    #---------------------------------------------------------------------------
    def processSuperTags(self):
        self.__searchAndReplace.setContents(self.__appSuperTemplate.getContents());
        self._contents = self.__searchAndReplace.getContents(1);        
        self.__appSuperTemplate.setContents(self._contents);
        pass;

    def processImageTags(self):
        startPos = self._contents.find("<img");
        endPos = 0;
        
        while startPos != -1:
            #find the ending image tag
            endPos = self._contents.find(">", startPos) + 1;
            imageTag = self._contents[startPos:endPos];
            
            srcBegin = imageTag.find('src="') + 5;
            srcEnd = imageTag.find('"', srcBegin);

            imageSrc = imageTag[srcBegin:srcEnd];

            #does the image source contain a ..
            if imageSrc.find("..") > -1:
                self.__printMessage("Reprocessing Image tag: " + imageTag + " for correct pathing.", Log.instance().bitMaskWarningAll());
                
                if imageSrc.rfind("/") == -1:
                    Log.instance().add("Error processing image tag.  Contains a .., but no /, this image has not been repathed", Log.instance().bitMaskWarningAll());
                else:
                    #path the image with /images and then everything after the last /
                    newImageSrc = "/images" + imageSrc[imageSrc.rfind("/"):len(imageSrc)];

                    #assign the new image tag starting from <img.....>
                    newImageTag = imageTag[0:srcBegin] + newImageSrc + imageTag[srcEnd:len(imageTag)];

                    #replace the image tag in the actual contents.  This will not get saved to the source file, only the destination file
                    self._newContents = self._contents[0:startPos];
                    self._newContents += newImageTag;
                    self._newContents += self._contents[endPos:len(self._contents)];

                    #make the new contents, the output contents
                    self._contents = self._newContents;
                    
            #find the next starting position
            startPos = self._contents.find("<img", endPos);

            #update the AppSuperTemplate to have the new contents after image parsing.
            self.__appSuperTemplate.setContents(self._contents);
            
  	pass;
 
    def __handleImageTag(self, tag):
	print tag;

    #---------------------------------------------------------------------------
    # Method: output
    # Scope: public function
    # Parameters: self
    #            as usual self is a reference to this instance of the class.
    # Purpose: write this online template to the right place when all the 
    #		actions have been performed.
    # Return Value: No return.get.
    #---------------------------------------------------------------------------
    def output(self):
        try:
            self.__appSuperTemplate.write();
        except IOError, message:
            self.__printMessage("TemplateGenerator: an error occurred while writing out the template, message generated", Log.instance().bitMaskCriticalAll());
            self.__printMessage(str(message), Log.instance().bitMaskCriticalAll());
            raise RuntimeError;
        return 1;
    
    #---------------------------------------------------------------------------
    # Method: __handleTag
    # Scope: private to this class
    # Parameters: self, tagName
    #            as usual self is a reference to this instance of the class.
    #            tagName is the tag found in the template, example: $$browse$$
    # Purpose: replace the $$tagname$$ with the results from __performTagAction
    # Return Value: This function has no return.get
    #---------------------------------------------------------------------------
    #handle the processing of this one tag
    def __handleTag(self, tagName):
        #see if the AppTemplateData class has any data for us?
        params = AppTemplateData([self.__xmlData, tagName, self.__appSuperTemplate.getFeatureName()]).getData();

        if params == None:
            return None;
        
        #params[0] = actionType defined in the xml file.
        #params[1] = data value from either the data cloud or the default xml value if it exists.
        if params[1] != None:
            actionType = params[0];
            dataValue = params[1];
            
            if actionType == "datareplace":
                return dataValue;
            elif actionType == "include":
                return OnlineInclude([dataValue, self.__sproductType, self.__ilevelid, self.__sViewMode]).process();
            elif actionType == "replace":
                return AppSuperTemplate(dataValue, [self.__sproductType, self.__xmlData, self.__sViewMode]).getContents().rstrip();
            else:
                #unknown action type.... generate a warning message.
                Log.instance().add("An unknown action type was specified in the xml file for tag: " + tagName + "...replacing this tag with nothin", Log.instance().bitMaskWarningAll())
                return "";
    
    def __printMessage(self, message, bitMask = None):
        for x in range(0, self.__ilevelid):
            message = "\t" +  message;

        #log the message
	if bitMask == None:
	        Log.instance().add(message);
	else:
		Log.instance().add(message, bitMask);

