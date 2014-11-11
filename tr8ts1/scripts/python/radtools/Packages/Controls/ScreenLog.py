#file ScreenLog.py
from wxPython.wx import *
from BaseClasses.subject import Subject
from BaseClasses.observer import Observer
from Controls.TextBox import *
import Log

#------------------------------------------------------
# Name:        ScreenLog
# Author:      Doug Farrell
# Date:        1-31-2003
# Description: This serves as a logging to screen
# message observer.
#------------------------------------------------------
class ScreenLog(wxTextCtrl, Observer):
    def __init__(self, subject, myPanel, myMediator):
        Observer.__init__(self)
        self.__subject = subject
        self.__subject.attach(self)
        self.myPanel = myPanel;
        
        wxTextCtrl.__init__(self, myPanel, -1, "", wxDefaultPosition, size = wxDefaultSize, style = wxTE_LEFT | wxTE_MULTILINE, validator = wxDefaultValidator);

        self.Enable(false);
	self.__logHistory = None;

    def update(self):
        #refresh this control
        self.Refresh();
        
        if self.__subject.bitMask() & self.__subject.bitMaskScreen():

            #if this is the first message coming through, then don't display a new line.
            if len(self.GetValue()) != 0:
                myMessage = "\n";
            else:
                myMessage = "";

            myMessage = myMessage + self.__subject.message();

            startposition = len(self.GetValue());
            endposition = startposition + len(myMessage);
	
            self.AppendText(myMessage);

            myFontStyling = None;
            myColorAttributes = None;
            
            if self.__subject.bitMask() & self.__subject.bitMaskWarning():                
                myFontStyling = wxFont(12, wxDEFAULT, wxNORMAL, wxNORMAL);
                myColorAttributes = wxTextAttr(wxBLUE, wxWHITE, myFontStyling);
                
            elif self.__subject.bitMask() & self.__subject.bitMaskCritical():                
                myFontStyling = wxFont(12, wxDEFAULT, wxNORMAL, wxNORMAL);
                myColorAttributes = wxTextAttr(wxRED, wxWHITE, myFontStyling);                
                
            elif self.__subject.bitMask() & self.__subject.bitMaskGeneral():
                myFontStyling = wxFont(12, wxDEFAULT, wxNORMAL, wxNORMAL);
                myColorAttributes = wxTextAttr(wxBLACK, wxWHITE, myFontStyling);
    
            #set the coloring style
            self.SetStyle(startposition, endposition, myColorAttributes);

