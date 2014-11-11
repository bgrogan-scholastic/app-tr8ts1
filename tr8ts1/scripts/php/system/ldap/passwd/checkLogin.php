<?php
	/* make a connection to the master ldap server */
	$ldapConnection = ldap_connect('gicauthm.grolier.com');
        $rdn =  'cn=' . $_POST['username'] . ",ou=Users,dc=grolier,dc=com";
	
	//make sure to decode the password using base64
	$bindResult = @ldap_bind($ldapConnection, $rdn, base64_decode($_POST['password']) );
echo $bindResult;
	if($bindResult === True) {
		echo 'Login valid';
	}
	else {
		echo 'Login invalid';
	}
?>
