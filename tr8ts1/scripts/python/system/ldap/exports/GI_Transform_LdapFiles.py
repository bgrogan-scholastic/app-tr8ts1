##################################
# Author: Todd A. Reisel
# Date: 08/31/2004
# Class: GI_Transform_LdapFiles
# Purpose: an interface for
#	building transformations
##################################

from system.common.utils.GI_Transform import *;

class GI_Transform_LdapFiles(GI_Transform):
	def __init__(self, name, inputBuffer, params):
	        GI_Transform.__init__(self, name, inputBuffer, params);
		self._ldapMarker = "+:x:::::";

		#make sure to remove the existing ldap data
                #remove the content after the +:x:::::
		startPos = self._inputBuffer.find(self._ldapMarker);

		if startPos != -1:
		    #remove everything including / after +:x
		    self._inputBuffer = self._inputBuffer[0:startPos];

		#make sure to add the marker!
		self._inputBuffer += self._ldapMarker + "\n";
		self._outputBuffer = self._inputBuffer;

	#this is the template pattern function of process function
	def _process(self):
		pass;
