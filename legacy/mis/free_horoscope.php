<?php
include("connect.inc");
include("../profile/arrays.php");
//free_horoscope.php
//MADE BY PUNEET MAKKAR TO KNOW THE NO OF FREE HOROSCOPE USERS ADDED FROM OCTOBER 
$db=connect_misdb();
$db2=connect_master();

if(authenticated($cid))
{
	if($CMDGo)
	{
		$smarty->assign("flag",1);

		if($day)
		{
			$st_date=$year."-".$month."-".$day." 00:00:00";
			$end_date=$eyear."-".$emonth."-".$eday." 23:59:59";
		}
		else
		{
			$st_date=$year."-".$month."-01 00:00:00";
			$end_date=$eyear."-".$emonth."-31 23:59:59";
		}

		$sql="SELECT COUNT(*) as count FROM newjs.JPROFILE  WHERE ENTRY_DT BETWEEN '$st_date' AND '$end_date' AND SHOW_HOROSCOPE='Y'";
		$res=mysql_query_decide($sql,$db) or die(mysql_error_js());
		
		while($row=mysql_fetch_array($res))
		{
			$count=$row['count'];
		}

		$smarty->assign("count",$count);

		$smarty->assign("day",$day);
		$smarty->assign("year",$year);
		$smarty->assign("month",$month);
		$smarty->assign("eday",$eday);
		$smarty->assign("eyear",$eyear);
		$smarty->assign("emonth",$emonth);
		$smarty->assign("cid",$cid);
       		$smarty->display("free_horoscope.htm");
	}
	
	else
	{
		for($i=0;$i<31;$i++)
		{
			$ddarr[$i]=$i+1;
		}

		for($i=0;$i<12;$i++)
                {
                        $mmarr[$i]=$i+1;
                }

                for($i=2004;$i<=date("Y");$i++)
{
        $yyarr[$i-2004]=$i;
}

		$smarty->assign("ddarr",$ddarr);
		$smarty->assign("mmarr",$mmarr);
                $smarty->assign("yyarr",$yyarr);
		$smarty->assign("cid",$cid);
		$smarty->display("free_horoscope.htm");
	}
}
else
{
	$smarty->assign("user",$username);
	$smarty->display("jsconnectError.tpl");
}
?>
