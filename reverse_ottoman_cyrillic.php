<?php

include("functions.php");

//load the rules text file
//this functin define in functions.php
$rules = get_the_rules("ottoman_cyrillic_rules.txt");

//get metadata information from the $_POST
$title = $_POST['title'];
if(!$title) $htitle = "untitled"; else $htitle = $title;
$author = $_POST['author'];
$date = $_POST['date'];
$responsibility = $_POST['responsibility'];

//check and see if a file was uploaded
if ($_FILES["file"]["error"] > 0) {
  $file = false;
  } else {
  $file = $_FILES["file"]["tmp_name"];
  }

//if a file was uploaded, append it to the text area content
if($file != false) {
	$input = $_POST['area'] . file_get_contents($file);
	} else {
	$input = $_POST['area'];
	}

//insert a leadind space
$input = " " . $input;

//count the number of tags like <stuff> and store them for later
preg_match_all('/<(.*?)>/', $input, $matches);

//replace all tags with a numbered tag like <1>
for($i = 0; $i < sizeof($matches[0]); $i++) {
	#$input = preg_replace('/<(.*?)>/', "<>", $input);
	$input = str_replace($matches[0][$i], "<".$i.">", $input);
	}

//count the entity references and store them for later
preg_match_all('/&#(.*?);/', $input, $matches2);

//replace the entity references with bracketed number like [1]
for($i = 0; $i < sizeof($matches2[0]); $i++) {
	$input = str_replace($matches2[0][$i], "[".$i."]", $input);
	}
	
//remove extraneous space
$input = preg_replace('([[:space:]]+)', " ", $input);

//retrieve the keys from the rules file
$keys = array_keys($rules);
//iterate over the rules and apply them
foreach ($keys as $key) {
	$input = str_replace($key, $rules[$key], $input);
	}

//get the font size
$size = $_POST['size'];

//the markers for line group breaks and line breaks
$pbreak = strpos($input, "**"); 
$lbreak = strpos($input, "*");

//if there are both lines and line groups, put <p> around the line <div>
if($pbreak !== false  && $lbreak !== false) {
	$input = str_replace("**", "</div>\n</p>\n<p>\n<div style=\"font-size:".$size."px\">", $input);
	}

//if just lines, put the line in a <div>
if($lbreak !== false) {
	$input = str_replace("*", "</div>\n<div style=\"font-size:".$size."px\">", $input);
	}
	
//replace the + with &# to correct the entity references
$input = str_replace("+", "&#", $input);

//put the stored tags back into place
for($i = 0; $i < sizeof($matches[0]); $i++) {
	$input = str_replace("<".$i.">", $matches[0][$i], $input);
	}

//put the stored entity references back into place
for($i = 0; $i < sizeof($matches2[0]); $i++) {
	$input = str_replace("[".$i."]", $matches2[0][$i], $input);
	}

//html stuff	
echo "<html>\n<head>\n<title>$htitle</title>\n";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style_cyrillic.css\" />\n";
echo "</head>\n<body>\n";
//use the font size
echo "<div style=\"width:720px;font-size:".$size."px\">\n";
echo "<p>$title<br/>$author<br/>$date<br/>$responsibility</p></br/>\n";

//take care of the various possibilities of line or line group
if($pbreak !== false) { echo "<p>\n"; }
if($lbreak !== false && $pbreak === false) { echo "<p>\n"; }
if($lbreak === false && $pbreak === false) { echo "<p>"; }
if($lbreak !== false) { echo "<div style=\"font-size:".$size."px\">"; }
echo $input;
if($lbreak !== false) { echo "</div>\n"; }
if($lbreak !== false && $pbreak === false) { echo "</p>\n"; }
if($lbreak === false && $pbreak === false) { echo "</p>\n"; }
if($pbreak !== false) { echo "</p>\n"; }

//close up
echo "</div>\n</body>\n</html>";

?>
