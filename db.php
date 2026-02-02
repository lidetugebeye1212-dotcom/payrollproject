<?php
$conn = mysqli_connect('localhost', 'root', '');

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

$select_db = mysqli_select_db($conn, 'payroll_s');
if (!$select_db) {
    die("Database Selection Failed: " . mysqli_error($conn));
}
