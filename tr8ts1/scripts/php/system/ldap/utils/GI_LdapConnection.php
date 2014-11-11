<?php

class GI_LdapConnection {
	/**
	 * user's id
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
	 * the user's ldap namespace
	 *
	 * @var string
	 */
	var $rdn;
	
	/**
	 * the ldap user connection
	 *
	 * @var GI_LdapConnection
	 */
	var $ldapConnection;
	
	/**
	 * is the user connected
	 *
	 * @var integer
	 */
	var $isConnected;

	function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
		$this->rdn = "cn=" . $this->username . ",ou=Users,dc=grolier,dc=com";
		$this->isConnected = false;

		if ( ($this->username != '') && ($this->password != '') ) {
			/* only make a connection if one hasn't been established already */
			if ($this->isConnected == false) {
				/* validate login credentials */
				$ldapConnection = ldap_connect('gicauthm.grolier.com');
				$bindResult = @ldap_bind($ldapConnection, $this->rdn , $this->password);
	
				if ($bindResult == true) {
					$this->ldapConnection = $ldapConnection;
					$this->isConnected = true;				
				}
			}

		}
		
	}

	/**
	 * get the connection to ldap
	 *
	 * @return object
	 */
	function getConnection() {
		$this->_connect();
		return $this->ldapConnection;
	}
	
	/**
	 * is the user connected?
	 *
	 * @return boolean
	 */
	function isConnected() {
		return $this->isConnected;
	}
	
	/**
	 * disconnect from ldap
	 * 
	 * @return boolean
	 */
	function disconnect() {
		@ldap_close($this->ldapConnection);
		$this->isConnected = false;
		return true;
	}
}
