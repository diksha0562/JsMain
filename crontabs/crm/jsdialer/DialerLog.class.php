<?php
class DialerLog
{
        public function __construct($db_js_111=''){

		$this->db_js_111 	=$db_js_111;
		$this->logFilePath	='/home/developer/jsdialer/';
        }

	public function logError($sql,$campaignName='',$dbConnect='',$ms='')
	{
		$today 		=@date("Y-m-d H:m:i");
		$filename 	=$this->logFilePath."logerror.txt";
		if(is_writable($filename)){
			if (!$handle = fopen($filename, 'a')){
				echo "Cannot open file ($filename)";
				exit;
			}
			if($ms)
				$string ="\n DATE:$today \t CAMPAIGN:$campaignName \t QUERY:$sql \t ERROR:".mssql_get_last_message($dbConnect);
			else
				$string ="\n DATE:$today \t CAMPAIGN:$campaignName \t QUERY:$sql \t ERROR:".mysql_error($dbConnect);
			fwrite($handle, $string);
			fclose($handle);
		}
		else{
			echo "The file $filename is not writable";
			if(!chmod($filename, 0666)){
				echo "Cannot change the mode of file ($filename)";
				exit;
			}
		}
	}
}
?>
