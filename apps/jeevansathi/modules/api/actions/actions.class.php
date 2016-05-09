<?php

/**
 * api actions.
 *
 * @package    jeevansathi
 * @subpackage api
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class apiActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
   // $this->forward('register', 'page1');
  }
  
  
	public function executeApiRequest(sfWebRequest $request) 
	{
                if(JsConstants::$appDown)
                {
                        $respObj = ApiResponseHandler::getInstance();
                        $respObj->setHttpArray(ResponseHandlerConfig::$APP_DOWN);
                        $respObj->generateResponse();
                        die;
                }
    		$this->apiWebHandler = ApiRequestHandler::getInstance($request);
		$request->setAttribute("mobileAppApi",1);
		$respObj = ApiResponseHandler::getInstance();
			if($request->getParameter("FROM_GCM")==1)
				$gcm=1;
    		$apiValidation=$this->apiWebHandler->getResponse();
		if($apiValidation["statusCode"] == ResponseHandlerConfig::$SUCCESS["statusCode"])
		{
			$upgradeStatus=$this->apiWebHandler->forceUpgradeCheck($request,"apiAction");
			$authChecksum=$request->getParameter("AUTHCHECKSUM");
			if($authChecksum)
			{
				$loginData=$this->apiWebHandler->validateAuthChecksum($authChecksum,$gcm);
				if($loginData[PROFILEID])
				{
					$this->AfterAuth($loginData,$request);
				}
			}
			$this->ForwardOrNot($request,$loginData,$upgradeStatus);
		}
		else
		{		
			$respObj->setHttpArray($this->apiWebHandler->getResponse());
			$respObj->generateResponse();
		}
           	die;
    	}
	private function AfterAuth($loginData,$request)
	{
		$respObj = ApiResponseHandler::getInstance();
		$request->setAttribute("loginData",$loginData);
		$request->setAttribute('profileid', $loginData[PROFILEID]);
		$respObj->setAuthChecksum($loginData[AUTHCHECKSUM]);
	}
	private function ForwardOrNot($request,$loginData,$upgradeStatus)
	{
		$respObj = ApiResponseHandler::getInstance();
		$forwardingArray=$this->apiWebHandler->getModuleAndActionName($request);
		$hamburgerDetails = HamburgerApp::getHamburgerDetails($loginData[PROFILEID],$request->getParameter("version"),$forwardingArray);
		$respObj->setHamburgerDetails($hamburgerDetails);
		if($upgradeStatus)
			$respObj->setUpgradeDetails($upgradeStatus);

		// Code added to update app device details (app version/os version/device model)
		if($forwardingArray["moduleName"]=='myjs'){
			NotificationFunctions::updateVersionDetails($request);
		}// Code ends
		$this->forward($forwardingArray["moduleName"],$forwardingArray["actionName"]);
	}
        public function executeHamburgerDetailsV1(sfWebRequest $request)
	{
		$respObj = ApiResponseHandler::getInstance();
		$respObj->setHttpArray(ResponseHandlerConfig::$SUCCESS);
		$respObj->generateResponse();
		die;
	}
}