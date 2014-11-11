<?php

class Locker_Rubric_Answer
{

	private $_taskid;
	private $_rubricquestionid;
	private $_answertext;
	private $_dateanswered;
	
	/**
	* __construct
	*
	* Create a Rubric Answer
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  Locker_Rubric_Answer
	* 
	* @param 	int $taskid
	* @param 	int $rubricquestionid
	* @param 	string $answertext
	* @param 	string $dateanswered
	*/
	public function __construct($taskid = NULL, $rubricquestionid = NULL, $answertext = NULL, $dateanswered = NULL)
	{		
		$this->settaskid($taskid);
		$this->setrubricquestionid($rubricquestionid);
		$this->setanswertext($answertext);
		$this->setdateanswered($dateanswered);

	}
   
	/**
	* gettaskid
	*
	* Returns taskid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  int
	*/	
	public function gettaskid()
	{
		return $this->_taskid;
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
	* getanswertext
	*
	* Returns answertext.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getanswertext()
	{
		return $this->_answertext;
	}
	
	/**
	* getdateanswered
	*
	* Returns dateanswered.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @return  string
	*/	
	public function getdateanswered()
	{
		return $this->_dateanswered;
	}

	/**
	* settaskid
	*
	* Sets taskid.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   int $taskid
	*/	
	public function settaskid($taskid)
	{
		$this->_taskid = $taskid;
	}
		
	/**
	* setrubricquestionid
	*
	* Sets rubricquestionid.
	*
	* @author  	John Palmer
	* @access  	public 
	* 
	* @param	int $rubricquestionid
	*/	
	public function setrubricquestionid($rubricquestionid)
	{
		$this->_rubricquestionid = $rubricquestionid;
	}


	/**
	* setanswertext
	*
	* Sets answertext.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $answertext
	*/	
	public function setanswertext($answertext)
	{
		$this->_answertext = $answertext;
	}

	/**
	* setdateanswered
	*
	* Sets dateanswered.
	*
	* @author  John Palmer
	* @access  public 
	* 
	* @param   string $dateanswered
	*/	
	public function setdateanswered($dateanswered)
	{
		$this->_dateanswered = $dateanswered;
	}	
}
?>