<?php 
include('connection.php');
?>

<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="refresh" content="2"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>HomePage</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style>
        
         ul{
        padding: 0;
        list-style: none;
        background: #f2f2f2;
        text-align: center;
    }
    ul li{

        display: inline-block;
        position: relative;
        line-height: 21px;
        text-align: center;
    }
    ul li a{

        display: block;
        padding: 8px 25px;
        color: #333;
        text-decoration: none;
        font-size: 1.5em;
    }
    ul li a:hover{

        color: #fff;
        background-color: red;
    }
    ul li ul.dropdown{
        min-width: 100%; /* Set width of the dropdown */
        background: #A6EADD;
        display: none;
        position: absolute;
        z-index: 999;
        left: 0;
    }
    ul li:hover ul.dropdown{
        display: block;	/* Display the dropdown */
    }
    ul li ul.dropdown li{
        display: block;
    }

</style>
    
    
    
</head>

<body>
 
    <div class="menu">
         <ul>
        <li><a href="#">Home</a></li>
        <li>
        	<a href="#">Search Faculty &#9662;</a>
        	<ul class="dropdown">
                <li><a href="FacultyPage1.php">Time wise</a></li>
                <li><a href="FacultyPage.php">Name wise</a></li>
                
            </ul>
        </li>
        <li>
            <a href="#">Search Rooms &#9662;</a>
            <ul class="dropdown">
                <li><a href="roomPage1.php">Time wise</a></li>
                <li><a href="roomPage.php">Room no. wise</a></li>
                
            </ul>
        </li>
        <li><a href="uploadfile.php">Guide Allotment</a></li>
        <li><a href="Scheduling.php">Scheduling</a></li>
    </ul>
    </div>

    <form action="Scheduling_dupli.php" method="GET">
        PANEL: <input type="number" name="panel">
        No. of Groups: <input type="number" name="noOfGroup">
        <input type="submit" name="submit">
    </form>

<div id="mainDiv">

    <!-- <table style="float:left; border:2px solid #0e9d8c; border-collapse:collapse; margin:10px auto auto 150px; border-radius:10px; width:50%;">
        <th>Groups</th>
        <th>Faculties</th>
        <th>Date</th>
        <th>Room</th>
        <th>Time</th>  -->
<?php

if (isset($_GET['submit'])) {

    
                
            if(empty($_GET['panel'])){
                $panel = 3;
            }
            else{
                $panel = (int)$_GET['panel'];
            }

            if(empty($_GET['noOfGroup'])){
                $noOfGroup = "";
            }
            else{
                $noOfGroup = $_GET['noOfGroup'];
            }

          

            $sql = 'select name from faculty';
            $result1 = $connect->query($sql);

            $facultyList = array();
            

            if($result1->num_rows>0)
            {
                while($row = $result1->fetch_assoc()){
                array_push($facultyList,$row['name']);
                }           
            }


            $excdata = "select * from excel_student";

            $result = $connect->query($excdata);

            $groupArray = array();
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()){
                    if($row['groupname']==""){

                    }else{
                        array_push($groupArray,$row['groupname']);
                    }
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


        $result1 = $connect->query($sqlQ);
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

    array_push($facultyNames, $subString1);
    array_push($facultyTime, $subString2);
    array_push($facultyDay,$substring3);

    
}

    
            // $panelCount = sizeof($groupArray)/$panel;

            echo "<div style='margin:20px auto;'>";
            
            $groupCounter = 1;
            $groupPanel = ceil(sizeof($groupArray)/$noOfGroup);
            echo "<div style='background:aqua; width:auto; height:auto; position:absolute'>";
            for($i=0; $i<$groupPanel; $i++){
                echo "<div style='background:green; border:1px solid red; width:200px; height:100px; text-align:center; line-height:100px;'>";
                for($j=0; $j<$noOfGroup; $j++){
                    echo "G$groupCounter ";
                    $groupCounter++;
                    if($groupCounter==sizeof($groupArray)+1){
                    break;
                }
                }


                echo "</div>";

            }


            echo "</div>";
            echo "<div style='background:aqua; margin-left: 200px; width:auto; height:auto; position:absolute'>";
            for($i=1; $i<=$groupPanel; $i++){
                echo "<div style='background:green; border:1px solid red; width:200px; height:100px; text-align:center; line-height:100px;'>";
                    echo "P$i ";
                echo "</div>";
            }
            echo "</div>";




           $facultyCounter = 1;
            echo "<div style='background:aqua; margin-left: 400px; width:auto; height:auto; position:absolute'>";
            for($i=0; $i<$groupPanel; $i++){
                echo "<div style='background:green; border:1px solid red; width:200px; height:100px; text-align:center;' id='facultyName$i'>";
                // for($j=0; $j<$panel; $j++){
                    echo "facul";
                //     $facultyCounter++;
                // }
                echo "</div>";

            }


            echo "</div>";
            echo "<div style='background:aqua; margin-left: 600px; width:auto; height:auto; position:absolute'>";
            for($i=1; $i<=$groupPanel; $i++){
                echo "<div style='background:green; border:1px solid red;width:200px; height:100px; text-align:center; line-height:100px;'>";
                    echo "<input type='date' name='date' onchange='changeTime(this.value,$i)'>";
                echo "</div>";
            }
            echo "</div>";



             echo "</div>";
            echo "<div style='background:aqua; margin-left: 800px; width:auto; height:auto; position:absolute'>";
            for($i=1; $i<=$groupPanel; $i++){
                echo "<div style='background:green; border:1px solid red; width:200px; height:100px; text-align:center; line-height:100px;' id ='facultyRooms$i'>";
                    echo "<select class='go'><option>Select Room</option></select>";
                echo "</div>";
            }
            echo "</div>";



            echo "</div>";
            echo "<div style='background:aqua; margin-left: 1000px; width:auto; height:auto; position:absolute'>";
            for($j=1; $j<=$groupPanel; $j++){
                echo "<div style='background:green; border:1px solid red; width:200px; height:100px; text-align:center; line-height:100px;' id='facultyTimes$j'>";
                    echo "<select onchange='setRooms(this.value,this.id)'><option value='0'>Select Time</option></select>";
                echo "</div>";
            }
            echo "</div>";


            echo "</div>";

            
                
            function returnDay($day){
                $timeArray = array();
                for($i=0; $i<sizeof($facultyDay); $i++){
                    if($day==$facultyDay[$i]){
                        array_push($timeArray, $facultyTime[$i]);
                    }
                }

                return $timeArray;
                
            } 
                

            // echo "<script>

            //       function setRooms(time,id){
       
        
            //         alert(id);
            //         // alert(day);

            //         var xmlhttp = new XMLHttpRequest();
            //         xmlhttp.onreadystatechange = function() {
            //             if (this.readyState == 4 && this.status == 200) {
            //                 document.getElementById('facultyRooms'+id).innerHTML = this.responseText;
            //             }
            //         };
            //         xmlhttp.open('GET', 'temp2.php?time='+time+'&day='+day, true);
            //         xmlhttp.send();
            //     }





            // </script>";
                
                 
                  
                
          

    
}



?>
</div>
<div><button style="margin-top:150px; margin-left: 100px">Submit</button></div>

<script type="text/javascript">


    $(".go").change(function(){
    var selVal=[];
    $(".go").each(function(){
        selVal.push(this.value);
    });
   
    $(this).siblings(".go").find("option").removeAttr("disabled").filter(function(){
       var a=$(this).parent("select").val();
       return (($.inArray(this.value, selVal) > -1) && (this.value!=a))
    }).attr("disabled","disabled");
});

$(".go").eq(0).trigger('change');
    
function returnDay(num){
                switch (num) {
                    case 1:
                        return 'monday';
                        break;

                    case 2:
                        return 'tuesday';
                        break;

                    case 3:
                        return 'wednesday';
                        break;

                    case 4:
                        return 'thursday';
                        break;

                    case 5:
                        return 'friday';
                        break;
                    
                    default:
                        return 'Error';
                        break;
                }
            } 

            var day;
            // var id;
    function changeTime(date,id){
        // id = i;
        var d = new Date(date);
        day = returnDay(d.getDay());
        // alert(day);
        // alert(id);

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("facultyTimes"+id).innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "temp.php?day=" + day+"&id="+id, true);
        xmlhttp.send();
    }



        // var xhttp = new XMLHttpRequest();
        //  xhttp.onreadystatechange = function(){
        //     if(xhttp.readyState ==4 && xhttp.status = 200){
        //         document.getElementById("facultyTimes").innerHTML = xhttp.responseText;
        //     }
        // };
        // // // var url = "temp.php";
        // // // var data = new FormData();
        // // // data.append('SearchValue',day);
        // xhttp.open("GET","temp.php?q="+day,true);
        // xhttp.send();

        function setRooms(time,id){
       
        
                    // alert(id);
                    // alert(day);
                    var panel = <?php echo $panel;?>;
                    // alert(panel);

                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById('facultyRooms'+id).innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open('GET', 'temp2.php?time='+time+'&day='+day, true);
                    xmlhttp.send();


                    var xmlhttp1 = new XMLHttpRequest();
                    xmlhttp1.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById('facultyName'+(id-1)).innerHTML = this.responseText;
                        }
                    };
                    xmlhttp1.open('GET', 'temp3.php?time='+time+'&day='+day+"&panel="+panel, true);
                    xmlhttp1.send();
                }

        // function setFaculty(time,id){
       
        
        //             // alert(id);
        //             // alert(day);

        //             var xmlhttp = new XMLHttpRequest();
        //             xmlhttp.onreadystatechange = function() {
        //                 if (this.readyState == 4 && this.status == 200) {
        //                     document.getElementById('facultyName'+id).innerHTML = this.responseText;
        //                 }
        //             };
        //             xmlhttp.open('GET', 'temp3.php?time='+time+'&day='+day, true);
        //             xmlhttp.send();
        //     }
       
    
    
    

</script>

</body></html>