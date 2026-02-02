<?php
include("db.php");
include("auth.php");

// Fetch default deduction rates
$deductions = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM deductions WHERE deduction_id=1"));
$healthinsurance = $deductions['healthinsurance'];
$garnishments = $deductions['garnishments'];
$others = $deductions['others'];
$fica = $deductions['fica'];
$loans = $deductions['loans'];

// Get employee ID
if(isset($_GET['emp_id'])){
    $emp_id = $_GET['emp_id'];
    $employee = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM employee WHERE emp_id='$emp_id'"));
} else {
    die("Error: Employee ID not specified!");
}

// Get overtime rate
$overtime_rate = mysqli_fetch_assoc(mysqli_query($conn, "SELECT rate FROM overtime LIMIT 1"))['rate'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payroll System - Employee Account</title>
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/justified-nav.css" rel="stylesheet">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" crossorigin="anonymous"/>
</head>
<body>
<div class="container">
    <div class="masthead">
        <h3>
            <b><a href="index.php" style="text-decoration:none; color:#3fb1d4;">
                <img src="assets/img.png" width="28px"> Payroll System</a></b>
            <a href="#colins" data-toggle="modal" class="pull-right">
                <button class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Exit</button>
            </a>
        </h3>
        <nav>
            <ul class="nav nav-justified">
                <li class="active"><a href="home_employee.php">Employee Section</a></li>
                <li><a href="home_deductions.php">Manage Deductions</a></li>
                <li><a href="home_salary.php">Payroll Section</a></li>
            </ul>
        </nav>
    </div>
    <br>

    <form action="update_salary.php" method="post" class="form-horizontal">
        <input type="hidden" name="emp_id" value="<?php echo $employee['emp_id']; ?>">

        <div class="form-group">
            <label class="col-sm-3 control-label">Employee:</label>
            <div class="col-sm-6">
                <h4><?php echo $employee['lname'] . ", " . $employee['fname']; ?></h4>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Salary:</label>
            <div class="col-sm-6">
                <input type="number" name="salary" class="form-control" value="<?php echo $employee['salary']; ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Overtime (hrs):</label>
            <div class="col-sm-6">
                <input type="number" name="overtime" class="form-control" value="<?php echo $employee['overtime']; ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Bonus:</label>
            <div class="col-sm-6">
                <input type="number" name="bonus" class="form-control" value="<?php echo $employee['bonus']; ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Deduction:</label>
            <div class="col-sm-6">
                <select name="deduction" class="form-control" required>
                    <option value="<?php echo $employee['deduction']; ?>"><?php echo $employee['deduction']; ?></option>
                    <option value="<?php echo $healthinsurance; ?>">Health Insurance</option>
                    <option value="<?php echo $garnishments; ?>">Garnishments</option>
                    <option value="<?php echo $others; ?>">Others</option>
                    <option value="<?php echo $fica; ?>">FICA</option>
                    <option value="<?php echo $loans; ?>">Loans</option>
                </select>
            </div>
        </div>

        <?php
        $net_pay = $employee['salary'] + ($employee['overtime'] * $overtime_rate) + $employee['bonus'] - $employee['deduction'];
        ?>

        <div class="form-group">
            <label class="col-sm-3 control-label">Net Pay:</label>
            <div class="col-sm-6">
                <h4>₱ <?php echo number_format($net_pay, 2); ?></h4>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-success">Update Salary</button>
                <a href="home_employee.php" class="btn btn-primary">Cancel</a>
            </div>
        </div>
    </form>

    <!-- Logout modal -->
    <div class="modal fade" id="colins" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3>You are logged in as <b><?php echo $_SESSION['username']; ?></b></h3>
                </div>
                <div class="modal-body">
                    <a href="logout.php" class="btn btn-block btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
