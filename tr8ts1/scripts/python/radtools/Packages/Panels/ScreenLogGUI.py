from wxPython.wx import *
import string
import sys
sys.path.append("/home/qadevWS/python/radtools/Packages");
from BaseClasses.Mediator import *
from BaseClasses.observer import Observer
from BaseClasses.GUI import *
from BaseClasses.Colleague import *
from Controls.giValidator import *
from FeatureTemplateShells import *
from Controls.DropDownList import *
from Controls.ScreenLog import *
from Features import *
import Log
from TemplateController import *

class ScreenLogGUI(GUI):
    slFrame = None;    
    def __init__(self, parentWindow, title):
        GUI.__init__(self, parentWindow, title, wxSize(600, 200));
        self.myID = wxNewId();
        self.__inProcess = false;
        Log.instance().attach(self);
        
    def __del__(self):
        GUI.__del__(self);

    def load(self):
        pass       

    def _save(self):
        pass

    #you implement this in your derived class.
    def update(self):
        (status, warn, crit) = Log.instance().getCounts();
        self.statusbar.SetStatusText("Messages recorded: Critical: " +str(crit) + ", Warnings: " +str(warn) + ", Status: " + str(status));

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
        self.Move((50, 50));
        self.Layout();
        return mainsizer;

def displayScreenLog():
    #print "Screen Log type: " + str(type(ScreenLogGUI.slFrame));
    if ScreenLogGUI.slFrame == None:
        ScreenLogGUI.slFrame = ScreenLogGUI(NULL, "Screen Log GUI Frame");
        ScreenLogGUI.slFrame.show(0)

def closeScreenLog():
    ScreenLogGUI.slFrame.Destroy();

class SLGUIApp(wxApp):
   def OnInit(self):
        #frame = ScreenLogGUI(NULL, "Screen Log GUI Frame");
        #frame.show(false)

        #frame2 = ScreenLogGUI(NULL, "Screen Log GUI Frame #2");
        #frame2.show(false)
        
        #self.SetTopWindow(frame)

        displayScreenLog();

        #displayScreenLog();
        
        return true

#---------------------------------------------
# Create and run our main app
#---------------------------------------------
if __name__ == "__main__":
    gapp = SLGUIApp(0);
    gapp.MainLoop();
