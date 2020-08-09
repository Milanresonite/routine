<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
     
        form{
            border: 2px solid #0e9d8c;
            width: 20%;
            margin: 50px auto auto auto;
            padding: 3%;
            border-radius: 5px;
            
            
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
    
    
    <div id="upload" >
    
    <?php
    include("connection.php");
$output ='';
$guideboolean = false;

if(isset($_POST["upload"]))
{
    $explod = explode(".", $_FILES["excel"]["name"]);
 $extension = end($explod); // For getting Extension of selected file
 $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
 if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
 {
  $file = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file
  include("PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
  $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file

  
  $worksheet = $objPHPExcel->getSheet(0);
      
   $highestRow = $worksheet->getHighestRow();
   
   
    $sql = "truncate table excel_student";
    if($connect->query($sql)){
    for($row=2; $row<=$highestRow; $row++)
   {
    
    $sno = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
    $name = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
    $roll = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
    $group = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
    $query = "INSERT INTO excel_student VALUES ('".$sno."', '".$roll."','".$name."','".$group."','')";


    if($connect->query($query))
    {
        $output = "successfully uploaded";
        $guideboolean = true;
    }
    else
   {
    $output = "galat hua hai";
    $guideboolean = false;
   }
    
   }
  
    }

 
   
 }
 else
 {
  $output = "<label style='color:red;'>Invalid File</label>"; //if non excel file then
 }
}
?>

   <form method="post" enctype="multipart/form-data">
    <label><b>Select Excel File of Student list</b></label><br><br>
    <input type="file" name="excel" />
    <br><br>
    <input type="submit" name="upload" class="btn btn-info" value="upload" />
   </form>
   
   <?php
    
    if($guideboolean==true){
        $output .=  "<a href='allotguide.php'>Click here to allot guide</a>";
    }
    echo "<p style='width:25%; margin: 5px auto auto auto;'>$output</p>";
    
   ?>



 </div>
   
</body>
</html>

