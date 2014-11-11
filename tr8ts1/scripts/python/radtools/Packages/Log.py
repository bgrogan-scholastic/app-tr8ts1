#file Log.py

from BaseClasses.subject import Subject

#------------------------------------------------------
# Name:        Log
# Author:      Doug Farrell
# Date:        1-31-2003
# Description: This serves as the subject for all
# message logging (implemented using the subject/observer
# design pattern).
#------------------------------------------------------
class Log(Subject):
    def __init__(self):
        Subject.__init__(self)
        self.__message = ""
        self.__bitmask       = 0x00
	
        #destinations for log messages
        self.__bitmaskFile   = 0x01
        self.__bitmaskScreen = 0x02
        self.__bitmaskAll    = 0x0F

        #user status levels
        self.__bitmaskWarning = 0x10
        self.__bitmaskCritical = 0x20
        self.__bitmaskGeneral = 0x40

        #levels
        self.countStatus = 0;
        self.countWarning = 0;
        self.countCritical = 0;
        
    def add(self, message, bitmask = 0x4F):
        if bitmask & self.bitMaskWarning():
            self.countWarning+=1;
            self.__message = "WARNING: " + message;
        elif bitmask & self.bitMaskCritical():
            self.countCritical+=1;
            self.__message = "CRITICAL: " + message;
        else:
            self.countStatus+=1;
            self.__message = "STATUS: " + message; 
            
        self.__bitmask = bitmask        

        print self.__message

        self.notify(self)

    def getCounts(self):
        return (self.countStatus, self.countWarning, self.countCritical);

    def message(self):
        return self.__message

    def bitMask(self):
        return self.__bitmask;

    def bitMaskAll(self):
        return self.__bitmaskAll;
    
    def bitMaskFile(self):
        return self.__bitmaskFile;

    def bitMaskScreen(self):
        return self.__bitmaskScreen;

    def bitMaskWarning(self):
        return self.__bitmaskWarning;

    def bitMaskCritical(self):
        return self.__bitmaskCritical;

    def bitMaskGeneral(self):
        return self.__bitmaskGeneral;
    

    #warnings
    def bitMaskWarningAll(self):
        return self.bitMaskWarning() | self.bitMaskAll()

    def bitMaskWarningFile(self):
        return self.bitMaskWarning() | self.bitMaskFile()

    def bitMaskWarningScreen(self):
        return self.bitMaskWarning() | self.bitMaskScreen()


    #critical
    def bitMaskCriticalAll(self):
        return self.bitMaskCritical() | self.bitMaskAll()

    def bitMaskCriticalFile(self):
        return self.bitMaskCritical() | self.bitMaskFile()

    def bitMaskCriticalScreen(self):
        return self.bitMaskCritical() | self.bitMaskScreen()
    
#----------------------------------
# the single, static instance of the Log
#---------------------------------------------
_logInstance = None

def instance():
    global _logInstance
    if _logInstance == None:
        _logInstance = Log()
    return _logInstance


