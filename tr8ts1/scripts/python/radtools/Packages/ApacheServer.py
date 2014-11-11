#file ApacheServer.py

#------------------------------------------------------
# Name:        ApacheServer
# Author:      Tyrone Mitchell
# Date:        2-10-2003
# Description: This will be responsible for handling creating
#  webserver enviroments for Linux/MySQL environments.
# 
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
from WebServerSuperTemplate import *
from BaseClasses.fileutils import FileIOString
import re
import shutil
import copy
from wxPython.wx import *

class ApacheServer(WebServerInterface):
    #------------------------------------------------------
    # Name:        __init__
    # Description: constructor
    #------------------------------------------------------    
    def __init__(self):
        WebServerInterface.__init__(self);
        self.__xmlData = XPath("/data/rad/supertemplates/xml/webservers.xml");
        #create a list of files that we'll need to process.
        self.filenames = ["virtualhost_base.conf", "virtualhost_base_ada.conf"];
        self.thisport = -1;
        self.odbcFilePath = "/etc/odbc.ini";        
    
    #------------------------------------------------------
    # Name:        __del__
    # Description: simple destructor
    #------------------------------------------------------
    def __del__(self):
        pass


    def generatePortnumber(self):
        yourPort = -1;
        #we wanted to assign port numbers randomly between
        #the following two port numbers.
        portnumber_begin = 1175;
        portnumber_end = 1200;
        
        portlist = [];
        #look in webserver virtualhost files, and find out which ports on both
        #machines to see what ports are already in use. 
        apachedir = "/data/apache/config/";
        filelist = os.listdir(apachedir);
        for file in filelist:
            #search for virtualhost*.conf files, look for the host directive.
            if (re.search("^virtualhost[a-zA-Z0-9_\-]*\.conf$", file)):
                fileio = FileIOString(os.path.join(apachedir, file));
                contents = fileio.getString();
                m = re.search("<VirtualHost\s([\.0-9a-zA-Z\-]*):([0-9]*?)>", contents);
                if (m != None):
                    #m.group(1) gets the machine ip@ or name,
                    #m.group(2) gets the port number.

                    #we don't want duplicates
                    if (int(m.group(2)) not in portlist):
                        portlist.append(int(m.group(2)));
        portlist.sort();
        print "Ports in use:" + str(portlist);
        for port in range(portnumber_begin, portnumber_end):
            if port not in portlist:
                yourPort = port;
                break;
            if port == portnumber_end:
                print "You're all out of ports! Free up a webserver";

        print "Your webserver port = " + str(yourPort);
        self.thisport = str(yourPort);
        DataCloud.instance().add("portnumber", self.thisport);
        #return str(yourPort);
    
    def __handleTag(self, tagName):
        #print tagName;
        tagText = tagName.replace("$$", "");
        tagText = tagText.replace("##", "");
        tagTextCopy = copy.deepcopy(tagText);
        #assuming I'm getting any tag from the product category
        #returnValue = self.sc.getFeature("product").get(tagText);
        if (tagText == "portnumber"):
            if (self.thisport != -1):
                returnValue = self.thisport;
            else:
                self.generatePortnumber();
                returnValue = self.thisport;
        else:
            if (tagText.isupper()):
                returnValue = self.sc.value(tagText.lower());
            else:
                returnValue = self.sc.value(tagText);

        if (tagTextCopy.isupper()):
            returnValue = returnValue.upper();
            
        return str(returnValue);

    #this is where you decide to delete configuration files
    def deleteServer(self, productcode):
        print "Deleting product server for: " + productcode;
        arguments = ["apache", self.__xmlData];
        self.removeEntryFromINIFile();
        for fname in self.filenames:
            self.apacheWSST = WebServerSuperTemplate(fname, arguments);
            outpath =  self.apacheWSST._getOutputFilePath();
            if (os.path.exists(outpath)):
                os.remove(outpath);

    #this is where the server configuration files are created
    def createServer(self):
##         username = os.environ["USER"];
##         if not username == "root":
##             print "Please re-run as user root.";
##             return;

        releaseversion = "";
        
        arguments = ["apache", self.__xmlData];
        #edit ODBC.INI file in /etc/ - allows the product to make DB requests
        self.insertEntryIntoINIFile();        
        for fname in self.filenames:
            self.apacheWSST = WebServerSuperTemplate(fname, arguments);
            contents = self.apacheWSST.getContents();
            self.xform = SearchAndReplace("\$\$[0-9a-zA-Z]*\$\$", self.__handleTag);
            self.xform.setContents(contents);
            filecontents = self.xform.getContents();

            #make a deep copy of the file contents of the virtual host file - I'll need to change it
            #in order to make it suitable for the release tool.
            releaseversion = copy.deepcopy(filecontents);
            self.transformForRelease(releaseversion, fname);
            
            #print filecontents;
            self.apacheWSST.setContents(filecontents);
            self.apacheWSST.write();

    #this is where I will substitute values in the host file for Lori's release tool config
    def transformForRelease(self, content, filename):
        content = content.replace("Listen", "##LISTEN##");
        content = content.replace("ServerName stress1-ada", "ServerName ##SERVER_ADA_HOSTNAME##");        
        content = content.replace("ServerName stress1", "ServerName ##SERVER_HOSTNAME##");        
        
        content = content.replace("<VirtualHost stress1-ada.grolier.com", "<VirtualHost ##SERVER_ADA_IP##");
        content = content.replace("<VirtualHost stress1.grolier.com", "<VirtualHost ##SERVER_IP##");

        content = content.replace("stress1-ada", "##SERVER_ADA_HOSTNAME##");
        content = content.replace("stress1", "##SERVER_HOSTNAME##");

        content = content.replace("qadev.grolier.com", "##HWHL_SERVER##");
        content = content.replace("HWHL_PORT 2000", "HWHL_PORT ##HWHL_PORT##");

        #in case the HWHL port is the same as the portnumber on the machine (shouldn't happen, but might.) I put this after the replacement for HWHL port
        content = content.replace(DataCloud.instance().value("portnumber"), "##SERVER_PORT##");


        filename = filename.replace("_base", "_" + DataCloud.instance().value("pcode"));
        releasenode = self.__xmlData.query('/webservers/server[@type="apache"]/files/file[@type="release"]');
        releaselocation = releasenode[0].getAttribute("dir");
        #I need to create the ##PCODE## directory in order to write the file correctly.
        (basedir, leaf) = os.path.split(releaselocation);

        releaselocation = releaselocation.replace("##PCODE##", DataCloud.instance().value("pcode"));

        if not (os.path.exists(releaselocation)):
            #if the path doesn't exist, I'm going to change directories, create, and back out
            #know where you are
            yourehere = os.getcwd();
            os.chdir(basedir);
            #create
            os.mkdir(DataCloud.instance().value("pcode"));
            #return to where we started.
            os.chdir(yourehere);
            
        self.releasepattern = "___data___apache___config___" + filename;
        fullpath = os.path.join(releaselocation, self.releasepattern);

        fio = FileIOString();
        fio.setString(content);
        print "Writing release config file at: " + fullpath;
        fio.write(fullpath);
        
    def restartServer(self):
	os.system("service httpd restart");

    def getODBCFileContents(self):
        originalFileContent = FileIOString(self.odbcFilePath).getString();
        #break up all the contents of the original file into single lines
        lines = re.split("\n", originalFileContent);
        return lines;

    def BackupODBCFile(self):
        wdt = wxDateTime();
        wdt.SetToCurrent();

        #I will use this to back up the odbc file based on the time you ran this.
        timestamp = str(wdt.GetMonth()+1) +  str(wdt.GetDay()) + str(wdt.GetYear()) + "-at-" + str(wdt.GetHour()) + str(wdt.GetMinute()) + str(wdt.GetSecond());
        #print timestamp;

        #make a copy of the existing odbc file.
        backuplocation = "/etc/backups/odbc-backup-" + timestamp + ".ini";
        shutil.copyfile(self.odbcFilePath, backuplocation);
        print "The ODBC file in /etc/odbc.ini bas been backed up as " + backuplocation;
        
    def removeEntryFromINIFile(self):
        #self.BackupODBCFile();
        lines = self.getODBCFileContents();
        inHeader = 0;
        newlines = [];
        for line in lines:
            if line=="[myodbc" + DataCloud.instance().value("pcode") + "]":
                inHeader = 1;
            if line== "" and inHeader==1:
                inHeader=0;
            
            if inHeader==0 and line.find("myodbc" + DataCloud.instance().value("pcode"))==-1:
                    newlines.append(line);


        removalList = [];
        #gather line numbers of lines that appear in pairs.
        for i in range(1, len(newlines)-1):
            if newlines[i]=="" and newlines[i+1]=="":
                removalList.append(i);
                
        #remove blank lines that appear in pairs
        removalList.reverse();
        for i in removalList:
            del newlines[i];

        #print "New ODBC File is as follows: ";
        #for x in newlines:
        #    print x;

        fio = FileIOString();
        fio.setListAsString(newlines);
        fio.write("/etc/odbc.ini");

        
    def insertEntryIntoINIFile(self):
        odbcInsertFilePath = "/data/rad/supertemplates/webservers/linuxmysql/odbc_insert.txt";

        #make a timestamped backup copy of the odbc.ini file.
        self.BackupODBCFile();

        magicHeaderBeginningString = "[ODBC Data Sources]";
        magicHeaderProductString = "[myodbc";

        #create a FileIOString object that will contain the new
        #information that we're inserting into the original file.
        fileio = FileIOString(odbcInsertFilePath);
        insertContents = fileio.getString();

        #replace all the tags in the file. 
        self.xform = SearchAndReplace("\$\$[0-9a-zA-Z]*\$\$", self.__handleTag);
        self.xform.setContents(insertContents);
        returnedContents = self.xform.getContents();

        lines = self.getODBCFileContents();

        #here's the new info that's going to be put in the odbc.ini file.
        newContentToInsert = re.split("\n", returnedContents);

        #the first line of that file should be the odbc data sources header line,
        #followed by a blank line.
        if (lines[0] == magicHeaderBeginningString):
            print "the magic line is: " +  lines[1];
        else:
            #there's an error. not good.
            print "Can't insert information into odbc.ini";
            return -1;

        #now, look for the next line that contains brackets.
        #print lines[2];
        for x in range(3, len(lines)):
            print lines[x];
            if (re.match('^\[.*\]', lines[x])!=None):
                #print "got it.";
                #print lines[x];
                #print x;
                break;

        #write file contents that appear before our new content
        newFile = [];
        for i in range(0, x-1):
            newFile.append(lines[i]);

        #write new content
        for t in range(1, len(newContentToInsert)):
            newFile.append(newContentToInsert[t]);

        #finish off rest of file.
        for i in range(x, len(lines)):
            newFile.append(lines[i]);

        fio = FileIOString();
        fio.setListAsString(newFile);
        fio.write("/etc/odbc.ini");
        
        
def main():
##    sdc = DataCloud.instance();
##    sdc.add("pcode", "radtest2");
##    sdc.add("ptitle", "Rapid Application Development Test Server #2");
##    sdc.add("hostname", "stress1");
##    sdc.add("pauth", "rad-auid");
    #sdc.add("portnumber", "1212");
    #sdc.printFeatures();
    DataCloud.instance().load("eas");
    apacheserver = ApacheServer();
    apacheserver.generatePortnumber();
    apacheserver.createServer();
    #apacheserver.deleteServer(DataCloud.instance().getFeature("product").get("pcode"));
    #apacheserver.restartServer();
    #apacheserver.createServer();
    #apacheserver.restartServer();

if __name__ == "__main__":
    main()
    
