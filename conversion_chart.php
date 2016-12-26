<?php

include("functions.php");

//get the font size if it exists, otherwise set to 18
$size = $_GET['size'];
if(!$size) $size = 18;

//load the rules file for the chart
$master = get_the_rules("dynamic_chart_rules.txt");

//load the rules for the different conversions
$arabic = get_the_rules("ottoman_arabic_rules.txt");
$latin = get_the_rules("ottoman_latin_rules.txt");
$turkish = get_the_rules("ottoman_turkish_rules.txt");
$cyrillic = get_the_rules("ottoman_cyrillic_rules.txt");

//get the master keys
$keys = array_keys($master);

//html boiler plate
echo "<html>\n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html;charset=UTF-8\" />\n";
echo "<html>\n<head>\n<title>Conversion Chart</title>\n";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"mystyle.css\" />\n";
echo "</head>\n<body>\n";
echo "<div style=\"width:720px;font-size:".$size."px;font-family:Arial;\">\n";
echo "<table border=\"1\" style=\"width:720px;font-size:".$size."px\">";

//table header
echo "<tr>";
echo "<th>Code</th><th>Description</th><th>Entity Reference</th><th>Arabic</th><th>Entity Reference</th><th>Latin</th><th>Entity Reference</th><th>Turkish</th>";
echo "<th>Entity Reference</th><th>Cyrillic</th>";
echo "</tr>";

//build the table
foreach ($keys as $key) {
	echo "<tr>\n";
	echo "<td style=\"text-align:center\">" . $key . "</td>";
	//get description from chart
	$val = $master[$key];
	//if no value, use space
	if($val == "") $val = "&nbsp;";
	//post value
	echo "<td style=\"text-align:center\">" . $val . "</td>";
	//get next column value
	$val = $arabic[$key];
	//if no value, use space
	if($val == "") $val = "&nbsp;";
	//replace " " with [space]
	$val2 = str_replace(" ", "[space]", $val); 
	//post value
	echo "<td style=\"text-align:center\">" . $val2 . "</td>";
	//post converted valuevalue
	echo "<td style=\"text-align:center\">" . str_replace("+", "&#", $val) . "</td>";
	//do like for the remaining columns
	$val = $latin[$key];
	if($val == "") $val = "&nbsp;";
	$val2 = str_replace(" ", "[space]", $val);
	echo "<td style=\"text-align:center\">" . $val2 . "</td>";
	echo "<td style=\"text-align:center\">" . str_replace("+", "&#", $val) . "</td>";
	$val = $turkish[$key];
	if($val == "") $val = "&nbsp;";
	$val2 = str_replace(" ", "[space]", $val);
	echo "<td style=\"text-align:center\">" . $val2 . "</td>";
	echo "<td style=\"text-align:center\">" . str_replace("+", "&#", $val) . "</td>";
	$val = $cyrillic[$key];
	if($val == "") $val = "&nbsp;";
	$val2 = str_replace(" ", "[space]", $val);
	echo "<td style=\"text-align:center\">" . $val2 . "</td>";
	echo "<td style=\"text-align:center\">" . str_replace("+", "&#", $val) . "</td>";
	echo "</tr>\n";
	}

//close up
echo "</table>";
echo "</div>\n</body>\n</html>";

?>