<?php
/* RSS feed to JavaScript src file
   This PHP script will take an RSS feed as a value of src=....
   and return a JavaScript file that can be linked 
   remotely from any other web page. Output includes
   Site title, link, and description as well as item site, link, and
   description.
   
   Hack script by Alan Levine 05.may.2003
   http:/jade.mcli.dist.maricopa.edu/alan/
   
   Cleanup by D'Arcy Norman 07.may.2003
   http://commons.ucalgary.ca/weblogs/dnorman/
   
   Modified by Alan Levine 13.may.2003
   - changed access to variables to $_GET array for servers
      with PHP globals set to off
   - added options to show/hide channel information, set number of
      items to display, and show/hide item descriptions 
      (thanks to suggestions from Randy Brown)
      
   Modified by D'Arcy Norman 13.may.2003
   - changed for loop to a while, to better handle small numbers
       of posts. Lets you specify the number of loops to run
       without running past the limit
   - subtract 1 from the num_option variable, since it seems
       to be zero-based, rather than 1-based.
   - added date parameter to request
   - added date displayer, using css span class "rss_date"
   
   Modified by Alan Levine 14.may.2003
   - fixed date format for output if item posting
   - added option for show/hide channel info for title only

    Modified by Alan Levine 15.sep.2003
   - added target option to item links to open in a new window

   Modified by Alan Levine 13.oct.2003
   - fixed sloppy code for cache names to make them unique

   Modified by Alan Levine 14.oct.2003
   - adjusted output to also use RSS 2.0 item <guid> elelement for link and
     <pubDate> for publish date
   
   Usage:
     see http://jade.mcli.dist.maricopa.edu/feed/

   Local customization can be achieved via declarations of CSS for
      div.rssbox (style for bounding box)
      class.rss_title (style for title of feed)
      class.rss_item, class.rss_item a (style for linked entry)
      class.rss_date (style for date display)

   This makes use of the Onyx RSS parser from
     http://www.readinged.com/onyx/rss/
*/

// utility to remove return characters fomr strings that might
// pollute JavaScript commands
function strip_returns ($text) {
	return ereg_replace("(\r\n|\n|\r)", " ", $text);
}


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
include 'onyx-rss.php';


// VARIABLES
// relative or full path to cache directory (must be writable permissions CHMOD 777)
$cachePath = 'cached';

// output spec for item date string if used
// see http://www.php.net/manual/en/function.date.php
$date_format = "F d, Y h:i:s a";

// START OUTPUT
// headers to tell browser this is a JS file
header("Content-type: application/x-javascript");

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
$str = "document.write('<div class=\"rss_box\">');\n";

if ($channel_option == 'yes') {
	// output channel title and description
	
	$str.= "document.write('<p class=\"rss_title\"><a class=\"rss_title\" href=\"$channel->link\">" . addslashes(strip_returns($channel->title)) . "</a><br /><span class=\"rss_item\">" . addslashes(strip_returns($channel->description)) . "</span></p>');\n";

} elseif ($channel_option == 'title') {
	// output title only
	$str.= "document.write('<p class=\"rss_title\"><a class=\"rss_title\" href=\"$channel->link\">" . addslashes(strip_returns($channel->title)) . "</a></p>');\n";

}	

// begin item listing
$str.= "document.write('<ul class=\"rss_items\">');\n";

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
		$my_title = addslashes(strip_returns($item->title));
	} else {
		// place holder for items w/o titles
		$my_title = "&lt;no title&gt;";
	}

	// write the item
	$str.= ("document.write('<li class=\"rss_item\"><a class=\"rss_item\" href=\"$my_url\"  target=\"feed\">" . $my_title . "</a>');\n");

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

			$str.= "document.write('<br /><span class=\"rss_date\">postado em $pretty_date </span>');\n"; 
		}
	}

	// output description of item if desired
	if ($desc_option == 'yes') {
		$str.= "document.write('<br />" . addslashes(strip_returns($item->description)) . "');\n"; 
	}
	
	
	$str.= "document.write('</li>');\n";	
}
	
$str .= "document.write('</ul></div>');\n";
$str .= "document.close();";
// return results
echo $str;

?>