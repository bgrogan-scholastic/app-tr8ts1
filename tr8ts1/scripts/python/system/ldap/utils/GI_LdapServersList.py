#################################################
# Author: Todd A. Reisel
# Date: 08/31/2004
# Class GI_LdapServersList
# Purpose: Provide a list of servers in ldap
#################################################

import ldap;
import utils.GI_XPath;

class GI_LdapServersList:
	def __init__(self):

		#open up the ldap config file and get settings
		self._configFile = utils.GI_XPath.GI_XPath('/data/techsvs/config/ldapexports.xml');

		self._configAttributes = self._configFile.query('/ldapexports/config');
		#get the ldap information out of the config file
		self._ldapUsername = self._configAttributes[0].getAttribute('ldapuser');
		self._ldapPassword = self._configAttributes[0].getAttribute('ldappassword');
		self._ldapServer = 'gicauthm.grolier.com';

		#get a list of localities (i.e: Danbury, Internal, etc.)
		self._ldapurl = "ldap://localhost/";
		self._ldapConnection = ldap.initialize(self._ldapurl)
		self._ldapConnection.bind_s(self._ldapUsername, self._ldapPassword, ldap.AUTH_SIMPLE);
		

		#get the root word out of the ldap database
		rootwordEntry = self._ldapConnection.search_s('dc=grolier,dc=com', ldap.SCOPE_ONELEVEL, "(uid=rootword)", []);
		rootword = rootwordEntry[0][1]['userPassword'][0];

		localities = self._ldapConnection.search_s('ou=Networking,dc=grolier,dc=com', ldap.SCOPE_ONELEVEL, "(objectClass=giNetworkLocation)", []);
		
		self._localities = {};
		
		for x in localities:
			localityName = x[1]['ou'][0];
			localityPwcode = x[1]['pwcode'][0];

			self._localities[localityName] = {};
			
			#search for servers in this locality
			servers = self._ldapConnection.search_s('ou=Physical Machines,' + x[0], ldap.SCOPE_ONELEVEL, "(|(objectClass=giLinuxServer)(objectClass=giSunServer))", []);
			for y in servers:
				serverName = y[1]['cn'][0];

				#determine what the root password for this machine is.  check to see
				# if the machine itself has its own rootword, if so , use it.
				serverRootword = '';
				serverRootPassword = '';

				if y[1].has_key('pwcode'):
					if y[1].has_key('rootword'):
						serverRootword = y[1]['rootword'][0];
						serverRootPassword = localityPwcode + y[1]['pwcode'][0] + '*' + serverRootword;
					else:
						serverRootPassword = localityPwcode + y[1]['pwcode'][0] + '*' + rootword;

				y[1]['rootpassword'] = [];
				y[1]['rootpassword'].append(serverRootPassword);

				self._localities[localityName][serverName] = y[1];
				
	def getServerList(self):
		return self._localities;	

if __name__ == '__main__':
	serverList = GI_LdapServersList();
	print serverList.getServerList();
