<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0048)http://english.selu.edu/humanitiesonline/ruskin/ -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<title>The Early Ruskin Manuscripts, Advanced Search Results</title>
	<link href="./The Early Ruskin Manuscripts, 1826–1842_files/styles.css" rel="stylesheet" type="text/css">
	<link rel="icon" type="image/png" href="http://english.selu.edu/humanitiesonline/ruskin/images/ruskin_icon.png">
</head>
<body>
		<div class="navigation">
        <a href="http://english.selu.edu/humanitiesonline/ruskin/index.php"><img src="./The Early Ruskin Manuscripts, 1826–1842_files/ruskin_logo.jpg" width="100%"></a>
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
        <span><a href="http://localhost/search.php">Search</a><span>
	</span></span></span></span></span></span></span></span></div>	
<?php

// MySQL server credentials.
$servername = 'localhost';
$username = 'root';
$password = 'kev#dr16';
$database = 'ruskin';

mysql_connect($servername, $username, $password);
mysql_select_db($database);

if (isset($_POST['keyword'])) {
	echo '<br />';
	echo "Keyword: " . $_POST['keyword'];
	echo '<br />';
	
	echo 'Poem: ';
	
	$query = 'SELECT * FROM `documents` WHERE ';
	$filter = 0;	
	
	if (isset($_POST['is_poem_document'])) {
		$query .= '`ispoem` = 1 AND ';
		$filter++;
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

	if ($filter > 0){
	$query = substr($query, 0, -4);
	}
	echo $query;
	
	// Finds all poems, and then from these peoms, search for the ones with a title containing "Calais"
	// SELECT * FROM (SELECT * FROM `documents` WHERE `ispoem` = '1') AS my_first_query WHERE `title` LIKE '%Calais%'
	
	
	// SELECT * FROM `keywords` WHERE `docid` IN (SELECT `id` AS `docid` FROM `documents` WHERE `ispoem` = 1) AND `tag` LIKE '%persName%'
	// Look in the documents table, and find all documents that are peoms. Then grab the id, and rename this to docid. Then using this list of docids, fetch all keywords
	// that exist in one of those documents IF that keyword is a persName keyword.
	
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