####################################
# Author: Todd A. Reisel
# Date: 08/31/2004
# Class: GI_LdapExportAddShadowInfo
# Derived from: GI_Transform_LdapFiles
####################################

from GI_Transform_LdapFiles import *;
from GI_LdapUserAccounts import *

class GI_LdapExportAddShadowInfo(GI_Transform_LdapFiles):
	def __init__(self, inputBuffer, params):
	    GI_Transform_LdapFiles.__init__(self, 'shadow', inputBuffer, params);
		
	def _process(self):
	    self._outputBuffer = self._inputBuffer + GI_LdapUserAccounts().getShadowByHost(self._parameters['hostname']);

		
