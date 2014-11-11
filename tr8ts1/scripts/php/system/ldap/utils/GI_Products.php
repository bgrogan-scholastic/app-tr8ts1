<?php

require_once('GI_LdapConnection.php');
require_once('GI_Product.php');

class GI_Products {
	var $ldapUserAccount;
	var $products = array();	
	
	function __construct($ldapUserAccount) {
		$this->ldapUserAccount = $ldapUserAccount;
		/* get a connection to ldap */
		$ldapConnection = new GI_LdapConnection($this->ldapUserAccount->getUsername(), $this->ldapUserAccount->getPassword());
				
		/* get a list of giProducts */
		$ldapProductsSearchQuery = ldap_search($ldapConnection->getConnection(), "ou=Products,dc=grolier,dc=com", "(&(objectClass=giProduct))");
		$ldapProductsSearchResult = ldap_get_entries($ldapConnection->getConnection(), $ldapProductsSearchQuery);

		for($i = 0; $i < $ldapProductsSearchResult['count']; $i++) {
		  /* add this product to the products list */
		  $productName = $ldapProductsSearchResult[$i]['cn'][0];
		  
		  $giProduct = new GI_Product($this->ldapUserAccount, $productName);
		  $this->products[] = $giProduct;		  
		}
	}
	
	function getProducts() {
		return $this->products;	
	}
}

?>
