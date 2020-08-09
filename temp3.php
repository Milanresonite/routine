<?php



	$q = $_REQUEST["day"];
	$tempTime = $_REQUEST['time'];
	$panel = $_REQUEST['panel'];


	$index = strpos($tempTime,":");
	$time = substr($tempTime,0,$index);



	$conn = new mysqli('localhost','root','','student');

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


	$schedule = array();
          
           for($i=0; $i<sizeof($facultyList); $i++){
            $sql = 'select '.$q.' from '.$facultyList[$i].' where time = '.$time.'';

        $result = $conn->query($sql);
        if($result){
            while($row = $result->fetch_assoc()){
                
                array_push($schedule,$row[$q]);
                
            }
        }
           }

           $availableFaculty=array();
         for($i=0; $i<sizeof($schedule); $i++){
                
                if(!strcmp('---',$schedule[$i])){
                    
                    array_push($availableFaculty,$facultyList[$i]);
                
                }

            }


	$facultyTime = array();
	$facultyDay = array();
	$facultyNames = array();
	$facultyDetails = array();

	$day = array('monday','tuesday','wednesday','thursday','friday');
	for($i=0; $i<sizeof($facultyList); $i++){
		for($j=0; $j<sizeof($day); $j++){
			$sqlQ = 'select * from '.$facultyList[$i].' where '.$day[$j].' like "%PRO%" and '.$day[$j].' not like "%MIN%" and '.$day[$j].' not like "%MJ%"';

			$result1 = $conn->query($sqlQ);
			if($result1->num_rows>0)
			{
			    while($row = $result1->fetch_assoc()){

			    	array_push($facultyDetails, $row[$day[$j]].'x'.$row['time'].'*'.$day[$j]);
			    	
			 	}           
			}

		}

	}

	$facultyDetailsUnique = array();

	foreach($facultyDetails as $inputArrayItem) {
	    foreach($facultyDetailsUnique as $outputArrayItem) {
	        if($inputArrayItem == $outputArrayItem) {
	            continue 2;
	        }
	    }
	    $facultyDetailsUnique[] = $inputArrayItem;
	}

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

	function returnDay($day,$facultyDay,$facultyTime){
                $timeArray = array();
                for($i=0; $i<sizeof($facultyDay); $i++){
                    if($day==$facultyDay[$i]){
                        array_push($timeArray, $facultyTime[$i]);
                    }
                }

                return $timeArray;
                
            } 

      

            $name = array();
     	for($i=0; $i<sizeof($facultyTime); $i++){
     		if($facultyDay[$i]==$q && $facultyTime[$i]==$time){
     			$name = explode(",",$facultyNames[$i]);
     			
     			
     		}
     }
     	$size = sizeof($name);


     	if($panel-sizeof($name)!=0){
     		while($panel-sizeof($name)!=0){
     			array_push($name,'*');
     		}
     	}


     	$counter = 0;
     	// echo "<div class='go'>";
     	for($i=0; $i<$panel; $i++){
     		if($counter!=$size){
     			echo $name[$counter]."<br>";
     			$counter++;
     		}
     		else{
     			echo "<select class='go'><option>select faculty</option>";
     			for($j=0; $j<sizeof($availableFaculty); $j++){
     				echo "<option>".$availableFaculty[$j]."<option>";
     			}
     			echo "</select>";
     		}

     	}

     	// echo "</div>";
     	// foreach ($name as $key ) {
     	// 	echo $key."<br>";
     	// }

		



?>