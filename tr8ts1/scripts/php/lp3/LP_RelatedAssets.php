<?php
require_once('DB.php');
include_once($_SERVER['COMMON_CONFIG_PATH'] . '/GI_ProductConfig.php'); 
$searchBaseHref = GI_ProductConfig::getBaseHref('go3-passport');
 
/**
 * A class managing the 'related assets' panel for a Lands and Peoples article
 *
 * Stub created 6/28/2010: R.E. Dye
 */
class LP_RelatedAssets {

    /*
     * The constructor
     * @param   var $inID   SLP ID of the parent article
     *
     */
    private $_db;
    private  $_id;
    protected $factnfigures_HTML;
    protected $sidebar_HTML;
    protected $flag_HTML;
    protected $web_HTML;
    protected $selected_HTML;
    protected $morepicture_HTML;
    protected $moremaps_HTML;
    protected $full_HTML;
    protected $spacer;

    
    
    public function __construct($inID){
    	
    	$this->_db = DB::connect($_SERVER['DB_CONNECT_STRING']);
 		$this->_id=$inID;
 		
 		$this->spacer='<tr height="10">';
 		$this->spacer.='<td width="135" height="10" align="center">';
 		$this->spacer.='<img height="10" width="135" src="/images/common/spacer.gif" alt="">';
 		$this->spacer.='</td></tr>';
	
 		$this->buildFlag_HTML($inID);
 		$this->buildFactsFigures_HTML($inID);
 		$this->buildsidebar_HTML($inID); 		
 		$this->buildWebLinks_HTML($inID);
 		$this->buildSelectedReadings_HTML($inID);
 		$this->buildMorePictures_HTML($inID);
 		$this->buildMoreMaps_HTML($inID);
 		
    }

    /**
     * output the related assets panel HTML
     *
     * @return  var     releted assts panel HTML
     *
     */
   public function getOutput(){
        
      	    $this->full_HTML= $this->flag_HTML;
            $this->full_HTML.= $this->factnfigures_HTML;
        	$this->full_HTML.= $this->sidebar_HTML;
        	$this->full_HTML.= $this->web_HTML;
        	$this->full_HTML.= $this->selected_HTML;
        	
        		$this->full_HTML.= $this->spacer;
     		
        	$this->full_HTML.= $this->moremaps_HTML;
        	
        	    $this->full_HTML.= $this->spacer;
        	        	
          	$this->full_HTML.= $this->morepicture_HTML;
           	
           	
    }
       
 
    
    /**
     * echo the related assets panel HTML to the output device
     */
    public function output(){
    	
    	$this->getOutput();
    	
    	echo $this->beautifyThisCode($this->full_HTML);
         
    }
   
    
     protected  function buildFlag_HTML(){
     	
   
 				 $flagQry='SELECT  c.slp_id,c.uid,c.src_product_id FROM manifest p, manifest c WHERE  c.type=\'0mf\'AND p.uid=c.puid AND p.slp_id=\''.$this->_id.'\'order by c.priority ASC, c.title_ent ASC';
 					
 				 $flagrslt = & $this->_db->query($flagQry);
 				   $rowcount= $flagrslt->numRows();
 					while($dbrow = $flagrslt->fetchRow(DB_FETCHMODE_ASSOC))
						{
					
						$flag_slpid=$dbrow['slp_id'];
						$flag_uid=$dbrow['uid'];
						$flag_src=$dbrow['src_product_id'];
				
						}
						if ($rowcount==0)
 							{$flag_HTML= false;}
 						else if ($rowcount>=1)
 					{
						$flag_HTML='<!--BEGIN FLAG-->';
						$flag_HTML.='<tr height="44">';
						$flag_HTML.='<td width="135" height="44" align="center">';
						$flag_HTML.='<a href="javascript:OpenBlurbWindow(\''.$this->_baseRef.'/flag/'.$flag_slpid.'/'.$flag_uid.'/'.$flag_src.'\',540,500,\'media\',\'on\')"><img height="44" width="68" src="/images/encyc/flag-button.gif" border="0" alt="Flag"></a>';
						$flag_HTML.='</td></tr>';
						$flag_HTML.='<!--END FLAG-->';
  
 					}
 					
 				$this->flag_HTML= $flag_HTML;
 			}
    
    protected  function buildFactsFigures_HTML(){
     
     
     	$factsQry = 'SELECT c.slp_id FROM manifest p,manifest c WHERE c.type =\'0taf\' And  p.uid= c.puid   And p.slp_id = \''.$this->_id.'\''; 
                                           
        $factrslt = & $this->_db->query($factsQry);
        $rowcount= $factrslt->numRows();
	    		while($dbrow = $factrslt->fetchRow(DB_FETCHMODE_ASSOC))
          			{    
          
		   				$factTitle = $dbrow['title'];
			 			$factid = $dbrow['slp_id'];
			 			$factprodid=$dbrow['src_product_id'];
			 			$factType=$dbrow['type'];
			 			

            		} 
            
           			 if ($rowcount==0)
            
 							{$factnfigures_HTML= false;}
 					 else if ($rowcount>0)
 						{        
 							
	 						$factnfigures_HTML='<!--BEGIN FACTS N FIGURES-->';                                            
	 						$factnfigures_HTML.='<tr height="45">';                                            
	 						$factnfigures_HTML.='<td width="135" height="45" align="center">';                                            
							$factnfigures_HTML.='<a href="/factbox/'.$factid.'"><img height="45" width="68" src="/images/encyc/facts-button.gif" border="0" alt="Facts & Figures"></a>';
							$factnfigures_HTML.='</td></tr>';   
							$factnfigures_HTML.='<!--END FACTS N FIGURES-->';   
 
 						}
 					$this->factnfigures_HTML= $factnfigures_HTML;
			                        
 }
 
  protected function buildsidebar_HTML(){

 		$sidebarQry = 'SELECT c.title_ent title,p.slp_id slp_id, c.slp_id id FROM manifest p,manifest c 
					WHERE c.type in (\'0tax\',\'0tat\') AND p.uid = c.puid  AND p.slp_id = \''.$this->_id.'\'';
 	   
 		$sidebarrslt = & $this->_db->query($sidebarQry);
 		$rowcount= $sidebarrslt->numRows();
 
 				while($dbrow = $sidebarrslt->fetchRow(DB_FETCHMODE_ASSOC))
 				{				
					$sidebar_slpid = $dbrow['slp_id'];
					$sidebar_cslpid=$dbrow['id'];
					$sidebar_title=$dbrow['title_ent'];
					
 				}                 
					 
            	if ($rowcount==0)
 							{$sidebar_HTML= false;}
 				
				else if($rowcount==1) {
						$sidebar_HTML='<!--BEGIN SIDEBAR-->'; 
						$sidebar_HTML.='<tr height="46">'; 
						$sidebar_HTML.='<td width="135" height="46" align="center">'; 
						$sidebar_HTML.='<a href="'.$this->_baseRef.'/sidebar/'.$sidebar_cslpid.'"><img height="46" width="68" src="/images/encyc/sidebar-button.gif" border="0" alt="Sidebar"></a>';
						$sidebar_HTML.='</td></tr>';
						$sidebar_HTML.='<!--END SIDEBAR-->';
 			
						
					}
					else if ($rowcount>1)
 					 {  
						$sidebar_HTML='<!--BEGIN SIDEBAR-->'; 
						$sidebar_HTML.='<tr height="46">'; 
						$sidebar_HTML.='<td width="135" height="46" align="center">'; 
                 		$sidebar_HTML.='<a href="javascript:OpenBlurbWindow(\''.$this->_baseRef.'/sidebars/'.$sidebar_slpid.'\',540,500,\'sidebar\',\'on\')"><img height="46" width="68" src="/images/encyc/sidebar-button.gif" border="0" alt="Sidebar"></a>'; 
                 		$sidebar_HTML.='</td></tr>';                                                    
                 		$sidebar_HTML.='<!--END SIDEBAR-->';                                                    
					 }
					 $this->sidebar_HTML=$sidebar_HTML;		                                                                 

         }  
        
                                                             
 				
 			
 			
 			                                                  
 	 protected  function buildWebLinks_HTML(){
 				
 	 			$web_HTML='<!--BEGIN WEBLINKS-->';
 				$web_HTML.='<tr><td width="135" align="center">';
 				$web_HTML.='<a href="/gii/'.$this->_id.'"><img height="44" width="68" src="/images/encyc/web_links.gif" border="0" alt="Web Links"></a>';
 				$web_HTML.='</td></tr>';
 				$web_HTML.='<!--END WEBLINKS-->';
 				
 			 	$this->web_HTML= $web_HTML;
 			}
 			
 			
 			
 			
  protected  function buildSelectedReadings_HTML(){
 				
 				$selectedQry=' SELECT  c.slp_id FROM manifest p, manifest c WHERE  p.uid=c.puid AND p.slp_id=\''.$this->_id.'\' AND c.type =\'0tab\' order by c.priority ASC, c.title_ent ASC';
 				
 				$selectedrslt=&$this->_db->query($selectedQry);
 				$rowcount= $selectedrslt->numRows();
 				while($dbrow = $selectedrslt->fetchRow(DB_FETCHMODE_ASSOC)){
 					
 					$selected_slpid=$dbrow['slp_id'];
 					
 				}
 				if ($rowcount==0)
 							{$selected_HTML=false;}
 				else if ($rowcount>=1)
 					{
	 					$selected_HTML='<!--BEGIN SELECTED READING-->';
	 					$selected_HTML.='<tr height="47"><td width="135" height="47" align="center">';
	 					$selected_HTML.='<a href="/reading/'.$selected_slpid.'"><img height="47" width="68" src="/images/encyc/readings-button.gif" border="0" alt="Selected Readings"></a>';
	 					$selected_HTML.='</td></tr>';
	 					$selected_HTML.='<!--END SELECTED READING-->';
 					}
 				$this->selected_HTML= $selected_HTML;
 			}
 			
 			
 			
 			
 	 protected  function buildMorePictures_HTML(){
 				$morepictureQry='SELECT c.slp_id ID, c.fext fext, c.title_ent, p.slp_id pid, c.uid uid FROM manifest p, manifest c WHERE p.uid=c.puid AND p.slp_id=\''.$this->_id.'\' AND c.type =\'0mp\' order by  c.title_ent desc';
 		
 				$morepicturerslt=&$this->_db->query($morepictureQry);
 			    $rowcount= $morepicturerslt->numRows();
 			  
 				while($dbrow = $morepicturerslt->fetchRow(DB_FETCHMODE_ASSOC)){
 					
 					$morepicture_cslpid=$dbrow['ID'];
 					$morepicture_cuid=$dbrow['uid'];
 					$morepicture_cfext=$dbrow['fext'];
 					$morepicture_ctitle=$dbrow['title_ent'];
 					$morepicture_pslpid=$dbrow['pid']; 						
 				} 
 									
 					if ($rowcount==0)
 							{$morepicture_HTML=false;}
 					else if ($rowcount==1)
 					{
 						$morepicture_HTML='<!--BEGIN MORE PICTURES-->';
 					    $morepicture_HTML .= '<tr><td width="135" align="center">';
 					    $morepicture_HTML .= '<a href="javascript:OpenBlurbWindow(\''.$this->_baseRef.'/picture/'.$morepicture_cslpid.'/'.$morepicture_cuid.'\',540,500,\'picturelist\',\'on\')"><img src="/csimage?product_id=lp&id='.$morepicture_cslpid.'&ext='.$morepicture_cfext.'&width=150" border="0" alt="'.$morepicture_ctitle.'" /></a>';
 					    $morepicture_HTML.='</td></tr>';
 					    $morepicture_HTML.='<!--END MORE PICTURES-->';
 					    
 					    
 					  

 					    
								
 					}
 					else if ($rowcount>1)
 					 {
 					 	$morepicture_HTML='<!--BEGIN MORE PICTURES-->';
 						$morepicture_HTML .= '<tr><td width="135" align="center">';									
 						$morepicture_HTML .= '<a href="javascript:OpenBlurbWindow(\''.$this->_baseRef.'/picture/'.$morepicture_cslpid.'/'.$morepicture_cuid.'\',540,500,\'picturelist\',\'on\')"><img src="/csimage?product_id=lp&id='.$morepicture_cslpid.'&ext='.$morepicture_cfext.'&width=150" border="0" alt="'.$morepicture_ctitle.'" /></a></td></tr>';									
 					    $morepicture_HTML.='<tr><td width="150" valign="top" align="center"><a href="javascript:OpenBlurbWindow(\''.$this->_baseRef.'/morepictures/'.$morepicture_pslpid.'\',540,500,\'picturelist\',\'on\')"><font size="-2">More Pictures</font></a></td></tr>';
 					    $morepicture_HTML.='<!--END MORE PICTURES-->';
 					    
 		 
 					     
 					}
 			$this->morepicture_HTML= $morepicture_HTML;
 			}
 			
 			
 			
 			
 	 protected function buildMoreMaps_HTML(){
 		
 		       $moremapsQry='SELECT c.slp_id id, c.fext fext, c.title_ent, p.slp_id pid from manifest p, manifest c where p.uid=c.puid and p.slp_id=\''.$this->_id.'\'  and c.type like \'0mm%\' order by c.title_ent desc';
 		  
 		       $moremapsrslt=&$this->_db->query($moremapsQry);
 		       $rowcount= $moremapsrslt->numRows();
 		       	while($dbrow = $moremapsrslt->fetchRow(DB_FETCHMODE_ASSOC)){
 		       		
 		       		$moremaps_slpid=$dbrow['id'];
 		       		$moremaps_ctitle=$dbrow['title_ent'];
 		       		$moremaps_pslpid=$dbrow['pid'];
 		       		 		       	
 		       	}
 		    
 		       	if ($rowcount==0){
 		       			$moremaps_HTML= false;
 		       	}else if ($rowcount==1)
 				{ 					      
 		       	   	$searchBaseHref = GI_ProductConfig::getBaseHref('go3-passport');
	 		       	$moremaps_HTML.='<!--BEGIN BUILD MORE MAPS-->';
	 		       	$moremaps_HTML.='<tr><td width="150" align="center">';
	 		        $moremaps_HTML.='<a href="javascript:OpenBlurbWindow(\''.$searchBaseHref.'/atlas?id='.$moremaps_slpid.'\',540,500,\'maplist\',\'on\')" ><img src="/csimage?product_id=go&id='.$moremaps_slpid.'&width=150&ext=png" border="0" alt="'.$moremaps_ctitle.'"  /></a></td></tr>';	 
	 		        $moremaps_HTML.='<!--END BUILD MORE MAPS-->';       
	   		       	 		       
 		       	}
 		       	else if ($rowcount>1) {
	 		       	$searchBaseHref = GI_ProductConfig::getBaseHref('go3-passport');
	 		       	$moremaps_HTML.='<!--BEGIN BUILD MORE MAPS-->';
	 		       	$moremaps_HTML.='<tr><td width="150" align="center">';
	 		        $moremaps_HTML.='<a href="javascript:OpenBlurbWindow(\''.$searchBaseHref.'/atlas?id='.$moremaps_slpid.'\',540,500,\'maplist\',\'on\')" ><img src="/csimage?product_id=go&id='.$moremaps_slpid.'&width=150&ext=png" border="0"alt="'.$moremaps_ctitle.'"  /></a></td></tr>';
	 		       	$moremaps_HTML.='<tr><td width="150" valign="top" align="center">';
	 		       	$moremaps_HTML.='<tr><td align="center"><a href="javascript:OpenBlurbWindow(\''.$this->_baseRef.'/moremaps/'.$moremaps_pslpid.'\',540,500,\'maplist\',\'on\')"><font size="-2">More Maps</font></a></td></tr>';
	 		       	$moremaps_HTML.='<!--END BUILD MORE MAPS-->';
	 		       			       	 		       		
 		       	}
 		      
 		       	$this->moremaps_HTML=$moremaps_HTML; 				
 			}
 			
 			
 	//************************************************************************
	//				This function just adds some carriage returns			// 
	//				so that BROWSERS VIEW SCRIPT is easier to read			//
	//************************************************************************
 
 protected function beautifyThisCode($beautifyThisCode) {
		
			$replaceWhat = array('<a','<img','<td', '</td','<tr','</tr','<!--');
			$replaceWith = array("\n\t\t\t\t\t<a","\n\t\t\t\t\t<img","\n\t\t\t\t<td","\n\t\t\t\t</td","\n\n\t\t\t<tr","\n\t\t\t</tr","\n\n\t\t\t<!--");
			$beautifyThisCode = str_replace($replaceWhat, $replaceWith, $beautifyThisCode);
			
			return $beautifyThisCode;
			
	}
	
 		
}                                                                           
                 
      