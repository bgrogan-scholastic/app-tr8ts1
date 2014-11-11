###################################################################################
# Class: TemplateController
# Author: Todd A. Reisel
# Date: 2/24/2003
# Purpose: This class will be responsible for building the feature's templates.
#    If given the feature article, the TemplateController will iinstantiate an
#    ArticleTemplateList class and get a template list from that class.  For each
#    entry returned the TemplateGenerator process will get invoked and the online
#    template will get created, along with all its html includes.
###################################################################################

#these are all the features the TemplateController supports.  To create a new feature
#  an <Feature>TemplateList must be created to return the templates for that feature, as
#  well as updating the function getTemplateList to recognize this new feature.

from ArticleTemplateList import *;
from BrowseTemplateList import *;
from MediaTemplateList import *;
from StaticTemplateList import *;
from TextTemplateList import *;
from SplashTemplateList import *;
from SearchTemplateList import *;

from TemplateGenerator import *;
import DataCloud;
import os;

from BaseClasses.PreviewBrowserCommands import *

class TemplateController:
    def __init__(self, featureName, viewmode = None):
	self._sFeatureName = featureName;
	self._sViewMode = viewmode;

    def process(self):
        # Keep an in memory list of the templates that have been processed for this feature, it starts off as a blank python list
        # to ensure that the variable is initialized.
        #
        #  In order to make sure templates for a feature get re-processed again if the feature is re-generated from the same instance of the tool
        #     we remove the list from memory and add back in a blank list.
        #
        #  Also don't bother to check the top level templates, as those are not likely to get repeated.  Its the includes below that will get
        #     repeated.
        
    	DataCloud.instance().removeNS("templatesprocessed");
    	DataCloud.instance().addNS("templatesprocessed", []);
    	
        Log.instance().add("Generating Templates for Feature: " + self._sFeatureName);

        #based on featurename get the templates to process.
        templatesList = self.getTemplateList();

        if templatesList != None:
            try:
                #loop through each template returned and make a call to the TemplateGenerator for each one.
                for x in templatesList:
                    myTG = TemplateGenerator(x[0], x[1], 1, self._sViewMode);
                    myTG.processSuperTags();
                    myTG.processImageTags();
                    myTG.output();

                    if x[0] == "graphical" and x[1] == "goatlas.html":
                        #get functionality from the releasetool.
                        import sys;
                        sys.path.append("/home/qadevWS/releasetool/");
                        import utilities;
                        import ftplib;
                        
                        try:
                            sourceFilePath = "/data/" + DataCloud.instance().value("pcode") + "/templates/" + x[1];
                            destinationFilePath = "/data/go/templates/atlas_new/atlas-" + DataCloud.instance().value("pauth") + "-interface.html";
                            #the hostname / username and password
                            destinationHostname = "qadev";
                            destinationUsername = os.environ["USER"];;
                            destinationPassword = DataCloud.instance().getMachinePassword(destinationHostname, destinationUsername);
                            
                            Log.instance().add("Ftping the source file: " + sourceFilePath + " to " + destinationHostname + " as: " + destinationFilePath);
                            
                            myFtpClient = utilities.giFtp(destinationHostname, destinationUsername, destinationPassword);
                            myFtpClient.binary_put(sourceFilePath, destinationFilePath);

                            # 6/23/2003: R.E. Dye - added this next bit to copy the map template's "base URL" include file
                            sourceFilePath = "/data/" + DataCloud.instance().value("pcode") + "/config/" + DataCloud.instance().value("pcode") + "_base_url.html"
                            destinationFilePath = "/data/go/config/rad/" + DataCloud.instance().value("pcode") + "_base_url.html"
                            myFtpClient.binary_put(sourceFilePath, destinationFilePath);
                            
                            myFtpClient.close();

                            Log.instance().add("FTP completed to: " + destinationHostname);
                            
                        except ftplib.error_perm, message:
                            Log.instance().add("The Ftp to " + destinationHostname + " failed for source file: " + sourceFilePath + "going to destination: " + destinationFilePath, Log.instance().bitMaskCriticalAll());	
		Log.instance().add("Completed Generating Templates for Feature: " + self._sFeatureName);

                #see if this is preview mode, if so launch a browser, so the user can see their work.
                if self._sViewMode == "preview":
                    webBrowserCommand = previewModeWebBrowserCommands[self._sFeatureName];
                    # 4/29/2003: R.E. Dye - A kludge so that the media preview will actually
                    #    bring up an article.
                    if self._sFeatureName == "media":
                        webBrowserCommand += "article.html &"
                    else:
                        webBrowserCommand += templatesList[0][1] + " &";  #append the template name on to the call

                    #launch the web browser to preview the page;
                    os.system(webBrowserCommand);                    
            except RuntimeError, message:
                Log.instance().add("An error occurred in the TemplateController while generating the (" + self._sFeatureName + ") feature\nThe Top Level template being generated was: " + x[1] + " for the " + x[0] + " version of the product\nExiting Template Generation for this feature", Log.instance().bitMaskCriticalAll());

        else:
            #no templates to process for this feature.
            Log.instance().add("No templates to generate for Feature: " + self._sFeatureName, Log.instance().bitMaskWarningAll());

        pass;
    
    #this is a factory method, it returns an object of base type TemplateList
    def getTemplateList(self):	
        if self._sFeatureName == "article":
            myList =[];
            for x in ArticleTemplateList(self._sViewMode).getList():
                myList.append(x);

            #only include browse, static and splash when not in preview mode
            if self._sViewMode != "preview":
                for x in BrowseTemplateList(self._sViewMode).getList():
                    myList.append(x);
                for x in SplashTemplateList(self._sViewMode).getList():
                    myList.append(x);
                for x in StaticTemplateList(self._sViewMode).getList():
                    myList.append(x);
		for x in TextTemplateList(self._sViewMode).getList():
		    myList.append(x);

            return myList;        
        elif self._sFeatureName == "media":
            return MediaTemplateList(self._sViewMode).getList();
        elif self._sFeatureName == "text":
            return TextTemplateList(self._sViewMode).getList();
        elif self._sFeatureName == "search":
            return SearchTemplateList(self._sViewMode).getList();

        #didn't find the feature in the list above, so can't process, returning None.
        return None;

