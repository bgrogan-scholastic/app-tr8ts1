from wxPython.wx import *
from BaseClasses.Colleague import *
from BaseClasses.Mediator import *
from BaseClasses.ControlColors import *
import string


class Button(wxButton,Colleague):
    def __init__(self, parent, mediator, controlid, label,  mySize = wxDefaultSize):
        self.parent=parent;
        self.controlid=controlid;
        self.label = label;
        self.mediator = mediator;
        wxButton.__init__(self, parent, controlid, label, wxDefaultPosition, mySize);
        Colleague.__init__(self, mediator);
        self.SetForegroundColour(gControlFGColor);
        self.SetBackgroundColour(gControlBGColor);
        EVT_BUTTON(self, controlid, self.ButtonPushed);

    def ButtonPushed(self, event):
        #this is where we call Changed.
        #dlg = wxMessageDialog(self.parent, "woohoo!", "Message box", wxOK | wxCANCEL | wxCENTRE, wxDefaultPosition);
        #dlg.ShowModal();
        self.Changed(self, event);



            
