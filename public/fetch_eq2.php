<?php


global $connection;
include("../connection/connect.php");

$id = $_GET['id'];
$data = "select * from equipements where id_equipement=$id";
$result = mysqli_query($connection, $data);
$row = mysqli_fetch_assoc($result);
echo json_encode($row);
