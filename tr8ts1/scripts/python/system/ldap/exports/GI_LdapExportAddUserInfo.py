####################################
# Author: Todd A. Reisel
# Date: 08/31/2004
# Class: GI_LdapExportAddUserInfo
# Derived from: GI_Transform_LdapFiles
####################################

from GI_Transform_LdapFiles import *;
from GI_LdapUserAccounts import *

class GI_LdapExportAddUserInfo(GI_Transform_LdapFiles):
	def __init__(self, inputBuffer, params):
	    GI_Transform_LdapFiles.__init__(self, 'group', inputBuffer, params);
		
	def _process(self):
	    self._outputBuffer = self._inputBuffer + GI_LdapUserAccounts().getUsersByHost(self._parameters['hostname']);
		
