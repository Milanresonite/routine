<?php 
include('connection.php');
?>

<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>HomePage</title>
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
     
        
        th{
            background: #b8d92b;
            font-size: 1.2em;
        }
        
        
        h3{
            margin: 10px 368px 0 758px;
            background: #b8d92b;
            text-align: center;
            padding: 1px;
            border: 1.5px solid #0e9d8c;
            
        }

        #divGuide .go{
            margin: 29px 10px;
            padding: 5.8px;

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
    
    <div id="mainDiv">

    <table style="float:left; border:2px solid #0e9d8c; border-collapse:collapse; margin:10px auto auto 150px; border-radius:10px; width:50%;">
        <th>S. No.</th>
        <th>Roll No.</th>
        <th>Name</th>
        <th>Group</th>
        

        <?php
            

            $excdata = "select * from excel_student";
            $guidedata = "select * from faculty";

            $result1 = $connect->query($excdata);
            $result2 = $connect->query($guidedata);
            $result3 = $connect->query($excdata);

            $guideArray = array();
            if($result2->num_rows>0){
                while($row = $result2->fetch_assoc()){
                    array_push($guideArray,$row['name']);
                }
            }

            $guideflag = array();
            for($i=0; $i<sizeof($guideArray); $i++){
                $guideflag[$i]=true;
            }

            
            $nameArray = array();
            $rollArray = array();
            $groupArray = array();
            if($result1->num_rows>0){
                while($row = $result1->fetch_assoc()){
                    array_push($nameArray,$row['name']);
                    array_push($rollArray,$row['roll']);
                    
                }
            }

            if($result3->num_rows>0){
                while($row = $result3->fetch_assoc()){
                    array_push($groupArray,$row['groupname']);
                }
            }

          

            $counter = 0;
            $srno=1;
            for($i=0; $i<sizeof($nameArray); $i++){


                
                echo "<tr>";
                if($nameArray[$i]==""){
                    echo "<td style='border:2px solid #0e9d8c; padding:5px; text-align:center;'>X</td>";
                    echo "<td style='border:2px solid #0e9d8c; padding:5px; text-align:center;'>X</td>";
                    echo "<td style='border:2px solid #0e9d8c; padding:5px;'>X</td>";
                }
                else{
                    echo "<td style='border:2px solid #0e9d8c; padding:5px; text-align:center;'>".$srno."</td>";
                    echo "<td style='border:2px solid #0e9d8c; padding:5px; text-align:center;'>".$rollArray[$i]."</td>";
                    echo "<td style='border:2px solid #0e9d8c; padding:5px;'>".$nameArray[$i]."</td>";
                    $srno++;
                }

                
                //echo "<td style='border:2px solid #0e9d8c; padding:5px; text-align:center;'>".$rollArray[$i]."</td>";
                
                
                   
                if($i%3==0){
                    echo "<td style='border:2px solid #0e9d8c; padding:5px; text-align:center; font-size:1.1em;' rowspan='3'><b>".$groupArray[$i]."</b></td>";
                    // echo "<td rowspan='3'>".$guideArray[$counter]."</td>";

            
                echo "</td>";
                


                     $counter++;
                 }
                
                
            echo "</tr>";
            }

            echo "</table></div>";
                
            echo "<h3>Guide</h3>";

            echo "<div id='divGuide'>";
            for($i=0; $i<(sizeof($nameArray)/3); $i++){
                echo "<select class='go'>";
                echo "<option disabled selected>---Select Faculty Name$i ---</option>";
                for($j=0; $j<sizeof($guideArray); $j++){
                    echo "<option >$guideArray[$j]</option>";
                }
                echo "</select><br>";
            }

            echo "</div>";
          
        //echo '<button style='margin:10px auto auto auto; width:10%; display:block' onClick='GetSelectedItem('select$i')' id='submit' name='submit'><b>Submit</b></button>';

    echo '<p id="pid">kk</p>';
    echo '<button style="margin:10px auto auto auto; width:10%; display:block;" id="submit" name="submit" onClick="GetSelectedItem()"><b>Submit</b></button>';



      //    echo ' <script>
      //   alert("hello Milan");
      //   function GetSelectedItem()
      //  {
      //   var t =2;
       
      //   el = document.getElementById("select"+t).value;
      //   alert(el);
      //   var FacultyArray = [];

      //   var i;
      //   for (i = 0; i < 4; i++) { 
      //     FacultyArray[i] = 
      //   }

      //   alert(y);
        
        
      //  }
      // </script>';



        ?>    
    
          <script>

         function GetSelectedItem(){

            var FacultyArray = $('select.go').map(function(){
                      return this.value
                  }).get();
           // alert(FacultyArray[2]);



           var jsonString = JSON.stringify(FacultyArray);
           $.ajax({
                type: "POST",
                url: "script.php",
                data: {data : jsonString}, 
                cache: false,

                success: function(hh){
                    document.getElementById('pid').innerHTML = hh;
                }
            });

                
    }





    

         
          
        

   






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



    // var selects = document.querySelectorAll('#guideid');
    

// function getOthers(current){
//     var values = [];
//     for(var i=0;i<selects.length;i++){
//         if(selects[i].value!='' && selects[i]!=current)
//             values.push(selects[i].value);
//     }
//     return values;
// }

// function checkUnique(){
//     if(this.value && getOthers(this).indexOf(this.value)>-1){
//         alert("Already selected.");
//         this.value = '';
//     }
// }

// for(var i=0;i<selects.length;i++)
//     selects[i].onchange = checkUnique;

// document.getElementById('submit').onclick = function(){
//     var values = getOthers(); // will return all selected values this time
//     if(values.length < 5){
//         alert("Select all Fields");
//         return false;
//     }
    
//     return true;
// }
    </script>
   
</body>
</html>

