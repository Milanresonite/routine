<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty - Name wise</title>
    <style>
        
        .menu{
            height: 100%;
        }
        
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
        display: block; /* Display the dropdown */
    }
    ul li ul.dropdown li{
        display: block;
    }
        
    
     #container{
            float: left;
            background: aqua;
            margin: 7%;
            width: 27%;
            height: auto;
            padding: 5%;
            border: 2px solid red;
            border-radius: 10px;
            font-size: 1.5em;
            clear: both;
        }
        
        .output{
           float: right;
            border-collapse: collapse;
            display: inline-block;
            clear: both;
            position: absolute;
            padding: 3%;
            padding-top: 1%;
            margin: 2%;
            border-radius: 10px;
        }
        
       
        #dayid{
            width: 50%;
            font-size: .8em;
            margin-left: 5%;
        }
        #facultyid{
            width: 50%;
            font-size: .6em;
            margin-left: 16%;
        }
        
        #searchbutton{
            padding: 2%;
            font-size: .8em;
            width: 30%;
            display: inline-block;
            position: relative;
            text-align: center;
            margin-left: 20%;
            border-radius: 10px;
            
        }
        #searchbutton:hover{
            background: white;
        }

</style>
    
    
    
</head>

<body>
   
  
   
   
   <div class="menu">
         <ul>
        <li><a href="homepage.php">Home</a></li>
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
    </ul>
    </div>
            
<div id="container">
      <form action="FacultyPage.php" method="post">
         Select Day:
          <select name="day" id="dayid">
           <option value="monday">Monday</option>
           <option value="tuesday">Tuesday</option>
           <option value="wednesday">Wednesday</option>
           <option value="thursday">Thursday</option>
           <option value="friday">Friday</option>
       </select>
       <br><br>
       Faculty: 
       <input list="faculty" name="facultyName" placeholder="Enter Faculty Name" required id="facultyid">
       
       
       <datalist id="faculty">
          
          <?php
           
          $conn = new mysqli('localhost','root','server','student');

            if($conn){
                echo "";
            }
            else{
                die("Connection Failed because ".$conn->connect_error);
            }       
          
         
         $sql = 'select name from faculty';

        $result = $conn->query($sql);


        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
            $data=$row['name'];
            echo "<option value='$data'>";
            
            
            }
            
            }

          
          ?>
         
       </datalist>
       
       
<!--
       <div>
    <script>
        function ShowHideDiv(chktime) {
            var bytime = document.getElementById("bytime");
            bytime.style.display = chktime.checked ? "block" : "none";
        }
   </script>
       
        <input type="checkbox" id="chktime" onclick="ShowHideDiv(this)" />
        By Time
    
    
    
    <div id="bytime" style="display: none">
           Select Time:
          <select name="time">
           <option value="8">8:00 AM</option>
           <option value="9">9:00 AM</option>
           <option value="10">10:00 AM</option>
           <option value="11">11:00 AM</option>
           <option value="12">12:00 PM</option>
           <option value="1">1:00 PM</option>
           <option value="2">2:00 PM</option>
           <option value="3">3:00 PM</option>
           <option value="4">4:00 PM</option>
           <option value="5">5:00 PM</option>
           <option value="6">6:00 PM</option>
       </select>
       </div>
       </div>
       
-->
       
         <br><br><br>
         <input type="submit" value="Search" id="searchbutton">
          
          

        
       
       
    </form>
    </div>  
    
    <div class="output">
        
       
        
        

       
       
          
          <?php
          
            
            $day="";
//            $time="";
            $faculty="";
          
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $conn = new mysqli('localhost','root','server','student');

                if($conn){
                    echo "";
                }
                else{
                    die("Connection Failed because ".$conn->connect_error);
                } 
                
                
            if(empty($_POST['day'])){
                $day = "";
            }
            else{
                $day=$_POST['day'];
            }
            if(empty($_POST['facultyName'])){
                $faculty="";
            }
            else{
                $faculty = $_POST['facultyName'];
            }
//            if(empty($_POST['time'])){
//                $time="";
//            }
//            else{
//                $time = $_POST['time'];
//            }
            
              
          
            $sql1 = 'select time,'.$day.' from '.$faculty.'';
              
              $result = $conn->query($sql1);


            $arrtime = array();
           $arrday=array();
            if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                if(strcasecmp($row[$day],'-x-')){
                
              array_push($arrday,$row[$day]);
              array_push($arrtime,$row['time']);
            
  
                    
            }
        
            
            }
            echo "<div style='clear:both; width:120%;'> <h3 style=' font-size:1.5em; float:left;'>Faculty: $faculty</h3> 
            <h3 style=' font-size:1.5em; float:right;'>Day: $day</h3></div>
            
            ";

            echo "<table border='2' style='border-collapse:collapse; font-size:1.2em; width:120%;'>
       <th>Time</th>
       <th>Schedule</th>";
            
            $rowspanValue=1;
            for($i=0; $i<sizeof($arrday);$i++){
                
                if(($i<sizeof($arrday)-1) && !strcmp($arrday[$i],$arrday[$i+1])){
                    
                    echo "<tr> <td style='padding:10px; text-align:center;'>".$arrtime[$i].":00</td>
                          <td rowspan=2 style='padding:10px; text-align:center; width:60%;'>".$arrday[$i]."</td>
               
                </tr>";
                    
                    echo "<tr> <td style='padding:10px; text-align:center;'>".$arrtime[$i+1].":00</td>               
                </tr>";
                    $i++;
                
                }
                else{
                    
                    echo "<tr> <td style='padding:10px; text-align:center;'>".$arrtime[$i].":00</td>
                          <td style='padding:10px; text-align:center'>".$arrday[$i]."</td>
               
                </tr>";
                }
                
                
                
                
            }
            
        }

            }
        echo "</table>";
          
          ?>
             
       
   
    </div>
   
</body>
</html>

