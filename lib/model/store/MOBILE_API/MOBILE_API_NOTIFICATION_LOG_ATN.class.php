<?php
class MOBILE_API_NOTIFICATION_LOG_ATN extends TABLE{
        public function __construct($dbname="")
        {
                        parent::__construct($dbname);
			$this->PROFILEID_BIND_TYPE = "INT";
			//$this->FREQUENCY_BIND_TYPE = "STR";
			$this->NOTIFICATION_KEY_BIND_TYPE = "STR";
			//$this->MESSAGE_BIND_TYPE = "STR";
			//$this->SEND_DATE_BIND_TYPE = "STR";
			$this->SENT_BIND_TYPE = "STR";
			$this->OS_TYPE_BIND_TYPE = "STR";
			$this->MESSAGE_ID_BIND_TYPE = "INT";
        }
	public function insert($profileid,$key,$messageId,$sent,$osType)
	{
		$sqlInsert = "INSERT IGNORE INTO  MOBILE_API.NOTIFICATION_LOG_ATN (`PROFILEID`,`NOTIFICATION_KEY`,`MESSAGE_ID`,`SEND_DATE`,`SENT`,`OS_TYPE`) VALUES (:PROFILEID,:NOTIFICATION_KEY,:MESSAGE_ID,now(),:SENT,:OS_TYPE)";
		$resInsert = $this->db->prepare($sqlInsert);
		$resInsert->bindValue(":PROFILEID",$profileid,constant('PDO::PARAM_'.$this->{'PROFILEID_BIND_TYPE'}));
		$resInsert->bindValue(":NOTIFICATION_KEY",$key,constant('PDO::PARAM_'.$this->{'NOTIFICATION_KEY_BIND_TYPE'}));
		$resInsert->bindValue(":MESSAGE_ID",$messageId,constant('PDO::PARAM_'.$this->{'MESSAGE_ID_BIND_TYPE'}));
		$resInsert->bindValue(":SENT",$sent,constant('PDO::PARAM_'.$this->{'SENT_BIND_TYPE'}));
		$resInsert->bindValue(":OS_TYPE",$osType,constant('PDO::PARAM_'.$this->{'OS_TYPE_BIND_TYPE'}));
		$resInsert->execute();
	}
        public function getNotificationProfiles()
        {
		try{
                	$sql = "SELECT PROFILEID FROM MOBILE_API.NOTIFICATION_LOG_ATN";
                	$res = $this->db->prepare($sql);
                	$res->execute();
                	while($rowSelectDetail = $res->fetch(PDO::FETCH_ASSOC))
 	        	       $detailArr[] = $rowSelectDetail['PROFILEID'];
                	return $detailArr;
                }
                catch(PDOException $e){
                        throw new jsException($e);
                }
                return NULL;
        }
}
?>
