#####################################
# Author: Todd A. Reisel
# Date: 08/31/2004
# Class: GI_DownloadFile
# Purpose: Download a file from a 
#		remote server.
#####################################

import os;
import pexpect;
import socket;
socket.setdefaulttimeout(10);

class GI_DownloadFile:
	def __init__(self, hostname, username, password):
		self._hostname = hostname;
		self._username = username;
		self._password = password;
		self._errorMessages = '';
	
	def getErrors(self):
	    return self._errorMessages;

	def getFile(self, srcdir, srcname, destdir, destname):
            #create the destination directory if it does not exist
            if not os.path.exists(destdir):
            	os.system("mkdir -p " + destdir);
            
            try:
                  #download the file from the remote server
                  #make sure to use the --copy-links argument as /etc/hosts on solaris is a sym link to /etc/inet/hosts
                  child = pexpect.spawn("rsync --copy-links -az -e ssh %s@%s:%s %s" % (self._username, self._hostname, os.path.join(srcdir, srcname), os.path.join(destdir, destname)));
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
                  
		  #make sure to change the ownership of these files so they are correct
		  os.system("chown techsvs:techsvs %s"  % os.path.join(destdir, destname) );

		  #make sure no one can read these files other than techsvs user and group users.
		  os.system("chmod 660 %s"  % os.path.join(destdir, destname) );

            except pexpect.EOF, message:
                #ssh is not present on this machine.
                self._errorMessages += "\t\tSSH server on " + self._hostname + " could not be reached for rsync over ssh command";
                return False;
            
            except pexpect.TIMEOUT, message:
                self._errorMessages += "\t\t" + str(message);
                return False;

	    return True;

if __name__ == '__main__':
	df = GI_DownloadFile('linuxstage.grolier.com', 'root', 'DL*blinx6');
	print df.getFile('/etc', 'passwd', '/data/techsvs/ldap-exports/passwd', 'passwd.stress2');
	print df.getFile('/etc', 'shadow', '/data/techsvs/ldap-exports/shadow', 'shadow.stress2');
	print df.getFile('/etc', 'hosts', '/data/techsvs/ldap-exports/hosts', 'hosts.stress2');
	print df.getFile('/etc', 'group', '/data/techsvs/ldap-exports/group', 'group.stress2');
	print df.getErrors();
