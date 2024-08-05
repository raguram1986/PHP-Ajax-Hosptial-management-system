<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "layhospital";
$conn = new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error)
{
    die("connection failed" . $conn->connect_error);
}
$query = "select  * from patient ORDER by patientno desc limit 1";
if($result = mysqli_query($conn,$query))
{
    $row = mysqli_fetch_assoc($result);
    $count = $row['patientno'];
    $count = $count + 1;
    $codeno  = "S" . $codeno;
    echo json_encode($codeno);
}
?>