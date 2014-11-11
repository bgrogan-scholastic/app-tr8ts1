#########################################################
# Author: Todd A. Reisel
# Date: 2/24/2003
# Class: TextTemplateList
#########################################################

from BaseClasses.TemplateList import *;

class TextTemplateList(TemplateList):
    def __init__(self, viewMode = None):
        TemplateList.__init__(self, viewMode);
        
    def getList(self):
#        return None;

        #finish templates.
        #return [ ["graphical", "text_popup.html"], ["graphical", "text_popup_back.html"], ["graphical", "textlist.html"], ["graphical", "textlist_popup.html"], ["ada", "text_back.html"], ["ada", "textlist.html"],  ["ada", "text.html"] ];
        return [ ["graphical", "text_popup.html"], ["graphical", "text_popup_back.html"], ["graphical", "textlist.html"], ["ada", "text_back.html"], ["ada", "textlist.html"],  ["ada", "text.html"] ];
    
    def getFeatureName(self):
        return "text";
    
