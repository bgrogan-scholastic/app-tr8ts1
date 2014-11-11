<?php

class GI_LdapUserAccount {
	/**
	 * the user's name
	 *
	 * @var string
	 */
	var $username;
	
	/**
	 * the user's password
	 *
	 * @var string
	 */
	var $password;
	
	/**
	 * is the user authenticated?
	 *
	 * @var boolean
	 */
	var $isAuthenticated;
	
	/**
	 * the user's unix id
	 *
	 * @var integer
	 */
	var $uID;
	
	/**
	 * the user's primary unix group id
	 *
	 * @var integer
	 */
	var $primaryGroupID;
		
	function __construct($username, $password) {
		/* load all of the session information */
		$this->username = $username;
		$this->password = $password;
		
		$ldapConnection = new GI_LdapConnection($this->username, $this->password);
		$this->isAuthenticated = $ldapConnection->isConnected();
		$this->rdn = "ou=Users,dc=grolier,dc=com";
		
		$ldapConnection->disconnect();
		
		/* need to determine the user's primary group id */
		$ldapUserSearchQuery = ldap_search($ldapConnection->getConnection(), "ou=Users,dc=grolier,dc=com", "(cn=" . $this->username . ")");
		$ldapUserSearchResult = ldap_get_entries($ldapConnection->getConnection(), $ldapUserSearchQuery);

		$this->uID = $ldapUserSearchResult[0]['uidnumber'][0];
		$this->primaryGroupID = $ldapUserSearchResult[0]['gidnumber'][0];
	}
		
	function setUsername($username) {
		$this->username = $username;
	}
	
	function getUsername() {
		return $this->username;
	}
	
	function setPassword($password) {
		$this->password = $password;
	}
	
	function getPassword() {
		return $this->password;
	}
	
	function isAuthenticated() {
		return $this->isAuthenticated;
	}
	
	function getUserGroups() {
		$ldapConnection = new GI_LdapConnection($this->username, $this->password);

		/* need to determine what groups the user has get the user's primary group */
		$ldapGroupSearchQuery = ldap_search($ldapConnection->getConnection(), "ou=Groups,dc=grolier,dc=com", "(gidNumber=" . $this->primaryGroupID . ")");
		$ldapGroupSearchResult = ldap_get_entries($ldapConnection->getConnection(), $ldapGroupSearchQuery);
		$this->userGroups = array( $ldapGroupSearchResult[0]['cn'][0] );
		
		/* get the user's secondary groups make sure to only look in posixGroup objects based on memberUid attribute */
		$ldapSecondaryGroupSearchQuery = ldap_search($ldapConnection->getConnection(), "ou=Groups,dc=grolier,dc=com", "(&(objectClass=posixGroup)(memberUid=" . $this->username . "))");
		$ldapSecondaryGroupSearchResult = ldap_get_entries($ldapConnection->getConnection(), $ldapSecondaryGroupSearchQuery);

		for($i = 0; $i < $ldapSecondaryGroupSearchResult['count']; $i++) {
		  /* add this group to the groups list */
		  $this->userGroups[] = $ldapSecondaryGroupSearchResult[$i]['cn'][0];
		}
		sort($this->userGroups);

		$ldapConnection->disconnect();
		
		return $this->userGroups;
	}

	function getUserServers() {
		$ldapConnection = new GI_LdapConnection($this->username, $this->password);
		
		$ldapUserSearchQuery = ldap_search($ldapConnection->getConnection(), "ou=Users,dc=grolier,dc=com", '(cn=' . $this->username . ')');
		$ldapUserSearchResult = ldap_get_entries($ldapConnection->getConnection(), $ldapUserSearchQuery);

		/* need to determine what hosts the user has access to */
		$allowedHosts = $ldapUserSearchResult[0]['host'];
		array_shift($allowedHosts);
		sort($allowedHosts);

		$ldapConnection->disconnect();
		
		return $allowedHosts;
	}
	
	function isUserInGroup($groupName) {
		foreach ($this->userGroups as $group) {
			if ($group == $groupName) {
				return true;
			}
		}

		/* could not find the user in this group */
		return False;		
	}
}
?>
