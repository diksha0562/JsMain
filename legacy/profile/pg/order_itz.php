<?php
include ("../connect.inc");
include ("functions.php");
connect_db();

$ip = FetchClientIP();
if (strstr($ip, ",")) {
    $ip_new = explode(",", $ip);
    $ip = $ip_new[1];
}
if ($data = authenticated($checksum)) {
    $profileid = $data["PROFILEID"];
    
    $smarty->assign("SERVICE_SELECTED", $service);
    $smarty->assign("SERVICE_SELECTED", $service);
    $smarty->assign("VOICEMAIL", $voicemail);
    $smarty->assign("HOROSCOPE", $horoscope);
    $smarty->assign("BOLDLISTING", $boldlisting);
    $smarty->assign("MATRI_PROFILE", $matri_profile);
    $smarty->assign("KUNDLI", $kundli);
    
    $smarty->assign("SERVICE_STR", $service_str);
    $smarty->assign("SERVICE_MAIN", $service_main);
    $smarty->assign("SER_MAIN", $ser_main);
    $smarty->assign("SER_DURATION", $ser_duration);
    $smarty->assign("TYPE", $type);
    $smarty->assign("DISCOUNT_VALUE", $discount);
    $smarty->assign("TOTAL", $total);
    $smarty->assign("PAYMODE", $paymode);
    $smarty->assign("SETACTIVATE", $setactivate);
    $smarty->assign("CHECKSUM", $checksum);
    $smarty->assign("ACTION_PATH", $ACTION_PATH);
    $smarty->assign("ADDON", $addon);
    $smarty->assign("SER_MAIN", $stp);
    $smarty->assign("DEC_AG", $dec_ag);
    
    if ($checkout) {
        $notype = 0;
        if ($type == 'RS') {
            $Merchant_Id = "DEFAULT_JSATHI";
            $currency = "INR";
        }
        else {
            $notype = 1;
        }
        
        $total = $total;
        $ORDER = newOrder($profileid, $paymode, $type, $total, $service_str, $service_main, $discount, $setactivate, 'ITZ', $discount_type);
        
        if (!$ORDER || $notype == 1) {
            $smarty->assign("CHECKSUM", $checksum);
            $smarty->assign("HEAD", $smarty->fetch("headnew.htm"));
            $smarty->assign("SUBHEADER", $smarty->fetch("subheader.htm"));
            $smarty->assign("TOPLEFT", $smarty->fetch("topleft.htm"));
            $smarty->assign("LEFTPANEL", $smarty->fetch("leftpanelnew.htm"));
            $smarty->assign("FOOT", $smarty->fetch("foot.htm"));
            $smarty->assign("SUBFOOTER", $smarty->fetch("subfooternew.htm"));
            $smarty->display("pg/ordererror_new.htm");
            die;
        }
        
        $service = $ORDER["SERVICE_MAIN"] . "," . $ORDER["ADDON_SERVICE"];
        $service = getServiceName($service);
        $smarty->assign("MERCHANTID", $Merchant_Id);
        
        $amount = ($ORDER["AMOUNT"] * 100);
        $smarty->assign("AMOUNT", $amount);
        $smarty->assign("ORDERID", $ORDER["ORDERID"]);
        
        $smarty->assign("ACTIVE", $ORDER["ACTIVE"]);
        $smarty->assign("SERVICE", $service);
        $smarty->assign("CURRENCY", $currency);
        $smarty->assign("IMAGE_URL", "http://www.jeevansathi.com/profile/imagesnew/Matrimonial.gif");
        $smarty->display("pg/itz_redirect.htm");        
    } 
    else {
        $smarty->assign("CHECKSUM", $checksum);
        $smarty->assign("HEAD", $smarty->fetch("headnew.htm"));
        $smarty->assign("SUBHEADER", $smarty->fetch("subheader.htm"));
        $smarty->assign("TOPLEFT", $smarty->fetch("topleft.htm"));
        $smarty->assign("LEFTPANEL", $smarty->fetch("leftpanelnew.htm"));
        $smarty->assign("FOOT", $smarty->fetch("foot.htm"));
        $smarty->assign("SUBFOOTER", $smarty->fetch("subfooternew.htm"));
        $smarty->display("pg/ordererror_new.htm");        
    }
} 
else {
    TimedOut();
}
?>