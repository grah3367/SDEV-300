<?php


// takes an array of values and returns an array of results.
function slopeIntercept($values){
	$m=-2;$b=0;
	$results= array();
	
	foreach($values as $x){
		$y = $m*$x+$b;
		array_push($results, $y);
	}
	
	
	return $results;
}


// takes an array of values and returns an array of results.
function surfaceArea($values){
	$results= array();
	
	foreach($values as $x){
		$a = 4*pi()*($x*$x);
		array_push($results, $a);
	}
	
	
	return $results;
}

// returns an array of arrays
function velocity($values){
	
	$results= array();
	
	foreach($values as $x){
		
		$currentList = array();
		
		for($t=0;$t<=10;$t+=0.5){
			$v = $x*$t;
			array_push($currentList, $v);
		}
	
		array_push($results, $currentList);
	}
	
	return $results;
}

function



?>