#########################################################
# Author: Todd A. Reisel
# Date: 2/24/2003
# Class: BrowseTemplateList
#########################################################

from BaseClasses.TemplateList import *;

class BrowseTemplateList(TemplateList):
    def __init__(self, viewMode = None):
        TemplateList.__init__(self, viewMode);
        
    def getList(self):
        return [ ["graphical", "browse.html"], ["ada", "browse.html"], ["graphical", "browselist.html"], ["ada", "browselist.html"] ];

    
        
