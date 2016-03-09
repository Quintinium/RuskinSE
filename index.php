<?php
//program to populate search database
//authors: Elena, Garth

//open directory with xml files
if ($handle = opendir('xml')) {

    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
			
			$filename = "xml/" . $entry;
			
            $stuff = simplexml_load_file($filename);
			  if($stuff==false) {
          continue;
          }
			$doctype = $stuff->teiHeader->attributes();
			
			$title = $stuff->teiHeader->fileDesc->titleStmt->title;
			
      if(isset($stuff->text->body->div)){
        $divtype = $stuff->text->body->div->attributes()->type;
      } else {
        $divtype = '';
        continue;
      }
			//$divtype = $stuff->text->body->div->attributes()->type;
			
			
			$rawTextStuff = file_get_contents($filename);
			$start = strpos($rawTextStuff, '<text>');
			$end = strpos($rawTextStuff, '</text>');
			//echo substr($rawTextStuff, $start + 6, $end-$start -6);
			
			
			$text = '';
			foreach ($stuff->text->body->div->p AS $p) {
				$text .= $p;
			}
			
			
			if ($divtype == 'poem') {
				$meter = $stuff->text->body->div->attributes()->met;
				$rhyme = $stuff->text->body->div->attributes()->rhyme;
			} else {
				$meter = '';
				$rhyme = '';
			}
			
			
			//var_dump($stuff->text->body->div->attributes());
			
			if ($stuff->text->body->div->attributes()->subtype !== NULL) {
				$subtype = $stuff->text->body->div->attributes()->subtype;
			} else {
				$subtype = '';
			}
			
			
			echo "\n\nfilename: " . $filename;
			echo "\nDoctype: " . $doctype;
			echo "\ndivtype: " . $divtype;
			echo "\nsubtype: " . $subtype;
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
