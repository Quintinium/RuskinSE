<?php
//program to populate search database
//authors: Elena, Garth

//open directory with xml files

// Turn off output buffering so output is immediately printed to the screen rather than waiting until the entire page finishes downloading.
ob_implicit_flush(1);

if ($handle = opendir('xml')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
			
			$filename = "xml/" . $entry;
			
			// Skip the XML file if it has malformed code.
            if (($stuff = simplexml_load_file($filename)) === FALSE) {
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
			
			
			
			// Open the file as raw text for getting the "body text."
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
			
			
			
			// Construct URL.
			$url = 'http://english.selu.edu/humanitiesonline/ruskin/';
			
			if ($divtype == 'note') {
				$url .= 'notes/';
			} elseif ($divtype == 'apparatus') {
				$url .= 'apparatuses/';
			} elseif ($divtype == 'title') {
				$url .= 'witnesses/';
			}
			
			$url .= str_replace('xml', 'php', $entry);
			
			
			
			// See if the file exists or if there is a 404.
			$curl_handle = curl_init();
			
			curl_setopt($curl_handle, CURLOPT_URL, $url);
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 3);
			
			// Wait a second between requests;
			sleep(1);
			curl_exec($curl_handle);
			
			if (!curl_errno($curl_handle)) {
				$connection_info = curl_getinfo($curl_handle);
				$code = $connection_info['http_code'];
			} else {
				$code = '';
			}
			
			curl_close($curl_handle);
			
			
			
			
			
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
			echo "<br />Code: " . $code;
			
			if ($code != '200') {
				echo " - SKIPPING since file does not exist on actual website";
				continue;
			}
			
 			
			$servername = 'localhost';
			$username = 'root';
			$password = 'Killer5740.';
			$database = 'ruskin';
			
			//Create a connection
			$conn = mysqli_connect($servername,$username,$password,$database);
			
			//check connection
			if(mysqli_connect_errno()){
				die("Failed to connect to MySQL: ".mysqli_connect_errno());
			}
			
			
			//perform queries
			//mysqli_query($conn,"SELECT*FROM documents");
			
			$insert = "INSERT INTO `ruskin`.`documents` (
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
				'" . $conn->real_escape_string ($title) . "',
				'" . $conn->real_escape_string ($doctype) . "',
				'" . $conn->real_escape_string ($divtype) . "',
				'" . $conn->real_escape_string ($subtype) . "',
				'" . $conn->real_escape_string ($rhyme) . "',
				'" . $conn->real_escape_string ($meter) . "',
				'" . $conn->real_escape_string ($ispoem) . "',
				'" . $conn->real_escape_string ($text) . "',
				'" . $conn->real_escape_string ($url) . "'
			);";
			
			// Perform the MySQLi query.
			if (!mysqli_query($conn,$insert)) {
				// If there was an error performing the query, output the error.
				echo "<br />There was an error with the MySQLi query: " . $conn->error;
			} else {
				echo "<br />Entry was successfully added to the database!";
			}

			mysqli_close($conn);
			
			
			// Print 64k spaces so that our output buffer reaches the necessary size to be flushed to the browser.
			echo str_repeat(' ',1024*64);
        }
    }
    closedir($handle);
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
