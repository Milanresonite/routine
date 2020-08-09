<?php

// if($_POST['SearchValue']){
	// $day = $_POST['SearchValue'];

	$day = $_REQUEST["day"];
	// $day = "monday";
	$tempTime = $_REQUEST['time'];


	$index = strpos($tempTime,":");
	$time = substr($tempTime,0,$index);
	// echo $q;

	// $day = date('l', $q);
	// // var_dump($day);
	// echo $day;

	$conn = new mysqli('localhost','root','','student');

	if($conn){
	    echo "";
	}
	else{
	    die("Connection Failed because ".$conn->connect_error);
	}

	// $sql = 'select name from faculty';
	// $result = $conn->query($sql);

	// $facultyList = array();

	// if($result->num_rows>0)
	// {
	//     while($row = $result->fetch_assoc()){
	//     array_push($facultyList,$row['name']);
	//  	}           
	// }


	// $facultyTime = array();
	// $facultyDay = array();
	// $facultyNames = array();
	// $facultyDetails = array();

	// $day = array('monday','tuesday','wednesday','thursday','friday');
	// for($i=0; $i<sizeof($facultyList); $i++){
	// 	for($j=0; $j<sizeof($day); $j++){
	// 		$sqlQ = 'select * from '.$facultyList[$i].' where '.$day[$j].' like "%PRO%" and '.$day[$j].' not like "%MIN%" and '.$day[$j].' not like "%MJ%"';

	// 		$result1 = $conn->query($sqlQ);
	// 		if($result1->num_rows>0)
	// 		{
	// 		    while($row = $result1->fetch_assoc()){

	// 		    	array_push($facultyDetails, $row[$day[$j]].'x'.$row['time'].'*'.$day[$j]);
			    	
	// 		 	}           
	// 		}

	// 	}

	// }

	// $facultyDetailsUnique = array();

	// foreach($facultyDetails as $inputArrayItem) {
	//     foreach($facultyDetailsUnique as $outputArrayItem) {
	//         if($inputArrayItem == $outputArrayItem) {
	//             continue 2;
	//         }
	//     }
	//     $facultyDetailsUnique[] = $inputArrayItem;
	// }

	// for($i=0; $i<sizeof($facultyDetailsUnique); $i++){

	// $index1 = strpos($facultyDetailsUnique[$i],"D4CS")-1;
	// // echo $index."<br>";
	// $index2 = strpos($facultyDetailsUnique[$i],"x")+1;
	// // echo $index2."<br>";
	// $index3 = strpos($facultyDetailsUnique[$i],"*");
	// // echo $index3."<br>";
	// $index4 = strpos($facultyDetailsUnique[$i],"y");

	// $subString1 = substr($facultyDetailsUnique[$i],0,$index1);

	// $subString2 = substr($facultyDetailsUnique[$i],$index2,($index3-$index2));

	// $substring3 = substr($facultyDetailsUnique[$i],$index3+1,($index4-$index3));

	// // echo $subString2."<br>";
	// array_push($facultyNames, $subString1);
	// array_push($facultyTime, $subString2);
	// array_push($facultyDay,$substring3);

	// // str_replace($subString,'#',$facultyDetailsUnique[$i]);

	// }

	// function returnDay($day,$facultyDay,$facultyTime){
 //                $timeArray = array();
 //                for($i=0; $i<sizeof($facultyDay); $i++){
 //                    if($day==$facultyDay[$i]){
 //                        array_push($timeArray, $facultyTime[$i]);
 //                    }
 //                }

 //                return $timeArray;
                
 //            } 

 //      $timeArray = returnDay($day,$facultyDay,$facultyTime);

	$requiredRooms = array('S215','S216','S217','S218','TR_1','SL_I','SL_II','SL_III','PL_II','OS_II','R_LAB');


	$schedule = array();
	$availableRoom = array();
          
           for($i=0; $i<sizeof($requiredRooms); $i++){
            $sql = 'select '.$day.' from '.$requiredRooms[$i].' where time = '.$time.'';

                $result2 = $conn->query($sql);
                if($result2){
                    while($row = $result2->fetch_assoc()){
                        
                        // array_push($schedule,$row[$day]);
                        if(strcmp('---',$row[$day])){
                array_push($availableRoom, $requiredRooms[$i]);
            }
                        
                    }
                }
           }
           
           

          // foreach ($availableRoom as $key) {
          // 	echo $key."<br>";
           	
          //  } 

       echo "<select class='go'><option disabled selected>Select room</option>";
      foreach ($availableRoom as $key) {
      	echo "<option>".$key."</option>";
      }

      // echo "<select class='blablabla'>";
      // for($i=0; $i<sizeof($timeArray); $i++){
      // 	echo "<option>".$timeArray[$i]."</option>";
      // }

      echo "</select>";




// echo "<select class='blablabla' onchange='setRooms(this.value,this)'><option disabled selected>Select Time</option>";
//       foreach ($timeArray as $key) {
//       	echo "<option>".$key.":00</option>";
//       }

//       // echo "<select class='blablabla'>";
//       // for($i=0; $i<sizeof($timeArray); $i++){
//       // 	echo "<option>".$timeArray[$i]."</option>";
//       // }

//       echo "</select>";


// }
?>






