from wxPython.wx import *
import string
import sys
sys.path.append("/home/qadevWS/python/radtools/Packages")
from DataCloud import *
from Product import *
from ApacheServer import *
from BaseClasses.Mediator import *
from BaseClasses.observer import Observer
from BaseClasses.GUI import *
from BaseClasses.Colleague import *
from Controls.giValidator import *
import ScreenLogGUI
from TemplateGUI import *
from DataLoadGUI import *
from ReleaseGUI import *
from Release import *
class RadGUI(GUI):
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:  Constructor
    # Author:    Diane Langlois
    # Date:      April 15, 2003
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def __init__(self, parentWindow, title):
        GUI.__init__(self, parentWindow, title, (500,400))
        self.bordersize=5
        self._parentWindow = parentWindow
        self.__inProcess = false
        self._pcode = "";
        ScreenLogGUI.displayScreenLog()

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
        self.statusbar.SetStatusText("Rapid Application Development (RAD) GUI")

        # default sizes for Text and Buttons so everything lines up right.
        self._buttonSize = wxSize(175,25)
        self._codeSize = wxSize(50,25)
        self._titleSize = wxSize(150,25)

        # IDs for all the controls.
        [self._createButtonID, self._labelID1, self._labelID2,
         self._labelID3,self._pcodeTBID1, self._ptitleTBID,
         self._pauthTBID,self._exitButtonID, self._instructionLabelID,
         self._editButtonID,self._pcodeTBID2,self._deleteButtonID,
         self._pcodeTBID3,self._dataLoadButtonID,self._pcodeTBID4,
         self._releaseButtonID, self._pcodeTBID5] = map(lambda init: wxNewId(), range(17))

        #Tell the User what to do
        self._instructionLabel = wxStaticText(self.panel, self._instructionLabelID, "Pre-enter all information requested for your selection before clicking the button")


        #The Create Product Row
        self._createButton = Button(self.panel, self, self._createButtonID, "Create a Product",self._buttonSize)
        self._label1 = wxStaticText(self.panel,self._labelID1,"Product\nCode (ID)")
        self._pcodeTB1 = TextBox(self.panel, self, self._pcodeTBID1, wxTE_LEFT, "",giValidator(ALPHA_DIGIT_ONLY),mySize = self._codeSize)

        groupSizer1 = wxBoxSizer(wxVERTICAL)
        groupSizer1.Add(self._label1,0, flag=wxALL | wxALIGN_TOP | wxALIGN_LEFT, border=0)
        groupSizer1.Add(self._pcodeTB1,0, flag=wxALL | wxALIGN_TOP | wxALIGN_LEFT, border=1)

        self._label2 = wxStaticText(self.panel,self._labelID2,"Product\nTitle")
        self._ptitleTB = TextBox(self.panel, self, self._ptitleTBID, wxTE_LEFT, "",mySize = self._titleSize)

        groupSizer2 = wxBoxSizer(wxVERTICAL)
        groupSizer2.Add(self._label2,0, flag=wxALL | wxALIGN_TOP | wxALIGN_LEFT, border=0)
        groupSizer2.Add(self._ptitleTB,0, flag=wxALL | wxALIGN_TOP | wxALIGN_LEFT, border=1)

        self._label3 = wxStaticText(self.panel,self._labelID3,"Authentication\nCode")
        self._pauthTB = TextBox(self.panel, self, self._pauthTBID, wxTE_LEFT, "",mySize = self._codeSize)
        groupSizer3 = wxBoxSizer(wxVERTICAL)
        groupSizer3.Add(self._label3,0, flag=wxALL | wxALIGN_TOP | wxALIGN_LEFT, border=0)
        groupSizer3.Add(self._pauthTB,0, flag=wxALL | wxALIGN_TOP | wxALIGN_LEFT, border=1)

        # The Edit Product Row
        self._editButton = Button(self.panel, self, self._editButtonID, "Edit a RAD Product",self._buttonSize)
        self._pcodeTB2 = TextBox(self.panel, self, self._pcodeTBID2, wxTE_LEFT, "",mySize = self._codeSize)

        # The Delete Product Row
        self._deleteButton = Button(self.panel, self, self._deleteButtonID, "Delete a RAD Product",self._buttonSize)
        self._pcodeTB3 = TextBox(self.panel, self, self._pcodeTBID3, wxTE_LEFT, "",mySize = self._codeSize)

        # The Data Load Row
        self._dataLoadButton = Button(self.panel, self, self._dataLoadButtonID, "Process Data for a Product",self._buttonSize)
        self._pcodeTB4 = TextBox(self.panel, self, self._pcodeTBID4, wxTE_LEFT, "",mySize = self._codeSize)

        # The Release Row 
        self._releaseButton = Button(self.panel, self, self._releaseButtonID, "Release a Product",self._buttonSize)
        self._pcodeTB5 = TextBox(self.panel, self, self._pcodeTBID5, wxTE_LEFT, "",mySize = self._codeSize)


        # The last row of buttons
        self._exitButton = Button(self.panel, self, self._exitButtonID, "E&xit")

        rowSizer1 = wxBoxSizer(wxHORIZONTAL)
        rowSizer2 = wxBoxSizer(wxHORIZONTAL)
        rowSizer3 = wxBoxSizer(wxHORIZONTAL)
        rowSizer4 = wxBoxSizer(wxHORIZONTAL)
        rowSizer5 = wxBoxSizer(wxHORIZONTAL)
        
        # for anything that must be on the bottom of the panel
        rowSizerLast = wxBoxSizer(wxHORIZONTAL)
        rowSizer1.Add(self._createButton,0, flag = wxALL | wxALIGN_BOTTOM | wxALIGN_LEFT, border=4)
        rowSizer1.Add(groupSizer1,0, flag = wxALL | wxALIGN_TOP | wxALIGN_LEFT, border=2)
        rowSizer1.Add(groupSizer2,0, flag = wxALL | wxALIGN_LEFT, border=2)
        rowSizer1.Add(groupSizer3,0, flag = wxALL | wxALIGN_LEFT, border=2)

        rowSizer2.Add(self._editButton,0, flag = wxALL | wxALIGN_BOTTOM | wxALIGN_LEFT, border =4)
        rowSizer2.Add(self._pcodeTB2,0, flag = wxALL | wxALIGN_LEFT, border=2)
        rowSizer3.Add(self._deleteButton,0, flag = wxALL | wxALIGN_BOTTOM | wxALIGN_LEFT, border =4)
        rowSizer3.Add(self._pcodeTB3,0, flag = wxALL | wxALIGN_LEFT, border=2)
        rowSizer4.Add(self._dataLoadButton,0, flag = wxALL | wxALIGN_BOTTOM | wxALIGN_LEFT, border =4)
        rowSizer4.Add(self._pcodeTB4,0, flag = wxALL | wxALIGN_LEFT, border=2)

        rowSizer5.Add(self._releaseButton,0, flag = wxALL | wxALIGN_BOTTOM | wxALIGN_LEFT, border =4)
        rowSizer5.Add(self._pcodeTB5,0, flag = wxALL | wxALIGN_LEFT, border=2)


        rowSizerLast.Add(self._exitButton,0, flag = wxALL | wxALIGN_RIGHT, border=self.bordersize)

        mainSizer.Add(self._instructionLabel,0, flag=wxALL | wxALIGN_LEFT, border=self.bordersize)
        mainSizer.Add(rowSizer1,0, flag=wxALL | wxEXPAND | wxALIGN_LEFT, border=self.bordersize)
        mainSizer.Add(rowSizer2,0, flag=wxALL | wxALIGN_LEFT, border=self.bordersize)
        mainSizer.Add(rowSizer3,0, flag=wxALL | wxALIGN_LEFT, border=self.bordersize)
        mainSizer.Add(rowSizer4,0, flag=wxALL | wxALIGN_LEFT, border=self.bordersize)
        mainSizer.Add(rowSizer5,0, flag=wxALL | wxALIGN_LEFT, border=self.bordersize)
        mainSizer.Add(rowSizerLast,0, flag=wxALL | wxALIGN_RIGHT, border=self.bordersize)

        myColleagueMap = { self._createButton : self._createButtonClicked,
                           self._editButton : self._editButtonClicked,
                           self._deleteButton : self._deleteButtonClicked,
                           self._dataLoadButton : self._dataLoadButtonClicked,
                           self._releaseButton : self._releaseButtonClicked,
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
    # Function:    _createButtonClicked
    # Author:      Diane Langlois
    # Date:        April 15, 2003
    # Description: This method is called when the "create" button
    # is clicked.  Data is saved to the datacloud, message logging
    # takes place, and the product itself is created through the
    # use of a setup XML set of instructions.  Then the TemplateGUI
    # is opened and control is passed on.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def _createButtonClicked(self,event):
        self._pcode = self.getValue(self._pcodeTB1,self._label1.GetLabel())
        ptitle = self.getValue(self._ptitleTB,self._label2.GetLabel())
        auth = self.getValue(self._pauthTB,self._label3.GetLabel())
        #The pcode is a required field to complete the edit.
        if self._pcode != "" and ptitle != "" and auth != "":
            Log.instance().add("You've Selected to Add a New RAD Product")
            dc = DataCloud.instance()
            dc.add("pcode",self._pcode)
            dc.add("ptitle",ptitle)
            dc.add("pauth",auth)
	    Log.instance().add("Value for pauth is " + DataCloud.instance().value("pauth"));

            dbpassword = self.getPassword("stress1", "mysqldba")
            dc = DataCloud.instance()
            dc.add("dba",dbpassword)

            Log.instance().add("Adding webserver for "+self._pcode)
            as = ApacheServer()
            #Add new webserver (Add Data for ApacheServer)
            as.createServer()

            #create directory structures & databases
            p = Product(self,self._pcode)
            p.processSteps("/productsetup")

            # create appropriate release xml file
            radrelease = Release(DataCloud.instance().value('pcode'))
            radrelease.addRadProduct(DataCloud.instance().value('portnumber'))
            
            #start webserver now, directories are created.
            Log.instance().add("Starting webserver for "+self._pcode)
            as.restartServer()

            ### Startup TemplateGUI.py and close.
            frame = TemplateGUI(self, "Generate RAD Templates")
            frame.show(false)
            self.Hide()
        pass

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:    _releaseButtonClicked
    # Author:      Tyrone Mitchell
    # Date:        June 12, 2003
    # Description: This method is called when the "release" button
    # is clicked.  Data is loaded to the datacloud, message logging
    # takes place, and the product itself is loaded from files, and
    # the TemplateGUI is opened and control is passed on.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def _releaseButtonClicked(self,event):
        self._pcode = self.getValue(self._pcodeTB5,self._label1.GetLabel())
        #The pcode is a required field to complete the edit.
        if self._pcode != "":
            message = "Preparing to release the " + self._pcode + " RAD product."
            Log.instance().add(message, Log.instance().bitMaskCriticalAll())
            self._setupEditMode()
            ### Startup ReleaseGUI.py and close.
            frame = ReleaseGUI(self, "Generate RAD Templates")
            frame.show(false)
            self.Hide()

    

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:    _editButtonClicked
    # Author:      Diane Langlois
    # Date:        April 15, 2003
    # Description: This method is called when the "edit" button
    # is clicked.  Data is loaded to the datacloud, message logging
    # takes place, and the product itself is loaded from files, and
    # the TemplateGUI is opened and control is passed on.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def _editButtonClicked(self,event):
        self._pcode = self.getValue(self._pcodeTB2,self._label1.GetLabel())
        #The pcode is a required field to complete the edit.
        if self._pcode != "":
            message = "Editing the " + self._pcode + " RAD product."
            Log.instance().add(message, Log.instance().bitMaskCriticalAll())
            self._setupEditMode()
            ### Startup TemplateGUI.py and close.
            frame = TemplateGUI(self, "Generate RAD Templates")
            frame.show(false)
            self.Hide()
        pass

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:    _setupEditMode
    # Author:      Diane Langlois
    # Date:        April 17, 2003
    # Description: This method is called to setup datacloud
    # parameters when in "edit" mode.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def _setupEditMode(self):
            dc = DataCloud.instance()
            #Load data for this pcode and continue
            dc.add("pcode",self._pcode)
            dc.load(self._pcode)
            dc.addNS("mode","edit")
            pass

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:    _dataLoadButtonClicked
    # Author:      Diane Langlois
    # Date:        April 15, 2003
    # Description: This method is called when the "load data" button
    # is clicked.  This will open the DataLoadGUI and pass control.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def _dataLoadButtonClicked(self,event):
        self._pcode = self.getValue(self._pcodeTB4,self._label1.GetLabel())
        #The pcode is a required field to complete the data load.
        if self._pcode != "":
            message = "Loading Data for the " + self._pcode + " RAD product."
            Log.instance().add(message, Log.instance().bitMaskCriticalAll())
            self._setupEditMode()
            ### Startup DataLoadGUI.py and close.
            frame = DataLoadGUI(self, "Load Data for a RAD Product")
            frame.show(false)
            self.Hide()
        pass

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:    _deleteButtonClicked
    # Author:      Diane Langlois
    # Date:        April 15, 2003
    # Description: This method is called when the "delete" button
    # is clicked.  A set of XML instructions take place that
    # deletes the webserver, all delivery and product directories,
    # as well as the databases.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def _deleteButtonClicked(self,event):
        self._pcode = self.getValue(self._pcodeTB3,self._label1.GetLabel())
        DataCloud.instance().add("pcode",self._pcode)
        #The pcode is a required field to complete the delete.
        if self._pcode != "":
            #Make sure the user is aware of what is about to happen.
            dlg = wxMessageDialog(self, "You will be deleting the " + self._pcodeTB3.GetValue() + " product.  Are you sure?", "Delete Confirmation", wxYES_NO | wxYES_DEFAULT | wxCENTER | wxICON_QUESTION)
            if (dlg.ShowModal()== wxID_YES):
                Log.instance().add("Deleting the " + self._pcode + " RAD product.", Log.instance().bitMaskCriticalAll() )
                
                dbpassword = self.getPassword("stress1", "mysqldba")
                dc = DataCloud.instance()
                dc.add("dba",dbpassword)
                
                self._product = Product(self,self._pcode)
                self._product.processSteps("/productremove")
                Log.instance().add(self._pcode + " has been deleted", Log.instance().bitMaskCriticalAll() )
                Log.instance().add("Deleting webserver for "+self._pcode)
                as = ApacheServer()
                as.deleteServer(self._pcode)
                as.restartServer()
                DataCloud.instance().clear()
            else:
                Log.instance().add(self._pcode + " will NOT be deleted", Log.instance().bitMaskCriticalAll())
        pass

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:    getValue
    # Author:      Diane Langlois
    # Date:        April 15, 2003
    # Description: This method is to ensure a value is entered
    # in all required fields.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def getValue(self,control,label):
        val = control.GetValue()
        if val == "":
            dlg = wxMessageDialog(self, "You must enter a value in the " + label + " box to continue", "Blank Value Found", wxOK | wxCENTRE, wxDefaultPosition)
            dlg.ShowModal()
        return val

    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Function:    _exitButtonClicked
    # Author:      Diane Langlois
    # Date:        April 15, 2003
    # Description: This method is called when the "exit" button
    # is clicked.  All relevant data is saved to file and the
    # application ends.
    #++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    def _exitButtonClicked(self,event):
        mesg = wxMessageDialog(self, "Do you wish to save all your changes?","Yes", wxYES_NO | wxYES_DEFAULT | wxCENTER | wxICON_QUESTION)
        if (mesg.ShowModal()== wxID_YES):
            if (self._pcode != ""):
                DataCloud.instance().save(self._pcode)
            else:
                print "You haven't made any changes to save.";
            DataCloud.instance().detach(self)
            ScreenLogGUI.closeScreenLog()
            self.Destroy()
        else:
            DataCloud.instance().detach(self)
            ScreenLogGUI.closeScreenLog()
            self.Destroy()

    def load(self):
        pass

    def save(self):
        pass

    def cancel(self, event):
        self._exitButtonClicked(event)





###########################################################
#  Standalone test
class RadGUIApp(wxApp):
    def OnInit(self):
        frame = RadGUI(NULL, "Rapid Application Development (RAD)")
        frame.show(0)  #tell show not to use the default action buttons.
        self.SetTopWindow(frame)
        return true

#---------------------------------------------
# Create and run our main app
#---------------------------------------------
if __name__ == "__main__":
    app = RadGUIApp(0)
    app.MainLoop()
