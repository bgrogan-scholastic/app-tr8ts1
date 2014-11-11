<?php
	session_start();

	/* make a connection to the master ldap server */
	$ldapConnection = ldap_connect('gicauthm.grolier.com');
        $rdn =  'cn=' . $_POST['username'] . ",ou=Users,dc=grolier,dc=com";
	$bindResult = @ldap_bind($ldapConnection, $rdn , base64_decode($_POST['currentpw']) );

	/* determine whether the user was able to successfully login */
	if($bindResult === True) {
	  /* make sure the crypted password is in the standard unix format and not md5, etc */
	  $newPassword = crypt( base64_decode($_POST['newpw']) , CRYPT_STD_DES);
	  $values['userPassword'] = "{crypt}" . $newPassword;
	  $modifyResult = ldap_modify($ldapConnection, $rdn, $values);

	  /* was the user's password successfully modified? */
	  if ($modifyResult === True) {
		echo 'You password has been successfully updated!';
		$_SESSION['password'] =  base64_decode($_POST['newpw']);
	  }
	  else {
		echo 'Password update Failed...See GI System Administrators';
	  }
	}
	else {
	  /* the user could not be validated on their existing username / password */
	  echo 'Login invalid';
	}
?>
