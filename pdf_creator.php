<?php  
 function fetch_data()  
 {  
      $output = '';  
      $conn = mysqli_connect("localhost", "root", "server", "student");  
      $sql = "SELECT * FROM excel_student";  
      $result = mysqli_query($conn, $sql);  
      while($row = mysqli_fetch_array($result))  
      {       
      $output .= '<tr>  
                          <td>'.$row["srno"].'</td>  
                          <td>'.$row["roll"].'</td>  
                          <td>'.$row["name"].'</td>  
                          <td>'.$row["groupname"].'</td>  
                          <td>'.$row["facultyname"].'</td>  
                     </tr>  
                          ';  
      }  
      return $output;  
 }  
 if(isset($_POST["generate_pdf"]))  
 {  
      require_once('tcpdf/tcpdf.php');  
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      $obj_pdf->SetCreator(PDF_CREATOR);  
      $obj_pdf->SetTitle("Group and Guides (Evening shift)");  
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('helvetica');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(TRUE, 10);  
      $obj_pdf->SetFont('helvetica', '', 11);  
      $obj_pdf->AddPage();   // To generate pdf
      $content = '';  
      $content .= '  
      <h2 align="center">Group and Guides (Evening shift)</h2>
                <h4 align="center"> Following is the list of the project guides alloted to students of D4CSE</h4><br />  
      <table border="1" cellspacing="0" cellpadding="4">  
           <tr>  
                <th width="8%"><b>Srno</b></th>
                 <th width="15%"><b>RollNo</b></th>  
                 <th width="30%"><b>Name</b></th>  
                 <th width="10%"><b>Group</b></th>
                 <th width="40%"><b>GuideName</b></th>  
            </tr>  
      ';  
      $content .= fetch_data();  
      $content .= '</table>';  
      $obj_pdf->writeHTML($content);  
      $obj_pdf->Output('Guide_Allotment_list.pdf', 'I');  
 }  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Group and Guides (Evening shift)</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />            
      </head>  
      <body>  
           <br />
           <div class="container">  
                <h2 align="center">Group and Guides (Evening shift)</h2>
                <h4 align="center"> Following is the list of the project guides alloted to students of D4CSE</h4><br />  
                <div class="table-responsive">  
                	<div class="col-md-12" align="right">
                     <form method="post">  
                          <input type="submit" name="generate_pdf" class="btn btn-success" value="Generate PDF" />  
                     </form>  
                     </div>
                     <br/>
                     <br/>
                     <table class="table table-bordered" >  
                          <tr>  
                              <th width="10%">Srno</th>
                               <th width="15%">RollNo</th>  
                               <th width="20%">Name</th>  
                               <th width="10%">GroupNo</th>
                               <th width="30%">GuideName</th>  
                          </tr>  
                     <?php  
                     echo fetch_data();  
                     ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
</html>