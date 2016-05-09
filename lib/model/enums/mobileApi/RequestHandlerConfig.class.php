<?php
class RequestHandlerConfig
{
	public static $moduleActionVersionArray = array(
	"notification"=>array(
		"updateNotificationStatus"=>array("v1"=>"updateNotificationStatusV1","v3"=>"updateNotificationStatusV1"),
		"registrationIdUpdate"=>array("v1"=>"registrationIdUpdateV1","v3"=>"registrationIdUpdateV1"),
		"registrationIdInsert"=>array("v1"=>"registrationIdInsertV1","v3"=>"registrationIdInsertV1"),
		"deliveryTracking"=>array("v1"=>"deliveryTrackingV1","v3"=>"deliveryTrackingV1"),
		"poll"=>array("v1"=>"pollV1","v3"=>"pollV1"),
        "insertChromeId"=>array("v1"=>"insertChromeIdV1"),
        "getNotification"=>array("v1"=>"getNotificationV1"),
        "updateNotificationSetting"=>array("v1"=>"updateNotificationSettingV1")),
	"search"=>array(
		"partnermatches"=>array("v1"=>"searchApiV1Action","v2"=>"","v3"=>"searchApiV1Action"),
		"perform"=>array("v1"=>"performV1","v2"=>"","v3"=>"performV1"),
                "matchAlertToggleLogic"=>array("v1"=>"matchAlertToggleApiV1","v2"=>"","v3"=>"matchAlertToggleApiV1"),
		"populateDefaultValues"=>array("v1"=>"populateDefaultValuesV1","v2"=>"populateDefaultValuesV2","v3"=>"populateDefaultValuesV1"),
		"searchFormData"=>array("v1"=>"SearchFormDataV1","v2"=>"","v3"=>"SearchFormDataV1"),
		"ViewSimilarProfiles"=>array("v1"=>"ViewSimilarProfilesV1","v2"=>"","v3"=>"ViewSimilarProfilesV1"),
		"saveSearchCall"=>array("v1"=>"saveSearchCallV1","v2"=>"","v3"=>"saveSearchCallV1"),
		"saveDpp"=>array("v1"=>"saveDppV1","v2"=>"","v3"=>"saveDppV1"),
		"gunaScore"=>array("v1"=>"getGunaScoreV1","v2"=>"","v3"=>"getGunaScoreV1")),
	"myjs"=>array(
                "perform"=>array("v1"=>"performV1","v2"=>"","v3"=>"performV1")),
	"faq"=>array(
				"feedbackAbuse"=>array("v1"=>"ApiFeedbackV1","v2"=>"","v3"=>"ApiFeedbackV1")),
	"contactus"=>array(
				"info"=>array("v1"=>"ApiContactUsV1","v2"=>"","v3"=>"ApiContactUsV1")),
	"membership"=>array(
				"membershipDetails"=>array("v1"=>"ApiMembershipDetailsV1","v2"=>"ApiMembershipDetailsV2","v3"=>"ApiMembershipDetailsV3")),
    "profile"=>array(
		"editprofile"=>array("v1"=>"ApiEditV1","v2"=>"ApiEditV1","v3"=>"ApiEditV1"),
		"editsubmit"=>array("v1"=>"ApiEditSubmitV1","v2"=>"","v3"=>"ApiEditSubmitV1"),
		"filter"=>array("v1"=>"ApiEditFilterV1","v2"=>"","v3"=>"ApiEditFilterV1"),
		"filtersubmit"=>array("v1"=>"ApiEditFilterSubmitV1","v2"=>"","v3"=>"ApiEditFilterSubmitV1"),
		"dppsubmit"=>array("v1"=>"apieditdppv1","v2"=>"","v3"=>"apieditdppv1"),
		"detail"=>array("v1"=>"apidetailedv1","v2"=>"","v3"=>"apidetailedv1"),
		"gunascore"=>array("v1"=>"gunascorev1","v2"=>"","v3"=>"gunascorev1"),
		"alterseen"=>array("v1"=>"AlterSeenV1","v2"=>"","v3"=>"AlterSeenV1"),
        "coverphoto"=>array("v1"=>"CoverPhotoV1"),
        "horoscope"=>array("v1"=>"HoroscopeV1"),
        "deepLinking"=>array("v1"=>"apiDeepLinkingTrackingV1","v2"=>"apiDeepLinkingTrackingV1","v3"=>"apiDeepLinkingTrackingV1")),
    "settings"=>array(
		"alertManager"=>array("v1"=>"AlertManagerV1","v2"=>"","v3"=>"AlertManagerV1"),
    	"deleteProfile"=>array("v1"=>"DeleteProfileV1","v2"=>"","v3"=>"DeleteProfileV1")),
	"api"=>array(
		"appReg"=>array("v1"=>"AppRegV1","v2"=>"AppRegV1","v3"=>"AppRegV1"),
		"login"=>array("v1"=>"LoginV1","v2"=>"","v3"=>"LoginV1"),
		"forgotlogin"=>array("v1"=>"ForgotloginV1","v2"=>"","v3"=>"ForgotloginV1"),
		"PassChange"=>array("v1"=>"pass_changev1","v2"=>"","v3"=>"pass_changev1"),
		"logout"=>array("v1"=>"logoutv1","v2"=>"logoutv1","v3"=>"logoutv1"),
		"versionupgrade"=>array("v1"=>"versionupgrade_v1","v3"=>"versionupgrade_v1"),
		"hamburgerDetails"=>array("v1"=>"hamburgerDetailsV1","v3"=>"hamburgerDetailsV1")),
	"social"=>array(
		"requestPhoto"=>array("v1"=>"RequestPhotoV1","v2"=>"","v3"=>"RequestPhotoV1"),
		"uploadPhoto"=>array("v1"=>"SelfPhotoFunctionalityV1","v2"=>"","v3"=>"SelfPhotoFunctionalityV1"),
		"deletePhoto"=>array("v1"=>"SelfPhotoFunctionalityV1","v2"=>"","v3"=>"SelfPhotoFunctionalityV1"),
		"setProfilePhoto"=>array("v1"=>"SelfPhotoFunctionalityV1","v2"=>"","v3"=>"SelfPhotoFunctionalityV1"), 
		"getProfilePhoto"=>array("v1"=>"GetProfilePicV1","v2"=>"","v3"=>""), 
		"saveCroppedProfilePic"=>array("v1"=>"SelfPhotoFunctionalityV1","v2"=>"","v3"=>"SelfPhotoFunctionalityV1"),
		"changePhotoPrivacy"=>array("v1"=>"changePhotoPrivacyV1","v2"=>"","v3"=>"changePhotoPrivacyV1"),		
		"getAlbum"=>array("v1"=>"GetAlbumV1","v2"=>"","v3"=>"GetAlbumV1"),
		"import"=>array("v1"=>"","v2"=>"","v3"=>"import"),
		"importFb"=>array("v1"=>"","v2"=>"","v3"=>"importFbV1"),
		"MobPhotoTracking"=>array("v1"=>"MobPhotoTrackingV1","v2"=>"","v3"=>"MobPhotoTrackingV1")),
	"register"=>array(
				"page1"=>array("v1"=>"page1v1","v2"=>"","v3"=>"page1v1"),
					"page2"=>array("v1"=>"page2v1","v2"=>"","v3"=>"page2v1"),
				 "page3"=>array("v1"=>"page3v1","v2"=>"","v3"=>"page3v1"),  
					"staticTablesData"=>array("v1"=>"StaticDataV1","v2"=>"","v3"=>"StaticDataV1")),
				"contacts"=>array("contactDetails"=>array("v1"=>"ContactDetailsV1","v2"=>"ContactDetailsV2","v3"=>"ContactDetailsV2"),
					  "postEOI"=>array("v1"=>"postEOIv1","v2"=>"postEOIv2","v3"=>"postEOIv2"),
					  "MessageHandle"=>array("v1"=>"MessageHandleV1","v2"=>"MessageHandleV1","v3"=>"MessageHandleV1"),
					  "WriteMessage"=>array("v1"=>"WriteMessagev1","v2"=>"WriteMessagev2","v3"=>"WriteMessagev2"),
					  "postWriteMessage"=>array("v1"=>"postWriteMessageV1","v2"=>"postWriteMessageV2","v3"=>"postWriteMessageV2"),
					  "accept"=>array("v1"=>"postAcceptv1","v2"=>"postAcceptv2","v3"=>"postAcceptv2"),
					  "postAccept"=>array("v1"=>"postAcceptv1","v2"=>"postAcceptv2","v3"=>"postAcceptv2"),
					  "decline"=>array("v1"=>"postNotInterestedv1","v2"=>"postNotInterestedv2","v3"=>"postNotInterestedv2"),
					  "postNotInterested"=>array("v1"=>"postNotInterestedv1","v2"=>"postNotInterestedv2","v3"=>"postNotInterestedv2"),
					  "reminder"=>array("v1"=>"postSendReminderv1","v3"=>"postSendReminderv1"),
					  "postSendReminder"=>array("v1"=>"postSendReminderv1","v2"=>"postSendReminderv2","v3"=>"postSendReminderv2"),
					  "history"=>array("v1"=>"CommunicationHistoryV1","v3"=>"CommunicationHistoryV1"),
	 				  "postCancelInterest"=>array("v1"=>"postCancelInterestv1","v2"=>"postCancelInterestv2","v3"=>"postCancelInterestv2"),
					  "cancel"=>array("v1"=>"postCancelInterestv1","v2"=>"postCancelInterestv2","v3"=>"postCancelInterestv2"),
					  "preWriteMessage"=>array("v2"=>"PreWriteMessagev2")),
	"common"=>array("AddBookmark"=>array("v1"=>"AddBookmarkv1","v3"=>"AddBookmarkv1"),"ignoreprofile"=>array("v1"=>"ApiIgnoreProfileV1","v3"=>"ApiIgnoreProfileV1"),"engagementcount"=>array("v2"=>"GetEngagementCountv1"),"caLayer"=>array("v1"=>"ApiCALayerV1","v2"=>"ApiCALayerV1","v3"=>"ApiCALayerV1"),"criticalActionLayerTracking"=>array("v1"=>"","v2"=>"","v3"=>"criticalActionLayerTracking"),"verificationData"=>array("v1"=>"ApiVerificationDataV1","v3"=>"ApiVerificationDataV1"),"trackRCB"=>array("v1"=>"TrackRCBV1","v3"=>"TrackRCBV1")),
	"common"=>array("AddBookmark"=>array("v1"=>"AddBookmarkv1","v3"=>"AddBookmarkv1"),"ignoreprofile"=>array("v1"=>"ApiIgnoreProfileV1","v3"=>"ApiIgnoreProfileV1"),"engagementcount"=>array("v2"=>"GetEngagementCountv1"),"caLayer"=>array("v1"=>"ApiCALayerV1","v2"=>"ApiCALayerV1","v3"=>"ApiCALayerV1"),"criticalActionLayerTracking"=>array("v1"=>"","v2"=>"","v3"=>"criticalActionLayerTracking"),"verificationData"=>array("v1"=>"ApiVerificationDataV1"),"trackRCB"=>array("v1"=>"TrackRCBV1","v3"=>"TrackRCBV1")),
	"inbox"=>array("perform"=>array("v1"=>"performV1","v2"=>"performV2","v3"=>"performV2")),
	"phone"=>array("display"=>array("v1"=>"displayV1","v2"=>"displayV1","v3"=>"displayV1"),
			"save"=>array("v1"=>"saveV1","v3"=>"saveV1"),
			"verified"=>array("v1"=>"verifiedV1","v3"=>"verifiedV1"),
			"sendOTPSMS"=>array("v1"=>"SendOtpSMS","v2"=>"SendOtpSMS","v3"=>"SendOtpSMS"),
			"matchOTP"=>array("v1"=>"MatchOtp","v2"=>"MatchOtp","v3"=>"MatchOtp")),
	"static"=>array("page"=>array("v1"=>"pagev1","v2"=>"pagev1","v3"=>"pagev1"),"pagehits"=>array("v1"=>"savehitsv1","v2"=>"savehitsv1","v3"=>"savehitsv1"))	
);

        public static $moduleActionHamburgerArray = array(
	"myjs"=>array(
                "performV1"=>true),
	"api"=>array(
		"hamburgerDetailsV1"=>true),
	"inbox"=>array(
                "performV2"=>true),
	"search"=>array(
                "performV1"=>true)
	);
	//created for authenication
	public static $AUTH_IP_COUNT = 100;
	public static $ENABLED = "E";
	public static $DISABLED = "D";
	
	
	public static $trackLoginArray = array(
	"notification"=>array(
		"updateNotificationStatus"=>array("v1"=>"N"),
		"registrationIdUpdate"=>array("v1"=>"N"),
		"registrationIdInsert"=>array("v1"=>"N"),
		"deliveryTracking"=>array("v1"=>"N"),
		"poll"=>array("v1"=>"N")
		),
	"profile"=>array(
	"gunascore"=>array("v1"=>"N","v2"=>"N","v3"=>"N"),
	),
	);
	
}
?>