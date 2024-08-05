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


if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $stmt = $conn->prepare("insert into user(fullname,uname,password,utype) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss",$fullname,$uname,$password,$utype);

    $fullname = $_POST['fullname'];
    $uname = $_POST['uname'];
    $password = md5($_POST["pass"]);
    $utype =  $_POST['utype'];

    if($stmt->execute())
    {
        echo 1;
    }
    else
    {
        echo 0;
    }


    $stmt->close();


}


?>