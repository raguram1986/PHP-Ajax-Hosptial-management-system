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
$query = "select MAX(doctorno) from doctor";
if($result = mysqli_query($conn,$query))
{
    $row = mysqli_fetch_assoc($result);
    $count = $row['doctorno'];
    if ($count == "")
    {
        $doctor_ID = "CUS0";
    }
    else
    {
        $doctor_ID = substr($count, 3);
        $doctor_ID = intval($doctor_ID);
        $doctor_ID =    ("CUS" . ($doctor_ID + 1));
    }
    echo $doctor_ID;

}
?>

