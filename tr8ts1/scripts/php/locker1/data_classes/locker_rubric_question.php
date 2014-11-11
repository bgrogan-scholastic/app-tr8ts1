<?php

class Locker_Rubric_Question
{
	private $_rubricquestionid;
	private $_tasktypeid;
	private $_questiontext;
	
	/**
	* __construct
	*
	* Create a rubric question object
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @return  	Locker_Rubric_Question
	* 
	* @param 	int $rubricquestionid
	* @param 	int $tasktypeid
	* @param 	string $questiontext
	*/
	public function __construct($rubricquestionid = NULL, $tasktypeid = NULL, $questiontext = NULL)
	{		
		$this->setrubricquestionid($rubricquestionid);
		$this->settasktypeid($tasktypeid);
		$this->setquestiontext($questiontext);
	}
   
	/**
	* getrubricquestionid
	*
	* Returns rubricquestionid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function getrubricquestionid()
	{
		return $this->_rubricquestionid;
	}

	/**
	* gettasktypeid
	*
	* Returns tasktypeid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function gettasktypeid()
	{
		return $this->_tasktypeid;
	}

	/**
	* getquestiontext
	*
	* Returns questiontext.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getquestiontext()
	{
		return $this->_questiontext;
	}	
		
	/**
	* setrubricquestionid
	*
	* Sets rubricquestionid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $rubricquestionid
	*/	
	public function setrubricquestionid($rubricquestionid)
	{
		$this->_rubricquestionid = $rubricquestionid;
	}
	
	/**
	* settasktypeid
	*
	* Sets tasktypeid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $tasktypeid
	*/	
	public function settasktypeid($tasktypeid)
	{
		$this->_tasktypeid = $tasktypeid;
	}

	/**
	* setquestiontext
	*
	* Sets questiontext.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $questiontext
	*/	
	public function setquestiontext($questiontext)
	{
		$this->_questiontext = $questiontext;
	}	
}

?>