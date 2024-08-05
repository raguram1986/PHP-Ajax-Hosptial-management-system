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



$stmt = $conn->prepare("select c.chno,d.dname,p.name,c.rno,c.date from channel c JOIN  doctor d ON c.docno = d.doctorno JOIN  patient p ON  c.pno = p.patientno where d.log_id = ?");
$stmt->bind_param("s",$logid);
$logid = $_POST['logid'];



$stmt->bind_result($chno,$dname,$pname,$rno,$date);

if($stmt->execute())
{
    while($stmt->fetch())
    {
        $output[] = array("chno"=> $chno,"dname"=> $dname,"pname"=> $pname,"rno"=> $rno,"date"=> $date);
    }

    echo json_encode( $output);
}
$stmt->close();



?>