<?php
//program to populate search database
//authors: Elena, Garth

//open directory with xml files
if ($handle = opendir('xmlOLD')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
			
			$filename = "xmlOLD/" . $entry;
			
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
			
			
			
			echo "\n\nfilename: " . $filename;
			echo "\nDoctype: " . $doctype;
			echo "\nTitle: " . $title;
			echo "\ndivtype: " . $divtype;
			echo "\nsubtype: " . $subtype;
			echo "\nText (length): " . strlen($text);
			echo "\nIs Poem: " . $ispoem;
			echo "\nMeter: " . $meter;
			echo "\nRhyme: " . $rhyme;
			echo "\nSubtype: " . $subtype;
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
