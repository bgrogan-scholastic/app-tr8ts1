<?php

include_once 'DB.php';
require_once($_SERVER['PHP_INCLUDE_HOME'].'ereads1/GI_ThinkTankHandler.php');
require_once($_SERVER['PHP_INCLUDE_HOME'].'ereads1/GI_BundleCollectiveHandler.php');
include_once($_SERVER["PHP_INCLUDE_HOME"]."locker1/client/locker_soap_client.php");
//Include Cookie
require_once($_SERVER['PHP_INCLUDE_HOME']."common/auth/cookie_reader.php");

class GI_ThinkTankDisplay 
{
	public static function init()
	{
		
	}
	
	public static function showRankItResults($params)
	{
		$retVal = "";
		$topic_slp_id = $params['topicslpid'];
		$activity_id = $params['activityid'];
		
		
		$thinkTank = new GI_ThinkTankHandler();
		$activity = $thinkTank->getActivity($activity_id);
		$activity = $activity[0]; 
		
		$retVal .= '<p>'.$activity['activity_text'].'</p>';
		$retVal .= '<br><p>'.$activity['instructions'].'</p>';
		$retVal .= '<hr class="firstquizhr"/>';
		
		//get all of the activity questions for a specific activity. 
		$activity_questions = $thinkTank->getActivityQuestions($activity_id);
		$questionNum = count($activity_questions);
		
		$paramsCount = count($params);
		$sortOrder = 0;
		//go through the users list
		$retVal .= '<table cellspacing=5>';
		foreach ($params as $key => $value) {
			
			
			//make sure its not one of these 2 params.
		    if($key != "topicslpid" && $key != "activityid"){
		    	
		    	//if its a question then go through the questions we got back to find the correct one.
				for ($i=0;$i<$questionNum;$i++){
					
					//if its this one then..
					if($activity_questions[$i]['id'] == $key){
						
						
						$activity_text = $activity_questions[$i]['question_text'];
						$sortOrder = $sortOrder + 1;
						
						$retVal .='<tr><td>';
							$retVal .='<div style="margin-right:14px;" class="rankittextfields">';
							$retVal .= $sortOrder;
							$retVal .='</div></td>';  
						$retVal .='<td><div class="rankitquestion">'.$activity_text.'</div>';
						$retVal .='</td></tr>';  
						
						
					}
					
					
				}

		    }
		}
		$retVal .='</table>';
				
		 echo $retVal;
		
	}
	
	public static function showCaptionresults($params){
		
		$topic_slp_id = $params['topicslpid'];
		$activity_id = $params['activityid'];
		
		$captiontext = $params['caption'];
		
		$retVal = "";
		
		$thinkTank = new GI_ThinkTankHandler();
		$activity = $thinkTank->getActivity($activity_id);
		$activity = $activity[0]; 
		
		$retVal .= '<p>'.$activity['activity_text'].'</p>';
		$retVal .= '<br><p>'.$activity['instructions'].'</p>';
		
		
		$retVal .= '<hr class="firstquizhr"/>';
		
		$photo_slp_id = $activity['photo_slp_id'];
		
		$activity_questions = $thinkTank->getCaptionPicInfo($photo_slp_id);
		$contentImage = "/csimage?id={$photo_slp_id}&product_id=ereads&skipdb=y&height=390&width=700";
		
		$retVal .= '<img src="'. $contentImage.'" alt="'. $activity_questions[0]['ada_text'].'" border=0/>';
		
		//$retVal .= '<img src="/images/thinktank/10007520.jpg" alt="'. $activity_questions[0]['ada_text'].'" border=0/>';
		$retVal .= '<textarea ROWS="3" COLS="20" readonly="readonly">'. $captiontext .'</textarea>';
		
		echo $retVal;
		
		
		
		
	}
	
	public static function showPollresults($params){
		
		$retVal = "";
		$topic_slp_id = $params['topicslpid'];
		$activity_id = $params['activityid'];
		
		
		$thinkTank = new GI_ThinkTankHandler();
		$activity = $thinkTank->getActivity($activity_id);
		$activity = $activity[0]; 

		$cookiereader = new Cookie_Reader($_SERVER['AUTH_PCODE']);
		$profile_id = $cookiereader->getprofileid();		
		
		$locker_client = new Locker_Client();
		$getAllResults = $locker_client->getthinktankresults($profile_id, $topic_slp_id, $activity_id);
		
		$resultsArray = $getAllResults->_resultsarray;
		$totalResponses = 0;
		$RateitResults = array();
		for($k=0;$k<count($resultsArray);$k++){
			
			$theAnswer = $resultsArray[$k]['answer'];
			$theTotal = $resultsArray[$k]['Total'];
			$RateitResults[$theAnswer] = $theTotal;
			$totalResponses = $totalResponses + $theTotal;
		}		
		
		$retVal .= '<p>'.$activity['activity_text'].'</p>';
		$retVal .= '<br><p>'.$activity['instructions'].'</p>';
		 
		$retVal .= '<hr class="firstquizhr"/>';
		$retVal .= '<table class="pollTable">';
		for($j=1;$j>=0;$j--){
			
			$total = $RateitResults[$j];
			$percentageTotal = round(($total / $totalResponses) * 100);	
			
			$barWidth = ($percentageTotal * 280) / 100;
			
			$retVal .= '<tr><td>';
			
			if($j==1){
				
				$retVal .= "Yes";
			}else{
				
				$retVal .= "No";
			}
			
			$retVal .= '</td><td>';
			if($j==1){
				$retVal .= '<table cellpadding=0 cellspacing=0 style="padding:0px; margin:0px;" border="0"><tr><td><div style="width:13px;" id="leftGreen"></div></td>';
				$retVal .= '<td><div style="width:'.$barWidth.'px" id="yesBar"></div></td>';
				$retVal .= '<td><div style="width:13px;" id="rightGreen"></div></td></tr></table>';
			
			}else{
				
				$retVal .= '<table cellpadding=0 cellspacing=0 style="padding:0px; margin:0px;" border="0"><tr><td><div style="width:13px;" id="leftRed"></div></td>';
				$retVal .= '<td><div style="width:'.$barWidth.'px" id="noBar"></div></td>';
				$retVal .= '<td><div style="width:13px;" id="rightRed"></div></td></tr></table>';				
				
			}
			$retVal .= '</td><td>';
			$retVal .= $percentageTotal . "%";
			
			$retVal .= '</td></tr>';
				
		}//end for
		$retVal .= '</table>';	
	
		
		echo $retVal;
		
		
	}
	
	public static function showQuizResults($params){
		
			$retVal = "";
			$topic_slp_id = $params['topicslpid'];
			$activity_id = $params['activityid'];
			$user_score = $params['totalScore'];
			
			
			$thinkTank = new GI_ThinkTankHandler();
			$activity = $thinkTank->getActivity($activity_id);
			$activity = $activity[0]; 

			$quizresults = $thinkTank->getQuizResults($activity_id, $user_score);
			$quizresults = $quizresults[0];
			

			$quiz_resulttext = $quizresults['result_text'];
			
			$retVal .= '<p>'.$activity['activity_text'].'</p>';
			$retVal .= '<br><p>'.$activity['instructions'].'</p>';
			 
			$retVal .= '<hr class="firstquizhr"/>';
			
			$retVal .= '<div class="quizresult"><p>The verdict is in.</p><p>'.$quiz_resulttext.'</p></div>';
			
			
			echo $retVal;
		
		
	}	
	
	public static function showSayWhatResults($params){
		
		$topic_slp_id = $params['topicslpid'];
		$activity_id = $params['activityid'];
		
		$captiontext1 = $params['caption1'];
		$captiontext2 = $params['caption2'];
		
		$retVal = "";
		
		$thinkTank = new GI_ThinkTankHandler();
		$activity = $thinkTank->getActivity($activity_id);
		$activity = $activity[0]; 
		
		$activity_questions = $thinkTank->getCaptionPicInfo($photo_slp_id);
		
		$retVal .= '<p>'.$activity['activity_text'].'</p>';
		$retVal .= '<br><p>'.$activity['instructions'].'</p>';
		
		
		$retVal .= '<hr class="firstquizhr"/>';
		
		
		$photo_slp_id = $activity['photo_slp_id'];
		
		$activity_questions = $thinkTank->getCaptionPicInfo($photo_slp_id);
		$contentImage = "/csimage?id={$photo_slp_id}&product_id=ereads&skipdb=y&height=390&width=700";
		
		$retVal .= '<table><tr><td><textarea class="caption" name="caption1" id="caption1" readonly="readonly">'. $captiontext1 .'</textarea></td>';
		$retVal .= '<td><img src="'. $contentImage.'"  alt="'.$activity_questions[0]['ada_text'].'" border=0/></td>';
		//$retVal .= '<td><img src="/images/thinktank/10007520.jpg" alt="'. $activity_questions[0]['ada_text'].'" border=0/></td>';
		$retVal .= '<td><textarea class="caption" name="caption2" id="caption2" readonly="readonly">'. $captiontext2 .'</textarea></td></tr></table>';
		
		echo $retVal;
		
		
		
		
	}	
	
	public static function showRateItResults($params){
		
		$topic_slp_id = $params['topicslpid'];
		$activity_id = $params['activityid'];
		
		$starselected = $params['starSelected'];
		$level = $params['level'];
		
		$retVal = "";
		
		$bundleXmlBundle = new GI_BundleCollectiveHandler($activity_id,$_SERVER['AUTH_PCODE'], $level);
ob_start();
?>		
			<table width="249" border="0" cellspacing="0" cellpadding="0">
			  <tr>
			    <th scope="row" width="249" height="66" style="background-image:url('/images/articlePage/rate_it_header.jpg');">
			    	 <h1>Rate It</h1>
 			    </th> 
			  </tr>
			  <tr>
			    <th align="left" style="background-image:url('/images/articlePage/rate_it_content.jpg');" scope="row">
		    

				<div id="rateitcontent"> 
                     <p><?php echo $bundleXmlBundle->getRatedLeadingQuestion();?></p>
                     
                    <div class="arrowrate">
                    <?php
                    $retVal .= ob_get_contents();
                    ob_end_clean();
                    
                    for($i=1;$i<=5;$i++){
                    	
                    	if($i<=$starselected){
                    		
                    		$retVal .= '<div class="star_filled"></div>';	
                    	
                    	}else{
                    		
                    		$retVal .= '<div class="star_unfilled"></div>';
                    		
                    	}
                    	
                    	
                    	
                    }
                    
                    
                   ob_start(); 
                    ?>
          
					</div>
                    
                     <div class="arrowheading">
                         <div class="arrowsleft">Not at all</div>
                         <div class="arrowsmiddle"></div>
                         <div class="arrowsright">Definetly</div>
                     </div>
                    
                       <div onclick="open_rateitresults('Rate it','/images/greenstar.gif', '<?php echo $activity_id;?>', '410 410', '<?php echo $topic_slp_id;?>'); collectStat('survey','ereads','report','<?php echo $activity_id;?>', ''); return false;" id="rateit_view" class="rateit_viewResults">
                                <div>VIEW RESULTS</div>
                       </div>

                    
                     </div>
                     
                   
			    </th>
			  </tr>
			  <tr>
			    <th scope="row"><img src="/images/articlePage/rate_it_footer.jpg" alt="Thinktank footer" width="249" height="15"/></th>
			  </tr>
			</table>
<?php		
		
		$retVal .= ob_get_contents();		
		ob_end_clean();
		
		
		echo $retVal;
		
		
		
		
	}	
		
}