<?php
/**************************************************\
| Description: Extract keywords from XML files     |
|              and populate the SQL database.      |
|                                                  |
| Authors: Elena, Garth                            |
\**************************************************/



// MySQL server credentials.
$servername = 'localhost';
$username = 'root';
$password = 'Killer5740.';
$database = 'ruskin';
$xml_folder = 'xmlOLD/';



// Turn off output buffering so output is immediately printed to the screen rather than waiting until the entire page finishes downloading.
ob_implicit_flush(1);

// Override default execution time limit of 30 seconds, and allow the script to execute for as long as it needs.
set_time_limit(0);

// Only report errors. Do not report warnings.
error_reporting(E_ERROR);



// Function to construct the URL to the PHP file on the Ruskin website that corresponds to a given XML file.
function construct_url($filename, $divtype) {
	// Base URL of website.
	$url = 'http://english.selu.edu/humanitiesonline/ruskin/';
	
	// Use the divtype of the file to determine which folder the file is located on the site.
	if ($divtype == 'note') {
		$url .= 'notes/';
	} elseif ($divtype == 'apparatus') {
		$url .= 'apparatuses/';
	} elseif ($divtype == 'title') {
		$url .= 'witnesses/';
	} elseif ($divtype == 'poem') {
		$url .= 'showcase/';
	}
	
	// Change the extension of the file from .XML to .PHP
	$url .= str_replace('xml', 'php', $entry);
	
	return $url;
}

// Function that checks the response code of a URL on the Ruskin server. This is used for checking if a file exists (200 code) or if a file does not exist on the server (404 code).
function get_response($url) {
	// Wait half a second between requests. This is needed so that we don't accidentally DOS attack the Ruskin server.
	usleep(500000);
	
	// Initiate the CURL handle.
	$curl_handle = curl_init();
	
	// Give our URL to CURL.
	curl_setopt($curl_handle, CURLOPT_URL, $url);
	
	// Tell CURL not to output the page contents to the screen. We only care about the response code.
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
	
	// Tell CURl to timeout the connection in 3 seconds if the server does not respond.
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 3);
	
	// Perform the CURL operation.
	curl_exec($curl_handle);
	
	// Check if there was an error performing the CURL operation.
	if (!curl_errno($curl_handle)) {
		// If there was no error, then grab the connection info from our CURL session.
		$connection_info = curl_getinfo($curl_handle);
		
		// Extract the HTTP response code from our CURL session.
		$code = $connection_info['http_code'];
	} else {
		// If there was an error performing the CURL operation, then leave the response code blank.
		$code = '';
	}
	
	// Close our CURL session.
	curl_close($curl_handle);
	
	// Return our HTTP response code for the URL we accessed from the Ruskin server. This should usually be either 200 or 404.
	return $code;
}

function rstrpos($haystack, $needle, $offset){
	$size = strlen($haystack);
	$pos = strpos(strrev($haystack),$needle,$size-$offset);
	
	if($pos=== false){
		return false;
	}
	
	return $size - $pos;
	
}

// Attempt to open our directory.
if ($handle = opendir('xmlOLD')) {
	
	// Attempt to connect to the MySQL server.
	if (!$db_conn = mysqli_connect($servername, $username, $password)) {
		die("Failed to connect to the MySQL server: " . mysqli_connect_errno());
	} 
	
	// Define an array to the hold the names of the files in our directory.
	$files = array();
	
	// Loop through each file in our directory.
    while (false !== ($entry = readdir($handle))) {
		// Don't parse . or .. since these are directories.
        if ($entry != "." && $entry != "..") {
			// Add our file entry to the array.
			array_push($files, $entry);
		}
	}
	
	// Count the total number of XML files we have.
	$total_files = count($files);
	
	// Keep track of which XML file we are on.
	$current_file = 0;
	
	// Keep track of the files that were successfully added to the database.
	$success_count = 0;
	
	// Keep track of the files that were skipped due to malformed XML.
	$malformed_count = 0;
	
	// Keep track of the files that were missing on the site.
	$missing_count = 0;
	
	// Keep track of the database errors.
	$database_errors = 0;
	
	echo '<h2>Ruskin XML parser</h2><h3>Parsing ' . $total_files . ' XML files</h3>';
	
	// Iterate through the files in our directory.
	foreach ($files AS $entry) {
		// Print 64k spaces so that our output buffer reaches the necessary size to be flushed to the browser.
		echo str_repeat(' ', 4096);
		
		// Path to XML file.
		$filename = $xml_folder . $entry;
		
		$current_file++;
		echo '<br />Progress: <b>' . round($current_file / $total_files * 100, 1) .  '%</b> ';
		
		// Skip the XML file if it has malformed code.
		if (($stuff = simplexml_load_file($filename)) === FALSE) {
			echo "<span style='color: red; font-weight: bold;'>FAILED: '" . $filename . "' (malformed XML)</span>";
			$malformed_count++;
			continue;
		}
		
		// Get doctype.
		$doctype = $stuff->teiHeader->attributes();
		
		// Get title.
		$title = $stuff->teiHeader->fileDesc->titleStmt->title;
		
		// Check if div exists.
		if ($stuff->text->body->div !== NULL) {
			// Get divtype if div exists.
			$divtype = $stuff->text->body->div->attributes()->type;
			$subtype = $stuff->text->body->div->attributes()->subtype;
		} else {
			// Make divtype blank if it does not exist.
			$divtype = '';
			$subtype = '';
		}
		
		// Check if this is a poem.
		if ($divtype == 'poem') {
			// If this is a poem, get poem info.
			$ispoem = '1';
			$meter = $stuff->text->body->div->attributes()->met;
			$rhyme = $stuff->text->body->div->attributes()->rhyme;
		} else {
			// If this is not a poem, set poem info to defaults.
			$ispoem = '0';
			$meter = '';
			$rhyme = '';
		}
		
		// Open the file and extract "body text"
		$rawTextStuff = file_get_contents($filename);
		
		// Get start position of the text tag.
		$start = strpos($rawTextStuff, '<text>');
		
		// Get the end position of the text tag.
		$end = strpos($rawTextStuff, '</text>');
		
		// Check that the start and end positions were successfully retrieved.
		if ($start !== FALSE AND $end !== FALSE) {
			$text = substr($rawTextStuff, $start + 6, $end-$start -6);
		} else {
			$text = '';
		}
		
		
		
		// Determine the URL of the file on the website.
		$url = construct_url($filename, $divtype);
		
		// Determine whether the requested URL exists.
		$code = get_response($url);
		
		/*
		echo "<br /><br />filename: " . $filename;
		echo "<br />Doctype: " . $doctype;
		echo "<br />Title: " . $title;
		echo "<br />divtype: " . $divtype;
		echo "<br />subtype: " . $subtype;
		echo "<br />Text (length): " . strlen($text);
		echo "<br />Is Poem: " . $ispoem;
		echo "<br />Meter: " . $meter;
		echo "<br />Rhyme: " . $rhyme;
		echo "<br />URL: " . $url;
		echo "<br />Code: '" . $code . "'";
		*/
		
		if ($code != '200') {
			echo "<span style='color: red; font-weight: bold;'>FAILED '" . $filename . "' (missing)</span>";
			$missing_count++;
			continue;
		}
		
		// Constrcut an SQL query to insert the document into the MySQL database.
		$insert = "INSERT INTO `" . $db_conn->real_escape_string($database) . "`.`documents` (
			`title`,
			`doctype`,
			`divtype`,
			`subtype`,
			`rhyme`,
			`meter`,
			`ispoem`,
			`text`,
			`url`
		) VALUES (
			'" . $db_conn->real_escape_string($title) . "',
			'" . $db_conn->real_escape_string($doctype) . "',
			'" . $db_conn->real_escape_string($divtype) . "',
			'" . $db_conn->real_escape_string($subtype) . "',
			'" . $db_conn->real_escape_string($rhyme) . "',
			'" . $db_conn->real_escape_string($meter) . "',
			'" . $db_conn->real_escape_string($ispoem) . "',
			'" . $db_conn->real_escape_string($text) . "',
			'" . $db_conn->real_escape_string($url) . "'
		);";
		
		// Perform the MySQLi query.
		if (mysqli_query($db_conn, $insert)) {
			echo "<span style='color: green; font-weight: bold;'>SUCCESS: '" . $filename . "'</span>";
			$success_count++;
		} else {
			// If there was an error performing the query, output the error.
			echo "<span style='color: red; font-weight: bold;'>There was an error with the MySQLi query: " . $db_conn->error . "</span>";
			$database_errors++;
		}
		
		
		$strdivpos = strpos($text,'<div');
		$enddivpos = strpos($text,'>',$strdivpos);
		$text = substr($text,$enddivpos + 1);	
		$counter = 0;
		
		while(strpos($text, 'corresp="') !== false){
			$corresplocation = strpos($text,'corresp="');
			$leftbcklocation = rstrpos($text, '<' , $corresplocation);
			$rightbcklocation = strpos($text, '>', $corresplocation);
			$keyword = substr($text, $leftbcklocation - 1, ($rightbcklocation - $leftbcklocation)+2);
			echo "\n".$keyword;
			$text= substr($text, $rightbcklocation +1);

		}
/* 		while(strpos($text, '<') !== false){
			//echo "\n\n\n\n\n".$counter;
			$counter ++;
			$strtagpos = strpos($text,'<');
			
			//checks if is is a comment & skips it
			if(substr($text,$strtagpos + 1,1)=='!'){
				$endbrckpos = strpos($text,'->')+1;
				$text = substr($text,$endbrckpos);
				continue;
			}			
			//echo "\n".$strtagpos;
			//echo $strtagpos;
			//echo "\n";
			//die();
			$endbrckpos = strpos($text,'>')+ $strtagpos;
			//echo "\n".$endbrckpos;			
			
			$keyword = substr($text, $strtagpos, ($endbrckpos - $strtagpos)+1);				
			$text = substr($text,$endbrckpos);

		
			if(strpos($keyword,'corresp="') !== false){
				echo "true";
				$strtag = strpos($keyword,'<');
				$endtag = strpos($keyword, ' ') - 1;
				$tag = substr($keyword, $strtag+1, $endtag - $strtag);
				
				//echo "\n".$keyword."\n";
			} else {
				//echo "false";
				continue;
			}
	
		} */
		
		
		
	
		
		
		
		
    }
	
	// Show some stats about the parsed files.
	echo '<h2>Parsing complete!</h2>
	<b>Stats:
	<br />Successful files: ' . $success_count . '
	<br />Files skipped due to malformed XML: ' . $malformed_count . '
	<br />Files skipped that were missing on website: ' . $missing_count . '
	<br />Database errors: ' . $database_errors . '</b>';
	
	// Close the connection to our MySQL server.
	mysqli_close($db_conn);
	
	// Close our directory handle.
    closedir($handle);
} else {
	// Output an error message if the XML directory couldn't be opened.
	echo "Sorry, there was an error opening the XML directory. Check your code!";
}


//loop through all files
// Example #2 in the PHP documentation shows how to loop through all of the files in a directory: http://php.net/manual/en/function.readdir.php

  //open file
  // Examples #1 and #2 explain how to read the contents of a file and print them to the screen: http://php.net/manual/en/function.file-get-contents.php
  
  //extract information from document
  // We will need the following PHP functions to extract information from our XML documents:
  // substr: http://php.net/manual/en/function.substr.php
  // strlen: http://php.net/manual/en/function.strlen.php
  // strpos: http://php.net/manual/en/function.strpos.php
  // simplexml_load_file: http://php.net/manual/en/function.simplexml-load-file.php
  // json_encode: http://php.net/manual/en/function.json-encode.php
  // json_decode: http://php.net/manual/en/function.json-decode.php
  
  
  //extract title
  //extract doctype                                       
  //extract meter
  //extract rhyme
  //extract text
  //extract url
  
  //insert into document table
  // MySQL insert command: http://www.w3schools.com/php/php_mysql_insert.asp
  
    //start loop to grab all tags
    //extract keywords from document
    //extract tag
    //extract subtag
    //extract content
    //insert into keyword table with corrs docid
    //end tag loop
   
//end loop
?>
