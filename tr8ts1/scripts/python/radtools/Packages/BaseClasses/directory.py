#file directory.py

import os
import shutil
#------------------------------------------------------
# Name:        Directory
# Author:      Diane Langlois
# Date:        1-29-2003
# Description: This class encapsulates a whole bunch
# of directory functions.  
#------------------------------------------------------

class Directory(object):
    """This is the Directory object which provides access to 
    directories in the system.
    """
    def __init__(self):
        pass
    #--------------------------------------------------
    # Name:        listFiles
    # Description: This method takes a pathname & issues
    # a directory listing command and loads only items
    # that are files into a list
    # Returns:     returns the list of files
    # Parameters:
    #    path      string containing the path to list
    #--------------------------------------------------
    def listFiles(self,path):
        """list all the files in the 'path' directory"""
        mylist = self.listAll(path)
        outlist = []
        for eachfile in mylist:
            if not os.path.isdir(eachfile): outlist.append(eachfile)
        return outlist
    #--------------------------------------------------
    # Name:        listDirectories
    # Description: This method takes a pathname & issues
    # a directory listing command and loads only items
    # that are directories into a list
    # Returns:     returns the list of directories
    # Parameters:
    #    path      string containing the path to list
    #--------------------------------------------------
    def listDirectories(self,path):
        """list all the directories in the 'path' directory"""
        mylist = self.listAll(path)
        outlist = []
        for eachfile in mylist:
            if os.path.isdir(eachfile): outlist.append(eachfile)
        return outlist
            
    #--------------------------------------------------
    # Name:        listAll
    # Description: This method takes a pathname & issues
    # a directory listing command and loads all items
    # into a list
    # Returns:     returns the list of all items
    # Parameters:
    #    path      string containing the path to list
    #--------------------------------------------------
    def listAll(self,path):
        """list all the files & directories in the 'path' directory"""
        mylist = os.listdir(path)
        outlist = []
        for eachfile in mylist:
            outlist.append(path + sep + eachfile)
        return outlist
    #--------------------------------------------------
    # Name:        remove
    # Description: This method takes a pathname & issues
    # a utility command to recursively remove a directory
    # path
    # Returns:     none
    # Parameters:
    #    path      string containing the path to remove
    #--------------------------------------------------
    def remove(self,path):
        """remove all files & directories recursively from path"""
        shutil.rmtree(path)
    #--------------------------------------------------
    # Name:        create
    # Description: This method takes a pathname & issues
    # a utility command to recursively create a directory
    # path.
    # Returns:     none
    # Parameters:
    #    path      string containing the path to create
    #--------------------------------------------------
    def create(self,path):
        """we shall recursively create path"""
        os.makedirs(path)
    #--------------------------------------------------
    # Name:        copy
    # Description: This method takes a pathname & issues
    # a utility command to recursively copy one directory
    # path to another
    # Returns:     none
    # Parameters:
    #    path      string containing the path to remove
    #--------------------------------------------------
    def copy(self,frompath,topath):
        """we shall copy one path to another recursively"""
        shutil.copytree(frompath,topath)

#------------------------------------------
#Testing 1, 2, 3
#------------------------------------------
def main():
    """This is the test harness for this object.  It only runs if the 
    object is invoked outside of any other program.
    """
    d = Directory()
    print "These are all files found in /home" 
    print d.listFiles("/home")
    print "These are directories found in /home"
    print d.listDirectories("/home")
    print "These are all directories and files found in /home" 
    print d.listAll("/home")
    d.create("/home/dummy/newdir")
    print "Created a new directory tree"
    print d.listAll("/home") + d.listAll("/home/dummy") + d.listAll("/home/dummy/newdir")
    print "Copying that tree to /home/newdummy"
    d.copy("/home/dummy","/home/newdummy")
    print d.listAll("/home") + d.listAll("/home/newdummy") + d.listAll("/home/newdummy/newdir")
    print "Removing the trees I just created"
    d.remove("/home/dummy")
    d.remove("/home/newdummy")
    print d.listAll("/home")
    
if __name__ == "__main__":
    main()
    
    
