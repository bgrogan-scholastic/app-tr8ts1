
from wxPython.wx import *
import re, string

# this is the base class mediator, implemented
# as a template pattern. your form/dialog box/panel should inherit from this
class Mediator:
    def __init__(self):
        pass

    def __del__(self):
        print "Mediator::__del__";
        pass
    
    def ColleagueChanged(self, colleague, event):
        """Template pattern interface method, intended to be called directly"""
        self._ColleagueChanged(colleague, event)

    def _ColleagueChanged(self, colleague, event):
        """Template pattern polymorphic method, intended to be inherited"""
        pass
    


