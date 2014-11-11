#file ScreenLog.py
from wxPython.wx import *
from BaseClasses.subject import Subject
from BaseClasses.observer import Observer
from Controls.TextBox import *;

#------------------------------------------------------
# Name:        ScreenLog
# Author:      Doug Farrell
# Date:        1-31-2003
# Description: This serves as a logging to screen
# message observer.
#------------------------------------------------------
class ScreenLog(Observer, TextBox, myPanel):
    def __init__(self, subject):
        Observer.__init__(self)
        self.__subject = subject
        self.__subject.attach(self)
        Log.instance().attach(self);
        TextBox.__init__(myPanel, self, -1, wxTE_LEFT | wxTE_MULTILINE, "Screen Log", mySize = wxSize(100, 500));

    def update(self):
        if self.__subject.bitMask() & self.__subject.bitMaskScreen():
            print "Screen : %s" % self.__subject.message()
            SetValue(GetValue() + "\n" + "hello");

            #bold the text in red for the first 10 characters
            myFONT = wxFont(12, wxDEFAULT, wxDEFAULT, wxBOLD);
            myTA = wxTextAttr(wxRED, wxWHITE, myFONT);
            
            SetStyle(0, 10, myTA);
