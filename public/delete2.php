<?php
global $connection;
include ('../connection/connect.php');

$id=$_GET['id'];
if(!is_numeric($id)){
    die("suspcious :)");
}
$cmd = "DELETE FROM cours WHERE id_cours=$id";
mysqli_query($connection, $cmd);
header("location:cours.php");
exit();