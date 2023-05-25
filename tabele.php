<!DOCTYPE html>
<html>
<head>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #2d63c8;
    color: white;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

button {
    color: #ffffff;
    background-color: #2d63c8;
    font-size: 15px;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #4471e0;
}

a {
    text-decoration: none;
}
</style>
</head>
<body>
<?php
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
$sql_data_display = "SELECT id, username, password, email, academic_context, phone FROM users";
$result_data = $connection_data->query($sql_data_display);
if ($result_data->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Nume si Prenume</th>
                <th>Email</th>
                <th>Parola</th>
                <th>Context Academic</th>
                <th>Nr. Telefon</th>

            </tr>";
    // output data of each row
    while($row = $result_data->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"]. "</td>
                <td>" . $row["username"]. "</td>
                <td>" . $row["email"]. "</td>
                <td>" . $row["password"]. "</td>
                <td>" . $row["academic_context"]. "</td>
                <td>" . $row["phone"]. "</td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "Error or no results";
}
$connection_data->close();
?>

<br><br>
<a href="exportCSV.php"><button type="button" name="export_csv">EXPORT CSV</button></a>
<a href="exportPDF.php"><button type="button" name="export_pdf">EXPORT PDF</button></a>
</body>
</html>
