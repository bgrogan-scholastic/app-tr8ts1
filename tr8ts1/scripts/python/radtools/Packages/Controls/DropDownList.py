from wxPython.wx import *
from BaseClasses.Colleague import *
import string
from BaseClasses.ControlColors import *

class DropDownList(wxChoice,Colleague):
    def __init__(self, parent, mediator, controlid, elements):
        self.parent=parent;
        self.controlid=controlid;
        self.mediator = mediator;
        wxChoice.__init__(self, parent, controlid, wxDefaultPosition, wxDefaultSize, elements);
        Colleague.__init__(self, mediator);
        self.SetForegroundColour(gControlFGColor);
        self.SetBackgroundColour(gControlBGColor);
        EVT_CHOICE(self, controlid, self.ListItemSelected);

    def ListItemSelected(self, event):
        #this is where we call Changed.
        self.Changed(self, event);
