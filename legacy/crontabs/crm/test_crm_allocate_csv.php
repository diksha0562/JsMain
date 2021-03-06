<?php 
  $curFilePath = dirname(__FILE__)."/"; 
 include_once("/usr/local/scripts/DocRoot.php");


	ini_set("max_execution_time","0");
	//include ("../connect.inc");
	include("$_SERVER[DOCUMENT_ROOT]/crm/connect.inc");
	include("$_SERVER[DOCUMENT_ROOT]/profile/comfunc.inc");
	//include ("connect.inc");

	//define values to be used globally.
	$MAX_ALLOCATE_TOTAL = 75;
	$MAX_ALLOCATE_FAILED = 25;
	$MAX_ALLOCATE_NEW = 50;
	$FAILED_ALLOCATED = 0;
	$MAX_WRITE_NCR = 2000;
	$MAX_WRITE_SOUTH = 1000;
	$MAX_WRITE_ROI = 2500;

	$ncr_written = 0;
	$south_written = 0;
	$roi_written = 0;

	$db = connect_db2();

	$ts = time();
	$ts -= 30*24*60*60;
	$last_day = date("Y-m-d",$ts);

	$regarr = array('N','S','W');
	$regcount = count($regarr);

	//truncate profile allocation table.
	$sql="TRUNCATE TABLE test.PROFILE_ALLOCATION";
	mysql_query($sql) or die("$sql".mysql_error());

	for($i=0; $i<$regcount; $i++)
	{
		$j=0;
		// to find cities which fall in a particular region
		$sql = "SELECT NAME, VALUE  FROM incentive.BRANCHES WHERE REGION = '$regarr[$i]' AND VALUE!='UP25'";
		$res = mysql_query ($sql) or die("$sql".mysql_error());
		while ($row = mysql_fetch_array($res))
		{
			$branch_arr[$regarr[$i]]['NAME'][$j] = $row['NAME'];
			$branch_arr[$regarr[$i]]['VALUE'][$j] = $row['VALUE'];
			$j++;
		}
		$branch_arr_count = count($branch_arr[$regarr[$i]]['NAME']);

		for ($k=0; $k<$branch_arr_count; $k++)
		{
			$branch = strtoupper($branch_arr[$regarr[$i]]['NAME'][$k]);
			$l=0;
			$m=0;
			$n=0;
			$allocate_new_profiles = 0;

			//query to find executives for each Branch
			$sql_center = "SELECT USERNAME from jsadmin.PSWRDS where PRIVILAGE like '%IUO%' and UPPER(PSWRDS.CENTER)='$branch' AND ACTIVE='Y'";
			$res_center = mysql_query($sql_center) or die("$sql_center".mysql_error());
			while($row_center = mysql_fetch_array($res_center))
			{
				$userarr[$l]['NAME'] = $row_center['USERNAME'];
				$userarr[$l]['ALLOTED']	= 0;
				$l++;
			}

			$total_executives = count($userarr);
			$city_res = $branch_arr[$regarr[$i]]['VALUE'][$k];

			// query to find cities which are covered by a particular Branch
			echo $sql_cities = "SELECT VALUE FROM incentive.BRANCH_CITY WHERE LEFT(PRIORITY,4) = '$city_res'";
			$res_cities = mysql_query ($sql_cities) or die("$sql_cities".mysql_error());
			while($row_cities = mysql_fetch_array($res_cities))
				$cityarr[] = $row_cities['VALUE'];

			if(is_array($cityarr))
				$city_str = "'".implode ("','",$cityarr)."'";

			if($city_str)
			{
				$MAX_ALLOCATE = $MAX_ALLOCATE_FAILED;
				//finding user's who tried for payment.
				$sql = "SELECT DISTINCT PROFILEID FROM billing.ORDERS WHERE STATUS='' AND ENTRY_DT>=DATE_SUB(CURDATE(),INTERVAL 1 DAY) UNION SELECT DISTINCT PROFILEID FROM billing.PAYMENT_HITS WHERE ENTRY_DT>=DATE_SUB(CURDATE(),INTERVAL 1 DAY) AND PAGE>1";
				$res = mysql_query($sql) or die("$sql".mysql_error());
				while($row = mysql_fetch_array($res))
				{
					unset($allocate);
					$profileid = $row['PROFILEID'];

					$sql_jp = "SELECT PHONE_RES,PHONE_MOB from newjs.JPROFILE WHERE ACTIVATED IN ('Y','H') AND INCOMPLETE='N' AND PROFILEID ='$profileid' AND SUBSCRIPTION='' AND CITY_RES IN ($city_str)";

					$res_jp = mysql_query($sql_jp) or die("$sql_jp".mysql_error());
					if($row_jp = mysql_fetch_array($res_jp))
					{
						if(check_profile($profileid))
						{
							$sql_history = "SELECT ENTRY_DT FROM incentive.HISTORY WHERE PROFILEID='$profileid' ORDER BY ID DESC LIMIT 1";
							$res_history = mysql_query($sql_history) or die("$sql_history".mysql_error());
							// profile has been handled once
							if($row_history = mysql_fetch_array($res_history))
							{
								$profile_type = 'O';
								if($row_history['ENTRY_DT']<=$last_day)
								{
									$allocate = 1;
								}
							}
							// new profile
							else
							{
								$profile_type = 'N';    
								$allocate = 1;
							}
							if($allocate && ($row_jp['PHONE_RES'] || $row_jp['PHONE_MOB']))
							{
								if($userarr[$total_executives-1]['ALLOTED'] < $MAX_ALLOCATE && !profile_allocated($profileid))
								{
									$user_value = $userarr[$m]['NAME'];

									//allocate the profile.
									$sql_ins = "INSERT IGNORE INTO test.PROFILE_ALLOCATION (PROFILEID, ALLOTED_TO , ALLOT_DT,STATUS,PROFILE_TYPE) VALUES('$profileid','$user_value',now(),'N','$profile_type')";
									mysql_query($sql_ins) or die("$sql_ins".mysql_error);
									$userarr[$m]['ALLOTED']++;

									$m++;
									if($m == $total_executives)
										$m = 0;
								}
							}
						}
					}
				}
				$MAX_ALLOCATE = $MAX_ALLOCATE_NEW + $MAX_ALLOCATE_FAILED;
				//finding user's who registered in last 15 days.
				$sql = "SELECT PROFILEID FROM incentive.MAIN_ADMIN_POOL WHERE CITY_RES IN ($city_str) AND ALLOTMENT_AVAIL ='Y' AND TIMES_TRIED < 3 AND ENTRY_DT < DATE_SUB(CURDATE(),INTERVAL 15 DAY) ORDER BY SCORE DESC";
				$res = mysql_query($sql) or die("$sql".mysql_error());
				while($row = mysql_fetch_array($res))
				{
					unset($allocate);
					$profileid = $row['PROFILEID'];

					$sql_jp = "SELECT PHONE_RES,PHONE_MOB from newjs.JPROFILE WHERE ACTIVATED IN ('Y','H') AND INCOMPLETE='N' AND PROFILEID ='$profileid' AND SUBSCRIPTION=''";
					$res_jp = mysql_query($sql_jp) or die("$sql_jp".mysql_error());
					if($row_jp = mysql_fetch_array($res_jp))
					{
						if(check_profile($profileid))
						{
							$sql_history = "SELECT ENTRY_DT FROM incentive.HISTORY WHERE PROFILEID='$profileid' ORDER BY ID DESC LIMIT 1";
							$res_history = mysql_query($sql_history) or die("$sql_history".mysql_error());
							// profile has been handled once
							if($row_history = mysql_fetch_array($res_history))
							{
								$profile_type = 'O';
								if($row_history['ENTRY_DT']<=$last_day)
								{
									$allocate = 1;
								}
							}
							// new profile
							else
							{
								$profile_type = 'N';    
								$allocate = 1;
							}
							if($allocate && ($row_jp['PHONE_RES'] || $row_jp['PHONE_MOB']))
							{
								if($userarr[$total_executives-1]['ALLOTED'] < $MAX_ALLOCATE && !profile_allocated($profileid))
								{
									$user_value = $userarr[$n]['NAME'];

									//allocate the profile.
									$sql_ins = "INSERT IGNORE INTO test.PROFILE_ALLOCATION (PROFILEID, ALLOTED_TO , ALLOT_DT,STATUS,PROFILE_TYPE) VALUES('$profileid','$user_value',now(),'N','$profile_type')";
									mysql_query($sql_ins) or die("$sql_ins".mysql_error);
									$userarr[$n]['ALLOTED']++;

									$n++;
									if($n == $total_executives)
										$n = 0;
								}
							}
						}
					}
					if($userarr[$total_executives-1]['ALLOTED'] == $MAX_ALLOCATE)
						break;
				}
			}
		}
		unset($city_str);
		unset($cityarr);
		unset($userarr);
	}

	//define header to write into csv file.
	$header="\"PROFILEID\"".","."\"PHONE NO.(1)\"".","."\"PHONE NO.(2)\"".","."\"CITY\"".","."\"PHOTO\"".","."\"CONTACTS INITIATED\"".","."\"CONTACTS ACCEPTED\"".","."\"CONTACTS RECEIVED\"".","."\"ACCEPTANCE RECEIVED\"".","."\"DATE OF BIRTH\"".","."\"POSTEDBY\"".","."\"GENDER\"".","."\"CASTE\"".","."\"COMMUNITY\"".","."\"PROFILELENGTH\"".","."\"DESIRED PARTNER PROFILE\"".","."\"LAST LOGIN DATE\"".","."\"SCORE\"".","."\"ENTRY_DATE\"\n";

        $filename1 = "$_SERVER[DOCUMENT_ROOT]/crm/csv_files/temp-bulk_csv_crm_data_".date('Y-m-d')."_n.txt";
        $filename2 = "$_SERVER[DOCUMENT_ROOT]/crm/csv_files/temp-bulk_csv_crm_data_".date('Y-m-d')."_s.txt";
        $filename3 = "$_SERVER[DOCUMENT_ROOT]/crm/csv_files/temp-bulk_csv_crm_data_".date('Y-m-d')."_roi.txt";
        $filename4 = "$_SERVER[DOCUMENT_ROOT]/crm/csv_files/temp-bulk_csv_crm_data_".date('Y-m-d')."_mh.txt";

        $fp1 = fopen($filename1,"w+");
        $fp2 = fopen($filename2,"w+");
        $fp3 = fopen($filename3,"w+");
        $fp4 = fopen($filename4,"w+");

        if(!$fp1 || !$fp2 || !$fp3 || !$fp4)
        {
                die("no file pointer");
        }

        fwrite($fp1,$header);
        fwrite($fp2,$header);
        fwrite($fp3,$header);
        fwrite($fp4,$header);
	

	//define ncr array.
	$ncrarr = array('DE00','UP25','HA03','HA02','UP12');

	//finding user's who tried payment.
	$sql = "SELECT DISTINCT PROFILEID FROM billing.ORDERS WHERE STATUS='' AND ENTRY_DT>=DATE_SUB(CURDATE(),INTERVAL 1 DAY) UNION SELECT DISTINCT PROFILEID FROM billing.PAYMENT_HITS WHERE ENTRY_DT>=DATE_SUB(CURDATE(),INTERVAL 1 DAY) AND PAGE>1";
	$myres=mysql_query($sql) or die("$sql".mysql_error());
	while($myrow=mysql_fetch_array($myres))
	{
		$profileid=$myrow['PROFILEID'];
		if(!profile_allocated($profileid))
		{
			if(check_profile($profileid))
			{
				$sql="SELECT ENTRY_DT, LAST_LOGIN_DT , USERNAME , STD, PHONE_RES  , DTOFBIRTH  , PHONE_MOB , CITY_RES , COUNTRY_RES , MTONGUE , GENDER , RELATION , HAVEPHOTO , CASTE , CHAR_LENGTH(YOURINFO) + CHAR_LENGTH(FAMILYINFO) + CHAR_LENGTH(SPOUSE) + CHAR_LENGTH(JOB_INFO) + CHAR_LENGTH(SIBLING_INFO) + CHAR_LENGTH(FATHER_INFO) AS PROFILELENGTH from newjs.JPROFILE where PROFILEID='$profileid' and COUNTRY_RES=51 AND ACTIVATED IN ('Y','H') AND INCOMPLETE='N' AND SUBSCRIPTION=''";

				write_contents_to_file($sql,$profileid);
			}
		}
		$pidarr[]=$profileid;
	}
	unset($cityarr);
	unset($citystr);

	//finding Maharashtra and Gujrat cities
/*	$sql="SELECT VALUE FROM incentive.BRANCH_CITY WHERE VALUE LIKE 'MH%' UNION SELECT VALUE FROM incentive.BRANCH_CITY WHERE VALUE LIKE 'GU%'";
	$res=mysql_query($sql) or die("$sql".mysql_error());
	while($row=mysql_fetch_array($res))
	{
		$cityarr[]=$row['VALUE'];
	}

	$citystr = implode("','",$cityarr);
*/

	//query to find cities.
	$sql_city = "SELECT VALUE FROM incentive.BRANCH_CITY WHERE LEFT(PRIORITY,4) = 'UP25'";
	$res_city =  mysql_query($sql_city) or die("$sql_city".mysql_error());
	while($row_city = mysql_fetch_array($res_city))
	{
		$cityarr[]	= $row_city['VALUE'];
	}
	$citystr = implode("','",$cityarr);

	$sql_pid = "SELECT PROFILEID, SCORE FROM incentive.MAIN_ADMIN_POOL WHERE ALLOTMENT_AVAIL='Y' AND CITY_RES IN ('$citystr') AND TIMES_TRIED<3 ";
	if(count($pidarr))
	{
		$pidstr=implode(",",$pidarr);
		$sq_pid.=" AND PROFILEID NOT IN ($pidstr) ";
		unset($pidstr);
	}
	$sql_pid.=" ORDER BY SCORE DESC LIMIT 150000";

	$res_pid = mysql_query($sql_pid) or die("$sql_pid".mysql_error());
	$row_pid = mysql_fetch_array($res_pid);
	while($row_pid = mysql_fetch_array($res_pid))
	{
		unset($allow);

		$profileid = $row_pid['PROFILEID'];
		if(!profile_allocated($profileid))
		{
			$score = $row_pid['SCORE'];

			$sql_history = "SELECT ENTRY_DT FROM incentive.HISTORY WHERE PROFILEID='$profileid' ORDER BY ID DESC LIMIT 1";
			$res_history = mysql_query($sql_history) or die("$sql_history".mysql_error());
			if($row_history = mysql_fetch_array($res_history))
			{
				// profile has been handled once
				if($row_history['ENTRY_DT']<=$last_day)
					$allow=1;
			}
			else
			{
				// new profile
				$allow=1;
			}

			if(!check_profile($profileid))
				$allow=0;

			if($allow)	
			{
				// query to find details of users who have registered one week back and whose profiles are active 
				$sql = "SELECT ENTRY_DT, LAST_LOGIN_DT , USERNAME , PHONE_RES  , DTOFBIRTH  , STD, PHONE_MOB , CITY_RES , COUNTRY_RES , MTONGUE , GENDER , RELATION , HAVEPHOTO , CASTE , CHAR_LENGTH(YOURINFO) + CHAR_LENGTH(FAMILYINFO) + CHAR_LENGTH(SPOUSE) + CHAR_LENGTH(JOB_INFO) + CHAR_LENGTH(SIBLING_INFO) + CHAR_LENGTH(FATHER_INFO) AS PROFILELENGTH FROM newjs.JPROFILE WHERE ACTIVATED IN ('Y','H') AND INCOMPLETE='N' AND PROFILEID ='$profileid' AND SUBSCRIPTION='' AND ENTRY_DT < DATE_SUB(CURDATE(), INTERVAL 15 DAY) AND LAST_LOGIN_DT>=DATE_SUB(CURDATE(), INTERVAL 45 DAY)";

				write_contents_to_file($sql,$profileid,$score);
			}
		}
	}

	unset($cityarr);
	//query to find cities.
	$sql_city = "SELECT VALUE FROM incentive.BRANCH_CITY WHERE LEFT(PRIORITY,4) != 'UP25'";
	$res_city =  mysql_query($sql_city) or die("$sql_city".mysql_error());
	while($row_city = mysql_fetch_array($res_city))
	{
		$cityarr[]	= $row_city['VALUE'];
	}
	$citystr = implode("','",$cityarr);

	$sql_pid = "SELECT PROFILEID, SCORE FROM incentive.MAIN_ADMIN_POOL WHERE ALLOTMENT_AVAIL='Y' AND CITY_RES IN ('$citystr') AND SCORE > 324 AND TIMES_TRIED<3 ";
	if(count($pidarr))
	{
		$pidstr=implode(",",$pidarr);
		$sq_pid.=" AND PROFILEID NOT IN ($pidstr) ";
		unset($pidarr);
		unset($pidstr);
	}
//	$sql_pid.=" ORDER BY SCORE DESC LIMIT 150000";

	$res_pid = mysql_query($sql_pid) or die("$sql_pid".mysql_error());
	$row_pid = mysql_fetch_array($res_pid);
	while($row_pid = mysql_fetch_array($res_pid))
	{
		unset($allow);

		$profileid = $row_pid['PROFILEID'];
		if(!profile_allocated($profileid))
		{
			$score = $row_pid['SCORE'];

			$sql_history = "SELECT ENTRY_DT FROM incentive.HISTORY WHERE PROFILEID='$profileid' ORDER BY ID DESC LIMIT 1";
			$res_history = mysql_query($sql_history) or die("$sql_history".mysql_error());
			if($row_history = mysql_fetch_array($res_history))
			{
				// profile has been handled once
				if($row_history['ENTRY_DT']<=$last_day)
					$allow=1;
			}
			else
			{
				// new profile
				$allow=1;
			}

			if(!check_profile($profileid))
				$allow=0;

			if($allow)	
			{
				// query to find details of users who have registered one week back and whose profiles are active 
				$sql = "SELECT ENTRY_DT, LAST_LOGIN_DT , USERNAME , PHONE_RES  , DTOFBIRTH  , STD, PHONE_MOB , CITY_RES , COUNTRY_RES , MTONGUE , GENDER , RELATION , HAVEPHOTO , CASTE , CHAR_LENGTH(YOURINFO) + CHAR_LENGTH(FAMILYINFO) + CHAR_LENGTH(SPOUSE) + CHAR_LENGTH(JOB_INFO) + CHAR_LENGTH(SIBLING_INFO) + CHAR_LENGTH(FATHER_INFO) AS PROFILELENGTH FROM newjs.JPROFILE WHERE ACTIVATED IN ('Y','H') AND INCOMPLETE='N' AND PROFILEID ='$profileid' AND SUBSCRIPTION='' AND ENTRY_DT < DATE_SUB(CURDATE(), INTERVAL 15 DAY) AND LAST_LOGIN_DT>=DATE_SUB(CURDATE(), INTERVAL 45 DAY)";

				write_contents_to_file($sql,$profileid,$score);
			}
		}
	}
	fclose($fp4);

	$profileid_file1 = $SITE_URL."/crm/csv_files/bulk_csv_crm_data_".date('Y-m-d')."_n.txt";
	$profileid_file2 = $SITE_URL."/crm/csv_files/bulk_csv_crm_data_".date('Y-m-d')."_s.txt";
	$profileid_file3 = $SITE_URL."/crm/csv_files/bulk_csv_crm_data_".date('Y-m-d')."_roi.txt";
	$profileid_file4 = $SITE_URL."/crm/csv_files/bulk_csv_crm_data_".date('Y-m-d')."_mh.txt";

	$msg="For south : ".$profileid_file2;
	$msg.="\nFor NCR : ".$profileid_file1;
	$msg.="\nFor rest of india : ".$profileid_file3;
	$msg.="\nFor Maharastra : ".$profileid_file4;

	$to="anamika.singh@jeevansathi.com,surbhi.aggarwal@naukri.com,mandeep.choudhary@naukri.com,divya.jain@naukri.com,deepak.sharma@naukri.com, samrat.chada@naukri.com";
	$bcc="shiv.narayan@jeevansathi.com, sriram.viswanathan@jeevansathi.com";
	$sub="Daily CSV for calling";
	$from="From:shiv.narayan@jeevansathi.com";
	$from .= "\r\nBcc:$bcc";

//	mail($to,$sub,$msg,$from);

	function check_profile($profileid)
	{
		$sql_dnt_call = "SELECT COUNT(*) AS COUNT FROM incentive.DO_NOT_CALL WHERE PROFILEID='$profileid' AND REMOVED='N'";
		$res_dnt_call = mysql_query($sql_dnt_call) or die("$sql_dnt_call".mysql_error());
		$row_dnt_call = mysql_fetch_array($res_dnt_call);

		$sql_invalid = "SELECT COUNT(*) AS COUNT from incentive.INVALID_PHONE WHERE PROFILEID='$profileid'";
		$res_invalid = mysql_query($sql_invalid) or die("$sql_invalid".mysql_error());
		$row_invalid = mysql_fetch_array($res_invalid);

		$sql_md = "SELECT COUNT(*) AS COUNT from incentive.MAIN_ADMIN WHERE PROFILEID='$profileid'";
		$res_md = mysql_query($sql_md) or die("$sql_md".mysql_error());
		$row_md = mysql_fetch_array($res_md);

		$sql_check = "SELECT COUNT(*) AS COUNT FROM billing.PURCHASES WHERE PROFILEID='$profileid' AND STATUS='DONE' AND ENTRY_DT>=DATE_SUB(CURDATE(),INTERVAL 30 DAY)";
		$res_check = mysql_query($sql_check) or die("$sql_check".mysql_error());
		$row_check = mysql_fetch_array($res_check);

		if($row_dnt_call['COUNT']==0 && $row_invalid['COUNT']==0 && $row_md['COUNT']==0 && $row_check['COUNT']==0)
			return 1;
		else
			return 0;
	}

	function profile_allocated($profileid)
	{
		$sql = "SELECT COUNT(*) AS COUNT FROM test.PROFILE_ALLOCATION WHERE PROFILEID='$profileid'";
		$res = mysql_query($sql) or die("$sql".mysql_error());
		$row = mysql_fetch_array($res);
		if($row['COUNT'] > 0)
			return 1;
		else
			return 0;
	}

	function write_contents_to_file($sql,$profileid,$score="", $close_files="")
	{
		global $MAX_WRITE_NCR, $MAX_WRITE_SOUTH, $MAX_WRITE_ROI, $fp1, $fp2, $fp3, $fp4, $ncr_written, $roi_written, $south_written, $ncrarr;

		$res = mysql_query($sql) or die("$sql".mysql_error());
		if ($row = mysql_fetch_array($res))
		{
			$PHONE_RES = $row['PHONE_RES'];
			if($PHONE_RES)
				$PHONE_RES=$row['STD'].$PHONE_RES;
			if(substr($PHONE_RES,0,1)==0)
				$PHONE_RES = substr($PHONE_RES,1);
			$PHONE_RES = substr($PHONE_RES,-10);
			if(strlen($PHONE_RES)<10)
				$PHONE_RES="";

			//added by sriarm on June 12 2007 to show alternate number (if any)
			$sql_alt = "SELECT ALTERNATE_NUMBER FROM incentive.PROFILE_ALTERNATE_NUMBER WHERE PROFILEID = '$profileid' ORDER BY ID DESC LIMIT 1";
			$res_alt = mysql_query($sql_alt) or die("$sql_alt".mysql_error());
			if($row_alt = mysql_fetch_array($res_alt))
				$PHONE_MOB = $row_alt['ALTERNATE_NUMBER'];
			else
				$PHONE_MOB = $row['PHONE_MOB'];
			//end of - added by sriarm on June 12 2007 to show alternate number (if any)

			if(substr($PHONE_MOB,0,1)==0)
				$PHONE_MOB = substr($PHONE_MOB,1);
			$PHONE_MOB = substr($PHONE_MOB,-10);
			if(strlen($PHONE_MOB)<10)
				$PHONE_MOB="";
			$PHOTO = $row['HAVEPHOTO'];
			$ENTRY_DT = $row['ENTRY_DT'];

			$city =  $row['CITY_RES'];
			$subcity=substr($city,0,2);

			/*if(@!in_array($city,$ncrarr))
			{
				if($score >= 324 && !profile_allocated($profileid))
					$mh_allow=1;
				else
					$mh_allow=0;
			}
			else
				$mh_allow=1;
			*/

			if((trim($PHONE_RES) || trim($PHONE_MOB)))
			{
				// query to find count of contacts made and accepted
				$sql1 = "SELECT COUNT(*) as CNT FROM newjs.CONTACTS WHERE RECEIVER = '$profileid' AND TYPE='A'";
				$res1 = mysql_query($sql1) or die("$sql1".mysql_error());
				$row1 = mysql_fetch_array($res1);
				$ACCEPTANCE_RCVD = $row1['CNT'];

				// query to find count of contacts initiated by user and accepted
				$sql2 = "SELECT COUNT(*) as CNT FROM newjs.CONTACTS WHERE SENDER = '$profileid' AND TYPE='A'";
				$res2 = mysql_query($sql2) or die("$sql2".mysql_error());
				$row2 = mysql_fetch_array($res2);
				$ACCEPTANCE_MADE = $row2['CNT'];
				
				//query to find count of contacts received and not responded yet.
				$sql3="SELECT COUNT(*) AS CNT3 FROM newjs.CONTACTS WHERE RECEIVER = '$profileid' AND TYPE='I'";
				$res3 = mysql_query($sql3) or die("$sql3".mysql_error());
				$row3 = mysql_fetch_array($res3);
				$RECEIVE_CNT = $row3['CNT3'];

				//query to find count of contacts initiated by user and has not been responded.
				$sql4 ="SELECT COUNT(*) AS CNT4 FROM newjs.CONTACTS WHERE SENDER = '$profileid' AND TYPE='I'";
				$res4 = mysql_query($sql4) or die("$sql4".mysql_error());
				$row4 = mysql_fetch_array($res4);
				$INITIATE_CNT= $row4['CNT4'];

				$DOB = $row['DTOFBIRTH'];

				$posted = $row['RELATION'];
				switch($posted)
				{
					case '1': $POSTEDBY='Self';
						  break;
					case '2': $POSTEDBY='Parent/Guardian';
						  break;
					case '3': $POSTEDBY='Sibling';
						  break;
					case '4': $POSTEDBY='Friend';
						  break;
					case '5': $POSTEDBY='Marriage Bureau';
						  break;
					case '6': $POSTEDBY='Other';
						  break;
				}

				if($row['GENDER']=='F')
					$GENDER='Female';
				else
					$GENDER='Male';

				$caste = $row['CASTE'];
				$caste_label= label_select('CASTE',$caste);
				$CASTE=$caste_label[0];

				$mtongue = $row['MTONGUE'];
				$mtongue_label= label_select('MTONGUE',$mtongue);
				$MTONGUE= $mtongue_label[0];

				$country =  $row['COUNTRY_RES'];
				$country_label = label_select('COUNTRY',$country);
				$COUNTRY= $country_label[0];

				if($country=='51')
				{
					$city_label=label_select('CITY_INDIA',$city);
					$CITY_RES=$city_label[0];
				}
				elseif($country=='128')
				{
					$city_label=label_select('CITY_USA',$city);
					$CITY_RES=$city_label[0];
				}
				else
					$CITY_RES='NA';

				$sql5 = "SELECT PARTNERID FROM newjs.JPARTNER WHERE PROFILEID = '$profileid'";
				$res5 = mysql_query($sql5) or die("$sql5".mysql_error());
				$row5 = mysql_fetch_array($res5);

				$partner_id = $row5["PARTNERID"];
				if ($partner_id)
				{
					$partner_tbl_arr = array('PARTNER_BTYPE','PARTNER_CASTE','PARTNER_CITYRES','PARTNER_COMP','PARTNER_COUNTRYRES','PARTNER_DIET','PARTNER_DRINK','PARTNER_ELEVEL','PARTNER_ELEVEL_NEW','PARTNER_FBACK','PARTNER_INCOME','PARTNER_MANGLIK','PARTNER_MSTATUS','PARTNER_MTONGUE','PARTNER_OCC','PARTNER_RES_STATUS','PARTNER_SMOKE');
					for($i=0;$i<count($partner_tbl_arr);$i++)
					{
						$sql6 = "SELECT COUNT(*) AS CNT4 FROM newjs.$partner_tbl_arr[$i] WHERE PARTNERID = '$partner_id'";
						$res6 = mysql_query($sql6) or die("$sql6");
						if ($row6 = mysql_fetch_array($res6))
						{
							if ($row6["CNT4"] > 0)
							{
								$DPP =  1;
								break;
							}
							else
								$DPP =  0;
						}
					}
				}
				else
					$HAVEPARTNER = 'N';

				// member as filled in his/her desired partner profile
				if ($DPP ==  1)
					$HAVEPARTNER = 'Y';
				else
					$HAVEPARTNER = 'N';

				//$PROFILELENGTH = strlen($row['YOURINFO']) + strlen($row['FAMILYINFO']) + strlen($row['SPOUSE']) + strlen($row['FATHER_INFO']) + strlen($row['SIBLING_INFO']) + strlen($row['JOB_INFO']);
				$PROFILELENGTH=$row['PROFILELENGTH'];

				$LAST_LOGIN_DT = $row['LAST_LOGIN_DT'];

				// cretaing content to be written to the file
				if ($PHONE_MOB && $PHONE_RES)
				{
					$line="\"$profileid\"".","."\"$PHONE_MOB\"".","."\"$PHONE_RES\"".","."\"$CITY_RES\"".","."\"$PHOTO\"".","."\"$INITIATE_CNT\"".","."\"$ACCEPTANCE_MADE\"".","."\"$RECEIVE_CNT\"".","."\"$ACCEPTANCE_RCVD\"".","."\"$DOB\"".","."\"$POSTEDBY\"".","."\"$GENDER\"".","."\"$CASTE\"".","."\"$MTONGUE\"".","."\"$PROFILELENGTH\"".","."\"$HAVEPARTNER\"".","."\"$LAST_LOGIN_DT\"".","."\"$score\"".","."\"$ENTRY_DT\"";
				}
				elseif ($PHONE_MOB && $PHONE_RES =='')
				{
					$line="\"$profileid\"".","."\"$PHONE_MOB\"".",\"\","."\"$CITY_RES\"".","."\"$PHOTO\"".","."\"$INITIATE_CNT\"".","."\"$ACCEPTANCE_MADE\"".","."\"$RECEIVE_CNT\"".","."\"$ACCEPTANCE_RCVD\"".","."\"$DOB\"".","."\"$POSTEDBY\"".","."\"$GENDER\"".","."\"$CASTE\"".","."\"$MTONGUE\"".","."\"$PROFILELENGTH\"".","."\"$HAVEPARTNER\"".","."\"$LAST_LOGIN_DT\"".","."\"$score\"".","."\"$ENTRY_DT\"";
				}
				elseif ($PHONE_MOB =='' && $PHONE_RES)
				{
					$line="\"$profileid\"".","."\"$PHONE_RES\"".",\"\","."\"$CITY_RES\"".","."\"$PHOTO\"".","."\"$INITIATE_CNT\"".","."\"$ACCEPTANCE_MADE\"".","."\"$RECEIVE_CNT\"".","."\"$ACCEPTANCE_RCVD\"".","."\"$DOB\"".","."\"$POSTEDBY\"".","."\"$GENDER\"".","."\"$CASTE\"".","."\"$MTONGUE\"".","."\"$PROFILELENGTH\"".","."\"$HAVEPARTNER\"".","."\"$LAST_LOGIN_DT\"".","."\"$score\"".","."\"$ENTRY_DT\"";
				}

				$data = trim($line)."\n";
				$output = $data;
				unset($data);
				unset($DPP);

				// writing content to file
				if($subcity=="TN" || $subcity=="KE" || $subcity=="KA" ||$subcity=="AP")
				{
					if($south_written < $MAX_WRITE_SOUTH)
						fwrite($fp2,$output);
					$south_written++;
				}
				elseif(in_array($city,$ncrarr))
				{
					if($ncr_written < $MAX_WRITE_NCR)
						fwrite($fp1,$output);
					$ncr_written++;
				}
				elseif($subcity=="MH" || $subcity=="GU")
					fwrite($fp4,$output);
				else
				{
					if($roi_written < $MAX_WRITE_ROI)
						fwrite($fp3,$output);
					$roi_written++;
				}
			}
		}
		if ($south_written == $MAX_WRITE_SOUTH)
		{
			$south_written++;
			fclose($fp2);
		}
		if ($ncr_written == $MAX_WRITE_NCR)
		{
			$ncr_written++;
			fclose($fp1);
		}
		if ($roi_written == $MAX_WRITE_ROI)
		{
			$roi_written++;
			fclose($fp3);
		}
		if($south_written >= $MAX_WRITE_SOUTH && $ncr_written >= $MAX_WRITE_NCR && $roi_written >= $MAX_WRITE_ROI)
			break;
	}
?>
