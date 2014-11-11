#################################################
# Author: Todd A. Reisel
# Date: 08/31/2004
# Class GI_LdapServersExportList
# Purpose: Provide a list of servers in ldap
#################################################

from system.ldap.utils.GI_LdapServersList import *;

class GI_LdapServersExportList(GI_LdapServersList):
	def __init__(self):
	    GI_LdapServersList.__init__(self);
	
	def getCompleteServerList(self):
	    return self.getServerList();

	def getLimitedServerList(self):
		servers = {};
		for localityName in self._localities:
			for serverName in self._localities[localityName]:
				if self._localities[localityName][serverName].has_key('exportLdapData'):
					if self._localities[localityName][serverName]['exportLdapData'][0] == 'Y':
						#make sure the locality key exists
						if servers.has_key(localityName) == False:
							servers[localityName] = {};
						
						servers[localityName][serverName] = self._localities[localityName][serverName];
		return servers;
					
	def exportCommitToServer(self, localityName, serverName):
		returnResult = False;
		
		if self._localities[localityName].has_key(serverName):
			if self._localities[localityName][serverName].has_key('exportLdapCommitData'):
				if self._localities[localityName][serverName]['exportLdapCommitData'][0] == 'Y':
					returnResult = True;
		
		return returnResult;
		
if __name__ == '__main__':
	serverList = GI_LdapServersExportList();
	servers = serverList.getServerList();
	for localityName in servers:
		for serverName in servers[localityName]:
			print serverName;
			if serverList.exportCommitToServer(localityName, serverName) == True:
				print "Commit to: " + serverName;
