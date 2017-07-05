<?php
require_once("./util.inc.php");
$rulename = ereg_replace('/|.xml', '', $_SERVER["QUERY_STRING"]);
$rulename = str_replace('/', '', $rulename);
if($rulename == "") {
	include("index.php");
} else {
	$rulefile = "./parsers/$rulename.inc.php";
	if($url != '') {
		if($ag != '') {
			$xmlfile  = "./cache/$rulename-$url-$ag.xml";
		} else { 
			$xmlfile  = "./cache/$rulename-$url.xml";
		}  
	} else {
	$xmlfile  = "./cache/$rulename.xml";
	}  
	if(valid_file($xmlfile)) {
		$output = read_file($xmlfile);
	} else {
		include($rulefile);
		$output = template_xml();
		$output = str_replace('%%TITLE%%', $xml['title'], $output);
		$output = str_replace('%%LINK%%', $xml['link'], $output);
		$output = str_replace('%%DESCRIPTION%%', $xml['description'], $output);
		$output = str_replace('%%PUBLISHER%%', $xml['publisher'], $output);
		$output = str_replace('%%ITEM%%', $xml['item'], $output);
		write_file($xmlfile, $output);
	}  
	header ("Content-Type: text/xml");
	echo $output;
}
