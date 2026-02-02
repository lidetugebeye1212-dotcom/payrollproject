<?php
require("db.php"); // Use the same db connection

if(isset($_POST['submit']))
{
    // Collect form data safely
    $lname      = mysqli_real_escape_string($conn, $_POST['lname']);
    $fname      = mysqli_real_escape_string($conn, $_POST['fname']);
    $gender     = mysqli_real_escape_string($conn, $_POST['gender']);
    $type       = mysqli_real_escape_string($conn, $_POST['emp_type']);
    $division   = mysqli_real_escape_string($conn, $_POST['division']);
    $contact    = mysqli_real_escape_string($conn, $_POST['contact']);
    $address    = mysqli_real_escape_string($conn, $_POST['address']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $salary     = mysqli_real_escape_string($conn, $_POST['salary']); // NEW salary field

    // Insert employee into DB, including salary
    $sql = mysqli_query($conn, "INSERT INTO employee (lname, fname, gender, emp_type, division, contact, address, email, salary) 
                               VALUES ('$lname', '$fname', '$gender', '$type', '$division', '$contact', '$address', '$email', '$salary')");

    if($sql)
    {
        ?>
        <script>
            alert('Employee has been added successfully!');
            window.location.href='home_employee.php?page=emp_list';
        </script>
        <?php
    }
    else
    {
        ?>
        <script>
            alert('An error occurred: <?php echo mysqli_error($conn); ?>');
            window.location.href='index.php';
        </script>
        <?php
    }
}
?>
