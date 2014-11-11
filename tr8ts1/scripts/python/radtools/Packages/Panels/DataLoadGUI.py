from wxPython.wx import *
import string
import sys
sys.path.append("/home/qadevWS/python/radtools/Packages")
from DataCloud import *
from Product import *
from BaseClasses.Mediator import *
from BaseClasses.observer import Observer
from BaseClasses.GUI import *
from BaseClasses.Colleague import *
import ScreenLogGUI

class DataLoadGUI(GUI):
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:  Constructor
    # Author:    Diane Langlois
    # Date:      April 15, 2003
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def __init__(self, parentWindow, title):
        GUI.__init__(self, parentWindow, title, (450,300))
        self.bordersize=5
        self._parentWindow = parentWindow
        self.__inProcess = false
        self._pcode = DataCloud.instance().value("pcode")
        self._product = Product(self,self._pcode)

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:  Destructor
    # Author:    Diane Langlois
    # Date:      April 15, 2003
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def __del__(self):
        GUI.__del__(self)

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:    _show
    # Author:      Diane Langlois
    # Date:        April 15, 2003
    # Description: Called by Base class. Sets up and Displays
    # screen elements.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def _show(self):
        # set up the outer most window sizer
        mainSizer = wxBoxSizer(wxVERTICAL)
        self.statusbar.SetStatusText("Load Data for Rapid Application Development (RAD) GUI")

        # default sizes for Text and Buttons so everything lines up right.
        self._buttonSize = wxSize(200,25)
        self._codeSize = wxSize(50,25)
        self._titleSize = wxSize(150,25)

        # IDs for all the controls.
        [self._loadDBButtonID,self._exitButtonID, self._instructionLabelID,
         self._validateDeliveryButtonID, self._indexPlwebButtonID,
         self._validateDatabaseButtonID,
         self._prebuildButtonID,self._distributeButtonID] = map(lambda init: wxNewId(), range(8))

        #Tell the User what to do
        self._instructionLabel = wxStaticText(self.panel, self._instructionLabelID, "Before making a selection, be sure the relevant data has been delivered.")


        #The Load DataBase Product Row
        self._loadDBButton = Button(self.panel, self, self._loadDBButtonID, "Load Database Delivery",self._buttonSize)

        # The RunPrebuild Product Row
        self._prebuildButton = Button(self.panel, self, self._prebuildButtonID, "Prebuild all text",self._buttonSize)

        # The Run Plweb index on QADEV Row
        self._indexPlwebButton = Button(self.panel, self, self._indexPlwebButtonID, "Index Search Engine",self._buttonSize)

        # The Validate Database Delivery Row
        self._validateDeliveryButton = Button(self.panel, self, self._validateDeliveryButtonID, "Validate Database Deliveries",self._buttonSize)

        # The Validate Database Row
        self._validateDatabaseButton = Button(self.panel, self, self._validateDatabaseButtonID, "Validate Database Records",self._buttonSize)

        # The Distribute Asset Row
        self._distributeButton = Button(self.panel, self, self._distributeButtonID, "Distribute Assets",self._buttonSize)

        # The last row of buttons
        self._exitButton = Button(self.panel, self, self._exitButtonID, "Back to Main Menu")

        mainSizer.Add(self._instructionLabel,0, flag=wxALL | wxALIGN_LEFT, border=self.bordersize)
        mainSizer.Add(self._validateDeliveryButton,0, flag=wxALL | wxALIGN_CENTER, border=self.bordersize)
        mainSizer.Add(self._loadDBButton,0, flag=wxALL | wxALIGN_CENTER, border=self.bordersize)
        mainSizer.Add(self._validateDatabaseButton,0, flag=wxALL | wxALIGN_CENTER, border=self.bordersize)
        mainSizer.Add(self._prebuildButton,0, flag=wxALL | wxALIGN_CENTER, border=self.bordersize)
        mainSizer.Add(self._indexPlwebButton,0, flag=wxALL | wxALIGN_CENTER, border=self.bordersize)
        mainSizer.Add(self._distributeButton,0, flag=wxALL | wxALIGN_CENTER, border=self.bordersize)
        mainSizer.Add(self._exitButton,0, flag=wxALL | wxALIGN_BOTTOM | wxALIGN_RIGHT, border=self.bordersize)
        myColleagueMap = { self._validateDeliveryButton : self._validateDeliveryButtonClicked,
                           self._loadDBButton : self._loadDBButtonClicked,
                           self._validateDatabaseButton : self._validateDatabaseButtonClicked,
                           self._prebuildButton : self._prebuildButtonClicked,
                           self._indexPlwebButton : self._indexPlwebButtonClicked,
                           self._distributeButton : self._distributeButtonClicked,
                           self._exitButton : self._exitButtonClicked
                           }
        self._colleagueMap.update(myColleagueMap)
        mainSizer.Add(self, option=0, flag=wxALL | wxALIGN_LEFT, border=self.bordersize)
        return mainSizer

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:    _ColleagueChanged
    # Author:      Diane Langlois
    # Date:        April 15, 2003
    # Description: Called by Base class when one of the screen
    # elements receives an event. This is the mediator portion
    # of a colleague/mediator pattern.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # This is the mediator action.
    def _ColleagueChanged(self, colleague, event):
        """This method gets called when one of the colleagues has changed.
        This is the central 'clearing' house for all changes and orchestrates
        these changes among the cooperating controls"""
        # don't get recursive on us
        if self.__inProcess != true:
            self.__inProcess = true

            # call the cooresponding method directly using a map lookup
	    if self._colleagueMap.has_key(colleague):
                self._colleagueMap[colleague](event)
            self.__inProcess = false

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:    _loadDBButtonClicked
    # Author:      Diane Langlois
    # Date:        April 15, 2003
    # Description: This method is called when the "loadDB" button
    # is clicked.  Database deliveries are loaded into the existing
    # tables. Load Scripts listed in the XML file are run.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def _loadDBButtonClicked(self,event):
        Log.instance().add("Loading database records for "+self._pcode)
        self._product.processSteps("/loaddatabase")
        Log.instance().add("Load Complete")
        pass

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:    _validateDeliveryButtonClicked
    # Author:      Diane Langlois
    # Date:        April 15, 2003
    # Description: This method is called when the "prebuild" button
    # is clicked.  Data is loaded to the datacloud, message logging
    # takes place, and the product itself is loaded from files, and
    # the TemplateGUI is opened and control is passed on.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def _validateDeliveryButtonClicked(self,event):
        Log.instance().add("Validating database records loaded for "+self._pcode)
        self._product.processSteps("/validatedatabasedeliveries")
        Log.instance().add("Validation Complete")
        pass

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:    _validateDatabaseButtonClicked
    # Author:      Diane Langlois
    # Date:        April 15, 2003
    # Description: This method is called when the "prebuild" button
    # is clicked.  Data is loaded to the datacloud, message logging
    # takes place, and the product itself is loaded from files, and
    # the TemplateGUI is opened and control is passed on.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def _validateDatabaseButtonClicked(self,event):
        Log.instance().add("Validating database records loaded for "+self._pcode)
        self._product.processSteps("/validatedatabase")
        Log.instance().add("Validation Complete")
        pass

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:    _prebuildButtonClicked
    # Author:      Diane Langlois
    # Date:        April 15, 2003
    # Description: This method is called when the "prebuild" button
    # is clicked.  Data is loaded to the datacloud, message logging
    # takes place, and the product itself is loaded from files, and
    # the TemplateGUI is opened and control is passed on.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def _prebuildButtonClicked(self,event):
        Log.instance().add("Prebuilding all text deliveries for "+self._pcode)
        self._product.processSteps("/prebuildall")
        Log.instance().add("Prebuild Complete")
        Log.instance().add("You will need to reindex PLWeb for searching to resume.",Log.instance().bitMaskCriticalAll())
        pass

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:    _indexPlwebButtonClicked
    # Author:      Diane Langlois
    # Date:        April 15, 2003
    # Description: This method is called when the "index plweb" button
    # is clicked.  A telnet session is opened and the plweb indexing
    # script is executed.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def _indexPlwebButtonClicked(self,event):
        Log.instance().add("Indexing all searchable text built for "+self._pcode)
        self._product.processSteps("/indexplweb")
        Log.instance().add("Indexing Complete")
        pass

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:    _distributeButtonClicked
    # Author:      Diane Langlois
    # Date:        April 15, 2003
    # Description: This method is called when the "distribute" button
    # is clicked.  A set of XML instructions take place that
    # distributes the webserver, all delivery and product directories,
    # as well as the databases.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def _distributeButtonClicked(self,event):
        Log.instance().add("Distributing all media assets for "+self._pcode)
        self._product.processSteps("/distributeall")
        Log.instance().add("Distribution Complete")
        pass

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:    _exitButtonClicked
    # Author:      Diane Langlois
    # Date:        April 15, 2003
    # Description: This method is called when the "exit" button
    # is clicked.  All relevant data is saved to file and the
    # application ends.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def _exitButtonClicked(self,event):
        DataCloud.instance().detach(self);
        if self._parentWindow != NULL:
            self._parentWindow.Show()
        self.Destroy()

    def load(self):
        pass

    def save(self):
        pass

    def cancel(self, event):
        self._exitButtonClicked(event)





###########################################################
#  Standalone test
class DataLoadGUIApp(wxApp):
    def OnInit(self):
        DataCloud.instance().add("pcode","eas")
        frame = DataLoadGUI(NULL, "Load Data for (RAD)")
        frame.show(0)  #tell show not to use the default action buttons.
        self.SetTopWindow(frame)
        return true

#---------------------------------------------
# Create and run our main app
#---------------------------------------------
if __name__ == "__main__":
    app = DataLoadGUIApp(0)
    app.MainLoop()
