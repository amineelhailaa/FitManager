<?php
require "../connection/connect.php";
global $connection;
$cours = $_GET['id_cours'];
$equi = $_GET['id_equipement'];
mysqli_begin_transaction($connection);
$query = "delete from cours_equipement where id_cours=$cours and id_equipement = $equi";
$query2 = "update equipements set qte=qte+(select quantity from cours_equipement where id_cours=$cours and id_equipement = $equi) where id_equipement= $equi ";
if(mysqli_query($connection,$query2) ){

    if (mysqli_query($connection,$query)){
        mysqli_commit($connection);
        header('location: associations.php?id=5000');

    }
    else{
        mysqli_rollback($connection);
        header("location: index.php");

    }

}
else{
    mysqli_rollback($connection);
    header("location: index.php");
}

exit();