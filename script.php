<?php 
include('connection.php');

$data = json_decode(stripslashes($_POST['data']));

for($j=0;$j<sizeof($data);$j++)
{
	$index = strrpos($data[$j],"_") -1;
	$data[$j] = substr($data[$j],0,$index);
}
for($i=0;$i<sizeof($data);$i++){
//$sql = "insert into excel_student values('".$data[$i]."') where groupname IS NOT NULL ";

$sql = "update excel_student set facultyname = '".$data[$i]."' where groupname= 'e".($i+1)."'";
$connect->query($sql);



}

echo $data[4];





  ?>