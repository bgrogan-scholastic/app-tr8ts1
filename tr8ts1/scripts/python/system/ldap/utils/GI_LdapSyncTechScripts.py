
__author__ = "Todd Reisel"
__date__ = "September 13, 2004"

from GI_LdapServersExportList import *;
import pexpect;

class GI_LdapSyncTechScripts:
	def __init__(self):
		self._serversList = GI_LdapServersExportList();
		self._limitedList = self._serversList.getLimitedServerList();
		self._errorMessages = '';

	def sync(self):
		print "Getting a list of servers to syncronize the tech scripts (/data/techsvs/scripts) to";

		for localityName in self._limitedList.keys():
			for serverName in self._limitedList[localityName].keys():
				serverObject = self._limitedList[localityName][serverName];
				serverIPAddress = serverObject['ipHostNumber'][0];

				rootpassword = serverObject['rootpassword'][0];

				if ( (serverName != "linuxdev") and (serverName !="devserver2") ):
					print serverName;
					commandResult = self._syncScripts(localityName, serverName, serverIPAddress, rootpassword);
					if commandResult == False:
						print "\tSync Failed!";
						print "\t" + self._errorMessages;
					else:
						print "\tCompleted";

					print "";

	def _syncScripts(self, localityName, serverName, ipAddress, rootpassword):
            try:
		child = pexpect.spawn("rsync -avzogp -e ssh /data/techsvs/scripts root@%s:/data/techsvs" % (ipAddress));
		i = child.expect(['authenticity', 'password:']);
		if i == 0:
		    self._errorMessages += "SSH was asking for authenticity, provided it a yes answer" + "\n";
		    child.sendline('yes');
		    child.expect('password:');
		    child.sendline(rootpassword);
		else:
		    child.sendline(rootpassword);
		
		child.expect(pexpect.EOF);

		commandResults = child.before;

		if commandResults.find('error') != -1:
		    self._errorMessages += commandResults;
		    return False;
                    
	    except pexpect.EOF, message:
                #ssh is not present on this machine.
                self._errorMessages += "\t\tSSH server on " + serverName + " could not be reached for rsync over ssh command";
                return False;
            
            except pexpect.TIMEOUT, message:
                self._errorMessages += "\t\t" + str(message);
                return False;

	    return True;


if __name__ == '__main__':
	techScripts = GI_LdapSyncTechScripts();
	techScripts.sync();

