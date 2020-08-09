<?php
include "simple_html_dom.php";

$conn = new mysqli('localhost','root','server','student');

if($conn){
    echo "";
}
else{
    die("Connection Failed because ".$conn->connect_error);
}

$sql = 'select name from faculty';
$result = $conn->query($sql);

$facultyList = array();

if($result->num_rows>0)
{
    while($row = $result->fetch_assoc()){
    array_push($facultyList,$row['name']);
 	}           
}

// foreach ($facultyList as $key) {
// 	echo $key;
// }


// $sqlQ = 'select * from kapil_sharma__kps where monday like "%PRO%"';


// $result1 = $conn->query($sqlQ);
// 		if($result1->num_rows>0)
// 		{
// 		    while($row = $result1->fetch_assoc()){
// 		    echo ($row['monday']);
// 		 	}           
// 		}


$facultyTime = array();
$facultyDay = array();
$facultyNames = array();
$facultyDetails = array();

$day = array('monday','tuesday','wednesday','thursday','friday');
for($i=0; $i<sizeof($facultyList); $i++){
	for($j=0; $j<sizeof($day); $j++){
		$sqlQ = 'select * from '.$facultyList[$i].' where '.$day[$j].' like "%PRO%" and '.$day[$j].' not like "%MIN%" and '.$day[$j].' not like "%MJ%"';

// 		$sqlQ = "select * from kapil_sharma__kps where monday like '%PRO%'";

		$result1 = $conn->query($sqlQ);
		if($result1->num_rows>0)
		{
		    while($row = $result1->fetch_assoc()){

		    	array_push($facultyDetails, $row[$day[$j]].'x'.$row['time'].'*'.$day[$j]);
		    	// array_push($facultyTime, $row['time']);
		    	// array_push($facultyDay,$day[$j]);
		    	// array_push($facultyNames, $row[$day[$j]]);
		    // echo ($row[$day[$j]]) ."<br>";
		 	}           
		}

	}

}



// $facultyDetails1 = array_unique($facultyDetails);  //duplicattion removal


$facultyDetailsUnique = array();

foreach($facultyDetails as $inputArrayItem) {
    foreach($facultyDetailsUnique as $outputArrayItem) {
        if($inputArrayItem == $outputArrayItem) {
            continue 2;
        }
    }
    $facultyDetailsUnique[] = $inputArrayItem;
}


// $index = strpos($outputArray[4],"D4CS");
// 	echo $index."<br>";
for($i=0; $i<sizeof($facultyDetailsUnique); $i++){

	$index1 = strpos($facultyDetailsUnique[$i],"D4CS")-1;
	// echo $index."<br>";
	$index2 = strpos($facultyDetailsUnique[$i],"x")+1;
	// echo $index2."<br>";
	$index3 = strpos($facultyDetailsUnique[$i],"*");
	// echo $index3."<br>";
	$index4 = strpos($facultyDetailsUnique[$i],"y");

	$subString1 = substr($facultyDetailsUnique[$i],0,$index1);

	$subString2 = substr($facultyDetailsUnique[$i],$index2,($index3-$index2));

	$substring3 = substr($facultyDetailsUnique[$i],$index3+1,($index4-$index3));

	// echo $subString2."<br>";
	array_push($facultyNames, $subString1);
	array_push($facultyTime, $subString2);
	array_push($facultyDay,$substring3);

	// str_replace($subString,'#',$facultyDetailsUnique[$i]);

}


foreach ($facultyNames as $key) {
	echo $key."<br>";
}
foreach ($facultyDay as $key) {
	echo $key."<br>";
}
foreach ($facultyTime as $key) {
	echo $key."<br>";
}


$string = explode(",", $facultyNames[1]);

foreach ($string as $key) {
	# code...
	echo $key."<br>";
}







?>