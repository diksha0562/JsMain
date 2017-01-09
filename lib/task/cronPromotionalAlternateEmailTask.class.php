
<?php
/**
 * This cron identifies Junk characters entered in 'About me' and auto-mark incomplete after removing Junk characters
 */

class cronPromotionalAlternateEmailTask extends sfBaseTask
{
    CONST MAIL_ID = "1844";

    protected function configure()
    {
        $this->namespace           = 'cron';
        $this->name                = 'cronPromotionalAlternateEmail';
        $this->briefDescription    = 'cron to send promotional mails.';
        $this->detailedDescription = <<<EOF
    This cron is for sending promotional alternate emails. 
      Call it with:[php symfony cron:cronPromotionalAlternateEmail  totalScript currentScript isLegacyProfiles]
EOF;
        $this->addArguments(array(
            new sfCommandArgument('totalScript', sfCommandArgument::REQUIRED, 'My argument'),
            new sfCommandArgument('currentScript', sfCommandArgument::REQUIRED, 'My argument'),
            new sfCommandArgument('isLegacyProfiles', sfCommandArgument::REQUIRED, 'My argument'),
            ));
        $this->addOptions(array(
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', 'jeevansathi')
        ));
    }
    
    protected function execute($arguments = array(), $options = array()){   
        if(!sfContext::hasInstance())
            sfContext::createInstance($this->configuration);

        $totalScript = $arguments["totalScript"]; // total no of scripts
        $currentScript = $arguments["currentScript"]; // current script number

        /**
         * this variable decides whether code is executed only once or multiple times.
         * @var int
         */
        
        $isLegacyProfiles = $arguments["isLegacyProfiles"]; // whether mail is to be sent all legacy profiles?

        $profileIDs = array();
        $profileIdsNoContacts = array();
        $profileIDs = array();
        
        $jprofileContact = new NEWJS_JPROFILE_CONTACT("newjs_slave");

        try 
        {
            if ( !$isLegacyProfiles )
            {
                $activateDate = date('Y-m-d',strtotime(PromotionalAlternateEmailEnums::VERIFY_ACTIVATED_LIMIT));
                $entryDate = date('Y-m-d',strtotime(PromotionalAlternateEmailEnums::ENTRY_DATE_LIMIT));

                $profileIDs = $jprofileContact->getPromotionalMailerAccounts($activateDate,$entryDate,$totalScript,$currentScript);

                $profileIdsNoContacts = $jprofileContact->getPromotionalMailerAccountNoContact($activateDate,$entryDate,$totalScript,$currentScript);
            }
            else
            {
                $activateDate = date('Y-m-d',strtotime(PromotionalAlternateEmailEnums::VERIFY_ACTIVATED_LIMIT));
                $lastLoginDate = date('Y-m-d',strtotime(PromotionalAlternateEmailEnums::LAST_LOGIN_LIMIT));
                $profileIDs = $jprofileContact->getPromotionalMailerAccountsOnce($activateDate,$lastLoginDate,$totalScript,$currentScript);
                $profileIdsNoContacts = $jprofileContact->getPromotionalMailerAccountNoContactOnce($activateDate,$lastLoginDate,$totalScript,$currentScript);
            }

            if ( is_array($profileIDs) && is_array($profileIdsNoContacts))
            {   
                $profileIDs = array_merge($profileIDs,$profileIdsNoContacts);
            }
            elseif (is_array($profileIdsNoContacts)) {
                $profileIDs = $profileIdsNoContacts;
            }

            if ( is_array($profileIDs))
            {
                foreach ($profileIDs as $profileId) {
                    $this->sendPromotionalAlternateEmail($profileId);
                }
            }
            
        } catch (Exception $e) {
            jsException::nonCriticalError("cronPromotionalAlternateEmail ".$e);
        }

        
    }


    
    /**
     * This function is used to send email for a given profile id for Promotional Alternate Email Id.
     * @param  string $profileId 
     */
    public function sendPromotionalAlternateEmail($profileId)
    {
        $email_sender = new EmailSender(MailerGroup::PROMOTIONAL_ALTERNATE_EMAIL, self::MAIL_ID);
        $emailTpl = $email_sender->setProfileId($profileId);
        $smartyObj = $emailTpl->getSmarty();
        $email_sender->send();
    }
}

