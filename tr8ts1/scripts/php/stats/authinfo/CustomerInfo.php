<?php
    require_once('DB.php');

/**
* A class for retrieving and holding infomation about a single customer
* 
* 12/05/06 SJF PHP 5 Conversion.
* 
* Note on the properties.  I am making them public even though my usual MO is
* to protect everyting.  I have come across code that accesses class 
* properties directly.  All properties have getters aleady.
* 
*/
class CustomerInfo {

    /**
    * Customer's name
    * @var  string
    * @access public
    */
    public $_name = "";

    /**
    * Customer's city
    * @var  string
    * @access public
    */
    public $_city = "";

    /**
    * Customer's state
    * @var  string
    * @access public
    */
    public $_state = "";

    /**
    * Customer's aggregate (group) code
    * @var  string
    * @access public
    */
    public $_aggcode = "";

    /**
    * Products licensed by customer (by human-friendly name)
    * @var  stringarray
    * @access public
    */
    public $_products = array();

    /**
    * Customer's authenticated IPs
    * @var  stringarray
    * @access public
    */
    public $_ips = array();

    /**
    * Customer's referring page URLs
    * @var  stringarray
    * @access public
    */
    public $_refpages = array();

    /**
    * Count of customer's PUPs (and hbp/cookie password sets)
    * @var  int
    * @access public
    */
    public $_pupcount = 0;

    /**
    * Customer's RPE signup URLs
    * @var  stringarray
    * @access public
    */
    public $_rpepages = array();

    /**
    * Count of customer's RPE patrons
    * @var int
    * @access public
    */
    public $_rpecount = 0;

    /**
    * Customers proxy IPs
    * @var stringarray
    * @access public
    */
    public $_proxyips = array();

    /**
    * Constructor
    * 
    * @access public
    *
    */
    public function __construct($CUID){
        $db = DB::connect($_SERVER['AUTH_CONNECT_STRING']);
        if (DB::isError($db)) {
            print "\n<p>".$db->getMessage()."\n</p>\n";
        } else {

            # Fetch the basic customer information
            $queryString = "select NAME, CITY, STATE, AGGREGATE from CUSTOMER ";
            $queryString .= "where CUSTOMER_ID='$CUID'";
            $result =& $db->query($queryString);
	        if (DB::isError($result)) {
                print "\n<p>".$result->getMessage()."\n</p>\n";
	        } else {
	            if ($dbrow =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
    	            $this->_name = $dbrow['NAME'];
    	            $this->_city = $dbrow['CITY'];
	                $this->_state = $dbrow['STATE'];
	                $this->_aggcode = $dbrow['AGGREGATE'];
	            }
                $result->free();
    	    }

    	    # Fetch the customer licenses
    	    $queryString = "select PR.PRODUCT_NAME THENAME ";
            $queryString .= "from PRODUCT PR, PREFERENCE PF ";
            $queryString .= "where ";
            $queryString .= "PF.AU_ID in (select AU_ID from AU where RECIPIENT_ID='$CUID') ";
            $queryString .= "and PF.PREF_CODE = PR.PRODUCT_CODE ";
            $queryString .= "group by PR.PRODUCT_NAME";
            $result =& $db->query($queryString);
	        if (DB::isError($result)) {
                print "\n<p>".$result->getMessage()."\n</p>\n";
	        } else {
	            while ($dbrow =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                    $this->_products[] = $dbrow['THENAME'];
	            }
                $result->free();
    	    }

            # Fetch count of old-fashioned password sets
            $queryString = "select count(*) from au_uid ";
            $queryString .= "where au_id in (select AU_ID from AU where RECIPIENT_ID='$CUID')";
            $this->_pupcount = $db->getOne($queryString);

            # Fetch the referring pages
            $queryString = "select ref_url from au_url ";
            $queryString .= "where au_id in (select AU_ID from AU where RECIPIENT_ID='$CUID')";
            $result =& $db->query($queryString);
	        if (DB::isError($result)) {
                print "\n<p>".$result->getMessage()."\n</p>\n";
	        } else {
	            while ($dbrow =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                    $this->_refpages[] = $dbrow['REF_URL'];
	            }
                $result->free();
    	    }

    	    # Fetch the authentication IPs
    	    $queryString = "select IP from IP ";
            $queryString .= "where au_id in (select AU_ID from AU where RECIPIENT_ID='$CUID')";
            $result =& $db->query($queryString);
	        if (DB::isError($result)) {
                print "\n<p>".$result->getMessage()."\n</p>\n";
	        } else {
	            while ($dbrow =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                    $this->_ips[] = $dbrow['IP'];
	            }
                $result->free();
    	    }

    	    # fetch the RPE signup URLs
    	    $queryString = "select REMOTE_URL from REMOTE_URL ";
            $queryString .= "where au_id in (select AU_ID from AU where RECIPIENT_ID='$CUID')";
            $result =& $db->query($queryString);
	        if (DB::isError($result)) {
                print "\n<p>".$result->getMessage()."\n</p>\n";
	        } else {
	            while ($dbrow =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                    $this->_rpepages[] = $dbrow['REMOTE_URL'];
	            }
                $result->free();
    	    }

            # Get the count of RPE patrons
            $queryString = "select count(*) from ng_au_uid ";
            $queryString .= "where au_id in (select AU_ID from AU where RECIPIENT_ID='$CUID')";
            $this->_rpecount = $db->getOne($queryString);

            $queryString = "select proxy_ip_addr from proxy_uid ";
            $queryString .= "where au_id in (select AU_ID from AU where RECIPIENT_ID='$CUID')";
            $result =& $db->query($queryString);
	        if (DB::isError($result)) {
                print "\n<p>".$result->getMessage()."\n</p>\n";
	        } else {
	            while ($dbrow =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                    $this->_proxyips[] = $dbrow['PROXY_IP_ADDR'];
	            }
                $result->free();
    	    }

            $db->disconnect();
        }

    }


    /**
    * getName()
    *
    * Return the customer's name
    *
    * @return   string  Customer name
    * @access public
    */
    public function getName(){
        return $this->_name;
    }

    /**
    * getAddress()
    *
    * Return the customer's city and state
    *
    * @return   string  Customer address
    * @access public
    */
    public function getAddress(){
        return $this->_city . ", " . $this->_state;
    }

    /**
    * getAggcode()
    *
    * Return the customer's aggregate (group) code, if any
    *
    * @return   string  Customer agg code
    * @access public
    */
    public function getAggcode(){
        return $this->_aggcode;
    }

    /**
    * getProducts()
    *
    * Return the list of this customer's products
    *
    * @return   stringarray  Customer's products
    * @access public
    */
    public function getProducts(){
        return $this->_products;
    }

    /**
    * getIPs()
    *
    * Return the list of this customer's IPs
    *
    * @return   stringarray Customer's IPs
    * @access public
    */
    public function getIPs(){
        return $this->_ips;
    }

    /**
    * getRefpages()
    *
    * Return the list of this customer's referring URLS
    *
    * @return   stringarray Customer's referring URLs
    * @access public
    */
    public function getRefpages(){
        return $this->_refpages;
    }

    /**
    * getPupcount()
    *
    * Return the count of this customer's old-fashioned password sets
    *
    * @return   int Customer's pupcount
    * @access public
    */
    public function getPupcount(){
        return $this->_pupcount;
    }

    /**
    * getRPEpages()
    *
    * Return the list of this customer's RPE signup URLs
    *
    * @return   stringarray Customer's RPE signup URLs
    * @access public
    */
    public function getRPEpages(){
        return $this->_rpepages;
    }

    /**
    * getRPEcount()
    *
    * Return the count of RPE patrons for this customer
    *
    * @return   int Count of customer's RPE patrons
    * @access public
    */
    public function getRPEcount(){
        return $this->_rpecount;
    }

    /**
    * getProxyIPs()
    *
    * Return the list of this customer's Proxy IPs (no passwords)
    *
    * @return   stringarray Customer's Proxy IPs
    * @access public
    */
    public function getProxyIPs(){
        return $this->_proxyips;
    }

}

?>
