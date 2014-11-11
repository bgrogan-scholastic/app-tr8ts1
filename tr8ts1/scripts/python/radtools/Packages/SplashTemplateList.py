#########################################################
# Author: Todd A. Reisel
# Date: 2/24/2003
# Class: SplashTemplateList
#########################################################

from BaseClasses.TemplateList import *;

class SplashTemplateList(TemplateList):
    def __init__(self, viewMode = None):
        TemplateList.__init__(self, viewMode);
        
    def getList(self):
	return [ ["graphical", "splashinterface.html"], ["ada", "splashinterface.html"] ];
    
    def getFeatureName(self):
        return "splash";
    
