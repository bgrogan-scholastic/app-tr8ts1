from wxPython.wx import *
#sys.path.append("/home/qadevWS/python/radtools/Packages");
from BaseClasses.Colleague import *
from BaseClasses.Mediator import *
from BaseClasses.ControlColors import *
import string

class CheckBox(wxCheckBox,Colleague):
    def __init__(self, parent, mediator, controlid, label):
         wxCheckBox.__init__(self, parent, controlid, label, wxDefaultPosition, wxDefaultSize);
         Colleague.__init__(self, mediator);

##         self.SetForegroundColour(gControlFGColor);
##         self.SetBackgroundColour(gControlBGColor);

         #leave this one alone, change the .SetBackGroundColour
         self.SetForegroundColour(gControlBGColor);
         self.SetBackgroundColour(gControlFGColor);        
         EVT_CHECKBOX(self, controlid, self.BoxChecked);


    def SetCheckboxValue(self, value):
        self.SetValue(value);
        #print value;
        if (value == 1 or value==true):
            #self.SetBackgroundColour(gControlFGColor);
            #self.SetForegroundColour(gControlBGColor);
            self.SetBackgroundColour(gControlOtherColor);
            self.SetForegroundColour(gControlBGColor);
        else:
            #self.SetBackgroundColour(gControlBGColor);
            #self.SetForegroundColour(gControlFGColor);
            self.SetBackgroundColour(gControlBGColor);
            self.SetForegroundColour(gControlOtherColor);


    def BoxChecked(self, event):
        #this is where we call Changed.
        self.SetCheckboxValue(self.GetValue());
        #if self.GetValue() == 1:
        #   self.SetBackgroundColour(gControlFGColor)

        self.Changed(self, event);
            
