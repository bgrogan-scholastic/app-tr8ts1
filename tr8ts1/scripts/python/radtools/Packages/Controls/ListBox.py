from wxPython.wx import *
#sys.path.append("/home/qadevWS/python/radtools/Packages");
from BaseClasses.Colleague import *
from BaseClasses.Mediator import *
from BaseClasses.ControlColors import *
import string

class ListBox(wxListBox,Colleague):
    def __init__(self, parent, controlid, choices, styles, mediator):
         wxListBox.__init__(self, parent, controlid, wxDefaultPosition, wxDefaultSize, choices, styles);
         Colleague.__init__(self, mediator);

         EVT_LISTBOX(self, controlid, self.ListBoxItemSelected)
         EVT_LISTBOX_DCLICK(self, controlid, self.ListItemDoubleClicked)

    def ListBoxItemSelected(self, event):
        #this is where we call Changed.
        self.Changed(self, event);
