######################################################
# Author: Todd A. Reisel
# Date: 7/20/2004
# GI_LdapPosixGroup
#
# Description: represents a unix group in ldap
######################################################

class GI_LdapPosixGroup:
    def __init__(self, basedn, name, attributes):
        self._name = name;
        self._basedn = basedn;
        self._attributes = attributes;
        self._users = {};
        self._usersList = [];
        

        if self._attributes.has_key('memberUid'):
            for x in self._attributes['memberUid']:
                self._users[x] = 'yes';
                self._usersList.append(x);
                
            
    def _load(self):
        pass;

    def getGroupId(self):
        return self._attributes['gidNumber'][0];

    def getUsers(self):
        return self._usersList;
    
    def hasUser(self, username):
        if self._users.has_key(username):
            return 'yes';
        else:
            return 'no';
        
    def getName(self):
        return self._name;
    
        
