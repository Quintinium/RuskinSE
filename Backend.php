<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Ruskin Search</title>
	</head>
	<body>
		<form method="POST">
			Keyword(s): <input type="text" name="keyword"><br /><br />
			<input type="checkbox" name="is_poem_document" value="true"> Is a poem?<br />
			<input type="checkbox" name="activate_document_filter" value="true">Show documents that are:
			<select name="divtype_document"> 
				<option value="apparatus">Apparatus</option>
				<option value="poem">Poem</option>
				<option value="note">Note</option>
			</select><br />
			<input type="checkbox" name="full_text_of_document" value="true"> Search full text<br />
			<input type="checkbox" name="activate_tag_filter" value="true">Show results if keyword is a:
			<select name="tag_keywords">				
				<option value="persName">Person Name</option>
				<option value="geogName">Geographical Name</option>
				<option value="placeName">Place Name</option>
				<option value="orgName">Organization Name</option>
				<option value="title">Title</option>
				<option value="name">Name</option>
				<option value="date">Date</option>
			</select>
			of a: 
			<select name="type_keywords">
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
				<!--<option value="peom">Peom</option> spelling error?-->
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
			<input type="submit" name="submit" value=" Search ">
		</form>
<?php

// MySQL server credentials.
$servername = 'localhost';
$username = 'root';
$password = 'zxcvbnm';
$database = 'ruskin';

mysql_connect($servername, $username, $password);
mysql_select_db($database);

if (isset($_POST['keyword'])) {
	echo '<br />';
	echo "Keyword: " . $_POST['keyword'];
	echo '<br />';
	
	echo 'Poem: ';
	
	if (isset($_POST['is_poem_document'])) {
		echo 'Exist';
	} else {
		echo 'Failed';
	}
	
	echo'<br />Document Filter: ';
	
	if (isset($_POST['activate_document_filter'])) {
		echo 'Exist';
	} else {
		echo 'Failed';
	}	
	
	echo '<br />Divtype Document: ' . $_POST['divtype_document'];
	
	echo '<br />Full Text: ';
	
	if (isset($_POST['full_text_of_document'])) {
		echo 'Exist';
	} else {
		echo 'Failed';
	}
	
	echo '<br />Tag Filter: '; 
	
	if (isset($_POST['activate_tag_filter'])) {
		echo 'Exist';
	} else {
		echo 'Failed';
	}
	
	echo '<br />Tag Keyword: ' . $_POST['tag_keywords'] . '<br />Type Keyword: ' . $_POST['type_keywords'];
			
	$results = mysql_query("SELECT * FROM `documents` WHERE `text` LIKE '%" . mysql_real_escape_string($_POST['keyword']) . "%' ORDER BY `documents`.`title` DESC");
	
	echo '<div class="container results-container">
	<h2>Search results for <span class="italic">"Ruskin"</span> :</h2>
			<div class="divider"></div>';
			
	while ($row = mysql_fetch_assoc($results)) {
		echo '<div class="result-container">
				<b>Location:</b> <a class="italic" href="' . $row['url'] . '">' . $row['url'] . '</a><br />
				<b>Matching text:</b> <span class="italic">' . $_POST['keyword'] . '</span><br />
				<b>Document type:</b> ' . $row['divtype'] . '
			</div>';
	}
	echo '</div>';
}

?>
	</body>
</html>