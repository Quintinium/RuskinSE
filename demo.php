<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Ruskin Search</title>
		<style>
			body {
				font-family: 'Open Sans', sans-serif;
				padding: 20px;
				background: #ccc;
			}
			
			.container {
				border: 1px solid #999;
				border-radius: 10px;
				padding: 15px;
				margin-top: 20px;
				background: #eee;
				width: 600px;
				margin-left: auto;
				margin-right: auto;
				box-shadow: 3px 3px 5px #666;
			}
			
			.results-container {
				border-radius: 0px;
			}
			
			.results-container h2 {
				margin-top: 0px;
			}
			
			.result-container {
				border: 1px solid #999;
				border-radius: 5px;
				background: #ddd;
				padding: 5px;
				margin: 10px;
			}
			
			.keyword-textbox {
				background: -webkit-linear-gradient(to bottom right, #bbb, #fff);
				background: -o-linear-gradient(to bottom right, #bbb, #fff);
				background: -moz-linear-gradient(to bottom right, #bbb, #fff);
				background: linear-gradient(to bottom right, #bbb, #fff);
				border-radius: 5px;
				border: 1px solid #444;
				padding: 5px;
				font-size: medium;
				box-shadow: inset 1px 1px 6px #666;
				color: #000;
				text-shadow: 1px 1px 1px #fff;
				width: 15em;
				outline: none;
			}
			
			.keyword-textbox {
				width: 20em;
				-webkit-transition: width .5s ease-in-out;
				-moz-transition: width .5s ease-in-out;
				-o-transition: width .5s ease-in-out;
				transition: width .5s ease-in-out;
			}
			
			.divider {
				height: 1px;
				background: #000;
			}
			
			input::-webkit-input-placeholder {
				color: #666;
				text-shadow: 1px 0px 1px #fff;
				font-style: italic;
			}
			
			input:-moz-placeholder {
				color: #666;
				text-shadow: 1px 0px 1px #fff;
				font-style: italic;
			}
			
			input::-moz-placeholder {
				color: #666;
				text-shadow: 1px 0px 1px #fff;
				font-style: italic;
			}
			
			input:-ms-input-placeholder {
				color: #666;
				text-shadow: 1px 0px 1px #fff;
				font-style: italic;
			}
			
			input[type=submit] {
				border-radius: 15px;
				background: -webkit-linear-gradient(to bottom right, #fff, #ccc);
				background: -o-linear-gradient(to bottom right, #fff, #ccc);
				background: -moz-linear-gradient(to bottom right, #fff, #ccc);
				background: linear-gradient(to bottom right, #fff, #ccc);
				padding: 6px;
				border: 1px solid #666;
				box-shadow: 4px 3px 5px #aaa;
				outline: none;
			}
			
			input[type=submit]:active {
				box-shadow: -1px -1px 5px #aaa;
			}
			
			.italic {
				font-style: italic;
			}
			
			.pages-container {
				padding: 10px;
			}
			
			.page {
				background: -webkit-linear-gradient(to bottom right, #fff, #ccc);
				background: -o-linear-gradient(to bottom right, #fff, #ccc);
				background: -moz-linear-gradient(to bottom right, #fff, #ccc);
				background: linear-gradient(to bottom right, #fff, #ccc);
				padding: 3px;
				margin: 2px;
				border: 1px solid #666;
				box-shadow: 1px 1px 0px #aaa;
				text-decoration: none;
				color: #000;
			}
			
			.date {
				width: 80px;
			}
		</style>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<h1>Ruskin Search:</h1>
		<span>This is a mockup design of the search engine for the Ruskin project. Please keep in mind this is intended mainly as a design reference - it is not yet functional.</span>
		<div class="container">
			<form method="POST">
				Keyword(s): <input type="text" name="keyword" class="keyword-textbox" placeholder="Enter a person, place, location..."><br /><br />
				<input type="submit" name="submit" value=" Search ">
			</form>
		</div>
<?php

// Load MySQL credentials from config file.
include('config.php');

mysql_connect($servername, $username, $password);
mysql_select_db($database);

if (isset($_POST['keyword'])) {
	$results = mysql_query("SELECT * FROM `ruskin`.`documents` WHERE `text` LIKE '%" . mysql_real_escape_string($_POST['keyword']) . "%';");
	
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