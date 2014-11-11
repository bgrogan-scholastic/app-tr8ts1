####################################
# Author: Todd A. Reisel
# Date: 08/31/2004
# Class: GI_LdapExportAddHostsInfo
# Derived from: GI_Transform
####################################

from GI_Transform_LdapFiles import *;
from GI_LdapPosixGroups import *
import copy;

class GI_LdapExportAddHostsInfo(GI_Transform_LdapFiles):
	def __init__(self, inputBuffer, params):
	    GI_Transform_LdapFiles.__init__(self, 'group', inputBuffer, params);
		
	def _process(self):
	    hostsData = '';

	    #always include the internal servers
	    internalServers = self._parameters['completeserversinfo'][self._parameters['locality']];
	    internalServerKeys = internalServers.keys();
	    internalServerKeys.sort();

	    for serverName in internalServerKeys:
		#make sure to not output the record for the server this file is going to, that server owns that line.
		if serverName != self._parameters['hostname']:
		    hostsData += internalServers[serverName]['ipHostNumber'][0] + "\t\t" + serverName;
		    
		    #make a deep copy of this, so that we can remove the current server.
		    serverAliases = copy.deepcopy(internalServers[serverName]['cn']);
		    serverAliases.pop(0);
		    
		    for serverAlias in serverAliases:
			hostsData += "       " + serverAlias

		    #make sure to seperate each record by a carriage return
		    hostsData += "\n";

	    #update the output buffer to be the new data
	    self._outputBuffer = self._inputBuffer + hostsData;
