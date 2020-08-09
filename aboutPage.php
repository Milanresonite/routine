<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <style>
        
        #image{
            text-align: center;
        }
        
        .menu{
            background: aqua;
            height: 50px;
            text-align: center;
        }
        .menu ul li{
            display: inline;
        
            
        }
        .menu ul a{
            text-decoration: none;
            background: blue;
            font-size: 1.5em;
            color: white;
            margin: 0 55px;;
            padding: 11px;
            display: inline-block;

            
        }
        
        ul a:hover,ul a.active{
            text-decoration: none;
            background: black;
            color: white;
            margin: 0 55px;;
            padding: 11px;
            display: inline-block;
            
            
        }
        
        
        



</style>
    
    
    
</head>

<body>
   
    <div id="image">
    <img src="https://www.gndec.ac.in/sites/default/logo.png" alt="Image Not Available"  >
    </div>  
       
   
   
    <div class="menu">
        <ul>
            <a href="#"  class="active"><li>Home</li></a>
            <a href="FacultyPage.html" ><li>Faculty</li></a>
            <a href="#"><li>Rooms</li></a>
            <a href="#"><li>About</li></a>
            <a href="#"><li>Help</li></a>
    </ul>
    </div>
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
    $query = "INSERT INTO excel_student VALUES ('".$sno."', '".$roll."','".$name."','".$group."')";

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
  $output = '<label class="text-danger">Invalid File</label>'; //if non excel file then
 }
}
?>

   <form method="post" enctype="multipart/form-data">
    <label>Select Excel File</label>
    <input type="file" name="excel" />
    <br />
    <input type="submit" name="upload" class="btn btn-info" value="upload" />
   </form>
   
   <?php
    
    if($guideboolean==true){
        $output .=  "<a href='allotguide.php'>Click here to allot guide</a>";
    }
    echo $output;
    
   ?>



 
   
</body>
</html>

