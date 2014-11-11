##############################################
# Author: Todd Reisel
# Class: SCCS_Commands
# Date: April, 26th, 2004
# Description: Mimic sccs commands set
##############################################

import os;
import random;
import sys;


#determine which module to import
if sys.platform == 'sunos5':
    #running on solaris, pexpect does not work, so use GI classes.
    import giTelnet;
    import giFtp;
else:
    #on another system, like linux, use pexpect;
    import pexpect;

class SCCS_Commands:
	def __init__(self, userInformation, sccsServer):
		self._sccsServer = sccsServer;

		self._userInformation = userInformation;
		self._sccsUsername = self._userInformation.getUsername();
		self._sccsPassword = self._userInformation.getPassword(self._sccsServer);

		#connection was successful
		self._errorFlag = 1;
		self._errorMessage = '';

		
		self._checkinCommand = '/usr/ccs/bin/sccs delget -s -y\"<comments>\"';
		self._checkinNewCommand = '/usr/ccs/bin/sccs create -y\"<comments>\"';
		self._checkoutCommand = '/usr/ccs/bin/sccs edit';
		self._uncheckoutCommand = '/usr/ccs/bin/sccs unedit';
		self._sccsStatusCommand = '/usr/bin/sccsstatus <workspace>';
		self._sccsDiffCommand = '/usr/ccs/bin/sccs get -s -G<filename>.sccstool_diff <filename> ' + "\n" + ' echo \"\"; echo \"--------------------------------------------------------------------------------\"; echo \"Current File Contents					Previous File Contents\"; echo \"--------------------------------------------------------------------------------\"; 		sdiff -l <filename> ./<filename>.sccstool_diff' + "\n" + 'rm ./<filename>.sccstool_diff' + "\n";


		if sys.platform == 'sunos5':
	    		myTelnet = giTelnet.giTelnet(self._sccsServer, self._sccsUsername, self._sccsPassword);
	    		myTelnet.command('/bin/ls -l');
	    		myTelnet.close();				
		else:
			try:
			    #check to see if a connection can be established
			    child = pexpect.spawn("ssh -l %s %s /bin/ls -l"%(self._sccsUsername, self._sccsServer))
			    i = child.expect(['authenticity', 'password:']);
			    if i == 0:
				print "SSH was asking for authenticity, provided it a yes answer";
				child.sendline('yes');
				child.expect('password:');
				child.sendline(self._sccsPassword);
			    else:
				child.sendline(self._sccsPassword);
	
			    child.expect(pexpect.EOF);
	
			except pexpect.TIMEOUT, message:
				self._errorMessage = message;
				self._errorFlag = 0;

	def isGood(self):
		return self._errorFlag;

	def getErrors(self):
		return self._errorMessage;
	
	def command(self, currentWorkspace, currentDirectory, command):
		commandArgs = command.split(' ');
		action = commandArgs[0];
		
		mycommand = '';
		sccsCommand = '';
		
		if action == 'edit':
			fileName = commandArgs[1];		
			mycommand = self._checkout(fileName);
			sccsCommand = '#!/bin/csh\ncd %s; \n%s %s\n' % (currentDirectory, mycommand, fileName);

		elif action == 'unedit':
			fileName = commandArgs[1];		
			mycommand = self._uncheckout(fileName);
			sccsCommand = '#!/bin/csh\ncd %s; \n%s %s\n' % (currentDirectory, mycommand, fileName);

		elif action == 'checkinnew':
			fileName = commandArgs[1];		
			mycommand = self._checkinnew(fileName);
			sccsCommand = '#!/bin/csh\ncd %s; \n%s %s\necho "Sccs Command Completed"\n' % (currentDirectory, mycommand, fileName);

		elif action == 'checkin':
			fileName = commandArgs[1];		
			mycommand = self._checkin(fileName);
			sccsCommand = '#!/bin/csh\ncd %s; \n%s %s\necho "Sccs Command Completed"\n' % (currentDirectory, mycommand, fileName);
		elif action == 'diff':
		    fileName = commandArgs[1];
		    mycommand = self._diff(fileName);
		    sccsCommand = '#!/bin/csh\ncd %s; \n%s\necho "Sccs Command Completed"\n' % (currentDirectory, mycommand);

		#get the checkin / checkout status for current user logged in
		elif action == 'status':
			mycommand = self._sccsStatus(currentWorkspace);
			sccsCommand = '#!/bin/csh\ncd %s; \n%s %s\n' % (currentDirectory, mycommand, self._sccsUsername);
		
		#get the checkin / checkout status for all users
		elif action == 'statusall':
			mycommand = self._sccsStatus(currentWorkspace);
			sccsCommand = '#!/bin/csh\ncd %s; \n%s %s\n' % (currentDirectory, mycommand, 'all');			
		
		#generate a random file name for this command.
		randomFilename = "sccstool_" + str(self.getRandomSccsID());
		

		localFilename = '/tmp/' + randomFilename;
		
		#write the remote commands into a file.
		fp = open(localFilename, 'w');
		fp.write(sccsCommand);
		fp.close();
		
		if sys.platform == 'sunos5':
		    myFtp = giFtp.giFtp(self._sccsServer, self._sccsUsername, self._sccsPassword);
		    print myFtp.binary_put(localFilename, localFilename);
		    
		    myTelnet = giTelnet.giTelnet(self._sccsServer, self._sccsUsername, self._sccsPassword);
		    commandResults = myTelnet.command('chmod 755 /tmp/%s; /tmp/%s; rm /tmp/%s' % (randomFilename, randomFilename, randomFilename), 5);
		    for x in range(len(commandResults) -1):
			print commandResults[x];
		    myTelnet.close();
		    print "";		    	
		    pass;
		else:	
		    try:
 	                #Copy the command to the sccs server, this is to avoid issues with sccs comments.
			child = pexpect.spawn('ftp ' + self._sccsServer);
			child.expect(': ');        
			child.sendline(self._userInformation.getUsername());
			child.expect('Password:');
			child.sendline(self._userInformation.getPassword(self._sccsServer));
			child.expect('ftp> ');
			child.sendline('cd /tmp');
			child.expect('ftp> ');
			child.sendline('bin');
			child.expect('ftp> ');
	                #change to the temp directory locally
			child.sendline('lcd /tmp');
			child.expect('ftp> ');
			child.sendline('put ' + randomFilename);
			child.expect('ftp> ');
			child.sendline('quit');
			child.expect(pexpect.EOF);
			
	                #remove the following from the returned commands
			removeList = ['221 Goodbye', 'Warning', 'stty', 'No match'];
	    
	                #change the permissions on the dynamic script, execute the sccs command and remove the temp file.
			remoteCommand = 'ssh -l %s %s "chmod 755 /tmp/%s; /tmp/%s; rm /tmp/%s"' % (self._sccsUsername, self._sccsServer, randomFilename, randomFilename, randomFilename);
			
	                #execute the sccs command, first cd to the remote directory, then use sccs to perform actions on the files.
			child = pexpect.spawn(remoteCommand);
			child.expect('password:');        
			child.sendline(self._userInformation.getPassword(self._sccsServer));
			child.expect(pexpect.EOF);
	
	                #remove the following strings from command
	
  	                #Warning
	                #stty
	                #quit
	                #221 Goodbye
	
			print child.before;

		    except pexpect.TIMEOUT, message:
			#remove the local filesystem temporary sccs file
			os.system("rm -f /tmp/" + randomFilename);
			print message;
			self._errorMessage = message;
			self._errorFlag = 0;
	    
	        #remove the temporary sccs file.
		os.system("rm -f /tmp/" + randomFilename);
			    


		
	def _substituteCommandParameters(self, command, fileName, comments = ''):
		newCommand = command;
		
		#make the substitution for the comments if they apply.
		if newCommand.find('<comments>') != -1:
			newCommand = newCommand.replace("<comments>", comments);		
		
		return newCommand;
	
	def _sccsStatus(self, currentWorkspace):
		newCommand = self._sccsStatusCommand;

		#make the substitution for the workspace if they apply.
		if newCommand.find('<workspace>') != -1:
			newCommand = newCommand.replace("<workspace>", currentWorkspace);		

		return newCommand;
	
	def _diff(self, fileName):
		newCommand = self._sccsDiffCommand.replace("<filename>", fileName);
		return newCommand;

	def _checkin(self, fileName):
		comments = self._getSCCSCheckinComments(fileName);
		return self._substituteCommandParameters(self._checkinCommand, fileName, comments);
		
	def _checkinnew(self, fileName):
		comments = self._getSCCSCheckinComments(fileName);
		return self._substituteCommandParameters(self._checkinNewCommand, fileName, comments);
	
	def _checkout(self, fileName):
		return self._substituteCommandParameters(self._checkoutCommand, fileName);	

	def _uncheckout(self, fileName):
		return self._substituteCommandParameters(self._uncheckoutCommand, fileName);
		

	def _getSCCSCheckinComments(self, filePath):
		#get the comments for this newly checked in file
		comments = '';

		while(len(comments) == 0):
			#keep asking for comments until some are entered
			print "Checking in " + filePath + "....";
			comments = self._sccsUsername + '-' + raw_input('Please enter your comments: ');

		#comments were successfully entered, return them.
		return comments;
	

	def getRandomSccsID(self):
		#get a random number
		return random.randint(0, 100000000);
