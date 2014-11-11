######################################################
# Author: Todd A. Reisel
# Date: 7/20/2004
# GI_LdapUserAccount
#
# Description: represents a user in the ldap database
######################################################

class GI_LdapUserAccount:
    def __init__(self, basedn, name, attributes):

        #the username
        self._name = name;

        #the ldap location of this record
        self._basedn = basedn;

        #attributes about this user
        self._attributes = attributes;

        #a list of servers this user has access to.
        self._hosts = {};

        #don;t assume the user has access to any machines
        if self._attributes.has_key('host') == True:
            for x in self._attributes['host']:
                self._hosts[x] = 'yes';

    def getUserPassword(self):

        #get rid of the word {crypt}
        crypt = "{crypt}";
        cryptlen = len(crypt);
	userPassword = self._attributes['userPassword'][0];
	#if self._name == 'gii':
	#	print "Working Value: N1PlmtVz8a5Ys		Ldap Value: " + userPassword[cryptlen:len(userPassword)];
   
	userPassword = userPassword[cryptlen:len(userPassword)]; 

        return userPassword;
    
    def getUserId(self):
        return self._attributes['uidNumber'][0];
    
    def getPrimaryGroupId(self):
        return self._attributes['gidNumber'][0];

    def getHomeDirectory(self):
        return self._attributes['homeDirectory'][0];

    def getLoginShell(self):
        return self._attributes['loginShell'][0];
    
    #does the user have access to the specified hostname?
    def hasHostAccess(self, hostname):
        if self._hosts.has_key(hostname) == True:
            return True;
        else:
            return False;

    #get the username
    def getName(self):
        return self._name;
    
        
