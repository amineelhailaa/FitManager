<?php

$host = "localhost";
$user = "root";
$password = "281102";
$database = "brief";

try {
    $connection = mysqli_connect($host, $user, $password, $database);
}
catch (mysqli_sql_exception) {
    echo "error srry";
}

//if($connection){
//    echo "connected";
//}
