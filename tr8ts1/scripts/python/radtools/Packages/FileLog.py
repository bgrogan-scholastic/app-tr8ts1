#file FileLog.py

from BaseClasses.subject import Subject
from BaseClasses.observer import Observer
import Log;
from BaseClasses.fileutils import FileIOString;
import os;

#------------------------------------------------------
# Name:        FileLog
# Author:      Doug Farrell
# Date:        1-31-2003
# Description: This serves as a logging to file
# message observer.
#------------------------------------------------------
class FileLog(Observer):
    def __init__(self, subject, filePath):
        Observer.__init__(self)
        self.__subject = subject;
        self.__subject.attach(self)
        self.__filePath = filePath;


        #make sure the log file exists
        os.system("touch " + self.__filePath);
        self.__fileIO = FileIOString(self.__filePath);
        
        self.__fileIOContents = self.__fileIO.getString();
        
    def update(self):
        if self.__subject.bitMask() & self.__subject.bitMaskFile():
            self.__fileIOContents = self.__fileIOContents + self.__subject.message() + "\n";
            self.__fileIO.setString(self.__fileIOContents);
            self.__fileIO.write();
        
#this is the FileLog that is passed back to you in the instance function.
#all objects should use this FileLog as a reference
singleFileLog = None;

#------------------------------------------------------
# Name:        instance
# Description: will return the singleFileLog object to you,
# but will be instantiated only once.
#------------------------------------------------------
def instance(filePath = None):
    global singleFileLog;
    if singleFileLog == None:
        singleFileLog = FileLog(Log.instance(), filePath);
    return singleFileLog;
