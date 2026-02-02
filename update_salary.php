<?php
include("db.php");

if(isset($_POST['emp_id'])) {
    $emp_id     = $_POST['emp_id'];
    $salary     = $_POST['salary'];
    $overtime   = $_POST['overtime'];
    $bonus      = $_POST['bonus'];
    $deduction  = $_POST['deduction'];

    $sql = mysqli_query($conn, "UPDATE employee 
                                SET salary='$salary', overtime='$overtime', bonus='$bonus', deduction='$deduction'
                                WHERE emp_id='$emp_id'");

    if($sql) {
        echo "<script>alert('Employee salary updated successfully!'); window.location.href='home_employee.php';</script>";
    } else {
        die("Error updating employee: " . mysqli_error($conn));
    }
} else {
    die("No employee selected!");
}
?>
