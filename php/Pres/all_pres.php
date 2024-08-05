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

$stmt = $conn->prepare("select pid,cno,dtype,des from  prescription order by pid DESC");
$stmt->bind_result($pid,$cno,$dtype,$des);

if($stmt->execute())
{
    while($stmt->fetch())
    {
        $output[] = array("pid"=> $pid,"cno"=> $cno,"dtype"=> $dtype,"des"=> $des);
    }

    echo json_encode( $output);
}
$stmt->close();



?>