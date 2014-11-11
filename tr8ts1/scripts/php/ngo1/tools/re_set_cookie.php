<?php

//
//set script can be used to reset the BFIF cookie which is used to determine weather we need to check the users
//flashversion..once checked this cookie is set and future visits will not require checking
 
 //$_SERVER['MIN_FLASH_VERSION']=10;
 
 	/**
	* 
	*
	* This is used for testing only
	* 
	*
	* @author  Peter Kujawa PKujawa-consultant@Scholastic.com 
	* 
	* @access  to be included into home.php on expertspace
	* 
	* @DATE 	 10/31/2008
	* 
	* @param 	This code is to be used to clear the BFIF cookie that is set by the check_flash_version.php and included in the main home.php of expert space....
	* 			
	* 			 
	* 
	* 
	* 			Original code pulled from bookflix and written by Richard
	*/
 	
 	?>

<script>

var BFIF = "<?php echo $_COOKIE['BFIF']; ?>";

document.write("Current cookie status is :"+BFIF+"<BR>");

if (BFIF==1){
	
	document.write("This means that the flash detection script has succesfully executed from home.php <br> with no issues and the cookie has been set so it will not have to run again<BR><BR><BR>");
	
}

document.write("Resetting cookie");

var BFIDomain = "<?php echo $_SERVER['SERVER_NAME']; ?>";
document.cookie = "BFIF=0; path=/; domain=" + BFIDomain; 

</script>