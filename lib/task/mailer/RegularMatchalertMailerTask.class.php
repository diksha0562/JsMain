<?php

/**
 This task is used to send regular matchalert mailer 
 *@author : Reshu Rajput
 *created on : 20 May 2014 
 */
class RegularMatchalertMailerTask extends sfBaseTask
{
    private $smarty;
    private $mailerName = "MATCHALERT";
    private $limit = 1000;
  
  protected function configure()
  {
    $this->namespace        = 'mailer';
    $this->name             = 'RegularMatchalertMailer';
    $this->briefDescription = 'regular matchalert mailer';
    $this->detailedDescription = <<<EOF
      The task send matchalert mailer .
      Call it with:

      [php symfony mailer:RegularMatchalertMailer totalScript currentScript] 
EOF;
    $this->addArguments(array(
		new sfCommandArgument('totalScript', sfCommandArgument::REQUIRED, 'My argument'),
                new sfCommandArgument('currentScript', sfCommandArgument::REQUIRED, 'My argument'),
                ));
    $this->addOptions(array(
        new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', 'jeevansathi'),
     ));
  }

  protected function execute($arguments = array(), $options = array())
  {
	if(!sfContext::hasInstance())
		sfContext::createInstance($this->configuration);
	$totalScript = $arguments["totalScript"]; // total no of scripts
        $currentScript = $arguments["currentScript"]; // current script number
	$LockingService = new LockingService;
        $file = $this->mailerName."_".$totalScript."_".$currentScript.".txt";
        $lock = $LockingService->getFileLock($file,1);
        if(!$lock)
        	successfullDie();
	$mailerServiceObj = new MailerService();
	// match alert configurations
        $fields ="SNO,RECEIVER,USER1,USER2,USER3,USER4,USER5,USER6,USER7,USER8,USER9,USER10,USER11,USER12,USER13,USER14,USER15,USER16,LOGIC_USED,FREQUENCY";
	$receivers = $mailerServiceObj->getMailerReceivers($totalScript,$currentScript,$this->limit,$fields);
	$clicksource = "matchalert1";
	$this->smarty = $mailerServiceObj->getMailerSmarty();
        $countObj = new jeevansathi_mailer_DAILY_MAILER_COUNT_LOG();
        $instanceId = $countObj->getID('MATCHALERT_MAILER');
        $this->smarty->assign('instanceID',$instanceId);
	if(is_array($receivers))
	{            
		$mailerLinks = $mailerServiceObj->getLinks();
		$this->smarty->assign('mailerLinks',$mailerLinks);
		$this->smarty->assign('mailerName',MAILER_COMMON_ENUM::getSenderEnum($this->mailerName)["SENDER"]);
		$widgetArray = Array("autoLogin"=>true,"nameFlag"=>true,"dppFlag"=>false,"membershipFlag"=>true,"openTrackingFlag"=>true,"filterGenderFlag"=>true,"sortPhotoFlag"=>true,"logicLevelFlag"=>true,"googleAppTrackingFlag"=>true);
		foreach($receivers as $sno=>$values)
		{
			$pid = $values["RECEIVER"];
			$sno = $values["SNO"];
			$data = $mailerServiceObj->getRecieverDetails($pid,$values,$this->mailerName,$widgetArray);
			if(is_array($data))
			{
                                $stypeMatch = $this->getStype($values["LOGIC_USED"]);
				//Common Parameters required in mailer links
				$data["stypeMatch"] =$stypeMatch."&clicksource=".$clicksource;
				$subjectAndBody= $this->getSubjectAndBody($data["USERS"][0],$data["COUNT"],$values["LOGIC_USED"]);
				$data["body"]=$subjectAndBody["body"];
				$data["showDpp"]=$subjectAndBody["showDpp"];
				$subject ='=?UTF-8?B?' . base64_encode($subjectAndBody["subject"]) . '?='; 
				$this->smarty->assign('data',$data);
				$msg = $this->smarty->fetch(MAILER_COMMON_ENUM::getTemplate($this->mailerName).".tpl");
				$flag = $mailerServiceObj->sendAndVerifyMail($data["RECEIVER"]["EMAILID"],$msg,$subject,$this->mailerName,$pid);
				
			}
			else
				$flag = "I"; // Invalid users given in database
			$mailerServiceObj->updateSentForUsers($sno,$flag);
			unset($subject);
			unset($mailSent);
			unset($data);
		}
	}
  }
  /**
   * This function returns stpe on the basis of logic level
   * @param int $logicUsed logic level
   * @return string stype based on logic level
   */
  function getStype($logicUsed){
    switch ($logicUsed) {
      case 1:
        return SearchTypesEnums::MatchAlertMailer1;
        break;
      case 2:
        return SearchTypesEnums::MatchAlertMailer2;
        break;
      case 3:
        return SearchTypesEnums::MatchAlertMailer3;
        break;
      default:
        return SearchTypesEnums::MatchAlertMailer;
        break;
    }
  }
  /**
  This function is to get subject of the mail required as per business
  *@param $name : name of the receiver of the mail
  *@param $count : number of users sent in mail
  *@return $subject : subject of the mail
  */
  protected function getSubjectAndBody($firstUser,$count,$logic)
  {
	$subject = array();
	$today = date("d M");
        $matchStr = " Matches";
        $these = ' these';
        if($count==1){
                $matchStr = " Match";
                $these = '';
        }
        $dateStr = '';
        $subject["showDpp"]= 0;
	switch($logic)
	{
		case "3": //NT-NT case
			$subject["subject"]= $count." Desired Partner".$matchStr." for today | $today";
			$subject["body"]="You may send interest to".$these." ".$count.strtolower($matchStr)." based on your Desired Partner Profile.";
                        $subject["showDpp"]= 1;
			break;
		case "2":// T-NT case
                        $subject["subject"]= $count." Desired Partner".$matchStr." for today | $today"; 
			$subject["body"]="You may send interest to".$these." ".$count.strtolower($matchStr)." based on your Desired Partner Profile.";
                        $subject["showDpp"]= 1;
                        break;
		case "4":// NT -T case
		case "1":// T-T case
                        $subject["subject"]= $count.$matchStr." based on your recent activity | $today";
			$subject["body"]="You may send interest to".$these." ".$count.strtolower($matchStr)." based on your recent activity. Your recent activity includes the interests, acceptances and declines sent in the last two months.";
                        break;
		default :
			 throw  new Exception("No logic send in subjectAndBody() in RegularMatchAlerts task");
			
	}
	
	return $subject;
  }

}