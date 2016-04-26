<?php
if ($_POST['is_poem_document']) {
	$poem_checkmark = 'checked';
} else {
	$poem_checkmark ='';
}
if ($_POST['full_text_of_document']) {
	$full_text_checkmark = 'checked';
} else {
	$full_text_checkmark ='';
}
if ($_POST['activate_tag_filter']) {
	$tag_filter_checkmark = 'checked';
} else {
	$tag_filter_checkmark ='';
}
if ($_POST['activate_document_filter']) {
	$document_filter_checkmark = 'checked';
} else {
	$document_filter_checkmark ='';
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0048)http://english.selu.edu/humanitiesonline/ruskin/ -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<title>The Early Ruskin Manuscripts, Advanced Search Results</title>
	<link href="http://english.selu.edu/humanitiesonline/ruskin/styles.css" rel="stylesheet" type="text/css">
	<link rel="icon" type="image/png" href="http://english.selu.edu/humanitiesonline/ruskin/images/ruskin_icon.png">
</head>
<body>
		<div class="navigation">
        <a href="http://english.selu.edu/humanitiesonline/ruskin/index.php"><img src="http://english.selu.edu/humanitiesonline/ruskin/images/ruskin_logo.jpg" width="100%"></a>
        <br>
		<br>
        <span class="navigation-title">
            The
            <br>Early
            <br>Ruskin
            <br>Manuscripts
            <div class="navigation-date">1826–1842</div>
        </span>
        <hr>
        <span class="navigation-editor"><a href="mailto:ruskinproject@selu.edu">David C. Hanson, Editor</a></span>
        <br>
		<br>
		<form action="http://localhost/Backend.php" method="post">
		<input type="text" name="keyword" placeholder="Search..." style="width: 120px;" />
		<input type="submit" name="submit" value="Go" style="width:35px;" />
		</form>
		<span><a class="subnavigation" href="http://localhost/search.php">Advanced Search</a><span>
		<br>
		<br>
        <span><a href="http://english.selu.edu/humanitiesonline/ruskin/index.php">Home</a><span>
        <span>
        	<br><a href="http://english.selu.edu/humanitiesonline/ruskin/essays/indices_essay.php">Indices</a>
            <br><a class="subnavigation" href="http://english.selu.edu/humanitiesonline/ruskin/essays/indices_essay.php#WORKS">Works</a>
            <br><a class="subnavigation" href="http://english.selu.edu/humanitiesonline/ruskin/essays/indices_essay.php#MANUSCRIPTS">Manuscripts</a>
            <br><a class="subnavigation" href="http://english.selu.edu/humanitiesonline/ruskin/essays/indices_essay.php#CORPORA">Corpora</a>
            <br><a class="subnavigation" href="http://english.selu.edu/humanitiesonline/ruskin/essays/indices_essay.php#WORKSBYOTHERS">Works by Others</a>
            <br><a class="subnavigation" href="http://english.selu.edu/humanitiesonline/ruskin/essays/indices_essay.php#COMMENTARY">Commentary</a>
            <br><a class="tion" href="http://english.selu.edu/humanitiesonline/ruskin/essays/indices_essay.php#ESSAYS">Essays</a>
        </span>
        <br>
		<span>XML</span>        <br>
		<span>Bibliography</span>
        <br>
        <span><a href="http://english.selu.edu/humanitiesonline/ruskin/webpages/staff.php">Staff and Support</a><span>
        <br>
        <span><a href="http://english.selu.edu/humanitiesonline/ruskin/webpages/legal.php">Legal</a><span>
		 <br>
	</span></span></span></span></span></span></span></span></div>
	
	<div class="content">
	
	<form action="http://localhost/Backend.php" method="post">
			<fieldset>
			<legend>Search</legend>
			Keyword(s): <input type="text" name="keyword" value="<?php echo $_POST['keyword']; ?>" /><input type="submit" name="submit" value=" Search " class="button"/><br /><br />
			<input type="checkbox" name="is_poem_document" value="true" id="is_poem_document" <?php echo $poem_checkmark; ?> /> Poem<br />
			<input type="checkbox" name="activate_document_filter" value="true" id="activate_document_filter" <?php echo $document_filter_checkmark; ?> />Show documents that are:
			<select name="divtype_document" id="divtype_document"> 
				<option value="apparatus">Apparatus</option>
				<option value="poem">Poem</option>
				<option value="note">Note</option>
			</select><br />
			<input type="checkbox" name="full_text_of_document" onclick="toggle()" id="full_text_of_document" value="true" <?php echo $full_text_checkmark; ?> /> Search full text<br />
			<input type="checkbox" name="activate_tag_filter" onclick="toggle()" id="activate_tag_filter" value="true" <?php echo $tag_filter_checkmark; ?>/>Show results if keyword is a:
			<select name="tag_keywords" id="tag_keywords">
				
				<option value="persName">Person Name</option>
				<option value="geogName">Geographical Name</option>
				<option value="placeName">Place Name</option>
				<option value="orgName">Organization Name</option>
				<option value="title">Title</option>
				<option value="name">Name</option>
				<option value="date">Date</option>
			</select>
			of a: 
			<select name="type_keywords" id="type_keywords">
				<option value="aa">Anything/Anyone</option>
				<option value="book">Book</option>
				<option value="poem">Poem</option>
				<option value="pen_name">Pen Name</option>
				<option value="periodical">Periodical</option>
				<option value="essay">Essay</option>
				<option value="bibliography">Bibliography</option>
				<option value="prose">Prose</option>
				<option value="archive">Archive</option>
				<option value="engraving">Engraving</option>
				<option value="collected_poems">Collected Poems</option>
				<option value="collected_sketches">Collected Sketches</option>
				<option value="anthology">Anthology</option>
				<option value="reference">Reference</option>
				<option value="biography">Biography</option>
				<option value="novel">Novel</option>
				<option value="magazine">Magazine</option>
				<option value="drama">Drama</option>
				<option value="collected_letters">Collected Letters</option>
				<option value="autobiography">Autobiography</option>
				<option value="bibliography_text">Bibliography Text</option>
				<option value="manuscript">Manuscript</option>
				<option value="program">Program</option>
				<option value="lesson">Lesson</option>
				<option value="gloss">Gloss</option>
				<option value="composite">Composite</option>
				<option value="sermon">Sermon</option>
				<option value="archive_digital">Archive Digital</option>
				<option value="archive_nondigital">Archive Non-Digital</option>
				<option value="series">Series</option>
				<option value="fictional">Fictional</option>
				<option value="story">Story</option>
				<option value="peom">Peom</option>
				<option value="architecture">Architecture</option>
				<option value="collected_works">Collected Works</option>
				<option value="painting">Painting</option>
				<option value="letter">Letter</option>
				<option value="guidebook">Guidebook</option>
				<option value="constellation">Constellation</option>
				<option value="book_chapter">Book Chapter</option>
				<option value="memoir">Memoir</option>
				<option value="composition">Composition</option>
				<option value="work">Work</option>
				<option value="scripture">Scripture</option>
				<option value="drawing">Drawing</option>
				<option value="collected_art">Collected Art</option>
				<option value="sketch">Sketch</option>
				<option value="map">Map</option>
				<option value="catalog_auction">Catalog Auction</option>
				<option value="dictionary">Dictionary</option>
				<option value="ana">Ana</option>
				<option value="collecte_poems">Collected Poems</option>
				<option value="tale">Tale</option>
				<option value="other">Other</option>
				<option value="article">Article</option>
			</select><br />
			</form>
		</fieldset>
		<script type ="text/javascript">
		document.onload = toggle()
		
		function toggle() {
			var full_text_of_document = document.getElementById('full_text_of_document');
			var activate_tag_filter = document.getElementById('activate_tag_filter');
			if (full_text_of_document.checked == true) {
				activate_tag_filter.disabled = true
				full_text_of_document.disabled = false
				tag_keywords.disabled = true
				type_keywords.disabled = true
				type_keywords.selectedIndex = 'aa'
			}
			if (activate_tag_filter.checked == true) {
				full_text_of_document.disabled = true
				activate_tag_filter.disabled = false
			}
			if (full_text_of_document.checked == false && activate_tag_filter.checked == false) {
				full_text_of_document.disabled = false
				activate_tag_filter.disabled = false
				tag_keywords.disabled = false
				type_keywords.disabled = false
			}
			console.log("Toggle function was called");
		}
		</script>
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

if (isset($_POST['keyword'])) {
	
	// Check to make sure the user searched for a keyword that is at least 3 characters long.
	if (strlen($_POST['keyword']) < 3) {
		die('<br /><span style="font-weight: bold; color: red;">Sorry, please try searching with a keyword that is at least 3 characters long.</span>');
	}
	
	// This is our base query. We will add constraints to make this query longer
	// depending on which filters are active.
	if (isset($_POST['full_text_of_document'])) {
		$query = "SELECT * FROM `documents` WHERE `documents`.`text` LIKE '%" . mysql_real_escape_string($_POST['keyword']) . "%' ";
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
		FROM `documents`, `keywords` WHERE `documents`.`id`=`keywords`.`docid` AND `keywords`.`content` LIKE '%" . mysql_real_escape_string($_POST['keyword']) . "%' ";
	}
	
	if (isset($_POST['is_poem_document'])) {
		$query .= "AND `documents`.`ispoem` = 1 ";
	}
	
	if (isset($_POST['activate_document_filter'])) {
		$query .= "AND `documents`.`divtype` LIKE '" . mysql_real_escape_string($_POST['divtype_document']) . "' ";
	}
	
	if (isset($_POST['activate_tag_filter']) AND !isset($_POST['full_text_of_document'])) {
		$query .= "AND `keywords`.`tag` LIKE '%" . mysql_real_escape_string($_POST['tag_keywords']) . "%' ";
	}
	
	if ($_POST['type_keywords'] !='aa' AND !isset($_POST['full_text_of_document'])){
		$query .= "AND `keywords`.`type` LIKE '%" . mysql_real_escape_string($_POST['type_keywords']) . "%' ";
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
	if (isset($_POST['page'])) {
		$startPage = ($_POST['page'] - 1) * 5;
	} else {
		$startPage = 0;
	}
	$query .= " LIMIT " . $startPage .",5";
	*/
	$results = mysql_query($query);
	
	echo '<div class="container results-container">
	<h2>Search results for <span class="italic">"' . $_POST['keyword'] . '"</span> :</h2>
	<h3>Found <span style="background-color: #94FF00;padding: 3px;font-weight: bold;">' . $numberOfResults['result'] . '</span> results in <span style="background-color: #94FF00;padding: 3px;font-weight: bold;">' . $numberOfDocuments['result'] . '</span> documents:</h3>
			<div class="divider"></div>';
			
	while ($row = mysql_fetch_assoc($results)) {
		if ($row['keyword'] == 'title') {
			$matchingText = $row['content'];
		} elseif (isset($_POST['full_text_of_document'])) {
			$row['text'] = html_entity_decode(strip_tags($row['text']));
			
			$matchLocation = stripos($row['text'], $_POST['keyword']);
			
			if ($matchLocation > 250) {
				$startLocation = $matchLocation - 250;
			} else {
				$startLocation = 0;
			}
			
			$row['text'] = substr($row['text'], $startLocation, 500);
			
			$startingSpace = strpos($row['text'], '>') + 1;
			$endingSpace = strrpos($row['text'], '<');
			
			$matchingText = '...' . trim(substr($row['text'], $startingSpace, $endingSpace - $startingSpace)) . '...';
			$matchingText = str_ireplace($_POST['keyword'], '<span style="background-color: #FFBF49;padding: 2px;font-weight: bold;">' . $_POST['keyword'] . '</span>', $matchingText);
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