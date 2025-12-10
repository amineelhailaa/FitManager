<?php

global $connection;
include ("../connection/connect.php");

$id = $_GET['id'];
$data = "select * from cours where id_cours='$id'";
$result = mysqli_query($connection, $data);

$row = mysqli_fetch_assoc($result);
echo json_encode($row);
