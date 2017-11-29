<?php 
  $curFilePath = dirname(__FILE__)."/"; 
 include_once("/usr/local/scripts/DocRoot.php");

ini_set('max_execution_time','0');
ini_set('memory_limit', '256M');
chdir(dirname(__FILE__));
$flag_using_php5=1;
include("config.php");
include("connect.inc");
//include("astro/lock.php");
//$fp=get_lock("swap_jprofile");
include(JsConstants::$docRoot."/commonFiles/comfunc.inc");
$today=date("Y-m-d");
$ts = time();
$ts-=30*24*60*60;
$start_dt=date("Y-m-d",$ts);

include_once($_SERVER['DOCUMENT_ROOT']."/classes/globalVariables.Class.php");
include_once($_SERVER['DOCUMENT_ROOT']."/classes/Mysql.class.php");
include_once($_SERVER['DOCUMENT_ROOT']."/classes/Memcache.class.php");
include_once($_SERVER['DOCUMENT_ROOT']."/profile/connect_functions.inc");
include_once($_SERVER['DOCUMENT_ROOT']."/classes/NEGATIVE_TREATMENT_LIST.class.php");
include_once(JsConstants::$docRoot."/commonFiles/dropdowns.php");
include_once($_SERVER['DOCUMENT_ROOT']."/ivr/jsivrFunctions.php");
include_once($_SERVER['DOCUMENT_ROOT']."/commonFiles/incomeCommonFunctions.inc");
include_once($_SERVER['DOCUMENT_ROOT']."/commonFiles/SymfonyPictureFunctions.inc");
include_once(JsConstants::$docRoot."/commonFiles/sms_inc.php");

if(CommonUtility::hideFeaturesForUptime() && JsConstants::$whichMachine == 'prod')
	successfullDie();
	


$mysqlObj=new Mysql;
//$db2 = connect_slave();
$LOG_PRO=array();

$db=connect_db();
mysql_query("set session wait_timeout=10000",$db);

/*
$sql_err="SELECT MIN(ID) as MIN FROM SWAP_JPROFILE_ERROR";
$res_err=mysql_query($sql_err) or die("e1".mysql_error1($db));
$row_err=mysql_fetch_assoc($res_err);
$min=$row_err['MIN'];

if($min)
{
$min=$min+1000;

$sql_cor="INSERT INTO SWAP_JPROFILE_ERROR_PIDS SELECT * FROM SWAP_JPROFILE";
$res_cor=mysql_query($sql_cor,$db) or die("e2".mysql_error1($db));

$sql_cor="DELETE SWAP_JPROFILE_ERROR.* FROM SWAP_JPROFILE_ERROR,SWAP_JPROFILE_ERROR_PIDS WHERE SWAP_JPROFILE_ERROR.PROFILEID=SWAP_JPROFILE_ERROR_PIDS.PROFILEID";
$res_cor=mysql_query($sql_cor,$db) or die("e2".mysql_error1($db));

$sql_cor="TRUNCATE TABLE SWAP_JPROFILE_ERROR_PIDS";
$res_cor=mysql_query($sql_cor,$db) or die("e2".mysql_error1($db));

$sql_err="SELECT count(*) CNT FROM SWAP_JPROFILE";
$row_err=mysql_query($sql_err,$db) or die("e1".mysql_error1($db));
$row_err=mysql_fetch_assoc($res_err);
$cntr=$row_err['CNT'];
if($cntr<10000)
{

$sql_cor="INSERT IGNORE INTO SWAP_JPROFILE SELECT PROFILEID FROM SWAP_JPROFILE_ERROR WHERE ID <$min";
$res_cor=mysql_query($sql_cor,$db) or die("e2".mysql_error1($db));

$sql_del="DELETE FROM SWAP_JPROFILE_ERROR WHERE ID <$min";
mysql_query($sql_del,$db) or die("e3".mysql_error1($db));
}
}
*/

							
// lock table SWAP_JPROFILE so that the JPROFILE trigger does not insert new records untill the lock is released
$sql="lock tables SWAP_JPROFILE WRITE, SWAP_JPROFILE1 WRITE";
mysql_query($sql,$db) or die("01".mysql_error1($db));

// insert SWAP_JPROFILE records to SWAP_JPROFILE1
$sql="INSERT IGNORE INTO SWAP_JPROFILE1 SELECT * FROM SWAP_JPROFILE";
mysql_query($sql,$db) or die("02".mysql_error1($db));

// empty SWAP_JPROFILE

$sql="DELETE FROM SWAP_JPROFILE";
mysql_query($sql,$db) or die("03".mysql_error1($db));

// release lock
$sql="UNLOCK TABLES";
mysql_query($sql,$db) or die("04".mysql_error1($db));


/** Code block for swap login date only table data transfer starts here**/
// lock table SWAP_JPROFILE_LOGIN_DT so that the JPROFILE trigger does not insert new records untill the lock is released
$sql="lock tables SWAP_JPROFILE_LOGIN_DT WRITE, SWAP_JPROFILE_LOGIN_DT1 WRITE";
mysql_query($sql,$db) or die("01".mysql_error1($db));
// insert SWAP_JPROFILE_LOGIN_DT records to SWAP_JPROFILE_LOGIN_DT1
$sql="INSERT IGNORE INTO SWAP_JPROFILE_LOGIN_DT1 SELECT * FROM SWAP_JPROFILE_LOGIN_DT";
mysql_query($sql,$db) or die("02".mysql_error1($db));
// empty SWAP_JPROFILE_LOGIN_DT
$sql="DELETE FROM SWAP_JPROFILE_LOGIN_DT";
mysql_query($sql,$db) or die("03".mysql_error1($db));
// release lock
$sql="UNLOCK TABLES";
mysql_query($sql,$db) or die("04".mysql_error1($db));
/** Code block for swap login date only table data transfer ends here**/

//This section deletes common entries if exist in SEARCH_MALE and SEARCH_FEMALE
unset($idArr);

$sql = "SELECT A.PROFILEID AS PROFILEID FROM newjs.SEARCH_MALE A,newjs.SEARCH_FEMALE B WHERE A.PROFILEID = B.PROFILEID";
$res=mysql_query($sql,$db) or die("555-1".mysql_error1($db));
while($row=mysql_fetch_array($res))
{
	$idArr[] = $row["PROFILEID"];
}

if($idArr && is_array($idArr))
{
	$sql = "DELETE FROM newjs.SEARCH_MALE WHERE PROFILEID IN (".implode(",",$idArr).")";
	mysql_query($sql,$db) or die("555-2".mysql_error1($db));

	$sql = "DELETE FROM newjs.SEARCH_FEMALE WHERE PROFILEID IN (".implode(",",$idArr).")";
	mysql_query($sql,$db) or die("555-3".mysql_error1($db));

	$sql = "INSERT IGNORE INTO newjs.SWAP_JPROFILE1 VALUES (".implode("),(",$idArr).")";
	mysql_query($sql,$db) or die("555-3".mysql_error1($db));
}
unset($idArr);
//This section ends

$sql="DELETE FROM SWAP_JPROFILE1 WHERE PROFILEID IN (136580,4676516,4676543,4676566,4676712,4676726,4676882,4676898,4676900,4676958,4677049)";
mysql_query($sql,$db) or die("02".mysql_error1($db));

$NEGATIVE_TREATMENT_LIST=new NEGATIVE_TREATMENT_LIST($db);
$parameters['FLAG_VIEWABLE']='N';
$NEGATIVE_TREATMENT_LIST->deleteJoin($parameters,'SWAP_JPROFILE1','PROFILEID');
/*
$sql="DELETE A.* FROM SWAP_JPROFILE1 A , incentive.NEGATIVE_TREATMENT_LIST WHERE A.PROFILEID=B.PROFILEID AND FLAG_VIEWABLE='N'";
*/
for($activeServerId=0;$activeServerId<$noOfActiveServers;$activeServerId++)
{
        $myDbName=getActiveServerName($activeServerId);
        $myDb[$myDbName]=$mysqlObj->connect("$myDbName");
	mysql_query("set session wait_timeout=10000",$myDb[$myDbName]);
        
        $mySlaveDbName           = getActiveServerName($activeServerId, "slave");
        $mySlaveDb[$mySlaveDbName] = $mysqlObj->connect("$mySlaveDbName");
        mysql_query('set session wait_timeout=10000', $mySlaveDb[$mySlaveDbName]);
}
$timeval = time();
$timeval1 = $timeval;

$sql="SELECT LAST_TIME FROM SWAP_LOG ORDER BY ID DESC LIMIT 1";
$res=mysql_query($sql,$db) or die("0".mysql_error1($db));
$row=mysql_fetch_array($res);
$last_time=$row['LAST_TIME'];
$timeval = date("YmdH0000",$last_time);


$sql="truncate table SWAP";

mysql_query($sql,$db) or die("1 ".mysql_error1($db));

//$sql = "UPDATE SWAP_JPROFILE_LOGIN_DT1 a SET SORT_DT = GREATEST(a.SORT_DT,a.LAST_LOGIN_DT,(select SORT_DT FROM SEARCH_SORT_DT as aa where aa.PROFILEID = a.PROFILEID))";
$sql = "UPDATE SWAP_JPROFILE_LOGIN_DT1 A LEFT JOIN SEARCH_SORT_DT B ON A.PROFILEID=B.PROFILEID SET A.SORT_DT = GREATEST(A.SORT_DT,A.LAST_LOGIN_DT,IF(B.SORT_DT IS NULL,'0000-00-00',B.SORT_DT))";
mysql_query($sql,$db) or die("13 ".mysql_error1($db));

$sql="SELECT * FROM SWAP_JPROFILE_LOGIN_DT1";
$res=mysql_query($sql,$db) or die("swap login select fail".mysql_error1($db)); 

$sqlUpdateM="";
$sqlUpdateF="";
while($row=  mysql_fetch_assoc($res))
{ 
        $sqlUpdateM = "UPDATE `SEARCH_MALE` SET `LAST_LOGIN_DT` = '".$row["LAST_LOGIN_DT"]."',`SORT_DT` = '".$row["SORT_DT"]."' WHERE PROFILEID=".$row["PROFILEID"].";";
        $sqlUpdateF = "UPDATE `SEARCH_FEMALE` SET `LAST_LOGIN_DT` = '".$row["LAST_LOGIN_DT"]."',`SORT_DT` = '".$row["SORT_DT"]."' WHERE PROFILEID=".$row["PROFILEID"].";";
        mysql_query($sqlUpdateM,$db) or die("swap login update failed M".mysql_error1($db));
        mysql_query($sqlUpdateF,$db) or die("swap login update failed F".mysql_error1($db));
}
$sql="truncate table SWAP_JPROFILE_LOGIN_DT1";
mysql_query($sql,$db) or die("swap login truncate failed ".mysql_error1($db));

// take the profiles from SWAP_JPROFILE1. This table could contain records older than the previous hour also if the script did not execute properly last time around. This ensures that all updates to JPROFILE are eventually reflected in search tables  even if the script misbehaves.
		
$memcacheObj = JsMemcache::getInstance();
$sql="SELECT PROFILEID FROM SWAP_JPROFILE1";
$res=mysql_query($sql,$db) or die("3 ".mysql_error1($db));
$popular=0;
while($row=mysql_fetch_row($res))
{ 
        $swapFields = array();
        $profileid=$row[0];
        $sqlT="SELECT SCREENING,CITY_RES,INCOME FROM newjs.JPROFILE WHERE PROFILEID='".$profileid."'";
        $resT=mysql_query($sqlT,$db) or die("3 ".mysql_error1($db));
        while($rowT=mysql_fetch_row($resT)){
                $row[1]=$rowT[0];
		$cityRes = $rowT[1];
		$income = $rowT[2];
		if(substr($cityRes,2)=="OT")
			$cityRes = substr($cityRes,0,2)."000";
        }
        $income=getSortByIncome($income);
        $swapFields[] = "INCOME_SORTBY = '".$income."'";
        
        //Photo first check. Verify Date to be updated accordingly in SWAP
        $sqlPhoto = "SELECT MIN(ENTRY_DT) as PHOTO_SCREENED_DT from newjs.PHOTO_FIRST where PROFILEID='".$profileid."'";        
        $resPhoto = mysql_query($sqlPhoto,$db) or die("3 ".mysql_error1($db));
        $rowPhoto = mysql_fetch_row($resPhoto);  
        if($rowPhoto["0"] !="")
            $firstPhotoScreenedDate = $rowPhoto["0"];
        else
            $firstPhotoScreenedDate = '0000-00-00 00:00:00';
        
        $loginDateObj = new MIS_LOGIN_TRACKING_OLDPROFILES("newjs_masterRep");
        $loginDate = $loginDateObj->getData($profileid);
        unset($loginDateObj);
        if($loginDate !="")
                $loginDate = $loginDate["LOGIN_DATE"];
        else
                $loginDate = '0000-00-00 00:00:00';
        
        $voaDateObj = new PROFILE_VOA_TRACKING("newjs_masterRep");
        $voaDate = $voaDateObj->getData($profileid);
        unset($voaDateObj);
        if($voaDate !="")
                $voaDate = $voaDate["CHANGE_DATE"];
        else
                $voaDate = '0000-00-00 00:00:00';

        if($row[0]){
                $sql_insert="INSERT INTO SWAP ( `PROFILEID` , `CASTE` , `MANGLIK` , `MTONGUE` , `MSTATUS` , `OCCUPATION` , `COUNTRY_RES` , `CITY_RES` , `HEIGHT` , `EDU_LEVEL` , `DRINK` , `SMOKE` , `HAVECHILD` , `BTYPE` , `COMPLEXION` , `DIET` , `HANDICAPPED` , `AGE` , `HAVEPHOTO` , `LAST_LOGIN_DT` , `ENTRY_DT` , `INCOME` , `PRIVACY` , `SORT_DT` , `SUBSCRIPTION` , `EDU_LEVEL_NEW` , `RELATION` , `GENDER` , `ACTIVATED` , `SCORE_POINTS` , `FRESHNESS_POINTS` , `TOTAL_POINTS` , `PROFILE_SCORE` , `PHOTODATE` , `PHOTO_DISPLAY` , `NTIMES` , `RELIGION` , `INCOME_SORTBY` , `USERNAME` , `GOTHRA` , `SUBCASTE` , `YOURINFO` , `FAMILYINFO` , `EDUCATION` , `JOB_INFO` , `HOROSCOPE` , `SPEAK_URDU` , `HIJAB_MARRIAGE` , `SAMPRADAY` , `ZARATHUSHTRI` , `AMRITDHARI` , `CUT_HAIR` , `WEAR_TURBAN` , `MATHTHAB` , `WORK_STATUS` , `HIV` , `NATURE_HANDICAP` , `LIVE_PARENTS` , `FEATURE_PROFILE` , `POPULAR` , `EDUCATION_GROUPING` , `OCCUPATION_GROUPING` , `GOING_ABROAD` , `MARRIED_WORKING` , `CASTE_GROUP` , `STATE` , `LINKEDIN` , `ASTRO_DETAILS` , `PHOTOSCREEN` , `FEATURE_PROFILE_SCORE` , `WIFE_WORKING` , `UG_DEGREE` , `PG_DEGREE` , `OTHER_UG_DEGREE`, `OTHER_PG_DEGREE` , `COMPANY_NAME` , `COLLEGE` , `PG_COLLEGE`, `ANCESTRAL_ORIGIN` , `SCHOOL` , `KEYWORDS` , `NAKSHATRA` , `CHECK_PHONE` , `MOD_DT`,VERIFY_ACTIVATED_DT, `KNOWN_COLLEGE`) SELECT J.PROFILEID , CASTE , MANGLIK , MTONGUE , MSTATUS , OCCUPATION , COUNTRY_RES ,'$cityRes' , HEIGHT , EDU_LEVEL, DRINK , SMOKE , HAVECHILD , BTYPE , COMPLEXION , DIET , HANDICAPPED , AGE , HAVEPHOTO, LAST_LOGIN_DT, J.ENTRY_DT, INCOME, PRIVACY, SORT_DT, SUBSCRIPTION, EDU_LEVEL_NEW,RELATION,J.GENDER,ACTIVATED,'','','','',PHOTODATE,PHOTO_DISPLAY,'',RELIGION,'',USERNAME,GOTHRA,SUBCASTE,YOURINFO,FAMILYINFO,EDUCATION,JOB_INFO,IF(A.PROFILEID IS NOT NULL OR H.PROFILEID IS NOT NULL,IF(J.SHOW_HOROSCOPE='Y','Y','N'),'N'),SPEAK_URDU,'','','','','','','',WORK_STATUS,HIV,NATURE_HANDICAP,if(J.GENDER='M', PARENT_CITY_SAME,''),IF(SUBSCRIPTION LIKE '%R%' OR SUBSCRIPTION LIKE '%J%',1,0),'$popular',IF(E.GROUPING,E.GROUPING,10),IF(O.GROUPING,O.GROUPING,11),GOING_ABROAD,MARRIED_WORKING,'',IF(COUNTRY_RES=51,SUBSTR(CITY_RES,1,2),''),IF(JC.SHOWLINKEDIN='Y' AND JC.LINKEDIN_URL IS NOT NULL AND JC.LINKEDIN_URL!='','Y','N'),IF(A.PROFILEID IS NULL,'N',CONCAT(A.LAGNA_DEGREES_FULL,':',A.SUN_DEGREES_FULL,':',A.MOON_DEGREES_FULL,':',A.MARS_DEGREES_FULL,':',A.MERCURY_DEGREES_FULL,':',A.JUPITER_DEGREES_FULL,':',A.VENUS_DEGREES_FULL,':',A.SATURN_DEGREES_FULL)),J.PHOTOSCREEN,IF(F.SCORE,F.SCORE,0),IF(J.GENDER='M',J.WIFE_WORKING,''),IF(JE.UG_DEGREE,JE.UG_DEGREE,0),IF(JE.PG_DEGREE,JE.PG_DEGREE,0),";
                if(Flag::isFlagSet("other_ug_degree", $row[1]))
                        $sql_insert.="SUBSTRING(JE.OTHER_UG_DEGREE,1,30),";
                else
                        $sql_insert.="'',";
                if(Flag::isFlagSet("other_pg_degree", $row[1]))
                        $sql_insert.="SUBSTRING(JE.OTHER_PG_DEGREE,1,30),";
                else
                        $sql_insert.="'',";
                
                if(Flag::isFlagSet("company_name", $row[1]))
                        $sql_insert.="J.COMPANY_NAME,";
                else
                        $sql_insert.="'',";
                
                if(Flag::isFlagSet("college", $row[1]))
                        $sql_insert.="JE.COLLEGE,";
                else
                        $sql_insert.="'',";
                
                if(Flag::isFlagSet("pg_college", $row[1]))
                        $sql_insert.="JE.PG_COLLEGE,";
                else
                        $sql_insert.="'',";
                
                if(Flag::isFlagSet("ancestral_origin", $row[1]))
                        $sql_insert.="ANCESTRAL_ORIGIN,";
                else
                        $sql_insert.="'',";
                
                $sql_insert.="JE.SCHOOL,J.KEYWORDS,J.NAKSHATRA,'',J.MOD_DT,GREATEST(IF(J.VERIFY_ACTIVATED_DT!= '0000-00-00 00:00:00',J.VERIFY_ACTIVATED_DT,J.ENTRY_DT),'".$firstPhotoScreenedDate."','".$loginDate."','".$voaDate."') AS VERIFY_ACTIVATED_DT,IF(W.TAGS,GROUP_CONCAT(W.TAGS),'000') AS KNOWN_COLLEGE FROM (((((((JPROFILE J LEFT JOIN EDUCATION_LEVEL_NEW E ON J.EDU_LEVEL_NEW=E.VALUE) LEFT JOIN OCCUPATION O ON J.OCCUPATION = O.VALUE) LEFT JOIN JPROFILE_CONTACT JC ON JC.PROFILEID = J.PROFILEID) LEFT JOIN ASTRO_DETAILS A ON J.PROFILEID = A.PROFILEID) LEFT JOIN HOROSCOPE H ON J.PROFILEID = H.PROFILEID) LEFT JOIN FEATURED_PROFILE_LIST F ON J.PROFILEID = F.PROFILEID) LEFT JOIN JPROFILE_EDUCATION JE ON J.PROFILEID=JE.PROFILEID) LEFT JOIN WELL_KNOWN_COLLEGE W ON (W.COLLEGE_NAME = JE.COLLEGE || W.COLLEGE_NAME = JE.PG_COLLEGE) WHERE J.PROFILEID=$profileid";                                
                mysql_query($sql_insert,$db) or die("3 1".mysql_error1($db));
                
                $sqlEduGrouping = "SELECT group_concat(DISTINCT(GROUPING)) AS GROUPING FROM SWAP J JOIN EDUCATION_LEVEL_NEW E WHERE J.PROFILEID =".$profileid." AND (J.EDU_LEVEL_NEW = E.VALUE OR J.PG_DEGREE = E.VALUE OR J.UG_DEGREE = E.VALUE ) ";
                $eduGrouping = mysql_query($sqlEduGrouping, $db) or die("edu query".mysql_error1($db));
                 
                while($roweduGroup=mysql_fetch_row($eduGrouping)){
                        $swapFields[] = "EDUCATION_GROUPING = '".$roweduGroup[0]."'";
                }
		/** Esha Jain**/
		if(Flag::isFlagSet("name_of_user", $row[1]))
		{
                        $nameOfUserObj = new NameOfUser();
                        $nameData = $nameOfUserObj->getNameData($profileid);
                        unset($nameOfUserObj);
                        if(!empty($nameData) && $nameData != "" && isset($nameData[$profileid]) && $nameData[$profileid]['DISPLAY']=="Y"){
                                $swapFields[] = "NAME_OF_USER = '".mysql_real_escape_string($nameData[$profileid]['NAME'])."'";
                        }
		}
		/** Esha Jain**/
		
		/*
                $myDbName = getProfileDatabaseConnectionName($profileid, 'slave', $mysqlObj);
                
                $sqlLoginDateTime = "SELECT PROFILEID,TIME as last_login_time FROM LOG_LOGIN_HISTORY WHERE PROFILEID =" . $profileid . " ORDER BY TIME DESC LIMIT 1"; 
                
                $lastLoginTime = mysql_query($sqlLoginDateTime, $mySlaveDb[$myDbName]) or die("3 6".mysql_error1($mySlaveDb[$myDbName]));
               
                while($rowDateTime=mysql_fetch_row($lastLoginTime)){
                  $sqlUpdate = "UPDATE `SWAP` SET `LAST_LOGIN_DT` = '".$rowDateTime[1]."' WHERE PROFILEID=$profileid";
                  mysql_query($sqlUpdate,$db) or die("3 5".mysql_error1($db));
                } 
		*/
        }
        /**
         * Verification Seal creation
         */
       
        $verificationSealObj=new VerificationSealLib(array($profileid),1);
        $verificationSealObj->codeVerificationSeal();
        unset($verificationSealObj);
        
        // END Verification Seal
        $sqlNativePlace = "SELECT NATIVE_STATE,NATIVE_CITY FROM newjs.NATIVE_PLACE WHERE PROFILEID=$profileid";
        $dataNativePlace = mysql_query($sqlNativePlace,$db) or die("error in data from NATIVE_PLACE".mysql_error1($db));
        $nativePlace    =mysql_fetch_array($dataNativePlace);
        if(!empty($nativePlace)){
                
                if(($nativePlace["NATIVE_CITY"] == "" || is_null($nativePlace["NATIVE_CITY"]) || $nativePlace["NATIVE_CITY"] == '0') && $nativePlace["NATIVE_STATE"] != ''){
                        $nativePlace["NATIVE_CITY"] = $nativePlace["NATIVE_STATE"]."000";
                }elseif($nativePlace["NATIVE_STATE"] == '' || $nativePlace["NATIVE_STATE"] == "0"){
                        $nativePlace["NATIVE_CITY"] = '';
                }
                $swapFields[] = "NATIVE_STATE = '".$nativePlace["NATIVE_STATE"]."'";
                $swapFields[] = "NATIVE_CITY = '".$nativePlace["NATIVE_CITY"]."'";
        }
        
        // Paid user check
        $dataIsPaid    = $memcacheObj->get("FreeToP_$profileid");
        if($dataIsPaid !== false && $dataIsPaid != ''){
                $swapFields[] = "PAID_ON = '".$dataIsPaid."'";
        }
        
        $memberShipObj = new MembershipHandler();
        $IsPaid    = $memberShipObj->getPurchaseDate($profileid);
        unset($memberShipObj);
        
        if($IsPaid['PURCHASE_DATE'] !== false && $IsPaid['PURCHASE_DATE'] != '' && !empty($IsPaid['PURCHASE_DATE'])){
                $swapFields[] = "PAID_DATE = '".$IsPaid['PURCHASE_DATE']."'";
        }
        // Paid user check end
        
        $sql_caste = "SELECT J.CASTE AS CASTE,J.SHOWPHONE_MOB AS SHOWPHONE_MOB,J.SHOWPHONE_RES AS SHOWPHONE_RES,J.PHONE_FLAG AS PHONE_FLAG,J.MOB_STATUS AS MOB_STATUS,J.LANDL_STATUS AS LANDL_STATUS,J.PHONE_MOB AS PHONE_MOB,J.PHONE_RES AS PHONE_RES,J.STD AS STD,JC.SHOWALT_MOBILE AS SHOWALT_MOBILE,JC.ALT_MOBILE AS ALT_MOBILE,JC.ALT_MOB_STATUS AS ALT_MOB_STATUS FROM newjs.JPROFILE J LEFT JOIN newjs.JPROFILE_CONTACT JC ON J.PROFILEID = JC.PROFILEID WHERE J.PROFILEID = ".$profileid;
	$result_caste = mysql_query($sql_caste,$db) or die("3-2".mysql_error1($db));
	$row_caste=mysql_fetch_array($result_caste);
	$caste = getGroupNames($row_caste["CASTE"]);
		
	$check_phone = getPhoneStatusForSearch($row_caste,$profileid,$db);

	if($caste || $check_phone)
	{
                $swapFields[] = "CASTE_GROUP = \"".$caste."\",CHECK_PHONE = \"".$check_phone."\" ";
	}
        
        if(!empty($swapFields)){
                $sql_swapUpdate = "UPDATE newjs.SWAP SET ".implode(", ",$swapFields)." WHERE PROFILEID=".$profileid;
                mysql_query($sql_swapUpdate,$db) or die("error in updating newjs.SWAP for multiple fields".mysql_error1($db));
        }
	//start: added by prinka to update column newjs.SWAP.NTIMES 
	$sql_ntimes="UPDATE SWAP S, JP_NTIMES JP SET S.NTIMES=JP.NTIMES WHERE S.PROFILEID=$profileid AND JP.PROFILEID=S.PROFILEID";
	mysql_query($sql_ntimes,$db) or die("error in updating newjs.SWAP.NTIMES from newjs.JP_NTIMES.NTIMES".mysql_error1($db));
	//end: added by prinka to update column newjs.SWAP.NTIMES 
        unset($swapFields);
}

$sql_search = "SELECT PROFILEID AS PROFILEID,GENDER FROM newjs.SWAP WHERE (CHECK_PHONE IN ('I','K','P','N') AND DATE(ENTRY_DT)>='".DateConstants::PhoneMandatoryLive."') or (ACTIVATED <>'Y' or PRIVACY='C')";
$result = mysql_query($sql_search,$db) or die("error in select of SWAP for delete on SEARCH_MALE".mysql_error1($db));

$maleProfiles = array();
$femaleProfiles = array();
while($myrow=mysql_fetch_array($result))
{
	if($myrow["GENDER"] == "M"){
		$maleProfiles[] = $myrow["PROFILEID"];
	}else{
		$femaleProfiles[] = $myrow["PROFILEID"];
	}
}
/*optimiztaion 2*/
mysql_free_result($result);
if($maleProfiles && is_array($maleProfiles))
{
	$deletePidArrStr=implode(",",$maleProfiles);
	unset($maleProfiles);
	$sql = "delete from SEARCH_MALE where PROFILEID IN ($deletePidArrStr)";
	mysql_query($sql,$db) or die("5 M".mysql_error1($db));

	$sql = "delete from SEARCH_MALE_TEXT where PROFILEID IN ($deletePidArrStr)";
	mysql_query($sql,$db) or die("22 M".mysql_error1($db));

	$sql = "delete from SEARCH_MALE_REV where PROFILEID IN ($deletePidArrStr)";
	mysql_query($sql,$db) or die("22 M".mysql_error1($db));

	$sql = "delete from SWAP where PROFILEID IN ($deletePidArrStr)";
	mysql_query($sql,$db) or die("22 M".mysql_error1($db));
}
if($femaleProfiles && is_array($femaleProfiles))
{
        $deletePidArrStr=implode(",",$femaleProfiles);
        unset($femaleProfiles);
	$sql = "delete from SEARCH_FEMALE where PROFILEID IN ($deletePidArrStr)";
	mysql_query($sql,$db) or die("5 F".mysql_error1($db));

	$sql = "delete from SEARCH_FEMALE_TEXT where PROFILEID IN ($deletePidArrStr)";
	mysql_query($sql,$db) or die("22 F".mysql_error1($db));

	$sql = "delete from SEARCH_FEMALE_REV where PROFILEID IN ($deletePidArrStr)";
	mysql_query($sql,$db) or die("22 F".mysql_error1($db));

	$sql = "delete from SWAP where PROFILEID IN ($deletePidArrStr)";
	mysql_query($sql,$db) or die("22 F".mysql_error1($db));
}
unset($delArr);

$sql="delete from SWAP where (ACTIVATED <>'Y' or PRIVACY='C' or LAST_LOGIN_DT < DATE_SUB(CURDATE(), INTERVAL 2 MONTH))";
mysql_query($sql,$db) or die("8 ".mysql_error1($db));

//UPDATE POPULAR SCORE
$sql_ntimes="UPDATE SWAP SET POPULAR=NTIMES/(POW((DATEDIFF(NOW(),ENTRY_DT)),.75))";
mysql_query($sql_ntimes,$db) or die("error in updating newjs.SWAP.NTIMES from newjs.JP_NTIMES.NTIMES".mysql_error1($db));

mysql_free_result($res);
/*
$sql = "SELECT count(*) AS C FROM SWAP";
$res = mysql_query($sql,$db) or die("count ".mysql_error1($db));
$row = mysql_fetch_array($res);
$totalEntry = $row["C"];

$sql = "SELECT PROFILEID FROM SWAP WHERE INCOME = '0' OR OCCUPATION = '0' OR EDU_LEVEL_NEW = '0' OR RELIGION = '' OR HEIGHT = '0' OR COUNTRY_RES = '0' OR MSTATUS = '' OR RELATION = '' OR MTONGUE = '0' OR CASTE = '0'";
$res = mysql_query($sql,$db) or die("count ".mysql_error1($db));
while($row = mysql_fetch_array($res))
{
        $delProfileIdArr[] = $row["PROFILEID"];
}
if($delProfileIdArr && is_array($delProfileIdArr))
{
$delEntry = count($delProfileIdArr);
if($delEntry)
{
        mail("lavesh.rawat@gmail.com,vidushi.engg@gmail.com","records deleted from SWAP","Deleted Count = ".$delEntry."----- Total Count = ".$totalEntry." -------- DELETED PROFILEID = ".implode(",",$delProfileIdArr));
}
}
unset($totalEntry);
unset($delEntry);
unset($delProfileIdArr);
*/

$sql_new="DELETE FROM SWAP WHERE INCOME = '0' OR OCCUPATION = '0' OR EDU_LEVEL_NEW = '0' OR RELIGION = '' OR HEIGHT = '0' OR COUNTRY_RES = '0' OR MSTATUS = '' OR RELATION = '' OR MTONGUE = '0' OR CASTE = '0'";
mysql_query($sql_new,$db) or die("16 ".mysql_error1($db));

$sql = "SELECT count(*) AS C FROM SWAP";
$res = mysql_query($sql,$db) or die("count ".mysql_error1($db));
$row = mysql_fetch_array($res);
if($row["C"]>30000)
{
	mail("lavesh.rawat@jeevansathi.com,kumar.anand@jeevansathi.com","More than 30000 records in SWAP","More than 30000 records in SWAP -> swap_jprofile.php");	
}

for($activeServerId=0;$activeServerId<$noOfActiveServers;$activeServerId++)
{
        $myDbName=getActiveServerName($activeServerId);

	$tableArr = array("SEARCH_MALE_REV","SEARCH_FEMALE_REV");

	foreach($tableArr as $k=>$v)
	{
		if($v=="SEARCH_MALE_REV")
			$gender = 'M';
		else
			$gender = 'F';

		$sql = "SELECT S1.PROFILEID AS PROFILEID FROM newjs.SWAP S1 LEFT JOIN newjs.".$v." S2 ON S1.PROFILEID = S2.PROFILEID WHERE S1.PROFILEID%3=".$activeServerId." AND S2.PROFILEID IS NULL AND S1.GENDER = '".$gender."'";
		$res = mysql_query($sql,$db) or die("13-".$activeServerId."-".$v." ".mysql_error1($db));
		while($row=mysql_fetch_array($res))
		{
			$idArr[] = $row["PROFILEID"];
		}
		if($idArr && is_array($idArr) && count($idArr))
		{
			$sql = "INSERT IGNORE INTO newjs.SWAP_JPARTNER(PROFILEID) VALUES (".implode("),(",$idArr).")";
			mysql_query($sql,$myDb[$myDbName]) or die("13 ".$activeServerId."-".$v."- SWAP_JPARTNER ".mysql_error1($myDb[$myDbName]));
		}
        	unset($idArr);
	}
}
        //$sql = "UPDATE SWAP a SET SORT_DT = GREATEST(a.SORT_DT,a.LAST_LOGIN_DT,(select SORT_DT FROM SEARCH_SORT_DT as aa where aa.PROFILEID = a.PROFILEID))";
        $sql = "UPDATE SWAP A LEFT JOIN SEARCH_SORT_DT B ON A.PROFILEID=B.PROFILEID SET A.SORT_DT = GREATEST(A.SORT_DT,A.LAST_LOGIN_DT,IF(B.SORT_DT IS NULL,'0000-00-00',B.SORT_DT))";
        mysql_query($sql,$db) or die("13 ".mysql_error1($db));

	 $sql = "REPLACE INTO SEARCH_MALE (PROFILEID , CASTE , MANGLIK , MTONGUE , MSTATUS , OCCUPATION , COUNTRY_RES , CITY_RES , HEIGHT , EDU_LEVEL , DRINK , SMOKE , HAVECHILD , BTYPE , COMPLEXION , DIET , HANDICAPPED , AGE , HAVEPHOTO, LAST_LOGIN_DT, ENTRY_DT, INCOME, PRIVACY, SORT_DT, SUBSCRIPTION, EDU_LEVEL_NEW, RELATION ,SCORE_POINTS,FRESHNESS_POINTS,TOTAL_POINTS,PROFILE_SCORE,PHOTO_DISPLAY,NTIMES,RELIGION,INCOME_SORTBY,FEATURE_PROFILE,POPULAR,EDUCATION_GROUPING,OCCUPATION_GROUPING,GOING_ABROAD,MARRIED_WORKING,CASTE_GROUP,STATE,LINKEDIN,ASTRO_DETAILS,PHOTOSCREEN,FEATURE_PROFILE_SCORE,WIFE_WORKING,UG_DEGREE,PG_DEGREE,OTHER_UG_DEGREE,OTHER_PG_DEGREE,CHECK_PHONE,MOD_DT,PHOTODATE,VERIFY_ACTIVATED_DT,VERIFICATION_SEAL,NATIVE_STATE,NATIVE_CITY,PAID_ON,KNOWN_COLLEGE,PAID_DATE) SELECT PROFILEID , CASTE , MANGLIK , MTONGUE , MSTATUS , OCCUPATION , COUNTRY_RES , CITY_RES , HEIGHT , EDU_LEVEL , DRINK , SMOKE , HAVECHILD , BTYPE , COMPLEXION , DIET , HANDICAPPED , AGE , HAVEPHOTO, LAST_LOGIN_DT, ENTRY_DT, INCOME, PRIVACY, SORT_DT, SUBSCRIPTION, EDU_LEVEL_NEW, RELATION,SCORE_POINTS,FRESHNESS_POINTS,TOTAL_POINTS,PROFILE_SCORE,PHOTO_DISPLAY,NTIMES,RELIGION,INCOME_SORTBY,FEATURE_PROFILE,POPULAR,EDUCATION_GROUPING,OCCUPATION_GROUPING,GOING_ABROAD,MARRIED_WORKING,CASTE_GROUP,STATE,LINKEDIN,ASTRO_DETAILS,PHOTOSCREEN,FEATURE_PROFILE_SCORE,WIFE_WORKING,UG_DEGREE,PG_DEGREE,OTHER_UG_DEGREE,OTHER_PG_DEGREE,CHECK_PHONE,MOD_DT,PHOTODATE,VERIFY_ACTIVATED_DT,VERIFICATION_SEAL,NATIVE_STATE,NATIVE_CITY,PAID_ON,KNOWN_COLLEGE,PAID_DATE from SWAP WHERE GENDER='M'";
	mysql_query($sql,$db) or die("13 ".mysql_error1($db));

        $sqlSelect="SELECT PROFILEID from SWAP where GENDER='M'";
        $resultSelect = mysql_query($sqlSelect,$db) or die("Select Fail ".mysql_error1($db));
        while($rowSelect = mysql_fetch_assoc($resultSelect)){
                $sql = "REPLACE INTO SEARCH_MALE_TEXT (PROFILEID , USERNAME, GOTHRA, SUBCASTE, YOURINFO, FAMILYINFO, EDUCATION, JOB_INFO, ANCESTRAL_ORIGIN, HOROSCOPE, SPEAK_URDU, HIJAB_MARRIAGE, SAMPRADAY, ZARATHUSHTRI, AMRITDHARI, CUT_HAIR, WEAR_TURBAN, MATHTHAB, WORK_STATUS, HIV, NATURE_HANDICAP, LIVE_PARENTS,COMPANY_NAME,COLLEGE,PG_COLLEGE,SCHOOL,KEYWORDS,NAKSHATRA,NAME_OF_USER) SELECT PROFILEID , USERNAME, GOTHRA, SUBCASTE, YOURINFO, FAMILYINFO, EDUCATION, JOB_INFO, ANCESTRAL_ORIGIN, HOROSCOPE, SPEAK_URDU, HIJAB_MARRIAGE, SAMPRADAY, ZARATHUSHTRI, AMRITDHARI, CUT_HAIR, WEAR_TURBAN, MATHTHAB, WORK_STATUS, HIV, NATURE_HANDICAP, LIVE_PARENTS,COMPANY_NAME,COLLEGE,PG_COLLEGE,SCHOOL,KEYWORDS,NAKSHATRA,NAME_OF_USER from SWAP where GENDER='M' AND PROFILEID='".$rowSelect['PROFILEID']."'";
                mysql_query($sql,$db) or die("20 ".mysql_error1($db));
        }

	$sql = "REPLACE INTO SEARCH_FEMALE (PROFILEID , CASTE , MANGLIK , MTONGUE , MSTATUS , OCCUPATION , COUNTRY_RES , CITY_RES , HEIGHT , EDU_LEVEL , DRINK , SMOKE , HAVECHILD , BTYPE , COMPLEXION , DIET , HANDICAPPED , AGE , HAVEPHOTO, LAST_LOGIN_DT, ENTRY_DT, INCOME, PRIVACY, SORT_DT, SUBSCRIPTION, EDU_LEVEL_NEW, RELATION,SCORE_POINTS,FRESHNESS_POINTS,TOTAL_POINTS,PROFILE_SCORE,PHOTO_DISPLAY, NTIMES,RELIGION,INCOME_SORTBY,FEATURE_PROFILE,POPULAR,EDUCATION_GROUPING,OCCUPATION_GROUPING,GOING_ABROAD,MARRIED_WORKING,CASTE_GROUP,STATE,LINKEDIN,ASTRO_DETAILS,PHOTOSCREEN,FEATURE_PROFILE_SCORE,UG_DEGREE,PG_DEGREE,OTHER_UG_DEGREE,OTHER_PG_DEGREE,CHECK_PHONE,MOD_DT,PHOTODATE,VERIFY_ACTIVATED_DT,VERIFICATION_SEAL,NATIVE_STATE,NATIVE_CITY,PAID_ON,PAID_DATE,KNOWN_COLLEGE) SELECT PROFILEID , CASTE , MANGLIK , MTONGUE , MSTATUS , OCCUPATION , COUNTRY_RES , CITY_RES , HEIGHT , EDU_LEVEL , DRINK , SMOKE , HAVECHILD , BTYPE , COMPLEXION , DIET , HANDICAPPED , AGE , HAVEPHOTO, LAST_LOGIN_DT, ENTRY_DT, INCOME, PRIVACY, SORT_DT, SUBSCRIPTION, EDU_LEVEL_NEW, RELATION,SCORE_POINTS,FRESHNESS_POINTS,TOTAL_POINTS,PROFILE_SCORE,PHOTO_DISPLAY, NTIMES,RELIGION,INCOME_SORTBY,FEATURE_PROFILE,POPULAR,EDUCATION_GROUPING,OCCUPATION_GROUPING,GOING_ABROAD,MARRIED_WORKING,CASTE_GROUP,STATE,LINKEDIN,ASTRO_DETAILS,PHOTOSCREEN,FEATURE_PROFILE_SCORE,UG_DEGREE,PG_DEGREE,OTHER_UG_DEGREE,OTHER_PG_DEGREE,CHECK_PHONE,MOD_DT,PHOTODATE,VERIFY_ACTIVATED_DT,VERIFICATION_SEAL,NATIVE_STATE,NATIVE_CITY,PAID_ON,PAID_DATE,KNOWN_COLLEGE from SWAP where GENDER='F'";
        mysql_query($sql,$db) or die("15 ".mysql_error1($db));

	$sqlSelect="SELECT PROFILEID from SWAP where GENDER='F'";
        $resultSelect = mysql_query($sqlSelect,$db) or die("Select Fail ".mysql_error1($db));
        while($rowSelect = mysql_fetch_assoc($resultSelect)){
                $sql = "REPLACE INTO SEARCH_FEMALE_TEXT (PROFILEID , USERNAME, GOTHRA, SUBCASTE, YOURINFO, FAMILYINFO, EDUCATION, JOB_INFO, ANCESTRAL_ORIGIN, HOROSCOPE, SPEAK_URDU, HIJAB_MARRIAGE, SAMPRADAY, ZARATHUSHTRI, AMRITDHARI, CUT_HAIR, MATHTHAB, WORK_STATUS, HIV, NATURE_HANDICAP,COMPANY_NAME,COLLEGE,PG_COLLEGE,SCHOOL,KEYWORDS,NAKSHATRA,NAME_OF_USER) SELECT PROFILEID , USERNAME, GOTHRA, SUBCASTE, YOURINFO, FAMILYINFO, EDUCATION, JOB_INFO, ANCESTRAL_ORIGIN, HOROSCOPE, SPEAK_URDU, HIJAB_MARRIAGE, SAMPRADAY, ZARATHUSHTRI, AMRITDHARI, CUT_HAIR, MATHTHAB, WORK_STATUS, HIV, NATURE_HANDICAP,COMPANY_NAME,COLLEGE,PG_COLLEGE,SCHOOL,KEYWORDS,NAKSHATRA,NAME_OF_USER from SWAP where GENDER='F' AND PROFILEID='".$rowSelect['PROFILEID']."'";
                mysql_query($sql,$db) or die("1999999999 ".mysql_error1($db));
        }
//This section sends entries to newjs.PICTURE_FOR_SCREEN_LEGACY table
$app_screen_module_live_dt = "2014-01-30 00:00:00";
$sql = "INSERT INTO newjs.PICTURE_FOR_SCREEN_APP_LEGACY(PROFILEID,LAST_LOGIN_DT,STATUS) SELECT S.PROFILEID AS PROFILEID,S.LAST_LOGIN_DT AS LAST_LOGIN_DT,'N' FROM newjs.SWAP S WHERE S.ENTRY_DT <='".$app_screen_module_live_dt."' AND S.HAVEPHOTO = 'Y' AND S.PHOTOSCREEN = 1 ON DUPLICATE KEY UPDATE newjs.PICTURE_FOR_SCREEN_APP_LEGACY.LAST_LOGIN_DT = IF(newjs.PICTURE_FOR_SCREEN_APP_LEGACY.STATUS='N',NOW(),newjs.PICTURE_FOR_SCREEN_APP_LEGACY.LAST_LOGIN_DT)";
mysql_query($sql,$db) or die("171".mysql_error1($db));
//This section ends

$sql="truncate table SWAP";
mysql_query($sql,$db) or die("16 ".mysql_error1($db));

$sql="INSERT INTO SWAP_LOG (LAST_TIME) VALUES('$timeval1')";
mysql_query($sql,$db) or die("17".mysql_error1($db));

// script has executed successfully. Truncate table SWAP_JPROFILE1
$sql="truncate table SWAP_JPROFILE1";
mysql_query($sql,$db) or die("18".mysql_error1($db));

//release_lock($fp);

function mysql_error1($db)
{
	global $sql_update,$sql,$sql_total_points;
	$msg=$sql_update .":".$sql.":".$sql_total_points;
	mail("lavesh.rawat@jeevansathi.com,kumar.anand@jeevansathi.com,lavesh.rawat@gmail.com,bhavanakadwal@gmail.com","Jeevansathi Error in swapping",$msg);
	mail("lavesh.rawat@jeevansathi.com,kumar.anand@jeevansathi.com,lavesh.rawat@gmail.com,bhavanakadwal@gmail.com","Jeevansathi Error in swapping",mysql_error($db));
        $date = date("Y-m-d h");
        $message        = "Mysql Error Count have reached swap jpartner $date within 5 minutes";
        $from           = "JSSRVR";
        $profileid      = "144111";
        $mobile         = "9773889617";
        $smsState = send_sms($message,$from,$mobile,$profileid,'','Y');
        CommonUtility::logTechAlertSms($message, $mobile);
        $mobile         = "9818424749";
        $smsState = send_sms($message,$from,$mobile,$profileid,'','Y');
        CommonUtility::logTechAlertSms($message, $mobile);
        $mobile         = "9873639543";
	$smsState = send_sms($message,$from,$mobile,$profileid,'','Y');
    CommonUtility::logTechAlertSms($message, $mobile);
}

function DayDiff($StartDate, $StopDate)
{
   // converting the dates to epoch and dividing the difference
   // to the approriate days using 86400 seconds for a day
   //
   return (date('U', strtotime($StopDate)) - date('U', strtotime($StartDate))) / 86400; //seconds a day
}

function update_score($pid)
{
	global $start_dt;
	global $myDb;
	global $db;
	global $entry_dt;
	global $mysqlObj;

	$sql_pid = "SELECT  AGE , YOURINFO , FAMILYINFO , SPOUSE , JOB_INFO , SIBLING_INFO  , FATHER_INFO , HAVEPHOTO , RELATION , LAST_LOGIN_DT  , CITY_RES, SOURCE , HAVEPHOTO,GENDER FROM newjs.JPROFILE WHERE PROFILEID ='$pid'";
												     
	$res_pid = mysql_query($sql_pid,$db) or logError($sql_pid);
												     
	if ($row_pid = mysql_fetch_array($res_pid))
	{
		$source=$row_pid['SOURCE'];
												     
		// query to find the first date in an interval of 30 days when the user logged in
		$myDbName=getProfileDatabaseConnectionName($pid);

		if(!$myDb[$myDbName])
                                $myDb[$myDbName]=$mysqlObj->connect("$myDbName");

		$sql_login_cnt = "SELECT COUNT(*) AS CNT FROM newjs.LOGIN_HISTORY WHERE PROFILEID = '$pid' AND LOGIN_DT >= '$start_dt'";
		$res_login_cnt = mysql_query($sql_login_cnt,$myDb[$myDbName]) or logError($sql_login_cnt);
												     
		while($row_login_cnt = mysql_fetch_array($res_login_cnt))
		{
			$login_cnt = $row_login_cnt['CNT'];
		}
												     
		//Sharding On Contacts done by Lavesh Rawat
		$contactResult=getResultSet("COUNT(*) AS CNT4",$pid,"","","","","","TIME >= '$start_dt'","","","","","");
                $row4["CNT4"]=$contactResult[0]['CNT4'];
		unset($contactResult);
		/*
		$sql_init_cnt ="SELECT COUNT(*) AS CNT4 FROM newjs.CONTACTS WHERE SENDER = '$pid' AND TIME >= '$start_dt'";
		$res4 = mysql_query($sql_init_cnt,$db) or logError($sql_init_cnt);
		$row4 = mysql_fetch_array($res4);
		*/
		$INITIATE_CNT= $row4['CNT4'];
		$contactResult=getResultSet("COUNT(*) AS CNT","","",$pid,"","'A'","","TIME >= '$start_dt'","","","","","");
		$myrow["CNT4"]=$contactResult[0]['CNT'];
		unset($contactResult);
		/*
		$sql_accpt_cnt="SELECT COUNT(*) AS CNT FROM newjs.CONTACTS  WHERE RECEIVER='$pid' and TYPE='A' AND TIME >= '$start_dt'";
		$result=mysql_query($sql_accpt_cnt,$db) or logError($sql_accpt_cnt);
		$myrow=mysql_fetch_array($result);
		*/
		//Sharding On Contacts done by Lavesh Rawat
												     
		$ACCEPTANCE_MADE = $myrow["CNT"];
		
		$contact_cnt = $INITIATE_CNT + $ACCEPTANCE_MADE;
		$PROFILELENGTH = strlen($row_pid['YOURINFO']) + strlen($row_pid['FAMILYINFO']) + strlen($row_pid['SPOUSE']) + strlen($row_pid['FATHER_INFO']) + strlen($row_pid['SIBLING_INFO']) + strlen($row_pid['JOB_INFO']);
		
	$score = calc_user_score_search($row_pid['AGE'],$row_pid['GENDER'],$PROFILELENGTH , $row_pid['HAVEPHOTO'], $row_pid['RELATION'],$entry_dt,$login_cnt,$contact_cnt);
		return $score;
	}
}

function getGroupNames($caste)
{
        global $CASTE_GROUP_ARRAY;
        foreach($CASTE_GROUP_ARRAY as $k=>$v)
        {
                $casteArr = explode(",",$v);
                foreach($casteArr as $kk=>$vv)
                {
                        if($vv == $caste || $k == $caste)
                        {
                                $casteGrp[] = $k;
                                break;
                        }
                }
        }
        if($casteGrp)
                return implode(",",$casteGrp);
        else
                return 0;
}

function getPhoneStatusForSearch($row1,$profileid,$db)
{
	$flagPhone = 0;
	$phoneArr["PROFILEID"] = $profileid;
	$phoneArr["PHONE_FLAG"] = $row1["PHONE_FLAG"];
	$phoneArr["MOB_STATUS"] = $row1["MOB_STATUS"];
	$phoneArr["LANDL_STATUS"] = $row1["LANDL_STATUS"];
	$phoneArr["PHONE_MOB"] = $row1["PHONE_MOB"];
	$phoneArr["PHONE_RES"] = $row1["PHONE_RES"];
	$phoneArr["ALT_MOBILE"] = $row1["ALT_MOBILE"];
	$phoneArr["ALT_MOB_STATUS"] = $row1["ALT_MOB_STATUS"];

	foreach($phoneArr as $kk=>$vv)
	{
		if(!$vv)
			$phoneArr[$kk]="";
	}

	if($row1["PHONE_MOB"])
	{
		if($row1["SHOWPHONE_MOB"]=="N")
			$mobile_hidden = 1;
		else
			$mobile_hidden = 0;
	}
	else
		$mobile_hidden = 1;
	if($row1["PHONE_RES"])
	{
		if($row1["SHOWPHONE_RES"]=="N")
			$landline_hidden = 1;
		else
			$landline_hidden = 0;
	}
	else
		$landline_hidden = 1;
	if($row1["ALT_MOBILE"])
	{
		if($row1["SHOWALT_MOBILE"]=="N")
			$alt_hidden = 1;
		else
			$alt_hidden = 0;
	}
	else
		$alt_hidden = 1;

	if($mobile_hidden && $landline_hidden && $alt_hidden)
          	$check_phone = "H";     //Hidden

	if(!$check_phone)
	{
		if($row1["PHONE_MOB"] || $row1["PHONE_RES"] || $row1["ALT_MOBILE"])
		{
			$check_phone = getPhoneStatus($phoneArr);
                        if($check_phone=="Y")
                                $check_phone = "V";     //Verified
                        elseif($check_phone=="I")
                                $check_phone = "I";     //Invalid
                        else
                        {
                                if($row1["PHONE_MOB"])
                                        $mob_invalid = checkMobileNumber($row1["PHONE_MOB"],$profileid,$db);
                                else
                                        $mob_invalid = "N";
                                if($row1["ALT_MOBILE"])
                                        $alt_invalid = checkMobileNumber($row1["ALT_MOBILE"],$profileid,$db);
                                else
                                        $alt_invalid = "N";
                                if($row1["PHONE_RES"])
                                        $land_invalid = checkLandlineNumber($row1["PHONE_RES"],$row1["STD"],$profileid,$db);
                                else
                                        $land_invalid = "N";

                                if($mob_invalid=="N" && $alt_invalid=="N" && $land_invalid=="N")
                                        $check_phone = "I";     //Invalid
                                else
                                        $check_phone = "P";     //Phone not verified, not invalid and atleast one not hidden
                        }
		}
		else
		{
			$check_phone="N";       //Phone does not exist
		}
	}
	else
	{
		if(!$row1["PHONE_MOB"] && !$row1["PHONE_RES"] && !$row1["ALT_MOBILE"])
			$check_phone = "N";     //Phone does not exist
		else
		{
			$check_stat = getPhoneStatus($phoneArr);
                        if($check_stat=="Y")
                                $check_phone = "H";     //Verified and Hidden
                        elseif($check_phone=="I")
                                $check_phone = "I";     //Invalid
                        else
                        {
                                if($row1["PHONE_MOB"])
                                        $mob_invalid = checkMobileNumber($row1["PHONE_MOB"],$profileid,$db);
                                else
                                        $mob_invalid = "N";
                                if($row1["ALT_MOBILE"])
                                        $alt_invalid = checkMobileNumber($row1["ALT_MOBILE"],$profileid,$db);
                                else
                                        $alt_invalid = "N";
                                if($row1["PHONE_RES"])
                                        $land_invalid = checkLandlineNumber($row1["PHONE_RES"],$row1["STD"],$profileid,$db);
                                else
                                        $land_invalid = "N";

                                if($mob_invalid=="N" && $alt_invalid=="N" && $land_invalid=="N")
                                        $check_phone = "I";     //Invalid
                                else
                                        $check_phone = "K";     //Phone not verified, not invalid and hidden
                        }
		}
	}

	return $check_phone;
}
?>
