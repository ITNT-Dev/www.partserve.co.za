<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

//putenv('ODBCINI=/etc/odbc.ini');

include_once("include/config.php");
include_once("include/db_access.php");

	$db_user        = "Master";
 	$db_pass        = "JobTrack";

	$sConnection= odbc_connect("test", $db_user, $db_pass);

	if(!$sConnection) die("Could not connect<br>");	//else die('Connected');

//$sel = mssql_select_db($msDb, $con) or die('DB Selection failed');
//if ($sel){echo"MS SQL Database Selected</br>";}

//Query the master table and import the data
//echo "Inserting Data into Master table - </br>";


$sql = "SELECT * FROM jobinfoweb";
$res = odbc_exec($sConnection,$sql);

//$a = array ('a' => 'apple', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
//print_r($a);

$mysql = new dbObject;

	$num=0;
	while(odbc_fetch_row($res)){
		
		//print_r($res);
		
		$test = $mysql->dbQuery("SELECT * from jobinfoweb WHERE job='".odbc_result($res,"job")."' ");
	if(mysql_num_rows($test)>0){
			echo odbc_result($res,"job")."-already Exists in database</br>";
		} 
		else{
		
			//echo $num++."-".odbc_result($res,"job")."<br>";

	   
			$sql = 'INSERT INTO jobinfoweb
						(
						 Job,Customer,CustomerName,
						 PhysicalAddress1,PhysicalAddress2,PhysicalAddress3,PhysicalAddress4,PhysicalAddress5,
						 AccountContactName,AccountContactEmail,AccountContactTel,AccountContactCell,
						 SalesContactName,SalesContactEmail,SalesContactCell,SalesContactTel,
						 LastContactNotes,
						 QuoteAccountNumber,QuoteDRRef,QuoteJobDate,QuoteMake,QuoteModel,QuoteSerialNumber,
						 QuoteActionRequired,QuoteTotal,QuoteDiscountPer,QuoteDiscount,QuoteTotalTax,QuoteGrandTotal,
						 FaultDescription,Accessories,WorkDone,Item,Status
						 )
					VALUES(
						 "'.trim(odbc_result($res,"Job")).'",
						 "'.trim(odbc_result($res,"Customer")).'",
						 "'.trim(odbc_result($res,"CustomerName")).'",
						 "'.trim(odbc_result($res,"PhysicalAddress1")).'",
						 "'.trim(odbc_result($res,"PhysicalAddress2")).'",
						 "'.trim(odbc_result($res,"PhysicalAddress3")).'",
						 "'.trim(odbc_result($res,"PhysicalAddress4")).'",
						 "'.trim(odbc_result($res,"PhysicalAddress5")).'",
						 "'.trim(odbc_result($res,"AccountContactName")).'",
						 "'.trim(odbc_result($res,"AccountContactEmail")).'",
						 "'.trim(odbc_result($res,"AccountContactTel")).'",
						 "'.trim(odbc_result($res,"AccountContactCell")).'",
						 "'.trim(odbc_result($res,"SalesContactName")).'",
						 "'.trim(odbc_result($res,"SalesContactEmail")).'",
						 "'.trim(odbc_result($res,"SalesContactCell")).'",
						 "'.trim(odbc_result($res,"SalesContactTel")).'",
						 "'.trim(odbc_result($res,"LastContactNotes")).'",
						 "'.trim(odbc_result($res,"QuoteAccountNumber")).'",
						 "'.trim(odbc_result($res,"QuoteDRRef")).'",
						 "'.trim(odbc_result($res,"QuoteJobDate")).'",
						 "'.trim(odbc_result($res,"QuoteMake")).'",
						 "'.trim(odbc_result($res,"QuoteModel")).'",
						 "'.trim(odbc_result($res,"QuoteSerialNumber")).'",
						 "'.trim(odbc_result($res,"QuoteActionRequired")).'",
						 "'.trim(odbc_result($res,"QuoteTotal")).'",
						 "'.trim(odbc_result($res,"QuoteDiscountPer")).'",
						 "'.trim(odbc_result($res,"QuoteDiscount")).'",
						 "'.trim(odbc_result($res,"QuoteTotalTax")).'",
						 "'.trim(odbc_result($res,"QuoteGrandTotal")).'",
						 "'.trim(odbc_result($res,"FaultDescription'")).'",
						 "'.trim(odbc_result($res,"Accessories")).'",
						 "'.trim(odbc_result($res,"WorkDone")).'",
						 "'.trim(odbc_result($res,"Item")).'",
						 "'.trim(odbc_result($res,"Status")).'"
						)';
					
			$result = $mysql->dbQuery($sql) or die("cannot insert");
			if($result){echo odbc_result($res,"Job")."</br>";}			
		}
	}



//Query the transactionreport view and import the data
//ini_set('memory_limit', '-1');
//$sql = "SELECT * FROM [dbo].[TRANSACTIONREPORT]";

//$today=time("Ymd");
//$pastWeek= date("Ymd",$today-777600); // go back 9 days
//$pastWeek= date("Ymd",$today-1209000);


/*echo "Inserting Data into TransactionsReport table from - ".$pastWeek."</br>";

$sql="SELECT dbo.TRANSACK.TR_SQ, dbo.TRANSACK.SITE_SLA, dbo.TRANSACK.TR_MSTSQ, dbo.TRANSACK.TR_Tagcode, dbo.TRANSACK.TR_TagType, dbo.TRANSACK.TR_Date,             dbo.TRANSACK.TR_Time, dbo.TRANSACK.TR_TermSLA, dbo.TRANSACK.TR_Direction, dbo.DEPARTMENT.DEPT_Name, dbo.DEPARTMENT.DEPT_No, 
             dbo.DEPARTMENT.SITE_SLA AS DEPTSITE_SLA, dbo.MASTER.MST_LastName, dbo.MASTER.MST_FirstName, dbo.EMPLOYEE.EMP_Employer, 
             dbo.EVENT_TYPE.ET_TypeNo, dbo.EVENT_TYPE.ET_Desc AS ET_NAME, dbo.SITE.SITE_Name, dbo.TERMINAL.TERM_Name, dbo.LOCATION.LOC_Name, 
             dbo.LOCATION.LOC_No, dbo.LOCATION.ZONE_No, dbo.ZONE.ZONE_Name, dbo.TAG_TYPE.TT_Name, dbo.CONTROLLER.CTRL_SLA, 
             dbo.CONTROLLER.CTRL_Name
			 FROM dbo.TRANSACK LEFT OUTER JOIN
                  dbo.MASTER ON dbo.TRANSACK.TR_MSTSQ = dbo.MASTER.MST_SQ LEFT OUTER JOIN
                  dbo.EMPLOYEE ON dbo.TRANSACK.TR_MSTSQ = dbo.EMPLOYEE.MST_SQ LEFT OUTER JOIN
                  dbo.SITE ON dbo.TRANSACK.SITE_SLA = dbo.SITE.SITE_SLA LEFT OUTER JOIN
                  dbo.EVENT_TYPE ON dbo.TRANSACK.TR_Event = dbo.EVENT_TYPE.ET_TypeNo LEFT OUTER JOIN
                  dbo.TAG_TYPE ON dbo.TRANSACK.TR_TagType = dbo.TAG_TYPE.TT_TypeNo LEFT OUTER JOIN
                  dbo.TERMINAL ON dbo.TRANSACK.TR_TermSLA = dbo.TERMINAL.TERM_SLA LEFT OUTER JOIN
                  dbo.DEPARTMENT ON dbo.EMPLOYEE.DEPT_No = dbo.DEPARTMENT.DEPT_No AND dbo.EMPLOYEE.SITE_SLA = dbo.DEPARTMENT.SITE_SLA LEFT OUTER JOIN
                  dbo.CONTROLLER ON dbo.TERMINAL.CTRL_SLA = dbo.CONTROLLER.CTRL_SLA LEFT OUTER JOIN
                  dbo.LOCATION ON dbo.TERMINAL.CTRL_SLA = dbo.LOCATION.CTRL_SLA AND dbo.TERMINAL.LOC_No = dbo.LOCATION.LOC_No LEFT OUTER JOIN
                  dbo.ZONE ON dbo.LOCATION.CTRL_SLA = dbo.ZONE.CTRL_SLA AND dbo.LOCATION.ZONE_No = dbo.ZONE.ZONE_No
			 WHERE(dbo.TRANSACK.TR_Date>'".$pastWeek."')";
			 
$res = mssql_query($sql, $con);

$mysql = new dbObject;

	while($row = mssql_fetch_assoc($res)){
		
		$test = $mysql->dbQuery("SELECT * from TRANSACTIONREPORT WHERE TR_SQ=$row[TR_SQ]");
		if(mysql_num_rows($test)>0){
			echo $row[TR_SQ]."-already Exists in database</br>";
		} 
		else{
	   
			$sql = 'INSERT INTO TRANSACTIONREPORT(TR_SQ,SITE_SLA,TR_MSTSQ,TR_TAGCODE,TR_TAGTYPE,TR_DATE,TR_TIME,TR_TERMSLA,TR_DIRECTION,
													DEPT_NAME,DEPT_NO,DEPTSITE_SLA,MST_LASTNAME,MST_FIRSTNAME,EMP_EMPLOYER,ET_TYPENO,
													ET_NAME,SITE_NAME,TERM_NAME,LOC_NAME,LOC_NO,ZONE_NO,ZONE_NAME,TT_NAME,CTRL_SLA,	CTRL_NAME)
					VALUES("'.join('","',$row).'")';
			$result = $mysql->dbQuery($sql) or die("cannot insert");
			if($result){echo $row[TR_SQ]."</br>";}			
		}
	}
*/



?>

<body>
</body>
</html>
