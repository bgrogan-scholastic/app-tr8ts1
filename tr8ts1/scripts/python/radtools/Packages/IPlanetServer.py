#file IPlanetServer.py

#------------------------------------------------------
# Name:        IPlanetServer
# Author:      Tyrone Mitchell
# Date:        2-11-2003
# Description: This will be responsible for handling creating
#  webserver enviroments for Solaris & Oracle environments,
#  IPlanet4.1 specifically.
#  Largely unimplemented due to time constraints.
#------------------------------------------------------

from BaseClasses.WebServerInterface import *
import DataCloud
from Features import *
import os
import os.path
#XPath class to handle xml data transactions.
from BaseClasses.xpath import *
#import the Search And Replace class.
from BaseClasses.searchandreplace import *

class IPlanetServer(WebServerInterface):
    def __init__(self):
        WebServerInterface.__init__(self);

    def __del__(self):
        pass

    def createServer(self):
        pass

    def restartServer(self):
        stopCmd = "/opt/iplanet4.1/https-" + self.__handleTag("pcode") + "/stop";
        startCmd = "/opt/iplanet4.1/https-" + self.__handleTag("pcode") + "/start"; 
        print "Command to issue: " + stopCmd;
        print "Command to issue: " + startCmd;
    
    def __handleTag(self, tagName):
        tagText = tagName.replace("$$", "");

        returnValue = self.sc.value(tagText);
        if (returnValue != ""):
            return returnValue;

        if tagText == "pcode":
            return "radtest2";
        elif tagText == "PCODE":
            return "RADTEST2";
        elif tagText == "portnumber":
            return "1212";

def main():
    singleDataCloud.add("pcode", "radtest2");
    singleDataCloud.add("PCODE", "radtest2");
    singleDataCloud.add("ptitle", "Rapid Application Development Test Server #2");
    singleDataCloud.add("portnumber", "1212");
    singleDataCloud.add("hostname", "qadev");  

    iplanetserver = IPlanetServer();
    iplanetserver.createServer();
    iplanetserver.restartServer();
    
if __name__ == "__main__":
    main()
    
