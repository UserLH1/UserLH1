<?php 
require_once("db.php");
//

require('fpdf185/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();

// code for print Heading of tables
$pdf->SetFont('Arial','B',12);	
// Load the database configuration file 
$servername = "localhost";  
$username = "root";  
$password = "";  
$dbname = "login_system";  
// Create a connection  
$connection_data = new mysqli($servername, $username, $password, $dbname);  
// Check the connection  
if ($connection_data->connect_error) {  
    die("Connection failed: " . $connection_data->connect_error);  
}  
 
// Fetch records from database 
$query = $connection_data->query("SELECT id, username, CONCAT(SUBSTRING(password,1,10),'...') AS password, email, academic_context, phone FROM users" ); 
//start
if($query->num_rows > 0)
{
    $pdf->Ln();
    $pdf->Cell(14,12,'id',1);
            $pdf->Cell(40,12,'Nume si Prenume',1);
            $pdf->Cell(30,12,'Parola',1);
            $pdf->Cell(46,12,'Email',1);
            $pdf->Cell(25,12,'Context',1);
            $pdf->Cell(35,12,'Telefon',1);
            
    while($row = $query->fetch_assoc()){ 
        //$status = ($row['status'] == 1)?'Active':'Inactive'; 
       // $lineData = array($row['id'], $row['username'], $row['password'], $row['email'], $row['create_datetime']); 
        //fputcsv($f, $lineData, $delimiter); 
        $pdf->SetFont('Arial','',10);	
            $pdf->Ln();
            //$pdf->Cell(46,12,$column,1);
           // foreach($row as $column)
            $pdf->Cell(14,12,$row['id'],1);
            $pdf->Cell(40,12,$row['username'],1);
            $pdf->Cell(30,12,$row['password'],1);
            $pdf->Cell(46,12,$row['email'],1);
            $pdf->Cell(25,12,$row['academic_context'],1);
            $pdf->Cell(35,12,$row['phone'],1);
            
    } 


    // foreach($results as $row) {
    //         $pdf->SetFont('Arial','',12);	
    //         $pdf->Ln();
    //         foreach($row as $column)
    //             $pdf->Cell(46,12,$row['id'],1);
    //             $pdf->Cell(46,12,$row['username'],1);
    //     } 
}
    $pdf->Output();
//end

exit; 
 
?>