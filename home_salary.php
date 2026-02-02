<?php
include("db.php");
include("auth.php");

// Fetch current overtime rate
$overtime_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT rate FROM overtime LIMIT 1"));
$overtime_rate = $overtime_row['rate'] ?? 0;

// Fetch all employees
$employees = mysqli_query($conn, "SELECT * FROM employee ORDER BY emp_id ASC");

// Fetch default deductions
$deductions = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM deductions WHERE deduction_id=1"));
$healthinsurance = $deductions['healthinsurance'];
$garnishments    = $deductions['garnishments'];
$others          = $deductions['others'];
$fica            = $deductions['fica'];
$loans           = $deductions['loans'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payroll System - Payroll Section</title>
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/justified-nav.css" rel="stylesheet">
<link href="assets/css/dataTables.min.css" rel="stylesheet">
<link href="assets/css/search.css" rel="stylesheet">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" crossorigin="anonymous"/>
<style>
.table th, .table td { vertical-align: middle !important; }
</style>
</head>
<body>
<div class="container">
    <div class="masthead">
        <h3>
            <b><a href="index.php" style="text-decoration:none; color:#3fb1d4;">
                <img src="assets/img.png" width="28px"> Payroll System</a></b>
            <a data-toggle="modal" href="#colins" class="pull-right">
                <button class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Exit</button>
            </a>
        </h3>
        <nav>
            <ul class="nav nav-justified">
                <li><a href="home_employee.php">Employee Section <span class="label label-primary"><?php echo mysqli_num_rows($employees); ?></span></a></li>
                <li><a href="home_deductions.php">Manage Deductions</a></li>
                <li class="active"><a href="">Payroll Section</a></li>
            </ul>
        </nav>
    </div>

    <br>
    <div class="well bs-component">
        <fieldset>
            <div class="row mb-2">
                <div class="col-md-6">
                    <button type="button" data-toggle="modal" data-target="#overtime" class="btn btn-warning"><i class="fa fa-hourglass-half"></i> Update Overtime Rate</button>
                </div>
                <div class="col-md-6 text-right">
                    <p>Overtime Rate (Per Hour): <b><?php echo number_format($overtime_rate,2); ?></b></p>
                </div>
            </div>

            <p align="center"><big><b>Payroll</b></big></p>
            <div class="table-responsive">
                <table class="table table-hover table-condensed" id="myTable">
                    <thead>
                        <tr>
                            <th>Fullname</th>
                            <th>Salary</th>
                            <th>Overtime (hrs)</th>
                            <th>Overtime Pay</th>
                            <th>Bonus</th>
                            <th>Deductions</th>
                            <th>Net Pay</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($emp = mysqli_fetch_assoc($employees)):
                            $salary = $emp['salary']; // use employee's own salary
                            $overtime_pay = $emp['overtime'] * $overtime_rate;
                            $bonus = $emp['bonus'];
                            $deduction = $emp['deduction'];
                            $netpay = $salary + $overtime_pay + $bonus - $deduction;
                        ?>
                        <tr>
                            <td align="center"><?php echo $emp['fname'] . ' ' . $emp['lname']; ?></td>
                            <td align="center">₱ <?php echo number_format($salary,2); ?></td>
                            <td align="center"><?php echo $emp['overtime']; ?> hrs</td>
                            <td align="center">₱ <?php echo number_format($overtime_pay,2); ?></td>
                            <td align="center">₱ <?php echo number_format($bonus,2); ?></td>
                            <td align="center">₱ <?php echo number_format($deduction,2); ?></td>
                            <td align="center">₱ <?php echo number_format($netpay,2); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </fieldset>
    </div>

    <!-- Update Overtime Modal -->
    <div class="modal fade" id="overtime" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">Enter Overtime Rate (Per Hour)</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="update_overtime.php">
                        <input type="number" step="0.01" name="rate" class="form-control" value="<?php echo $overtime_rate; ?>" required>
                        <br>
                        <input type="submit" name="submit" class="btn btn-success btn-block" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Logged in modal -->
    <div class="modal fade" id="colins" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">You are logged in as <b><?php echo $_SESSION['username']; ?></b></h4>
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
<script src="assets/js/dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#myTable').DataTable();
});
</script>
</body>
</html>
