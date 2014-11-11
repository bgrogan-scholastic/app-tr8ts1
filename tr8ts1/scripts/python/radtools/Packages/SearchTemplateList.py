#########################################################
# Author: Todd A. Reisel
# Date: 2/24/2003
# Class: SearchTemplateList
#########################################################

from BaseClasses.TemplateList import *;
import DataCloud;

class SearchTemplateList(TemplateList):
    def __init__(self, viewMode = None):
        TemplateList.__init__(self,viewMode);
        
    def getList(self):
	
        entireList = [ ["graphical", "search.html"], ["ada", "search.html"] , ["graphical", "quicksearch.html"] , ["ada", "quicksearch.html"] ];
        myFeat = DataCloud.instance().getFeature("quicksearch");
        print myFeat.get("advpagetype");
        DataCloud.instance().printFeatures();
        
	if DataCloud.instance().getFeature("quicksearch").get("advpagetype") == "_popup":
		entireList.append( ["graphical", "advsearch_popup.html"] );
		entireList.append( ["ada", "advsearch.html"] );

		entireList.append( ["graphical", "searchtips_popup.html"] );
		entireList.append( ["ada", "searchtips.html"] );
	else:
		entireList.append( ["graphical", "advsearch.html"] );
		entireList.append( ["ada", "advsearch.html"] );

		entireList.append( ["graphical", "searchtips.html"] );
		entireList.append( ["ada", "searchtips.html"] );

	return entireList;

    def getFeatureName(self):
        return "search";
    


    
        
