<?php
require "../connection/connect.php";
global $connection;
$cours = $_GET['id_cours'];
$equi = $_GET['id_equipement'];

$query = "delete from cours_equipement where id_cours=$cours and id_equipement = $equi";

if(mysqli_query($connection,$query)){
    header("location: associations.php");
    exit();
}