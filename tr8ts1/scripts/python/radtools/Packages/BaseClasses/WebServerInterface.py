#file WebServerInterface.py

#------------------------------------------------------
# Name:        WebServerInterface
# Author:      Tyrone Mitchell
# Date:        2-10-2003
# Description: This is the abstract base class that will be
#  derived by SolarisOracle and LinuxMySQL classes.
# 
#------------------------------------------------------

import DataCloud

class WebServerInterface:
    def __init__(self):
        self.sc = DataCloud.instance();

    def __del__(self):
        pass

    def createServer(self):
        pass

    def deleteServer(self, productcode):
        pass
    
    def restartServer(self):
        pass

    def __handleTag(self, tagName):
        pass

    def generatePortnumber(self):
        pass
