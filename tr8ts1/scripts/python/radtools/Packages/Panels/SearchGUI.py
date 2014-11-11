from wxPython.wx import *
import string
import sys
sys.path.append("/home/qadevWS/python/radtools/Packages");
from BaseClasses.Mediator import *
from BaseClasses.observer import Observer
from BaseClasses.GUI import *
from BaseClasses.Colleague import *
from Controls.giValidator import *
from Controls.DropDownList import *

import Log
from Features import *
from TemplateController import *;
from BaseClasses.PreviewBrowserCommands import *
import ScreenLogGUI

class SearchGUI(GUI):
    def __init__(self, parentWindow, title):
        GUI.__init__(self, parentWindow, title, wxSize(500,100));
        
        self.__inProcess = false;

        self.__headwordTuple = ["headword", "OFF"];
        self.__maxItemsTuple = ["maxitems", "25"];
        self.__searchTypeTuple = ["searchtype", "Ranked"];
        self.__viewNameTuple = ["viewname", "rad"];
        self.__dbNameTuple = ["dbname", DataCloud.instance().value("pcode")];

        #this holds the various information for a sorting search type.
        self.__searchTypeOptions_Sorting = ["sorting", "TITLE", ""];

        #Sorting is not enabled by default, but if it was the above options would be combined.
        self.__sortingTuple = ["sorting", '<input type="hidden" name="sorting" value="BYRELEVANCE">'];
        
        #time to get our saved settings.
        #see what the status of the datacloud is?
	print DataCloud.instance().hasFeature("search");
	DataCloud.instance().printFeatures();

        if DataCloud.instance().hasFeature("search") == false:
            #initialize the datacloud elements
            self.__saveDataCloudElements();
        else:
            Log.instance().add("Search feature already exists in datacloud, loading the values from the datacloud");
            myFeature = DataCloud.instance().getFeature("search");
            self.__maxItemsTuple[1] = myFeature.get(self.__maxItemsTuple[0]);
            self.__searchTypeTuple[1] = myFeature.get(self.__searchTypeTuple[0]);
            self.__viewNameTuple[1] = myFeature.get(self.__viewNameTuple[0]);
            self.__dbNameTuple[1] = myFeature.get(self.__dbNameTuple[0]);
                        
            #load the quicksearch options
            myFeature = DataCloud.instance().getFeature("quicksearch");
            self.__headwordTuple[1] = myFeature.get(self.__headwordTuple[0]);
            self.__sortingTuple[1] = myFeature.get(self.__sortingTuple[0]);

	    startPos = self.__sortingTuple[1].find("value=") + 7;
	    endPos = self.__sortingTuple[1].find("\"", startPos);
            sortingValue = self.__sortingTuple[1][startPos:endPos];

            if sortingValue != "BYRELEVANCE":
		self.__searchTypeTuple[1] = "Sorted";
                if sortingValue[0:1] == "-":
                    #sort ascending
                    self.__searchTypeOptions_Sorting = ["sorting", sortingValue[1:len(sortingValue)], "-"];
                else:
                    #sort descending
                    self.__searchTypeOptions_Sorting = ["sorting", sortingValue, ""];
            else:
                #ranked relevance
                self.__searchTypeTuple[1] = "Ranked";
                                                                         
    def __del__(self):
        GUI.__del__(self);

    def load(self):
        pass;
    
    def cancel(self, event):
        print "Search GUI Cancel Button Pressed";
        GUI.cancel(self, event);

    def _save(self):
        self.__saveDataCloudElements();

        #commit the datacloud....
        DataCloud.instance().commit();

	#save the data cloud to disk
        DataCloud.instance().save(DataCloud.instance().value("pcode"));

	#notify everyone the data has changed.
	DataCloud.instance().notify(self);
        
        #generating the search templates
        myTC = TemplateController("search");
        myTC.process();

	return true;

    def preview(self, event):
        
        #save internal gui state to the datacloud....
        self.__saveDataCloudElements();
        
        # use an existing database to preview the data
        #........ TODO: This will need to be saved to a rad database ......
        DataCloud.instance().getFeature("search").set("dbname", "eas");

        #generate the preview templates
        myTC = TemplateController("search", "preview");
        myTC.process();


        #rollback the datacloud to get back the original dbname
        DataCloud.instance().rollback();
        
    def help(self, event):
        os.system("mozilla '/home/qadevWS/python/radtools/Packages/Panels/Help/search.html'");
    
    def __saveDataCloudElements(self):
        myFeature = Features("search");
        myFeature.set(self.__maxItemsTuple[0], self.__maxItemsTuple[1]);
        myFeature.set(self.__searchTypeTuple[0], self.__searchTypeTuple[1]);
        myFeature.set(self.__viewNameTuple[0], self.__viewNameTuple[1]);
        myFeature.set(self.__dbNameTuple[0], self.__dbNameTuple[1]);
        
        #initialize this feature for the first time
        DataCloud.instance().addFeature(myFeature);

        #get the quick search values from the article gui section
        myFeature = DataCloud.instance().getFeature("quicksearch");
        myFeature.set(self.__headwordTuple[0], self.__headwordTuple[1]);
        myFeature.set(self.__sortingTuple[0], self.__sortingTuple[1]);

        #add quick search option to the data cloud
        DataCloud.instance().addFeature(myFeature);

        myFeature = Features("jssearch");
        myFeature.set("sortingkey", self.__sortingTuple[0]);

        #save either BYRELEVANCE or -TITLE, etc.
        startPos = self.__sortingTuple[1].find("value=") + 7;
        endPos = self.__sortingTuple[1].find("\"", startPos);
        sortingValue = self.__sortingTuple[1][startPos:endPos];

        myFeature.set("sortingvalue", sortingValue);
        
        myFeature.set(self.__headwordTuple[0], self.__headwordTuple[1]);

        #never load this dta, always repopulate it from existing internal variables
        DataCloud.instance().addFeature(myFeature);
        
    def _show(self):

        #create a Validator that'll only filter for digits.
        self.v1 = giValidator(DIGIT_ONLY);

        self.statusbar.SetStatusText("Search");
        #set up all of the controls;
        mainsizer = wxBoxSizer(wxVERTICAL);

        #give the screen a header
        mainsizer.Add(wxStaticText(self.panel, -1, "Options", wxDefaultPosition, wxDefaultSize), option = 0, flag = wxALL, border = self.bordersize);

        
        #create the ids for each element on the page.
        [tb1ID, cb1ID, dd1ID, dd2ID, dd3ID] = map(lambda x: wxNewId(), range(5));

        
        #add the first checkbox, for the maximum number of entries per page, the default is listed in the tuple above.
        maxItemsSizer = wxBoxSizer(wxHORIZONTAL);

        self.tb1 = TextBox(self.panel, self, tb1ID, wxTE_RIGHT, self.__maxItemsTuple[1], giValidator(DIGIT_ONLY), wxSize(25, -1));

        maxItemsSizer.Add(self.tb1, option = 0, flag =  wxALL,  border = self.bordersize);        
        maxItemsSizer.Add(wxStaticText(self.panel, -1, "Maximum Items to Display on Search Results Page"), option = 0, flag = wxALL, border = self.bordersize);
        mainsizer.Add(maxItemsSizer, option = 0, flag = wxTE_LEFT ,  border = self.bordersize);

        sortingSizer = wxBoxSizer(wxHORIZONTAL);
        sortingSizer.Add(wxStaticText(self.panel, -1, "Sorting"), option = 0, flag = wxALL, border = self.bordersize);

        #ranked or sorted query
        self.dd1 = DropDownList(self.panel, self, dd1ID, ["Ranked", "Sorted"]);
        sortingSizer.Add(self.dd1, option = 0, flag =  wxALL,  border = self.bordersize);        

        #set the default value
	print self.__searchTypeTuple[1];

        if self.__searchTypeTuple[1] == "Ranked":
            self.dd1.SetSelection(0);
        elif self.__searchTypeTuple[1] == "Sorted":
            self.dd1.SetSelection(1);
            
        #if sorting then by field name            
        self.dd2 = DropDownList(self.panel, self, dd2ID, ["TITLE"]);

        if self.__searchTypeTuple[1] == "Sorted":
            if self.__searchTypeOptions_Sorting[1] == "TITLE":
                #title sorting, so select this option
                self.dd2.SetSelection(0);
                
        #check to see what the data state is?
        if self.__searchTypeTuple[1] == "Sorted":
            self.dd2.Enable(true);
        else:
            self.dd2.Enable(false);
            
        sortingSizer.Add(self.dd2, option = 0, flag =  wxALL,  border = self.bordersize);        

        #if sorting ascending or decending
        self.dd3 = DropDownList(self.panel, self, dd2ID, ["Sort Ascending", "Sort Descending"]);

        if self.__searchTypeTuple[1] == "Sorted":
            if self.__searchTypeOptions_Sorting[2] == "-":
                self.dd3.SetSelection(1);
            else:
                self.dd3.SetSelection(0);
                

        #what is the data state?
        if self.__searchTypeTuple[1] == "Sorted":
            self.dd3.Enable(true);
        else:
            self.dd3.Enable(false);


        sortingSizer.Add(self.dd3, option = 0, flag =  wxALL,  border = self.bordersize);        
        
        mainsizer.Add(sortingSizer, option = 0, flag = wxTE_LEFT ,  border = self.bordersize);
        
        #search on headword?
        self.cb1 = CheckBox(self.panel, self, cb1ID, "Search on Headword");

        #should headword be checked or not checked
        if self.__headwordTuple[1] == "ON":
            #headword on
            self.cb1.SetCheckboxValue(1);
        else:
            #headword off
            self.cb1.SetCheckboxValue(0);
            
        mainsizer.Add(self.cb1, option = 0, flag =  wxALL,  border = self.bordersize);

        #build mapping of controls into function all dictionary
        myKeys = {};
        
        myColleagueMap = { self.tb1 : self._MaximumItemsHasChanged,
                           self.cb1 : self._HeadwordHasChanged,
                           self.dd1 : self._SearchTypeHasChanged,
                           self.dd2 : self._SortFieldHasChanged,
                           self.dd3 : self._SortFieldOrderHasChanged
                                };
        
        self._colleagueMap.update(myColleagueMap);
        
        #add everyone to a sizer.
        mainsizer.Add(self, option = 1, flag =  wxALL | wxALIGN_LEFT,  border = self.bordersize);

        #because I'm AR, I move the window to a point on the screen where I can constantly see it.
        self.Move((100,250));
       
        return mainsizer;

    def _ColleagueChanged(self, colleague, event):
        """This method gets called when when of the colleagues has changed.
        This is the central 'clearing' house for all changes and orchestrates
        these changes among the cooperating controls"""
        # don't get recursive on us
        if self.__inProcess != true:
            self.__inProcess = true

            # call the cooresponding method directly using a map lookup
	    if self._colleagueMap.has_key(colleague):
                self._colleagueMap[colleague](event)
            self.__inProcess = false

    def _MaximumItemsHasChanged(self, event):
        #update the data cloud to have the maximum items and save to the memory datacloud.
        self.__maxItemsTuple[1] = self.tb1.GetValue();

    def _SearchTypeHasChanged(self, event):
        self.__searchTypeTuple[1] = self.dd1.GetString(self.dd1.GetSelection());

        if self.__searchTypeTuple[1] == "Sorted":
            self.dd2.Enable(true);
            self.dd3.Enable(true);
            #make sure to update our hidden form field text
            self.__sortingTuple[1] = '<input type="hidden" name="sorting" value="' + self.__searchTypeOptions_Sorting[2] + self.__searchTypeOptions_Sorting[1] + '">';

        elif self.__searchTypeTuple[1] == "Ranked":
            self.dd2.Enable(false);
            self.dd3.Enable(false);            

            #make sure to update our hidden form field text
            self.__sortingTuple[1] = '<input type="hidden" name="sorting" value="BYRELEVANCE">';

        print self.__sortingTuple[1];
            
    def _SortFieldHasChanged(self, event):
        self.__searchTypeOptions_Sorting[1] = self.dd2.GetString(self.dd2.GetSelection());
        self.__sortingTuple[1] = '<input type="hidden" name="sorting" value="' + self.__searchTypeOptions_Sorting[2] + self.__searchTypeOptions_Sorting[1] + '">';

        print self.__sortingTuple[1];
        
    def _SortFieldOrderHasChanged(self, event):
        if self.dd3.GetString(self.dd3.GetSelection()) == "Sort Ascending":
            self.__searchTypeOptions_Sorting[2] = "";
        elif self.dd3.GetString(self.dd3.GetSelection()) == "Sort Descending":
            self.__searchTypeOptions_Sorting[2] = "-";

        #make sure to updat ethe hidden form field text.
        self.__sortingTuple[1] = '<input type="hidden" name="sorting" value="' + self.__searchTypeOptions_Sorting[2] + self.__searchTypeOptions_Sorting[1] + '">';

        print self.__sortingTuple[1];
        
    def _HeadwordHasChanged(self, event):
        #update the headword parameter and save to the memory datacloud.
        if self.cb1.GetValue() == 1:
            self.__headwordTuple[1] = "ON";
        else:
            self.__headwordTuple[1] = "OFF";

class SearchGUIApp(wxApp):
    def OnInit(self):
        frame = SearchGUI(NULL, "Search Generator");
        frame.show();
        self.SetTopWindow(frame)
        return true

if __name__ == "__main__":
        #load the data cloud
	import DataCloud
	DataCloud.instance().load("eas");

	#---------------------------------------------
	# Create and run our main app
	#---------------------------------------------
        ScreenLogGUI.displayScreenLog();
        app = SearchGUIApp(0);
	app.MainLoop()

