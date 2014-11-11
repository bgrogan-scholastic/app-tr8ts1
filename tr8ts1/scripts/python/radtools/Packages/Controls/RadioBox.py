from wxPython.wx import *
from BaseClasses.Colleague import *
from BaseClasses.Mediator import *
from BaseClasses.ControlColors import *
import string

class RadioBox(wxRadioBox,Colleague):
    #please note that RowsOrColumns should be either wxRA_SPECIFY_ROWS or wxRA_SPECIFY_COLS
    def __init__(self, parent, mediator, controlid, label, choices, numRowsOrColumns, RowsOrColumns):
        wxRadioBox.__init__(self, parent, controlid, label, wxDefaultPosition, wxDefaultSize, choices, numRowsOrColumns, RowsOrColumns);
        Colleague.__init__(self, mediator);

        #yes, I switched the colors for readability in this control
        #deliberately - otherwise you can't read the state of the radiobox and its text
        self.SetForegroundColour(gControlBGColor);
        self.SetBackgroundColour(gControlFGColor);
        
        EVT_RADIOBOX(self, controlid, self.RadioBoxChanged)
        
    def RadioBoxChanged(self, event):
        #this is where we call Changed.
        self.Changed(self, event);


            
