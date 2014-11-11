#########################################################
# Author: Todd A. Reisel
# Date: 2/24/2003
# Class: ArticleTemplateList
#########################################################

from BaseClasses.TemplateList import *;
import DataCloud;

class ArticleTemplateList(TemplateList):
    def __init__(self, viewMode = None):
        TemplateList.__init__(self, viewMode);
   
    def getList(self):

	if self._sViewMode == "preview":
		#build ada and graphical
	        entireList = [ ["graphical", "article.html"],["graphical", "toc.html"] , ["graphical", "relatedassets.html"], ["graphical", "quicksearch.html"], ["ada", "article.html"],["ada", "toc.html"] , ["ada", "relatedassets.html"], ["ada", "quicksearch.html"] ];

                return entireList;
	else:      
		#build all article features
        	entireList = [ ["graphical", "article.html"],["graphical", "toc.html"] , ["ada", "article.html"],["ada", "toc.html"] , ["graphical", "relatedassets.html"], ["ada", "relatedassets.html"], ["graphical", "quicksearch.html"] ];

		if DataCloud.instance().hasFeature("relweblinks") == true:
			entireList.append( ["graphical", "gii.html"] );
			entireList.append( ["ada", "gii.html"] );

                if DataCloud.instance().hasFeature("relpfe") == true:
			entireList.append( ["graphical", "pfe_print.html"] );
			entireList.append( ["ada", "pfe_print.html"] );
                        
			entireList.append( ["graphical", "pfe_print_email.html"] );
			entireList.append( ["ada", "pfe_print_email.html"] );

			entireList.append( ["graphical", "pfe_toc_select.html"] );
			entireList.append( ["ada", "pfe_toc_select.html"] );
                        
			entireList.append( ["graphical", "pfe_toc_select_email.html"] );
			entireList.append( ["ada", "pfe_toc_select_email.html"] );

                    
		if DataCloud.instance().hasFeature("relarts") == true:
			if DataCloud.instance().getFeature("relarts").get("pagetype") == "_popup":
				entireList.append( ["graphical", "relatedarticles_popup.html"] );
				entireList.append( ["ada", "relatedarticles.html"] );
			else:
				entireList.append( ["graphical", "relatedarticles.html"] );
				entireList.append( ["ada", "relatedarticles.html"] );

		if DataCloud.instance().hasFeature("relbiblios") == true:
			if DataCloud.instance().getFeature("relbiblios").get("pagetype") == "_popup":
				entireList.append( ["graphical", "biblios_popup.html"] );
				entireList.append( ["ada", "biblios.html"] );
			else:
				entireList.append( ["graphical", "biblios.html"] );
				entireList.append( ["ada", "biblios.html"] );
                print entireList;
                return entireList;
    
    def getFeatureName(self):
        return "article";
    
