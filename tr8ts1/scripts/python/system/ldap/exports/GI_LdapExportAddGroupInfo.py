####################################
# Author: Todd A. Reisel
# Date: 08/31/2004
# Class: GI_LdapExportAddGroupInfo
# Derived from: GI_Transform_LdapFiles
####################################

from GI_Transform_LdapFiles import *;
from GI_LdapPosixGroups import *

class GI_LdapExportAddGroupInfo(GI_Transform_LdapFiles):
	def __init__(self, inputBuffer, params):
	    GI_Transform_LdapFiles.__init__(self, 'group', inputBuffer, params);
		
	def _process(self):
	    self._outputBuffer = self._inputBuffer + GI_LdapPosixGroups().getGroups();
		
