#########################################################
# Author: Todd A. Reisel
# Date: 2/24/2003
# Class: StaticTemplateList
#########################################################

from BaseClasses.TemplateList import *;

class StaticTemplateList(TemplateList):
    def __init__(self, viewMode = None):
        TemplateList.__init__(self, viewMode);
        
    def getList(self):
        return [ ["graphical", "interface.html"], ["ada", "interface.html"] ];
    
    def getFeatureName(self):
        return "static";
    
