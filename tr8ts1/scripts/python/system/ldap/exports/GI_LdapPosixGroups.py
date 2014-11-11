######################################################
# Author: Todd A. Reisel
# Date: 7/20/2004
# GI_LdapPosixGroups
#
# Description: represents a list of posix groups
######################################################

import ldap;
from utils.GI_XPath import *;
from GI_LdapPosixGroup import *;

class _GI_LdapPosixGroups:
    _GI_LdapPosixGroups_Instance = None;
    
    def __init__(self):
        self._posixGroups = [];

        configFile = GI_XPath('/data/techsvs/config/ldapexports.xml');
	config = configFile.query('/ldapexports/config')[0];


	ldapurl = "ldap://localhost/"
	l = ldap.initialize(ldapurl)
	l.bind_s(config.getAttribute('ldapuser'), config.getAttribute('ldappassword'), ldap.AUTH_SIMPLE);

	#do a search for all the groups
	for x in l.search_s('ou=Groups,dc=grolier,dc=com', ldap.SCOPE_ONELEVEL, 'objectclass=posixGroup'):
		groupname = x[1]['cn'][0];
		groupdn = x[0];

		attributes = x[1];

		pg = GI_LdapPosixGroup(groupdn, groupname, attributes);
		self.add(pg);

    def add(self, group):
        self._posixGroups.append(group);
        
    def getGroups(self):
	contents = '';
	
	for x in self._posixGroups:
		contents += x.getName() + ':x:' + x.getGroupId() + ":";
		i = 0;
		
		for y in x.getUsers():
			if i != 0:
				contents += ',';				
			
			contents += y;
			i = i + 1;

		contents += "\n";

        return contents;
    
def GI_LdapPosixGroups():
    if _GI_LdapPosixGroups._GI_LdapPosixGroups_Instance == None:
        _GI_LdapPosixGroups._GI_LdapPosixGroups_Instance = _GI_LdapPosixGroups();

    return _GI_LdapPosixGroups._GI_LdapPosixGroups_Instance;

