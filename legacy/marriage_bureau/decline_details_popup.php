<?php
include('connectmb.inc');
$db=connect_dbmb();
$mbdata=authenticatedmb($mbchecksum);
if($mbdata)
{
        $profileid=$mbdata["PROFILEID"];
	include_once('../profile/contact.inc');
	$nikhil_marriage_bureau=1;
	include_once('../profile/connect.inc');
	mysql_select_db_js('newjs');
	$custmessage="";
	assign_template_pathprofile();
	send_response($againstprofileid,$pid,'D',$custmessage,'N','Y',0);
	assign_template_pathmb();
	$smarty->display('decline_details_popup.htm');
}
else
{
        timeoutmb();
}

?>