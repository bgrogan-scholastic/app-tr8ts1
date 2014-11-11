<?php

class Locker_AU
{

	private $_auid;
	private $_productarray;
	private $_prefarray;
	
	/**
	* __construct
	*
	* Create a Locker_AU object.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_AU
	* 
	* @param 	bool $auid
	* @param 	array[int] $productarray
	* @param 	array[int] $prefarray
	*/
	public function __construct($auid = NULL, $productarray = NULL, $prefarray = NULL)
	{		
		$this->setauid($auid);
				
		if(is_null($productarray))
		{
			$this->_productarray = array();
		}
		else 
		{
			$this->setproductarray($productarray);
		}	

		if(is_null($prefarray))
		{
			$this->_prefarray = array();
		}
		else 
		{
			$this->setprefarray($prefarray);
		}	
		
	}
   
	/**
	* getauid
	*
	* Returns auid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getauid()
	{
		return $this->_auid;
	}

	/**
	* getproductarray
	*
	* Returns productarray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array[int] $var
	*/	
	public function getproductarray()
	{
		return $this->_productarray;
	}	
	
	/**
	* getprefarray
	*
	* Returns prefarray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  array[int] $var
	*/	
	public function getprefarray()
	{
		return $this->_prefarray;
	}
		
	/**
	* setauid
	*
	* Sets auid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $auid
	*/	
	public function setauid($auid)
	{
		$this->_auid = $auid;
	}
	
	/**
	* setproductarray
	*
	* Sets productarray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   array[int] $productarray
	*/	
	public function setproductarray($productarray)
	{
		$this->_productarray = $productarray;
	}
	
	/**
	* setprefarray
	*
	* Sets prefarray.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   array[int] $prefarray
	*/	
	public function setprefarray($prefarray)
	{
		$this->_prefarray = $prefarray;
	}
	
	/**
	* addproduct
	*
	* Add product to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $product
	*/	
	public function addproduct($product)
	{
		$this->_productarray[] = $product;
	}
		
	/**
	* addpref
	*
	* Add pref to array.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   array[int] $pref
	*/	
	public function addprofilecookie($pref)
	{
		$this->_prefarray[] = $pref;
	}
}
?>