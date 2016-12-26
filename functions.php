<?php


function get_the_rules($path) {
	//get file contents
	$file = file_get_contents($path);
	//remove comments like /* xxxxx */
	$file = preg_replace('/\/\*(.*?)\*\//', "", $file);
	//temporarily remove commas, bracket so the explode on commas will still
	$file = str_replace(',}', ">}", $file);
	//separate the comma separated lines
	$lines = explode(",", $file);
	$rules = array();
	//build the rules
	foreach ($lines as $line) {
		//put the comma,bracket back
		$line = str_replace('>}', ",}", $line);
		//separate the key and value
		$words = explode("->", $line);
		//trim whitspace
		$key = trim($words[0]);
		//get rid of quotes
		$key = str_replace("\"", "", $key);
		//trim whitspace
		$val = trim($words[1]);
		//get rid of quotes
		$val = str_replace("\"", "", $val);
		//place the rule in the dictionary
		$rules[$key] = $val;
		}
	//return dictionary of rules
	return $rules;
	}

//this is not actually used
function get_the_rule_keys($path) {
	$file = file_get_contents($path);
	$file = preg_replace('/\/\*(.*?)\*\//', "", $file);
	$file = str_replace(',}', ">}", $file);
	$lines = explode(",", $file);
	$keys = array();
	for($i = 0; $i < count($lines); $i++) {
		$val = str_replace('>}', ",}", $lines[$i]);
		$val = trim($val);
		$val = str_replace("\"", "", $val);
		$keys[$i] = $val;
		}
	return $keys;
	}
	
?>

