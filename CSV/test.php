<?php

$arrayTest = array(
	array("empty line"),
	array("0","1","2"),
	array("test","truc","machin"),
	array("dix","onze","douze"),
);
//création de 
$render = "";
foreach ($arrayTest as $value) {
	if($value[0] != "empty line"){
		$render = $render . implode(",", $value);
	}
	$render = $render . "\n";
}
header('Content-Type: text/csv Content-Disposition: attachment; filename="test.csv"');
header('Content-Disposition: attachment; filename="test.csv"');
file_put_contents('test.csv', $render);
readfile('test.csv');
?>