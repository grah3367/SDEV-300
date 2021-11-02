<?php 
require_once('/Includes/Dbconnect.php');
$tutor1Pass = password_hash("t123", PASSWORD_DEFAULT);
$tutor2Pass = password_hash("t234", PASSWORD_DEFAULT);
$tutor2Pass = password_hash("t345", PASSWORD_DEFAULT);


$mysqli = connectdb();

$stmt1 = $mysqli->prepare('insert into TutorDetails values ("tutor1","?")');
$stmt1->bind_param('s',$tutor1Pass);
$stmt2 = $mysqli->prepare('insert into TutorDetails values ("tutor2","?")');
$stmt2->bind_param('s',$tname);
$stmt3 = $mysqli->prepare('insert into TutorDetails values ("tutor3","?")');
$stmt3->bind_param('s',$tname);

$stmt1->execute();
$stmt2->execute();
$stmt3->execute();

?>