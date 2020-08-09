<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty - Time wise</title>
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
        <li><a href="homePage.php">Home</a></li>
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
      <form action="FacultyPage1.php" method="post">
         Select Day:
          <select name="day" id="dayid">
           <option value="monday">Monday</option>
           <option value="tuesday">Tuesday</option>
           <option value="wednesday">Wednesday</option>
           <option value="thursday">Thursday</option>
           <option value="friday">Friday</option>
       </select>
       <br><br>
       
       
        <div id="timeid">
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
         <br><br><br>
         <input type="submit" value="Search" id="searchbutton">
          
          

        
       
       
    </form>
    </div>  
    
    <div class="output">
        
       
        
        

       
       
          
          <?php
          
            
            $day="";
            $time="";
//            $faculty="";
          
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
//            if(empty($_POST['facultyName'])){
//                $faculty="";
//            }
//            else{
//                $faculty = $_POST['facultyName'];
//            }
            if(empty($_POST['time'])){
                $time="";
            }
            else{
                $time = $_POST['time'];
            }
            
            $facultyName = array();

            $sql = 'select name from faculty';
            $res = $conn->query($sql);
            if($res){
                while($row = $res->fetch_assoc()){
                    array_push($facultyName,$row['name']);
                }
            }
        
        $schedule = array();
          
           for($i=0; $i<sizeof($facultyName); $i++){
            $sql = 'select '.$day.' from '.$facultyName[$i].' where time = '.$time.'';

        $result = $conn->query($sql);
        if($result){
            while($row = $result->fetch_assoc()){
                
                array_push($schedule,$row[$day]);
                
            }
        }
           }

           echo "<div style='clear:both;'> <h3 style=' font-size:1.5em; float:left;'>Day: $day</h3> 
            <h3 style=' font-size:1.5em; float:right;'>Time: $time:00</h3></div>
            
            ";
               
            echo "<table border='2' style='border-collapse:collapse; font-size:1.2em;'>
       <th>Time</th>
       <th>Schedule</th>";
            
            for($i=0; $i<sizeof($schedule); $i++){
                
                if(!strcmp('---',$schedule[$i])){
                    
                    echo "<tr> <td style='padding:10px; text-align:center;'>".$facultyName[$i]."</td>
                          <td style='padding:10px; width:60%; text-align:center; background:green;'>Available</td>
               
                </tr>";
                
                }
                else if(!strcasecmp('-x-',$schedule[$i])){
                    
                    echo "<tr> <td style='padding:10px; text-align:center;'>".$facultyName[$i]."</td>
                          <td style='padding:10px; text-align:center; background:red;'>Not Present</td>
               
                </tr>";
                
                }
                else{
                    echo "<tr> <td style='padding:10px; text-align:center;'>".$facultyName[$i]."</td>
                          <td style='padding:10px; text-align:center;'>Not Available</td>
               
                </tr>";
                }
            
            }
            
        }

            
        echo "</table>";
          
          ?>
             
       
   
    </div>
   
</body>
</html>

