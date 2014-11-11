###################################################################################
# Author: Todd Reisel
# Class: OS_Commands
# Date: April, 26rd, 2004
# Description: Provide cd, dir, ls, pwd functionality
#              In addition provide 
#				use <workspace>		- changes workspace
#				use 			- prints current workspace
###################################################################################

import os;
import sys;

#determine which module to import
if sys.platform == 'sunos5':
    #running on solaris, pexpect does not work, so use GI classes.
    import giTelnet;
    import giFtp;
else:
    #on another system, like linux, use pexpect;
    import pexpect;

class OS_Commands:
    def __init__(self, userInformation, hostname, baseDirectory, currentWorkspace):
        self._userInformation = userInformation;
        self._hostname = hostname;
        self._username = userInformation.getUsername();
        self._password = userInformation.getPassword(self._hostname);

        self._baseDirectory = baseDirectory;
        self._currentWorkspace = currentWorkspace;        
        self._currentDirectory = os.path.join(self._baseDirectory, self._currentWorkspace);

    def getCurrentWorkspace(self):
    	return self._currentWorkspace;
    	
    def getCurrentDirectory(self):
    	return self._currentDirectory;
    	  
    def command(self, command):
        if command.startswith('help') or command.startswith('?'):
            print self._help();
        
        elif command.startswith('pwd'):
            print self._pwd();
            
        elif command.startswith('use'):
            commandArgs = command.split(" ", 1);
            commandArgs.pop(0);
            self._use(commandArgs);

        elif command.startswith('dir') or command.startswith('ls'):
            self._dir();

        elif command.startswith('cd'):
            commandArgs = command.split(" ", 1);
            commandArgs.pop(0);
            self._cd(commandArgs);
	
	elif command.startswith('cat'):
            commandArgs = command.split(" ", 1);
            commandArgs.pop(0);
            self._view(commandArgs);
	

    def _cd(self, commandArgs):
        if len(commandArgs) == 0:
            #change to the root workspace directory
            self._currentDirectory = os.path.join(self._baseDirectory, self._currentWorkspace);
            print "Changed directory to: " + self._currentDirectory;
        else:
            cdCommandArg = commandArgs[len(commandArgs)-1];

            if cdCommandArg.startswith('..'):
            	#move back a directory
                if self._currentDirectory == os.path.join(self._baseDirectory, self._currentWorkspace):
                    print "Cd failed...You are at the root of the current workspace: " + self._currentWorkspace;
                else:
                    newDirectory = os.path.split(self._currentDirectory)[0];
                    self._currentDirectory = newDirectory;
                    print "Changed Directory to: " + self._currentDirectory;
            else:
                self._currentDirectory = os.path.join(self._currentDirectory, cdCommandArg);
                print "Changed Directory to: " + self._currentDirectory;


    def _use(self, commandArgs):
        if len(commandArgs) == 0:
            print "Using workspace: " + self._currentDirectory;
        else:
            self._currentWorkspace = commandArgs[0];
            self._currentDirectory = os.path.join(self._baseDirectory, self._currentWorkspace);
            print "Switched workspace to: " + self._currentDirectory;


    def _dir(self):
    	print "Directory Listing for: " + self._currentDirectory;
    	
    	if sys.platform == 'sunos5':
	    myTelnet = giTelnet.giTelnet(self._hostname, self._username, self._password);
	    commandResults = myTelnet.command('/bin/ls -l %s' % (self._currentDirectory) );
	    for x in range(len(commandResults) -1):
		print commandResults[x];
	    myTelnet.close();
	    print "";
        else:
	    child = pexpect.spawn("ssh -l %s %s /bin/ls -l %s" % (self._username, self._hostname, self._currentDirectory))
	    
	    child.expect('password:');        
	    child.sendline(self._password);
	    
	    child.expect(pexpect.EOF);
	    print child.before;

    def _view(self, commandArgs):
        print "Viewing File: " + os.path.join(self._currentDirectory, commandArgs[0]);

    	if sys.platform == 'sunos5':
	    myTelnet = giTelnet.giTelnet(self._hostname, self._username, self._password);
	    commandResults = myTelnet.command('/bin/cat %s' % (os.path.join(self._currentDirectory, commandArgs[0])));
	    for x in range(len(commandResults) -1):
		print commandResults[x];
	    myTelnet.close();
	    print "";
    	else:
	    child = pexpect.spawn("ssh -l %s %s /bin/cat %s" % (self._username, self._hostname, os.path.join(self._currentDirectory, commandArgs[0])));
	
	    child.expect('password:');        
	    child.sendline(self._password);
	    
	    child.expect(pexpect.EOF);
	    print child.before;


    def _pwd(self):
        return self._currentDirectory;


    def _help(self):
        return """
Interactive Mode help:
	
	Basic Command Set:
	
	help or ?           - you are here :)
	cat   <file>	    - view the contents of the file specified
	cd                  - changes to top-level workspace directory
	cd    <directory>   - changes to the specified directory
	dir or ls           - get a directory listing for the current directory
	pwd                 - the current working directory
	use                 - displays the name of the current workspace
	use   <workspace>   - changes the current workspace
	
	------------------------------------------------------------------------
	SCCS Command Set:
	
	edit       <file>   - checkout a file
	unedit     <file>   - undo changes to a checked out file
	checkin    <file>   - check in a checked out file
	checkinnew <file>   - check in a new file to source code control

	diff	   <file>   - compare current file contents to last checked
				in version.

	status		    - list files for the current user in this workspace:
				  -> that have never been checked in
			 	  -> that are currently checked out

	statusall	    - list files for all users in this workspace:
				  -> that have never been checked in
			 	  -> that are currently checked out

	quit                - exits program

	""";
