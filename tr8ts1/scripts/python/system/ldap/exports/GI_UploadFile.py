#####################################
# Author: Todd A. Reisel
# Date: 08/31/2004
# Class: GI_DownloadFile
# Purpose: Upload a file to a 
#		remote server.
#####################################

import os;
import pexpect;
import socket;
socket.setdefaulttimeout(10);

class GI_UploadFile:
	def __init__(self, hostname, username, password):
		self._hostname = hostname;
		self._username = username;
		self._password = password;
		self._errorMessages = '';
		self._commitExtension = '.notcommited';
		self._commitCommands = [];

	def getErrors(self):
	    return self._errorMessages;


	def commit(self):
	    for x in self._commitCommands:
		try:
		    child = pexpect.spawn(x);
		    i = child.expect(['authenticity', 'password:']);
		    if i == 0:
			self._errorMessages += "SSH was asking for authenticity, provided it a yes answer" + "\n";
			child.sendline('yes');
			child.expect('password:');
			child.sendline(self._password);
		    else:
			child.sendline(self._password);
                
			child.expect(pexpect.EOF);
			commandResults = child.before;
			if commandResults.find('error') != -1:
			    self._errorMessages += commandResults;
			    return False;
                    
		except pexpect.EOF, message:
                      #ssh is not present on this machine.
		    self._errorMessages += "\t\tSSH server on " + self._hostname + " could not be reached for rsync over ssh command";
		    return False;
            
		except pexpect.TIMEOUT, message:
		    self._errorMessages += "\t\t" + str(message);
		    return False;

	    return True;

	#auto commit should be true by default
	def putFile(self, srcdir, srcname, destdir, destname, autoCommit = True):
            try:
		#upload the file to the remote server
		#make sure to use the --copy-links argument as /etc/hosts on solaris is a sym link to /etc/inet/hosts
		rsyncCommand = '';

		if autoCommit == True:
		    rsyncCommand = "rsync --copy-links -az -e ssh %s %s@%s:%s " % (os.path.join(srcdir, srcname), self._username, self._hostname, os.path.join(destdir, destname));
		else:
		    rsyncCommand = "rsync --copy-links -az -e ssh %s %s@%s:%s%s " % (os.path.join(srcdir, srcname), self._username, self._hostname, os.path.join(destdir, destname), self._commitExtension);
		
		    commitCommand = "ssh %s@%s unalias cp; cp -f \ %s%s\ %s" % (self._username, self._hostname, os.path.join(destdir, destname), self._commitExtension, os.path.join(destdir, destname));

		    #save the commit command for later, so that it can be run as a batch process
		    self._commitCommands.append(commitCommand);


		child = pexpect.spawn(rsyncCommand);
		i = child.expect(['authenticity', 'password:']);
		if i == 0:
		    self._errorMessages += "SSH was asking for authenticity, provided it a yes answer" + "\n";
		    child.sendline('yes');
		    child.expect('password:');
		    child.sendline(self._password);
		else:
		    child.sendline(self._password);
                
		    child.expect(pexpect.EOF);
		    commandResults = child.before;
		    if commandResults.find('error') != -1:
			self._errorMessages += commandResults;
			return False;
                    
            except pexpect.EOF, message:
                #ssh is not present on this machine.
                self._errorMessages += "\t\tSSH server on " + self._hostname + " could not be reached for rsync over ssh command";
                return False;
            
            except pexpect.TIMEOUT, message:
                self._errorMessages += "\t\t" + str(message);
                return False;

	    return True;
	    
if __name__ == '__main__':
	df = GI_UploadFile('linuxstage.grolier.com', 'root', 'DL*blinx6');
	print df.putFile('/etc', '/data/techsvs/ldap-exports/passwd/passwd.stress2', '/etc', 'p.temp');
	print df.putFile('/etc', '/data/techsvs/ldap-exports/shadow/shadow.stress2', '/etc', 's.temp');
	print df.putFile('/etc', '/data/techsvs/ldap-exports/hosts/hosts.stress2', '/etc',  'h.temp');
	print df.putFile('/etc', '/data/techsvs/ldap-exports/group/group.stress2', '/etc', 'g.temp');
	
	print df.getErrors();
