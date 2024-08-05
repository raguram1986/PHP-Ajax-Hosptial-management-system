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

$stmt = $conn->prepare("select patientno,name,phone,address from patient order by patientno DESC");
$stmt->bind_result($patientno,$name,$phone,$address);

if($stmt->execute())
{
    while($stmt->fetch())
    {
        $output[] = array("patientno"=> $patientno,"name"=> $name,"phone"=> $phone,"address"=> $address);
    }

    echo json_encode( $output);
}
$stmt->close();



?>