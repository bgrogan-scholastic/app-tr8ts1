#########################################################
# Author: Todd A. Reisel
# Date: 2/24/2003
# Class: MediaTemplateList
#########################################################

from BaseClasses.TemplateList import *;
import DataCloud;

class MediaTemplateList(TemplateList):
    def __init__(self, viewMode = None):
        TemplateList.__init__(self, viewMode);
        
    def getList(self):
#        return [ ["graphical", "media.html"], ["graphical", "medialist_popup.html"], ["graphical", "media_popup.html"], ["graphical", "media_popup_back.html"], ["graphical", "medialist.html"], ["graphical", "media_back.html"] , ["ada", "medialist.html"], ["ada", "media.html"] , ["graphical", "goatlas.html"] ];

        entireList = [ ["graphical", "medialist_popup.html"], ["graphical", "media_popup.html"], ["graphical", "media_popup_back.html"], ["graphical", "maplist.html"], ["graphical", "maplist_popup.html"], ["ada", "medialist.html"], ["ada", "media.html"], ["ada", "maplist.html"] ];

        #check to see if the go atlas template is needed.
        if DataCloud.instance().hasFeature("relmaps") == true and self._sViewMode != "preview":
            entireList.append( ["graphical", "goatlas.html"] );

        return entireList;
    
    def getFeatureName(self):
        return "media";
    
