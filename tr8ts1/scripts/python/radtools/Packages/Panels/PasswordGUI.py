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

class PasswordGUI(GUI):
    def __init__(self, parentWindow, title, headerText):
        GUI.__init__(self, parentWindow, title, wxSize(400,100));
	self._sheaderText = headerText;        
        self.__inProcess = false;

    def __del__(self):
        GUI.__del__(self);

    def load(self):
        pass;
    
    def cancel(self, event):
        GUI.cancel(self, event);

    def _save(self):
	pass;
    def preview(self, event):
       pass;
 
    def help(self, event):
	pass;
    
    def _show(self):

        self.statusbar.SetStatusText("Password");
        #set up all of the controls;
        mainsizer = wxBoxSizer(wxVERTICAL);

        #give the screen a header
        mainsizer.Add(wxStaticText(self.panel, -1, self._sheaderText, wxDefaultPosition, wxDefaultSize), option = 0, flag = wxALL, border = self.bordersize);

        #create the ids for each element on the page.
        [tb1ID, tb2ID] = map(lambda x: wxNewId(), range(2));

        
        #username section
        usernameSizer = wxBoxSizer(wxHORIZONTAL);
        usernameSizer.Add(wxStaticText(self.panel, -1, "Username:"), option = 0, flag = wxALL, border = self.bordersize);
        self.tb1 = TextBox(self.panel, self, tb1ID, wxTE_RIGHT, "");
        usernameSizer.Add(self.tb1, option = 0, flag =  wxALL,  border = self.bordersize);        
        mainsizer.Add(usernameSizer, option = 0, flag = wxTE_LEFT ,  border = self.bordersize);


        passwordSizer = wxBoxSizer(wxHORIZONTAL);
        passwordSizer.Add(wxStaticText(self.panel, -1, "Password:"), option = 0, flag = wxALL, border = self.bordersize);
        self.tb2 = TextBox(self.panel, self, tb2ID, wxTE_RIGHT, "");
        passwordSizer.Add(self.tb2, option = 0, flag =  wxALL,  border = self.bordersize);        
        mainsizer.Add(passwordSizer, option = 0, flag = wxTE_LEFT ,  border = self.bordersize);

        #build mapping of controls into function all dictionary
        myKeys = {};
        
        myColleagueMap = { self.tb1 : self._UsernameHasChanged,
                           self.tb2 : self._PasswordHasChanged
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

    def _UsernameHasChanged(self, event):
	pass;

    def _PasswordHasChanged(self, event):
	pass;

class PasswordGUIApp(wxApp):
    def OnInit(self):
        frame = PasswordGUI(NULL, "Login Information", "Please enter your username and password for qadev");
        frame.show(0);
        self.SetTopWindow(frame)
        return true

if __name__ == "__main__":
        #load the data cloud
	import DataCloud
	DataCloud.instance().load("radtest");

	#---------------------------------------------
	# Create and run our main app
	#---------------------------------------------
        ScreenLogGUI.displayScreenLog();
        app = PasswordGUIApp(0);
	app.MainLoop()

