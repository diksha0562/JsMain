<?php
/**
* This taks will decide correct Strategy for the matchalerts users. 
*/
class MatchAlertCalculationTask extends sfBaseTask
{
	private $limit = 5000;
	private $limitNtRec = 16;
	private $limitTRec = 10;
	private $limitTRecTemp = 10;
	private $LowDppCountCachetime = 604800; // 1 week
	private $LowDppLimit = 10;
	private $LowUnifiedDppLimit = 20;
        private $limitCommunityRec = 10;
        private $limitLastSearchRec = 10;
	const clusterRecordLimit = 10;
        const _communityModelToggle=0;
        const limitNtWhenCommunity = 10;
  	const limitNtNoCommunity = 16;
        
	protected function configure()
  	{
		$this->addArguments(array(
                        new sfCommandArgument('totalScripts', sfCommandArgument::REQUIRED, 'My argument'),
                        new sfCommandArgument('currentScript', sfCommandArgument::REQUIRED, 'My argument'),
                        new sfCommandArgument('fromReg', sfCommandArgument::OPTIONAL, 'My argument',0),
        	));

		$this->addOptions(array(
		new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', 'jeevansathi'),
	     ));
	     
	    $this->namespace        = 'alert';
	    $this->name             = 'MatchAlertCalculation';
	    $this->briefDescription = '';
	    $this->detailedDescription = <<<EOF
	Call it with:
	  [php symfony alert:MatchAlertCalculation] 
EOF;
  	}

	protected function execute($arguments = array(), $options = array())
	{
		if(!sfContext::hasInstance())
			sfContext::createInstance($this->configuration);

                ini_set('memory_limit','512M');
                $totalScripts = $arguments["totalScripts"]; // total no of scripts
                $currentScript = $arguments["currentScript"]; // current script number
                $fromReg = $arguments["fromReg"]; // registered data flag
                $configObj = new MatchAlertsConfig();
                if($totalScripts == $configObj->instanceNonPeak){
                        $memObject=JsMemcache::getInstance();
                        $memObject->remove('MATCHALERT_POPULATE_EMPTY');
                        unset($memObject);
                }
                unset($configObj);
                $profilesWithLimitReached=array();
                $lowMatchesCheckObj = new LowDppMatchesCheck();
                $dateToCheck= date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . LowDppMatchesCheck::$mailerFreq ) );
                $profilesWithLimitReached = $lowMatchesCheckObj->getProfilesWithInformLimitReached($dateToCheck,$totalScripts,$currentScript);
                $lowTrendsObj = new matchalerts_LowTrendsMatchalertsCheck();
                $todayDate = date("Y-m-d H:i:s");
		$flag=1;
		do{
                        $this->killInstances($totalScripts);
			/**
			* Fetch Ids to be send.
			*/
                        $memObject=JsMemcache::getInstance();
			$matchalerts_MATCHALERTS_TO_BE_SENT = new matchalerts_MATCHALERTS_TO_BE_SENT;
			$arr = $matchalerts_MATCHALERTS_TO_BE_SENT->fetch($totalScripts,$currentScript,$this->limit,$fromReg);
                        //$arr = array(7043932=>array("HASTRENDS"=>0,"MATCH_LOGIC"=>'N','PERSONAL_MATCHES'=>'A'),144111=>array("HASTRENDS"=>0,"MATCH_LOGIC"=>'N','PERSONAL_MATCHES'=>'A'));
                       if(is_array($arr))
			{
				foreach($arr as $profileid=>$v)
				{
                                  $this->killInstances($totalScripts);
                                  if($v["HASTRENDS"] != 1)
                                    $v["HASTRENDS"] = 0;
					/**
					* update flag.
					*/
					$matchalerts_MATCHALERTS_TO_BE_SENT->update($profileid);
					$loggedInProfileObj = LoggedInProfile::getInstance();
					$loggedInProfileObj->getDetail($profileid,"PROFILEID","*");

					$trends = $v["HASTRENDS"];
                                        $matchesSetting = $v["PERSONAL_MATCHES"];
                                        $matchLogic = $v["MATCH_LOGIC"];
					if($loggedInProfileObj->getPROFILEID())
					{
                                                if($loggedInProfileObj->getPROFILEID()%99<=49){
                                                        if($matchLogic == "O"){
                                                                $strictDppObj = new StrictDppBasedMatchAlertsStrategy($loggedInProfileObj, MailerConfigVariables::$UNIFIED_LOGIC_LIST_COUNT,MailerConfigVariables::$UNIFIED_LOGIC_MAILER_COUNT, $trends);
                                                                $totalResults = $strictDppObj->getMatches();
                                                        }else{
                                                               $strictDppObj = new RelaxedDppBasedMatchAlertsStrategy($loggedInProfileObj, MailerConfigVariables::$UNIFIED_LOGIC_LIST_COUNT,MailerConfigVariables::$UNIFIED_LOGIC_MAILER_COUNT, $trends);
                                                                $totalResults = $strictDppObj->getMatches();
                                                                if($totalResults["CNT"] == 0 && $profileid%9==1){
                                                                        $lastSearchObj = new LastSearchBasedMatchAlertsStrategy($loggedInProfileObj,MailerConfigVariables::$UNIFIED_LOGIC_MAILER_COUNT,MailerConfigVariables::$lastSearch);
                                                                        $totalResults = $lastSearchObj->getMatches();
                                                                        $totalResults["LOGIC_LEVEL"] = MailerConfigVariables::$lastSearch;
                                                                }
                                                        }
                                                        if($totalResults["CNT"] == 0){
                                                                $lowTrendsObj->insertForProfile($profileid,$todayDate,$totalResults["LOGIC_LEVEL"]);
                                                        }
                                                        $this->logLowDppCount($lowMatchesCheckObj,$lowTrendsObj,$profileid,$totalResults,$totalResults["LOGIC_LEVEL"],$profilesWithLimitReached,$todayDate);
                                                        $this->setLowDppFlag($memObject,$profileid,$totalResults["CNT"],$this->LowUnifiedDppLimit);     
                                                }else{
                                                $returnTotalCountWithCluster = 0;
						if($trends)
						{
                                                        $profiles = array();
							/*
							* Two mails will be sent to user if has trends
							*/ 
                                                        
                                                        $StrategyReceiversNT = new DppBasedMatchAlertsStrategy($loggedInProfileObj,$this->limitTRec,MailerConfigVariables::$strategyReceiversTVsNT,MailerConfigVariables::$DppLoggedinWithReverseDppSort);
							$totalResults = $StrategyReceiversNT->getMatches('',1,array(),$matchesSetting,$matchLogic);
                                                        
                                                        $this->logLowDppCount($lowMatchesCheckObj,$lowTrendsObj,$profileid,$totalResults,MailerConfigVariables::$relaxedDpp,$profilesWithLimitReached,$todayDate);
                                                        // Set Low Dpp flag
                                                        $this->setLowDppFlag($memObject,$profileid,$totalResults["CNT"]);     
                                                        
                                                        if($totalResults["CNT"] == 0 && $profileid%9==1 && $matchLogic!='O'){
                                                                $lastSearchObj = new LastSearchBasedMatchAlertsStrategy($loggedInProfileObj,$this->limitLastSearchRec,MailerConfigVariables::$lastSearch);
                                                                $totalResults = $lastSearchObj->getMatches();
                                                                if($totalResults["CNT"] == 0){
                                                                        $lowTrendsObj->insertForProfile($profileid,$todayDate,MailerConfigVariables::$lastSearch);
                                                                }
                                                        }
                                                        
                                                        $StrategyReceiversT = new TrendsBasedMatchAlertsStrategy($loggedInProfileObj, $this->limitTRecTemp,MailerConfigVariables::$BroaderDppSort);   
                                                        $totalResults = $StrategyReceiversT->getMatches($profiles,$matchesSetting); 
                                                        if($totalResults["CNT"] == 0)
                                                        {                                                            
                                                            $lowTrendsObj->insertForProfile($profileid,$todayDate,MailerConfigVariables::$strategyReceiversTVsT);
                                                        }
						}
						else
						{
                                                    
                                                        if($fromReg!=1 && $this->checkForCommunityModel($loggedInProfileObj,$matchLogic)){
                                                                $matchalerts_MATCHALERTS_TO_BE_SENT->updateCommunity($profileid,"E");
                                                                $this->limitNtRec=self::limitNtWhenCommunity;
                                                        }else{
                                                                /**
                                                                * Matches : Trends are not set, Only one mailer will be sent. 
                                                                */
                                                           $includeDppCnt = 1;
                                                                $StrategyReceiversNT = new DppBasedMatchAlertsStrategy($loggedInProfileObj,$this->limitNtRec,MailerConfigVariables::$strategyReceiversNT,MailerConfigVariables::$DppLoggedinWithReverseDppSort);
                                                                $totalResults = $StrategyReceiversNT->getMatches($includeDppCnt,$returnTotalCountWithCluster,array(),$matchesSetting,$matchLogic);
                                                                $this->logLowDppCount($lowMatchesCheckObj,$lowTrendsObj,$profileid,$totalResults,MailerConfigVariables::$relaxedDpp,$profilesWithLimitReached,$todayDate);
                                                                // Set Low Dpp flag
                                                                $this->setLowDppFlag($memObject,$profileid,$totalResults["CNT"]);
                                                                if($totalResults["CNT"] == 0 && $profileid%9==1 && $matchLogic!='O'){
                                                                        $lastSearchObj = new LastSearchBasedMatchAlertsStrategy($loggedInProfileObj,$this->limitNtRec,MailerConfigVariables::$lastSearch);
                                                                        $totalResults = $lastSearchObj->getMatches();
                                                                        if($totalResults["CNT"] == 0){
                                                                                $lowTrendsObj->insertForProfile($profileid,$todayDate,MailerConfigVariables::$lastSearch);
                                                                        }
                                                                }
                                                        }
						}
                                                }
//                                                 cache ttl set to 1hr
//                                                $memObject->remove('SEARCH_JPARTNER_'.$profileid);
//                                                $memObject->remove('SEARCH_MA_IGNOREPROFILE_'.$profileid);
					}
				}
			
			}
			else
				$flag=0;
		}while($flag);
	}
        /**
         * This function logs 0 count data.
         * @param type $memObject Cahce Object
         * @param type $profileid // profile id
         */
        private function logLowDppCount($lowMatchesCheckObj,$lowTrendsObj,$profileID,$totalResults,$type,$profilesWithLimitReached,$todayDate){
                if(($totalResults["CNT"] == 0 || (isset($totalResults["actualDppCount"]) && $totalResults["actualDppCount"] == 0)) && !in_array($profileID, $profilesWithLimitReached)){
                        $lowMatchesCheckObj->insertForProfile($profileID);
                }
                if($totalResults["CNT"] == 0)
                {
                        $lowTrendsObj->insertForProfile($profileID,$todayDate,$type);
                }       
        }
        /**
         * This function sets low dpp cache flag.
         * @param type $memObject Cahce Object
         * @param type $profileid // profile id
         */
        private function setLowDppFlag($memObject,$profileid,$dppCount,$limitFlag=0){
                if($limitFlag == 0){
                        $limitFlag = $this->LowDppLimit;
                }
                if($dppCount < $limitFlag){
                        $memObject->set('MA_LOWDPP_FLAG_'.$profileid,1,$this->LowDppCountCachetime);
                        $memObject->incrCount('MA_LOWDPP_FLAG_COUNT');
                }else{
                        $memObject->remove('MA_LOWDPP_FLAG_'.$profileid);
                }       
        }
        
        /**
         * This function returns whether to use community model.
         */
        private function checkForCommunityModel($profileObj,$oldNewLogic){
                if($profileObj->getPROFILEID()%99<=49 && $profileObj->getGENDER() == "F" && $profileObj->getAGE() <= 30 && self::_communityModelToggle && $oldNewLogic=='N'){
                    return true;
                }
                else
                    return false;
        }
        private function killInstances($totalScripts){
                $configObj = new MatchAlertsConfig();
                if($configObj->isMatchAlertsForNonPeakHour() && $totalScripts == $configObj->instancePeak){
                        successfullDie("Reached peak hour kill extra instance and start new");
                }elseif($configObj->isMatchAlertsForNonPeakHour() == false && $totalScripts == $configObj->instanceNonPeak){
                        successfullDie("Reached non peak hour increase cron");
                }
                unset($configObj);
        }
}
