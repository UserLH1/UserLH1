<?php 
 
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
$query = $connection_data->query("SELECT id, username, password, email, academic_context, phone FROM users" ); 
 
if($query->num_rows > 0){ 
    $delimiter = ","; 
    $filename = "members-data_" . date('Y-m-d') . ".csv"; 
    $f = fopen('php://memory', 'w'); 

    $fields = array('id', 'username', 'password', 'email', 'academic_context','phone'); 
    fputcsv($f, $fields, $delimiter); 
     
    while ($row = $query->fetch_assoc()) {
        $lineData = array(
            $row['id'],
            $row['username'],
            $row['password'],
            $row['email'],
            $row['academic_context'],
            '"' . $row['phone'] . '"' 
        );
        fputcsv($f, $lineData, $delimiter); 
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit; 
 
?>