############################################
# Author: Todd A. Reisel
# Date: 7/20/2004
# GI_LdapUserAccounts
#
# Description: a list of unix user accounts
############################################

import ldap;
from utils.GI_XPath import *;
from GI_LdapUserAccount import *;

class _GI_LdapUserAccounts:
    _GI_LdapUserAccounts_Instance = None;
    
    def __init__(self):
        self._userAccounts = [];

	configFile = GI_XPath('/data/techsvs/config/ldapexports.xml');
	config = configFile.query('/ldapexports/config')[0];

	ldapurl = "ldap://gicauthm.grolier.com/";
	l = ldap.initialize(ldapurl);
	l.bind_s(config.getAttribute('ldapuser'), config.getAttribute('ldappassword'), ldap.AUTH_SIMPLE);
	
	#do a search for all the users
	for x in l.search_s('ou=Users,dc=grolier,dc=com', ldap.SCOPE_ONELEVEL, 'objectclass=giUserAccount'):
		username = x[1]['cn'][0];
		userdn = x[0];
		attributes = x[1];
		
		ua = GI_LdapUserAccount(userdn, username, attributes);
		#print ua.getName() + ", primary group: " + ua.getPrimaryGroup() + ", access to stage: " + ua.hasHostAccess('stage');
	
		self.add(ua);

    def add(self, userAccount):
        self._userAccounts.append(userAccount);
    
    def getShadowByHost(self, hostname):
    	contents = '';
    	
    	for x in self._userAccounts:
    		if x.hasHostAccess(hostname) == True:
    			contents += x.getName() + ":" + x.getUserPassword() + ":12487:0:99999:7:::\n";
    			
    	return contents;

    	
    def getUsersByHost(self, hostname):
    	contents = '';
    	
        userList = [];

        #loop over every user account and see if they have access to this host
        for x in self._userAccounts:
            if x.hasHostAccess(hostname) == True:
                
                contents += x.getName() + ':' + 'x:' + x.getUserId() + ':' + x.getPrimaryGroupId() + '::' + x.getHomeDirectory() + ':' + x.getLoginShell() + '\n';

        return contents;
    
def GI_LdapUserAccounts():
    if _GI_LdapUserAccounts._GI_LdapUserAccounts_Instance == None:
        _GI_LdapUserAccounts._GI_LdapUserAccounts_Instance = _GI_LdapUserAccounts();

    return _GI_LdapUserAccounts._GI_LdapUserAccounts_Instance;

