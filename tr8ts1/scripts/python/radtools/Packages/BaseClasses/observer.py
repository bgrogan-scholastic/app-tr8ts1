#file observer.py

#------------------------------------------------------
# Name:        Subject
# Author:      Doug Farrell
# Date:        1-31-2003
# Description: This is the base class for the observer
# part of the subject/observer pattern.  All observers
# should derive from this class.
#------------------------------------------------------
class Observer:
    """This is the Observer base class and provides one half
    of the Subject/Observer pattern implementation. Essentially this
    pattern provides a way for a data 'model' to notify many
    observers that something has changed."""

    def __init__(self):
        self.__subject = 0      # subject I'm attached to
        #print "Observer:__init__" + str(type(self.__subject));

    def update(self):       # virtual update() method
        pass

    def __del__(self):
        print "in Observer::__del__";
        if type(self.__subject) != type(int()):
            self.__subject.detach(self)
        else:
            print "can't detach";
            print "type of subject:" + str(type(self.__subject));


