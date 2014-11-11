from wxPython.wx import *

import string
import sys

sys.path.append("/home/qadevWS/python/radtools/Packages");

from BaseClasses.Mediator import *
from BaseClasses.observer import Observer
from BaseClasses.GUI import *
from BaseClasses.Colleague import *

from Panels.ArticleGUI import ArticleGUI
from Panels.SearchGUI import SearchGUI

# TemplateGUI class, derived from the GUI class
class TemplateGUI(GUI):

    # Constructor
    def __init__(self, parentWindow, title):
        GUI.__init__(self, parentWindow, title)
        self.__inProcess = false
        self.show(false)

    # Hollywood 'show()' function.
    def _show(self):
        self.statusbar.SetStatusText("Template GUI");

        #set up all of the controls;
        mainsizer = wxBoxSizer(wxVERTICAL);
        self.bordersize = 20;

        # First, set up the back and quit buttons, in their own sizer
        [self.ExitButtonID, self.BackButtonID] = map(lambda init: wxNewId(), range(2))

        self.buttonsizer = wxBoxSizer(wxHORIZONTAL);        
        self.ExitButton = Button(self.panel, self, self.ExitButtonID, "E&xit");
        self.BackButton = Button(self.panel, self, self.BackButtonID, "&Back to Main Menu");
        self.buttonsizer.Add(self.BackButton, option = 0, flag = wxALL, border = self.bordersize);
        self.buttonsizer.Add(10,10, option=1)
        self.buttonsizer.Add(self.ExitButton, option = 0, flag = wxALL, border = self.bordersize);

        # Now set up the panel's action buttons, in their own sizer
        [self.ArtButtonID, self.MediaButtonID, self.SearchButtonID] = map(lambda init: wxNewId(), range(3))
        
        self.actionssizer = wxBoxSizer(wxVERTICAL);
        
        self.ArtButton = Button(self.panel, self, self.ArtButtonID, "Article Template Generation Menu");
        self.MediaButton = Button(self.panel, self, self.MediaButtonID, "Media Template Generation Menu");
        self.SearchButton = Button(self.panel, self, self.SearchButtonID, "Search Template Generation Menu");

        self.actionssizer.Add(self.ArtButton, option = 0, flag = wxALL | wxALIGN_CENTER, border = self.bordersize);
        self.actionssizer.Add(self.MediaButton, option = 0, flag = wxALL | wxALIGN_CENTER, border = self.bordersize);
        self.actionssizer.Add(self.SearchButton, option = 0, flag = wxALL | wxALIGN_CENTER, border = self.bordersize);

        #add everyone to the main sizer.
        mainsizer.Add(self.actionssizer, option = 0, flag = wxALL | wxALIGN_CENTER, border = self.bordersize);
        mainsizer.Add(self.buttonsizer, option = 1, flag = wxALL | wxGROW , border = self.bordersize);

        # Now let's build our 'Colleague map' for mediation
        TemplateColleagueMap = {
                                 self.ArtButton : self._articleCall,
                                 self.SearchButton : self._searchCall,
                                 self.MediaButton : self._mediaCall,
                                 self.ExitButton : self.cancel,
                                 self.BackButton : self._backCall
                                 }

        self._colleagueMap.update(TemplateColleagueMap)

        self.windowsize=wxSize(550, 700)
        self.Move((100,50))
        return mainsizer

    # The destructor
    def __del__(self):
        GUI.__del__(self);


# This is the mediator action.
    def _ColleagueChanged(self, colleague, event):
        # Let's avoid recursion
        if self.__inProcess != true:
            self.__inProcess = true

            if self._colleagueMap.has_key(colleague):
                self._colleagueMap[colleague](event)
            else:
                dlg = wxMessageDialog(self, "TemplateGUI._ColleagueChanged", "Message box", wxOK | wxCENTRE, wxDefaultPosition);
                dlg.ShowModal();

        self.__inProcess = false


#----------------------------------------------------------
# Mediation functions
#----------------------------------------------------------

    def _backCall(self, event):
        dlg = wxMessageDialog(self, "TemplateGUI._backCall", "Message box", wxOK | wxCENTRE, wxDefaultPosition);
        dlg.ShowModal();

    def _articleCall(self, event):
        frame = ArticleGUI(NULL, "Article Generator")
        frame.show()
        frame.MakeModal(true);

    def _searchCall(self, event):
        frame = SearchGUI(NULL, "Search Generator")
        frame.show()

    def _mediaCall(self, event):
        dlg = wxMessageDialog(self, "TemplateGUI._mediaCall", "Message box", wxOK | wxCENTRE, wxDefaultPosition);
        dlg.ShowModal();


###########################################################
#
#  Standalone test
#
###########################################################
class TemplateGUIApp(wxApp):
    def OnInit(self):
        DataCloud.instance().load("radtest");
        frame = TemplateGUI(NULL, "Test Template GUI Frame");
        frame.Show(true)
        self.SetTopWindow(frame)
        return true

#---------------------------------------------
# Create and run our main app
#---------------------------------------------
if __name__ == "__main__":
    import DataCloud
    app = TemplateGUIApp(0);
    app.MainLoop()
