#file subject.py

#------------------------------------------------------
# Name:        Subject
# Author:      Doug Farrell
# Date:        1-31-2003
# Description: This is the base class for the subject
# part of the subject/observer pattern.  All subjects
# should derive from this class.
#------------------------------------------------------
class Subject(object):
    """This is the Subject base class and provides one half
    of the Subject/Observer pattern implementation. Essentially this
    pattern provides a way for a data 'model' to notify many
    observers that something has changed."""

    def __init__(self):
        self.__observers = []

    def notify(self, thisobserver):
        for observer in self.__observers:
            if cmp(observer,thisobserver)!=0:
                observer.update()

    def attach(self, observer):
        self.__observers.append(observer)

    def detach(self, observer):
        self.__observers.remove(observer)


def main():
    log = Log()

    screen = Screen(log)
    file   = File(log)

    log.add("We got some kind of error message here")
    log.add("A message for the screen", log.bitMaskScreen())
    log.add("A message for the file", log.bitMaskFile())

if __name__ == "__main__":
    main()
