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
$query = "select MAX(cast(id as decimal)) id from item";
if($result = mysqli_query($conn,$query))
{
    $row = mysqli_fetch_assoc($result);
    $count = $row['id'];
    $count = $count + 1;
    $codeno = str_pad($count,4, "0", STR_PAD_LEFT);
    echo json_encode($codeno);
















}
?>