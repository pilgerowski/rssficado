<?php
/* RSS feed to HTML
   This PHP script will take an RSS feed as a value of src=....
   and return an HTM page with results. This is a companian
   script to the RSS2JS (RSS to JavaScript) code for a link
   to the NOSCRIPT output (for accessibilityP
   
   Hack script by Alan Levine 08.aug.2003
   http:/jade.mcli.dist.maricopa.edu/alan/

   Modified by Alan Levine 13.oct.2003
   - fixed sloppy code for cache names to make them unique

   Modified by Alan Levine 14.oct.2003
   - adjusted output to also use RSS 2.0 item <guid> elelement for link and
     <pubDate> for publish date
          
   Usage:
     see http://jade.mcli.dist.maricopa.edu/feed/

  Customization can be achieved via declarations of external CSS
  
   This makes use of the Onyx RSS parser from
     http://www.readinged.com/onyx/rss/
*/


// POSTED VARS
// retrieve from posted vars, just in case PHP globals are off
$xml_src = $_GET['src'];

// flag to show channel info, values = no/yes/title; default = yes
if ($_GET['chan']) {
	$channel_option = $_GET['chan'];
} else {
	$channel_option = 'yes';
}

// variable to limit number of displayed items; default = 0 (show all)
if ($_GET['num']) {
	$num_option = $_GET['num'];
} else {
	$num_option = 0;
}

// flag to show item description,  values = no/yes; default = no
if ($_GET['desc']) {
	$desc_option = $_GET['desc'];
} else {
	$desc_option = 'no';
}

// flag to show date of posts, values = no/yes; default = no
if ($_GET['date']) {
	$date_option = $_GET['date'];
} else {
	$date_option = 'no';
}

// ERROR TRAP
// trap for missing src param, divert to an error page
if (!$xml_src) header("Location:nosource.html");


// INCLUDES
// path to location of onyx-rss code files
//include('onyx-rss.php');
include './onyx-rss.php';


// VARIABLES
// relative or full path to cache directory (must be writable permissions CHMOD 777)
$cachePath = './cached';

// output spec for item date string if used
// see http://www.php.net/manual/en/function.date.php
$date_format = "F d, Y h:i:s a";

// create unique cache file name based on URL of feed
$url_parts = parse_url($xml_src);

$xfile = $url_parts["host"] . $url_parts["path"] . $url_parts["query"];
$xfile = preg_replace("/(\/|=|&)/", "-", $xfile);

// Use Onyx RSS 
$rss = new ONYX_RSS();

// set local local cache (must by CMHMOD 777)
$rss->setCachePath($cachePath);

//use object mode
$rss->setFetchMode(ONYX_FETCH_OBJECT);

// set cache based on XML file / path name
$rss->parse($xml_src, "$xfile.cache");

// get channel data
$channel = $rss->getData(ONYX_META);

// begin javascript output string for channel info
$str = "<div class=\"rss_box\">\n";

if ($channel_option == 'yes') {
	// output channel title and description
	
	$str.= "<p class=\"rss_title\"><a class=\"rss_title\" href=\"$channel->link\">" . $channel->title . "</a><br /><span class=\"rss_item\">" . $channel->description . "</span></p>\n";

} elseif ($channel_option == 'title') {
	// output title only
	$str.= "<p class=\"rss_title\"><a class=\"rss_title\" href=\"$channel->link\">" . $channel->title . "</a></p>\n";

}	

// begin item listing
$str.= "<ul class=\"rss_items\">\n";

// set loop counter for items
if ($num_option == 0) {
	// get number of items in feed
	$item_count = $rss->numItems();
} else {
	// use number passed by parameters
	$item_count = $num_option - 1;
}

// walk the items
while ($item = $rss->getNextItem($item_count)) {
	if ($item->link) {
		// link url for RSS 0.9 and 1.0
		$my_url = $item->link;
		
	} elseif ($item->guid) {
		// link url for RSS 2.0
		$my_url = $item->guid;
	}
	
	if ($item->title) {
		// format item title
		$my_title = htmlspecialchars($item->title, ENT_QUOTES);
	} else {
		// place holder for items w/o titles
		$my_title = "&lt;no title&gt;";
	}


	$str.= ("<li class=\"rss_item\"><a class=\"rss_item\" href=\"$my_url\">" . $my_title . "</a>\n");

	// print out date if option indicated and feed returns a value
	if ($date_option == 'yes') {
	
		// set default for date found flag
		$nix_date = -1;
		
		if ($item->{"dc:date"}) {
			// RSS 1.0 date format
			
			// get date item from feed
			$dc_date = $item->{"dc:date"};
	
			// parse out to unix date from dc format yyyy-mm-ddThh:mm:ss-xx:xx 
			$nix_date = substr($dc_date, 0, 10) . ' ' . substr($dc_date, 11, 8);

		} elseif ($item->pubDate) {
			// RSS 2.0
			
			// format: "Day, dd Mmm yyyy hh:mm:ss-xx"
			$nix_date = substr($item->pubDate, 0, 24);
			
		}
		
		// check if we got a valid date
		if ($nix_date != -1) {
		
			// convert date to pretty string			
			$pretty_date = date($date_format, strtotime($nix_date));

			$str.= "<br /><span class=\"rss_date\">posted on $pretty_date </span>\n"; 
		}
	}

	// output description of item if desired
	if ($desc_option == 'yes') {
		$str.= "<br />" . $item->description . "\n"; 
	}
	
	
	$str.= "</li>\n";	
}
	
$str .= "</ul></div>\n";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/plain; charset=iso-8859-1" />
	<title><?php echo $channel->title?></title> 
	<link rel="Stylesheet" rev="Alternate" href="rss.css" />
	<style type="text/css">

#content { 
	margin: 10px 20px;
}

p { font-family: verdana, arial, sans-serif; 
	font-size: 12px;
	margin-top:0;
	margin-bottom:1em;
	}

h1 { font-family: verdana, arial, sans-serif; 
	 font-size: 24px;
	 margin-bottom: 2px;	  
	 text-align:center;
	}
</style>

</head>

<body bgcolor="#FFFFFF">
<div id="content">
<h1>RSS Feed for <?php echo $channel->title?></h1>
<p>Note: this RSS feed is provided as a text alternative to inline RSS feeds that may not display on all browsers</p>
<?php echo $str?>
</div>
</body>
</html>