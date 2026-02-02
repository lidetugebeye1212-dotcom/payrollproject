<?php

include 'db.php';

if(!$conn){
    die("Connection Failed");
}

$result = mysqli_query($conn, "SELECT * FROM employee");
$rows = mysqli_num_rows($result);
echo $rows;
?>