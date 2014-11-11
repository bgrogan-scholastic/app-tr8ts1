<?php

class GI_Server {
	/**
	 * ldapAccount
	 *
	 * @var GI_LdapUserAccount
	 */
	var $ldapAccount;
	
	/**
	 * ldap namespace 
	 *
	 * @var string
	 */
	var $serverRdn;
	
	/**
	 * the server's name
	 *
	 * @var string
	 */
	var $serverName;
	
	/**
	 * Internal, Danbury, Santa Clara
	 *
	 * @var string
	 */
	var $serverLocality;
	
	/**
	 * server aliases
	 *
	 * @var string
	 */
	var $serverAliases;
	
	/**
	 * the server's public ip address
	 *
	 * @var string
	 */
	var $publicIPAddress;
	
	/**
	 * the server's vpn address
	 *
	 * @var string
	 */
	var $vpnIPAddress;
	
	/**
	 * ip address used to directly login to the server or transfer files
	 *
	 * @var string
	 */
	var $accessIPAddress;
	
	/**
	 * the server's ssh port
	 *
	 * @var integer
	 */
	var $sshPort;

	/**
	 * the server's rsync port
	 *
	 * @var integer
	 */
	var $rsyncPort;
	
	/**
	 * the server's http port
	 *
	 * @var integer
	 */
	var $httpPort;
	
	/**
	 * the server's mysql port
	 *
	 * @var integer
	 */
	var $mysqlPort;
	
	/**
	 * the server's pyro (python remote objects) port
	 *
	 * @var integer
	 */
	var $pyroPort;
	
	function __construct($ldapAccount, $serverLocality, $serverName) {
		$this->ldapAccount = $ldapAccount;
		$this->serverName = $serverName;
		$this->serverLocality = $serverLocality;
		$this->_init();		
	}
	
	function _init() {
		$rdn = 'cn=' . $this->ldapAccount->getUsername() . ',ou=Users,dc=grolier,dc=com';
		
		$ldapConnection = new GI_LdapConnection($this->ldapAccount->getUsername(), $this->ldapAccount->getPassword());
				
		$this->serverRdn = 'ou=Physical Machines,ou=' . $this->serverLocality . ',ou=Networking,dc=grolier,dc=com';
		$ldapServerSearchQuery = ldap_search($ldapConnection->getConnection(), $this->serverRdn, '(cn=' . $this->serverName . ')');
		$ldapServerSearchResult = ldap_get_entries($ldapConnection->getConnection(), $ldapServerSearchQuery);

		$ldapConnection->disconnect();
	
		$this->description = $ldapServerSearchResult[0]['description'][0];		
		$this->publicIPAddress = $ldapServerSearchResult[0]['iphostnumber'][0];
		$vpnIPAddress = $ldapServerSearchResult[0]['ipvpnaddress'][0];

		if ($vpnIPAddress != '') {
			$this->vpnIPAddress = $vpnIPAddress;
			$this->accessIPAddress = $this->vpnIPAddress;
		}
		else {
			$this->accessIPAddress = $this->publicIPAddress;
		}

		$sshPort = $ldapServerSearchResult[0]['sshport'][0];

		if ($sshPort != '') {
			$this->sshPort = $sshPort;

			/* generate the port numbers based on our pattern */
			$this->httpPort = $this->sshPort;
			$this->httpPort[2] = 2;

			$this->mysqlPort = $this->sshPort;
			$this->mysqlPort[2] = 3;

			$this->pyroPort = $this->sshPort;
			$this->pyroPort[2] = 4;
		}
		else {
			//default ssh port
			$this->sshPort = '22';
			

			//default http port
			$this->httpPort = '80';

			//default mysdql port
			$this->mysqlPort = '3306';

			//default pyro port
			$this->pyroPort = '7766';
		}

		$rsyncPort = $ldapServerSearchResult[0]['rsyncport'][0];
		if ($rsyncPort != '') {
			$this->rsyncPort = $rsyncPort;
		}
		else {
			//default rsync port
			$this->rsyncPort = '873';
		}

		$serverAliases = $ldapServerSearchResult[0]['cn'];
		$serverAliasCount = $serverAliases['count'];

		for($i = 1; $i < $serverAliasCount; $i++) {
			$this->serverAliases[] = $serverAliases[$i];
		}
	}
	
	function getServerName() {
		return $this->serverName;
	}

	function getServerLocality() {
		return $this->serverLocality;
	}

	function getServerAliases() {
		return $this->serverAliases;
	}

	function getPublicIPAddress() {
		return $this->publicIPAddress;
	}

	function getVpnIPAddress() {
		return $this->vpnIPAddress;
	}

	function getAccessIPAddress() {
		return $this->accessIPAddress;
	}

	function getSshPort() {
		return $this->sshPort;
	}

	function getRsyncPort() {
		return $this->rsyncPort;
	}

	function getHttpPort() {
		return $this->httpPort;
	}

	function getMysqlPort() {
		return $this->mysqlPort;
	}

	function getPyroPort() {
		return $this->pyroPort;
	}

	function isInLocality($inLocality) {
		$findRdn = "ou=Physical Machines,ou=" . $inLocality . ",ou=Networking,dc=grolier,dc=com";
		if ($findRdn == $this->serverRdn) {
			return true;
		}
		else {
			return false;
		}
	}	
}

?>
