<?php
global $connection;
include("../connection/connect.php");
$idToDelete = $_GET['id'];
if(!is_numeric($idToDelete)){
    die("invalid id");
}
$delete = "delete from equipements where id_equipement=$idToDelete";

mysqli_query($connection, $delete);
header("Location: equipements.php");
exit;