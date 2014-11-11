<?php

require_once('GI_Server.php');

class GI_Servers {
	var $ldapUserAccount;
	var $servers;
	var $serversByLocality;
	
	function __construct($ldapUserAccount) {
		$this->ldapUserAccount = $ldapUserAccount;
		$this->_init();
	}

	function _init() {
		/* get a connection to ldap */
		$ldapConnection = new GI_LdapConnection($this->ldapUserAccount->getUsername(), $this->ldapUserAccount->getPassword() );

		/* get a list of giProducts */
		$ldapServersSearchQuery = ldap_search($ldapConnection->getConnection(), "ou=Networking,dc=grolier,dc=com", "(|(objectClass=giLinuxServer)(objectClass=giSunServer))");
		$ldapServersSearchResult = ldap_get_entries($ldapConnection->getConnection(), $ldapServersSearchQuery);

		for($i = 0; $i < $ldapServersSearchResult['count']; $i++) {
			/* add this server to the servers list */
			$serverName = $ldapServersSearchResult[$i]['cn'][0];
			$serverDN = $ldapServersSearchResult[$i]['dn'];
			$serverDNParts = explode(',', $serverDN);
			$serverLocalityParts = explode('=', $serverDNParts[ count($serverDNParts) -4 ] );
			$serverLocality = $serverLocalityParts[1];
 
			$giServer = new GI_Server($this->ldapUserAccount, $serverLocality, $serverName);
			$this->servers[] = $giServer;
			$this->serversByLocality[$serverLocality][] = $giServer;
		}
	}

	function getServerLocalities() {
		return array_keys($this->serversByLocality);	
	}
		
	function getServers() {
		return $this->servers;
	}

	function getServersByLocality($serverLocality) {
		if (array_key_exists($serverLocality, $this->serversByLocality) === FALSE) {
			return false;
		}
		else {
			return $this->serversByLocality[$serverLocality];
		}
	}
		
	function getServer($serverName) {		
		foreach($this->servers as $server) {
			if ($server->getServerName() == $serverName) {
				return $server;
			}
		}

		return false;
	}
	
	function getServerByLocality($serverLocality, $serverName) {		
		if (array_key_exists($serverLocality, $this->serversByLocality) === FALSE) {
			return false;
		}
		else {
			foreach($this->serversByLocality[$serverLocality] as $server) {
				if ($server->getServerName() == $serverName) {
					return $server;
				}
			}

			return false;
		}
	}
}
?>
