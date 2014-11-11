<?php

class GI_Product {
	var $ldapAccount;
	var $productName;
	var $description;
	var $url;	
	var $servers = array();
	
	function __construct($ldapAccount, $productName) {
		$this->ldapAccount = $ldapAccount;
		$this->productName = $productName;
		$rdn = 'cn=' . $this->ldapAccount->getUsername() . ',ou=Users,dc=grolier,dc=com';
		
		$ldapConnection = new GI_LdapConnection($this->ldapAccount->getUsername(), $this->ldapAccount->getPassword());
				
		$rdn = 'ou=Products,dc=grolier,dc=com';
		$ldapProductSearchQuery = ldap_search($ldapConnection->getConnection(), $rdn, '(cn=' . $this->productName . ')');
		$ldapProductSearchResult = ldap_get_entries($ldapConnection->getConnection(), $ldapProductSearchQuery);

		$ldapConnection->disconnect();
	
		$this->description = $ldapProductSearchResult[0]['description'][0];		
		$this->url = $ldapProductSearchResult[0]['url'][0];
	
		/* get the list of servers this product resides on */
		for($i=0; $i < $ldapProductSearchResult[0]['serverid']['count']; $i++) {
			$this->servers[] = $ldapProductSearchResult[0]['serverid'][$i];
		} 		
	}
	
	function _init() {
	}
	
	function getProductName() {
		return $this->productName;
	}

	function getDescription() {
		return $this->description;
	}

	function getUrl() {
		return $this->url;
	}
		
	function getServers() {
		return $this->servers;
	}
}

?>
