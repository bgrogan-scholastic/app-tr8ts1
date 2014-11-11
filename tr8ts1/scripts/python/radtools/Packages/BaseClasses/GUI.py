from wxPython.wx import *
import string
import sys
sys.path.append("/home/qadevWS/python/radtools/Packages");
from Mediator import *
from Colleague import *
from subject import Subject
from observer import Observer
from Controls.CheckBox import *
from Controls.TextBox import *
from Controls.RadioBox import *
from Controls.Button import *
from Controls.DropDownList import *
from Controls.ScreenLog import *
import DataCloud

import Log

class GUI(wxFrame, Mediator, Observer):
    count = 0;
    def __init__(self, parentWindow, title, windowsize=(500,700)):
        GUI.count = GUI.count + 1;
        self.myID = wxNewId();
        self.windowsize = windowsize

        wxFrame.__init__(self, parentWindow, self.myID, title, wxDefaultPosition, windowsize, wxDEFAULT_FRAME_STYLE | wxSTAY_ON_TOP | wxRESIZE_BORDER);
        Mediator.__init__(self);
        Observer.__init__(self);
        self.setBasicLook();
        
        EVT_CLOSE(self, self.cancel);

        self._colleagueMap = {};

        self.showLogHistory = false;
        #make this an observer
        Observer.__init__(self);
        #attach thyself to the Subject.
        guiDC = DataCloud.instance();
        guiDC.attach(self);
        
    def __del__(self):
        print "GUI::__del__";
        GUI.count = GUI.count - 1;
        DataCloud.instance().detach(self);
        Observer.__del__(self);
        Mediator.__del__(self);

    #you implement this in your derived class.
    def update(self):
        pass

    def setBasicLook(self):
        [self.SaveNExitButtonID, self.CancelButtonID, self.PreviewTemplatesButtonID, self.HelpButtonID] =  map(lambda init: wxNewId(), range(4))
        self.bordersize = 10;
        self.panel = wxPanel(self, -1, wxDefaultPosition, wxDefaultSize);
        self.panel.SetBackgroundColour(wxWHITE);
        #self.panel.SetForegroundColour(wxBLACK);
        self.panel.SetForegroundColour(gControlBGColor);
        self.statusbar = self.CreateStatusBar()
        self.statusbar.SetStatusText("This is the statusbar");
        
    def load(self):
        pass

    def save(self, event):
        mesg = wxMessageDialog(self, "Do you want to save your changes and exit?","Confirm", wxYES_NO | wxYES_DEFAULT | wxCENTER | wxICON_QUESTION);
        if (mesg.ShowModal()== wxID_YES):
            if (self._save() == true):
                DataCloud.instance().detach(self);
                self.Destroy();

    def preview(self, event):
        pass;
    
    def help(self, event):
        pass;

    def doGroundWork(self):
        pass

    def getPassword(self, host, username):

        password = DataCloud.instance().getMachinePassword(host, username);

        if password != None:
            return password;
        else:
            mypassword = "";
            
            while len(mypassword) == 0:
                myTextEntryDialog = wxTextEntryDialog(NULL,
                                                  "Please enter the " + \
                                                  "password for user: " + \
                                                  username + " on machine: " + host,
                                                  "Password Prompt", style = wxOK| wxTE_PASSWORD)

                myModalPtr = myTextEntryDialog.ShowModal()
                myTextEntryDialog.Destroy()

                mypassword = myTextEntryDialog.GetValue()

            DataCloud.instance().setMachinePassword(host, username, mypassword);

            return mypassword;

    def show(self, showbuttons=true):
        guimainsizer = wxBoxSizer(wxVERTICAL);
        usersizer = self._show();
        guimainsizer.Add(usersizer,2, wxALL | wxEXPAND | wxALIGN_CENTER, self.bordersize);
        if (showbuttons==true):
            self.buttonsizer = wxBoxSizer(wxHORIZONTAL);
            
            self.saveandexitbutton = Button(self.panel, self, self.SaveNExitButtonID, "Sa&ve and Exit");
            self.cancelbutton = Button(self.panel, self, self.CancelButtonID, "&Cancel");
            self.previewbutton = Button(self.panel, self, self.PreviewTemplatesButtonID, "Pre&view Templates");
            self.helpbutton = Button(self.panel, self, self.HelpButtonID, "Help");
            
            self.buttonsizer.Add(self.saveandexitbutton, option = 0, flag = wxALL, border = self.bordersize);
            self.buttonsizer.Add(self.cancelbutton, option = 0, flag = wxALL, border = self.bordersize);
            self.buttonsizer.Add(self.helpbutton, option = 0, flag = wxALL, border = self.bordersize);
            self.buttonsizer.Add(self.previewbutton, option = 0, flag = wxALL, border = self.bordersize);

            #build mapping of controls into function all dictionary
            myColleagueMap = { self.saveandexitbutton : self.save,
                                    self.cancelbutton : self.cancel,
                                    self.previewbutton : self.preview,
                                    self.helpbutton : self.help
                                };

            self._colleagueMap.update(myColleagueMap);
            
            #if the second argument is 0, the sizer will snap fit the elements in the sizer exactly, not much padding.
            #if the second argument is 1, the sizer will give it the appropriate weighting.
            guimainsizer.Add(self.buttonsizer, 0,  wxALL | wxALIGN_CENTER, self.bordersize);

        guimainsizer.SetMinSize(self.windowsize);
        self.panel.SetSizer(guimainsizer)
        self.panel.SetAutoLayout(1);
        guimainsizer.Fit(self)
        guimainsizer.Layout();
        self.Show(true);
        
    def _show(self):
        pass
    
    def cancel(self, event):
        mesg = wxMessageDialog(self, "You have not saved your changes. Do you wish to continue?","Confirm", wxYES_NO | wxYES_DEFAULT | wxCENTER | wxICON_QUESTION);
        if (mesg.ShowModal()== wxID_YES):
            #self.MakeModal(false);
            DataCloud.instance().rollback();
            #print "detaching from DC.";
            DataCloud.instance().detach(self);            
            self.Destroy()
            return true
        else:
            return false


class ScreenLogGUI(GUI):
    def __init__(self, parentWindow, title):
        GUI.__init__(self, parentWindow, title);
        self.myID = wxNewId();
        self.__inProcess = false;
        
    def __del__(self):
        GUI.__del__(self);

    def load(self):
        pass       

    def _save(self):
        pass

    #you implement this in your derived class.
    def update(self):
        pass

    def preview(self, event):
        pass

    def cancel(self, event):
        GUI.cancel(self, event);
    
    def _show(self):
        self.statusbar.SetStatusText("Single Log Window");
        #set up all of the controls;
        mainsizer = wxBoxSizer(wxVERTICAL);
        self.ScreenLogWindow = ScreenLog(Log.instance(), self.panel, self);
        mainsizer.Add(self.ScreenLogWindow, 1, wxALL | wxALIGN_CENTER | wxEXPAND,  border = self.bordersize);
        self.Move((100, 50));
        self.Layout();
        return mainsizer;


class GUIApp(wxApp):
   def OnInit(self):
        frame = GUI(NULL, "Test GUI Frame");
        print "gui count: " + str(GUI.count);
        frame.Show(true)
        self.SetTopWindow(frame)
        return true

#---------------------------------------------
# Create and run our main app
#---------------------------------------------
if __name__ == "__main__":
    gapp = GUIApp(0);
    gapp.MainLoop();
    print "gui count after loop: " + str(GUI.count);
