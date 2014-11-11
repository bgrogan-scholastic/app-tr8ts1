#!/usr/bin/python

########################################################################################
#
# File: newsupdate.py
#
# Author: Tyrone Mitchell
#
# Date: November 25, 2003
#
# This script works in conjunction with the news administration and update tool.
# It will open a file written by the news admin tool. Each line in the file contains
# an id and status. I'll find corresponding file, move it if necessary, then reindex plweb
# and restart the server.
########################################################################################


import string;
import sys
import re
import string
import os
import cgi
import urllib

#use this if the script starts giving you errors - it'll print the traceback to the screen.
import cgitb; cgitb.enable(0, 15)

#I placed a copy of giFTP and giTelnet in this directory. This directory should move to linuxstage / live.
sys.path.append("/data/nbk3/scripts/python/common/utils/");
import giTelnet


class NewsUpdate:
    def __init__(self, host, username, password):

        #set up my initial variables.
	self.plwebdir = "/data/nbk3/plweb";
        self.anewsdir = "/data/nbk3/plweb/news";
        self.inewsdir = "/data/nbk3/plweb/news-inactive";
        #this should exist on the same server we're running this script on.
        self.telnetfile = "/home/nbk3/newsadministration/telnetchanges.txt";
	self.movedfilelog = "/home/nbk3/newsadministration/moved_file_log.txt";
        self.contents = [];  #telnet file contents;
        
        print "Content-type: text/html\n\n";
        print "<pre>";

        #get the cookies which should contain a host, username and password to that box.
        cookies = self.get_cookies();
        #print cookies;
        
        #urllib.unquote(cookies);
        if ( (not (cookies.has_key("saved-host") and cookies.has_key("saved-user") and cookies.has_key("saved-pwd"))) and
             (host == "" and username=="" and password =="")):
            print "Please provide a host, username and a password.";
            return

        #this checks whether or not you've provided host name, username and password
        #information from the command line or the environment, since you can
        #run this the same either way.
        if (host != ""):
            self.host = host;
        else:
            self.host = cookies["saved-host"];

        if (password != ""):
            self.password = password;
        else:
            self.password = cookies["saved-pwd"];
            self.password = urllib.unquote_plus(self.password);


        if (username != ""):
            self.username = username;
        else:
            self.username = cookies["saved-user"];
            self.username = urllib.unquote_plus(self.username);

        
        print "Connecting to " + self.host + "<br>";

        print self.host, "<br>";
	print self.username, "<br>";
        #print self.password, "<br>";

        try:
	    #with the update to the users and groups (ldap) you can finally be yourself to do normal tasks.
	    self.gits = giTelnet.giTelnet(self.host, self.username, self.password);
        except:
            #this class (giTelnet) doesn't give you much in the way of errors. You kinds do what you can here.
            print "Error connecting to host " + self.host + "<br>";
            return

        #I clear the screen after every command, or else I end up having extra stuff from the screen saved back in the response array.
        #don't worry, after every command I tend to do this, just about.
        response = self.gits.command("clear");

        #find out what user we're really running as.
        response = self.gits.command("id");
        idcmd = response[1];

        #I have to determine if we really are logged in as root. If the password is incorrect, there's not much more you can check.
        #if (idcmd.find("root") == -1):
	#again, we can be ourselves here.
        print self.username;

	if (idcmd.find(self.username) == -1):
            print "Error: You are not logged in.";
            return
        else:
            print "User " + self.username + " OK";
        response = self.gits.command("clear");

        response = self.gits.command("cd " + self.anewsdir);
        response = self.gits.command("cd " + self.inewsdir);
        response = self.gits.command("clear");

        #load the data in to the self.contents array
        self.openFile();

	print "<br>\n";
        self.error = "";
##        while(len(self.contents) > 0 and self.error == ""):
##            self.processNextFile();
##            self.saveFile();
##            self.openFile();

##        if self.error != "":
##            print self.error;
##            return

        #move to the plweb directory
        response = self.gits.command("cd /data/stage/utils/nbk3/");
        self.printList(response);               
        response = self.gits.command("clear");

        #create nbk3 news, restart plweb
        response = self.gits.command("./newsadmin-reindex", 300);
        self.printList(response);       
        response = self.gits.command("clear");
        
        response = self.gits.command("cd /data/stage/utils/go2/");
        self.printList(response);       
        response = self.gits.command("clear");


        response = self.gits.command("./kids-newsadmin-reindex", 300);
        self.printList(response);       
        
        self.gits.close();
        print "Complete<br>";

    def processNextFile(self):
        print "Count of self.contents: " + str(len(self.contents));
        oline = self.contents[0]; #original line
        line = oline.rstrip();
        (id, status) = line.split("::");

	mvf = open(self.movedfilelog, "a");

        #run the find command in telnet
        location = self.findFileInTelnet(id, status);
	
	filestatus = "";
	if (location == ""):
	    filestatus = "yes";
	else:
	    filestatus = "no!";

	msg = "ID: " + id + "\tArchive Status: " + status + "\tFound?: " + filestatus + "\n";
	mvf.write(msg);


        if location == "":
            print "Not found, removing from list: " + oline;
            self.contents.remove(oline);
            #print "Count of self.contents: " + str(len(self.contents));            
        else:
            print "Found a match: Need to move";
            print "From: " + location;

	    #this should return (base, filename) tuple.
            locsplit = location.split("/");

            #now, we have to move it to the proper directory.
            if status == "active":
                base = self.anewsdir;
            else:
                base = self.inewsdir;

	    if (locsplit[0].startswith(base)):
		mvf.write("File " + locsplit[1] + " should have already been moved. Leaving it where it is\n");
	    else:
		#A word to the wise: locsplit[len(locsplit)-2] == locsplit[0] and 
		#locsplit[len(locsplit)-2] == locsplit[1]. I don't know why I originally wrote this. But it works.
		newlocation = os.path.join(base, locsplit[len(locsplit)-2]);
		newlocation = os.path.join(newlocation, locsplit[len(locsplit)-1]);
		print "To: " + newlocation;

                #create destination directory to keep pathing intact
		dirtocreate = os.path.join(base, locsplit[len(locsplit)-2]);

		#mkdir -p will create all the way down the tree without giving an error.
		command = "mkdir -p "+ dirtocreate;
		print command;
		response = self.gits.command(command);
		print response;
		self.gits.command("clear");
		
                #now, move file;
		command = "mv " + location + " " + newlocation;
		print command;
		mvf.write(command);
		mvf.write("\n");
		response = self.gits.command(command);
		self.printList(response);
		self.gits.command("clear");

                #delete the initial entry from the array.
		print "Deleting " + oline + " from array";
		self.contents.remove(oline); 
	mvf.close();          
        print "";
            
            
            
    #quickly saves the entire contents of the array to the file
    def saveFile(self):
        try:
            tf = open(self.telnetfile, "w");
            tf.writelines(self.contents);
            tf.close();
        except IOError, mesg:
            self.error= "Error in saveFile()" + str(mesg);
            

    #quickly opens the contents of the file into an array.
    def openFile(self):
        try:
            tf = open(self.telnetfile, "r");
            self.contents = tf.readlines();
            tf.close();
        except IOError, mesg:
            self.error= "Error in openFile()" + str(mesg);
	    
            
    def findFileInTelnet(self, id, status):
        #if the status is active, look for it in the inactive directory, and move it over if it exists there.
        #the converse is also true.
##         if status=="active":
##             location = self.inewsdir;
##         else:
##             location = self.anewsdir;

	#I'm just gonna look from the top of the plweb directory.
	location = self.plwebdir;

        #look for the file in question
        print "Looking for " + id;

        findcommand  = "find " + location + " -name \"" + id+"*\"";
        print findcommand;
	#give it a little time to think.
        response = self.gits.command(findcommand, 10);
        print response;
        size = len(response);
        if (size > 1) :
            if (response[0][-9:] == "No match"):
                return "";
            else:
                print "Found a match: "+ str(response[0]) + "<br>\n";
                return response[0];
        if (size == 1):
            return "";
        
        #print "Response" + str(response);
        #print "";


    def printList(self, mylist):
        for res in mylist:
            res.replace("<", "&lt;");
            res.replace(">", "&gt;");
            print res, "<br>";

    def get_cookies(self):
        #Copied from USENET.
        """Returns a dict containing all the cookies the client sent.
        
        If it sent two or more cookies with the same name, it returns those
        in a list.
        
        """
        
        try:
            cookie_str = os.environ['HTTP_COOKIE']
        except KeyError:
            return {}
        
        cookies = {}
        
        for s in string.split(cookie_str, '; '):
            keyval = string.split(s, '=')
            try:
                if type(cookies[keyval[0]]) == types.StringType:
                    cookies[keyval[0]] = [cookies[keyval[0]], keyval[1]]
                else:
                    cookies[keyval[0]].append(keyval[1])
            except KeyError:
                if len(keyval) > 1:
                    cookies[keyval[0]] = keyval[1]
                else:
                    pass

        return cookies

if __name__ == "__main__":
    #if you provide a host, username and password at the prompt, you can connect to the machine.
    if (len(sys.argv) == 4):
        #put sys.argv[1] as host
	#put sys.argv[2] as username
        #put sys.argv[3] as password
        host = sys.argv[1];
	username = sys.argv[2];
        password = sys.argv[3];
    else:
        host = "";
	username = "";
        password = "";

    nu = NewsUpdate(host, username, password);
    
