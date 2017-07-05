<?php echo '<?xml version="1.0" encoding="ISO-8859-1"?>'; ?>
<serviceList>
	<header>
		<updated>30/01/2002 21:45</updated>
	</header>
 

<?
include("/home/pilger/database.inc.php");

$db_name = 'pilger_rssficado';

error_reporting(0);
$dbh=mysql_connect ($db_host, $db_user, $db_pass) 
	or die ('I cannot connect to the database.');
mysql_select_db ($db_name, $dbh); 
$result = mysql_query("SELECT * FROM links",$dbh);

while ($myrow = mysql_fetch_row($result)) {
	echo "
	<service>
		<title>$myrow[1]</title>
		<url>$myrow[1]</url>
		<submitter>$myrow[1]</submitter>
		<description>$myrow[1]</description>
		<htmlUrl>$myrow[1]</htmlUrl>
	</service>
	";
}


