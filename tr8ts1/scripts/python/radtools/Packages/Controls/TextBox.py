from wxPython.wx import *
from BaseClasses.Colleague import *
from BaseClasses.Mediator import *
from BaseClasses.ControlColors import *
import string

class TextBox(wxTextCtrl,Colleague):
    #validator and size are optional.
    def __init__(self, parent, mediator, controlid, styles, value, myValidator = wxDefaultValidator, mySize = wxDefaultSize):
        wxTextCtrl.__init__(self, parent, controlid, value, wxDefaultPosition, size = mySize, style = styles, validator = myValidator);
        Colleague.__init__(self, mediator);
        self.SetForegroundColour(wxBLACK);
        self.SetBackgroundColour(wxColour(0xCF, 0xCF, 0xCF));
        
        #When text changes
        EVT_TEXT(self, controlid, self.TextChanged)
        
    def TextChanged(self, event):
        #this is where we call Changed.
        self.Changed(self, event);
        #event.Skip();

            
