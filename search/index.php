<?php

// Load MySQL credentials from config file.
include('config.php');

// Attempt to connect to the MySQL server.
if (!$db_conn = mysql_connect($servername, $username, $password)) {
	die("Failed to connect to the MySQL server: " . mysql_connect_errno());
}

// Attempt to connect to the database.
if (!mysql_select_db($database)) {
	die("Failed to select the database: " . $database);
}

function fixTag($tag) {
	$capitalizedTag = strtoupper(substr($tag, 0, 1)) . substr($tag, 1);
	
	$newTagNames = array(
		'GeogName' => 'Geographic Name',
		'PersName' => 'Person Name',
		'PlaceName' => 'Place Name',
		'OrgName' => 'Organization Name'
	);
	
	if (array_key_exists($capitalizedTag, $newTagNames)) {
		$capitalizedTag = $newTagNames[$capitalizedTag];
	}
	
	return $capitalizedTag;
}

if (isset($_GET['full_text_of_document']) AND $_GET['full_text_of_document'] == true) {
	$full_text_checkmark = 'checked';
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0048)http://english.selu.edu/humanitiesonline/ruskin/ -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<title>The Early Ruskin Manuscripts, Advanced Search Results</title>
	<link href="http://english.selu.edu/humanitiesonline/ruskin/styles.css" rel="stylesheet" type="text/css">
	<link href="searchStyle.css" rel="stylesheet" type="text/css">
	<link rel="icon" type="image/png" href="http://english.selu.edu/humanitiesonline/ruskin/images/ruskin_icon.png">
</head>
<body>
	<?php include("../navigation.inc.php"); ?>
		<form action="" method="get" style="background: white;">
			<fieldset>
				<legend>Advanced Search</legend>
				<div class="searchFields">
					<input type="text" name="keyword" placeholder="Search for a keyword or phrase..." onkeyup="fetchAutoComplete(this.value);" value="<?php echo $_GET['keyword']; ?>" autocomplete="off" style="
						width: 300px;
					" /><input type="submit" name="submit" value=" Search " /></br>
					<div id="autoCompleteResults" style="
						background: linear-gradient(gray, rgba(255, 255, 255, 0.25));
						top: 39px;
						position: absolute;
						left: 0px;
						width: 300px;
						padding: 10px;
						display: none;
					"></div>
					<input type="checkbox" name="full_text_of_document" onclick="toggle();" id="full_text_of_document" value="true" <?php echo $full_text_checkmark; ?> /> Search full text<br /><br />
					<select name="divtype_document" id="divtype_document"> 
						<option value="">Document Type</option>
						<?php
							$documentTypeDropdown = mysql_query("SELECT DISTINCT(`divtype`) FROM `documents` WHERE `divtype` != 'webpage';");
							while ($documentTypeRow = mysql_fetch_assoc($documentTypeDropdown)) {
								$capitalizedDocumentType = strtoupper(substr($documentTypeRow['divtype'], 0, 1)) . substr($documentTypeRow['divtype'], 1);
								
								echo '<option value="' . $documentTypeRow['divtype'] . '" ';
								
								if (isset($_GET['divtype_document']) AND $_GET['divtype_document'] == $documentTypeRow['divtype']) {
									echo 'selected';
								}
								
								echo '>' . $capitalizedDocumentType . '</option>';
							}
						?>
					</select><br />
					<select name="tag_keywords" id="tag_keywords" onchange="addSubtype(this.selectedIndex); toggle();">									
						<option value="">Keyword Type</option>
						<?php
							$tagDropdown = mysql_query("SELECT DISTINCT(`tag`) FROM `keywords` WHERE `tag` != 'ref' AND `tag` != 'cell' AND `tag` != 'date';");
							while ($tagRow = mysql_fetch_assoc($tagDropdown)) {
								echo '<option value="' . $tagRow['tag'] . '" ';
								
								if (isset($_GET['tag_keywords']) AND $_GET['tag_keywords'] == $tagRow['tag']) {
									echo 'selected';
								}
								
								echo '>' . fixTag($tagRow['tag']) . '</option>';
							}
						?>
					</select>
						<?php
							$tagDropdown = mysql_query("SELECT DISTINCT(`tag`) FROM `keywords` WHERE `tag` != 'ref' AND `tag` != 'cell' AND `tag` != 'date';");
							
							$subtypeCounter = 0;
							$makeAppear = 0;
							
							while ($tagRow = mysql_fetch_assoc($tagDropdown)) {
								$subtypeCounter++;
								
								$subtypeDropdown = mysql_query("SELECT DISTINCT(`type`) FROM `keywords` WHERE `tag` LIKE '" . mysql_real_escape_string($tagRow['tag']) . "' AND `type` NOT LIKE '';");
								
								if (mysql_num_rows($subtypeDropdown) > 0) {
									echo '<select class="subtype" name="type_keywords' . $subtypeCounter . '" id="type_keywords' . $subtypeCounter . '">
											<option value="">Type of ' . fixTag($tagRow['tag']) . '</option>';
									
									if (isset($_GET['type_keywords']) AND $_GET['type_keywords'] == '' AND isset($_GET['tag_keywords']) AND $_GET['tag_keywords'] == $tagRow['tag']) {
										$makeAppear = $subtypeCounter;
									}
									
									while ($subtypeRow = mysql_fetch_assoc($subtypeDropdown)) {
										$capitalizedType = strtoupper(substr($subtypeRow['type'], 0, 1)) . substr($subtypeRow['type'], 1);
										$capitalizedType = str_replace('_', ' ', $capitalizedType);

										echo "\n" . '<option value="' . $subtypeRow['type'] . '" ';
										
										if (isset($_GET['type_keywords']) AND $_GET['type_keywords'] == $subtypeRow['type']) {
											echo 'selected';
											$makeAppear = $subtypeCounter;
										}
										
										echo '>' . $capitalizedType . '</option>';
									}

									echo "\n" . '</select>' . "\n";
								}
							}
						?>
				</div>
			</fieldset>
		</form>

	<div class="content">
	
	
		<script type ="text/javascript">
		document.onload = toggle();
		document.onload = makeAppear();
		
		function toggle() {
			var full_text_of_document = document.getElementsByName('full_text_of_document')[0];
			var tag_keywords_filter = document.getElementsByName('tag_keywords')[0];
			
			if (tag_keywords_filter.selectedIndex != 0) {
				full_text_of_document.disabled = true;
			}
			
			if (full_text_of_document.checked == true) {
				tag_keywords_filter.disabled = true;
				addSubtype();
			}
			
			if (tag_keywords_filter.selectedIndex == 0 && full_text_of_document.checked == false) {
				full_text_of_document.disabled = false;
				tag_keywords_filter.disabled = false;
			}
			
			console.log("Toggle function was called");
		}
		
		function fetchAutoComplete(searchTerm) {
			var resultBox = document.getElementById("autoCompleteResults");
			
			if (searchTerm.length > 0) {
				var xhttp = new XMLHttpRequest();
				
				xhttp.onreadystatechange = function() {
					if (xhttp.readyState == 4 && xhttp.status == 200) {
						resultBox.innerHTML = xhttp.responseText;
						resultBox.style.display = 'block';
					}
				};
				
				xhttp.open("POST", "autocomplete.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.send("autoComplete=" + searchTerm);
				console.log("Sent an autocomplete request for term: " + searchTerm);
			} else {
				resultBox.style.display = 'none';
			}
		}
		
		function addSubtype(indexOfElement) {
			var totalSubtypes = <?php echo $subtypeCounter; ?>;
			
			if (typeof oldId == "undefined") {
				oldId = 0;
			}
			
			if (oldId != 0) {
				document.getElementsByName('type_keywords')[0].name = 'type_keywords' + oldId;
			}
			
			for (var i = 1; i <= totalSubtypes; i++) {
				if (document.getElementsByName('type_keywords' + i)[0] != null) {
					document.getElementsByName('type_keywords' + i)[0].style.display = 'none';
					document.getElementsByName('type_keywords' + i)[0].selectedIndex = 0;
				}
			}
			
			if (document.getElementsByName('type_keywords' + indexOfElement)[0] != null) {
				document.getElementsByName('type_keywords' + indexOfElement)[0].style.display = 'initial';
				document.getElementsByName('type_keywords' + indexOfElement)[0].name = 'type_keywords';
				oldId = indexOfElement;
			} else {
				oldId = 0;
			}
		}
		
		function makeAppear() {
			var makeAppearNum = <?php echo $makeAppear; ?>;
			console.log('Make this id appear ' + makeAppearNum);
			if (typeof oldId == "undefined") {
				oldId = 0;
			}
			
			document.getElementsByName('type_keywords' + makeAppearNum)[0].style.display = 'initial';
			document.getElementsByName('type_keywords' + makeAppearNum)[0].name = 'type_keywords';
			oldId = makeAppearNum;
		}
		</script>
<?php

if (isset($_GET['keyword'])) {
	
	// Check to make sure the user searched for a keyword that is at least 3 characters long.
	if (strlen($_GET['keyword']) < 3) {
		die('<br /><span style="font-weight: bold; color: red;">Sorry, please try searching with a keyword that is at least 3 characters long.</span>');
	}
	
	// This is our base query. We will add constraints to make this query longer
	// depending on which filters are active.
	if (isset($_GET['full_text_of_document'])) {
		$query = "SELECT * FROM `documents` WHERE `documents`.`text` LIKE '%" . mysql_real_escape_string($_GET['keyword']) . "%' ";
	} else {
		$query = "SELECT
		`documents`.`id`,
		`documents`.`title`,
		`documents`.`doctype`,
		`documents`.`divtype`,
		`documents`.`subtype`,
		`documents`.`rhyme`,
		`documents`.`meter`,
		`documents`.`ispoem`,
		`documents`.`text`,
		`documents`.`url`,
		`keywords`.`tag`,
		`keywords`.`type`,
		`keywords`.`corresp`,
		`keywords`.`content`
		FROM `documents`, `keywords` WHERE `documents`.`id`=`keywords`.`docid` AND `keywords`.`content` LIKE '%" . mysql_real_escape_string($_GET['keyword']) . "%' ";
	}
	
	if (isset($_GET['divtype_document']) AND $_GET['divtype_document'] != '') {
		$query .= "AND `documents`.`divtype` LIKE '" . mysql_real_escape_string($_GET['divtype_document']) . "' ";
	}
	
	if (isset($_GET['tag_keywords']) AND $_GET['tag_keywords'] != '' AND !isset($_GET['full_text_of_document'])) {
		$query .= "AND `keywords`.`tag` LIKE '%" . mysql_real_escape_string($_GET['tag_keywords']) . "%' ";
	}
	
	if (isset($_GET['type_keywords']) AND $_GET['type_keywords'] !='' AND !isset($_GET['full_text_of_document'])){
		$query .= "AND `keywords`.`type` LIKE '%" . mysql_real_escape_string($_GET['type_keywords']) . "%' ";
	}

	// Finds all poems, and then from these peoms, search for the ones with a title containing "Calais"
	// SELECT * FROM (SELECT * FROM `documents` WHERE `ispoem` = '1') AS my_first_query WHERE `title` LIKE '%Calais%'
	
	// SELECT * FROM `keywords` WHERE `docid` IN (SELECT `id` AS `docid` FROM `documents` WHERE `ispoem` = 1) AND `tag` LIKE '%persName%'
	// Look in the documents table, and find all documents that are peoms. Then grab the id, and rename this to docid. Then using this list of docids, fetch all keywords
	// that exist in one of those documents IF that keyword is a persName keyword.
	
	// SELECT * FROM `documents`, `keywords` WHERE `documents`.`id`=`keywords`.`docid` AND `documents`.`ispoem` = 1 AND `keywords`.`tag` LIKE '%persName%'
	// Here is an easier implementation of the query above.
	
	//echo 'Here is our query: ' . $query;
	
	$numberOfDocuments = mysql_fetch_assoc(mysql_query("SELECT COUNT(DISTINCT(`id`)) AS `result` FROM (" . $query . ") AS my_first_query "));
	$numberOfResults = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `result` FROM (" . $query . ") AS my_first_query "));
	
	/*
	if (isset($_GET['page'])) {
		$startPage = ($_GET['page'] - 1) * 5;
	} else {
		$startPage = 0;
	}
	$query .= " LIMIT " . $startPage .",5";
	*/
	
	if ($numberOfResults > 10) {
		
	}
	$results = mysql_query($query);
	
	echo '<div class="container results-container">
	<h2>Search results for <span class="italic">"' . $_GET['keyword'] . '"</span> :</h2>
	<h3>Found <span style="background-color: #94FF00;padding: 3px;font-weight: bold;">' . $numberOfResults['result'] . '</span> results in <span style="background-color: #94FF00;padding: 3px;font-weight: bold;">' . $numberOfDocuments['result'] . '</span> documents:</h3>
			<div class="divider"></div>';
			
	while ($row = mysql_fetch_assoc($results)) {
		if ($row['keyword'] == 'title') {
			$matchingText = $row['content'];
		} elseif (isset($_GET['full_text_of_document'])) {
			$row['text'] = html_entity_decode(strip_tags($row['text']));
			
			$matchLocation = stripos($row['text'], $_GET['keyword']);
			
			if ($matchLocation > 250) {
				$startLocation = $matchLocation - 250;
			} else {
				$startLocation = 0;
			}
			
			$row['text'] = substr($row['text'], $startLocation, 500);
			
			$startingSpace = strpos($row['text'], '>') + 1;
			$endingSpace = strrpos($row['text'], '<');
			
			$matchingText = '...' . trim(substr($row['text'], $startingSpace, $endingSpace - $startingSpace)) . '...';
			$matchingText = str_ireplace($_GET['keyword'], '<span style="background-color: #FFBF49;padding: 2px;font-weight: bold;">' . $_GET['keyword'] . '</span>', $matchingText);
		} else {
			$row['text'] = html_entity_decode(strip_tags($row['text']));
			
			$matchLocation = stripos($row['text'], $row['content']);
			
			if ($matchLocation > 250) {
				$startLocation = $matchLocation - 250;
			} else {
				$startLocation = 0;
			}
			
			$row['text'] = substr($row['text'], $startLocation, 500);
			
			$startingSpace = strpos($row['text'], '>') + 1;
			$endingSpace = strrpos($row['text'], '<');
			
			$matchingText = '...' . trim(substr($row['text'], $startingSpace, $endingSpace - $startingSpace)) . '...';
			$matchingText = str_ireplace($row['content'], '<span style="background-color: #FFBF49;padding: 2px;font-weight: bold;">' . $row['content'] . '</span>', $matchingText);
		}
		
		echo '<div style="background: #eee;padding: 15px;border-radius: 8px;border: 1px solid #aaa;margin-bottom: 10px;">
				<span style="font-size: 18px;color: #609;"><a href="' . $row['url'] . '">' . $row['title'] . '</a></span><br />
				<span style="margin-top: 10px; margin-bottom: 10px;display: block;"><b>Document type:</b> ' . $row['divtype'] . '</span>
				<span style="font-style: italic;">"' . $matchingText . '"</span><br />
			</div>';
	}
	echo '</div>';
	
}

?></div>
	</body>
</html>