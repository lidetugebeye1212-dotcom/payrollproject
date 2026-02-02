<?php
include("auth.php"); // include auth.php file on all secure pages
include("add_employee.php"); // handle add employee

// Get default deductions
$sql = mysqli_query($conn, "SELECT * FROM deductions WHERE deduction_id='1'");
$row = mysqli_fetch_array($sql);
$healthinsurance = $row['healthinsurance'];
$garnishments = $row['garnishments'];
$others = $row['others'];
$fica = $row['fica'];
$loans = $row['loans'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payroll System</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/justified-nav.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" crossorigin="anonymous"/>
    <link href="assets/css/search.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="masthead">
        <h3>
            <b><a href="index.php" style="text-decoration:none; color:#3fb1d4;">
            <img src="assets/img.png" alt="logo" width="28px;"> Payroll System</a></b>
            <a data-toggle="modal" href="#colins" class="pull-right">
                <b><button class="btn btn-danger" style="border-radius: 0%;">
                <i class="fas fa-sign-out-alt"></i> Exit</button></b>
            </a>
        </h3>
        <nav>
            <ul class="nav nav-justified" style="border-radius:0%">
                <li class="active"><a href="">Employee Section <span class="label label-danger"><?php include 'total_count.php'; ?></span></a></li>
                <li><a href="home_deductions.php">Manage Deductions</a></li>
                <li><a href="home_salary.php">Payroll Section</a></li>
            </ul>
        </nav>
    </div>

    <br>
    <div class="well bs-component">
        <fieldset>
            <button type="button" data-toggle="modal" data-target="#addEmployee" class="btn btn-info" style="border-radius:0%">
                <i class="fa fa-user-plus"></i> Add Employee Records
            </button>
            <p align="center"><big><b>Employee Records</b></big></p>

            <div class="table-responsive">
                <table class="table table-hover table-condensed" id="myTable">
                    <thead>
                        <tr>
                            <th align="center">Fullname</th>
                            <th align="center">Contact</th>
                            <th align="center">Email</th>
                            <th align="center">Gender</th>
                            <th align="center">Employee Type</th>
                            <th align="center">Department</th>
                            <th align="center">Salary</th>
                            <th align="center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = mysqli_query($conn, "SELECT * FROM employee ORDER BY emp_id ASC") or die(mysqli_error($conn));
                    while($row = mysqli_fetch_array($query))
                    {
                        $id = $row['emp_id'];
                        ?>
                        <tr>
                            <td align="center">
                                <a href="view_employee.php?emp_id=<?php echo $id; ?>" style="text-decoration:none; color:#0b3f75;">
                                    <?php echo $row['fname'].' '.$row['lname']; ?>
                                </a>
                            </td>
                            <td align="center"><?php echo $row['contact']; ?></td>
                            <td align="center"><?php echo $row['email']; ?></td>
                            <td align="center">
                                <?php echo ($row['gender']=='Male') ? '<i class="fas fa-male"></i> M' : '<i class="fas fa-female"></i> F'; ?>
                            </td>
                            <td align="center">
                                <?php
                                $type_class = [
                                    'Shiftworker'=>'label-primary',
                                    'Full-Time'=>'label-danger',
                                    'Part-Time'=>'label-warning',
                                    'Casual'=>'label-success'
                                ];
                                $cls = $type_class[$row['emp_type']] ?? 'label-default';
                                echo '<span class="label '.$cls.'">'.$row['emp_type'].'</span>';
                                ?>
                            </td>
                            <td align="center"><?php echo $row['division']; ?></td>
                            <td align="center">₱ <?php echo number_format($row['salary'],2); ?></td>
                            <td align="center">
                                <a class="btn btn-warning" style="border-radius:60px;" href="view_account.php?emp_id=<?php echo $id; ?>"><i class="fa fa-file-invoice"></i></a>
                                <a class="btn btn-danger" style="border-radius:60px;" href="delete.php?emp_id=<?php echo $id; ?>"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </fieldset>
    </div>

    <!-- ADD EMPLOYEE MODAL -->
    <div class="modal fade" id="addEmployee" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="padding:20px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 align="center"><b>Add New Employee</b></h3>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <form class="form-horizontal" action="#" method="post">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Firstname</label>
                            <div class="col-sm-8"><input type="text" name="fname" class="form-control" required></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Lastname</label>
                            <div class="col-sm-8"><input type="text" name="lname" class="form-control" required></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Gender</label>
                            <div class="col-sm-8">
                                <select name="gender" class="form-control" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8"><input type="email" name="email" class="form-control" required></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Contact</label>
                            <div class="col-sm-8"><input type="number" name="contact" class="form-control" required></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Address</label>
                            <div class="col-sm-8"><input type="text" name="address" class="form-control" required></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Employee Type</label>
                            <div class="col-sm-8">
                                <select name="emp_type" class="form-control" required>
                                    <option value="">Select Type</option>
                                    <option value="Part-Time">Part-Time</option>
                                    <option value="Full-Time">Full-Time</option>
                                    <option value="Shiftworker">Shiftworker</option>
                                    <option value="Casual">Casual</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Department</label>
                            <div class="col-sm-8">
                                <select name="division" class="form-control" required>
                                    <option value="">Select Department</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Purchase">Purchase</option>
                                    <option value="Personnel">Personnel</option>
                                    <option value="Maintenance">Maintenance</option>
                                    <option value="Control">Control</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Human Resource">Human Resource</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Salary</label>
                            <div class="col-sm-8">
                                <input type="number" name="salary" class="form-control" placeholder="Employee Salary" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-4">
                                <button type="submit" name="submit" class="btn btn-success" style="border-radius:60px;"><i class="fa fa-check"></i> Insert</button>
                                <button type="reset" class="btn btn-danger" style="border-radius:60px;"><i class="fa fa-times"></i> Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Logged in modal -->
    <div class="modal fade" id="colins" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" style="padding:20px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 align="center">You are logged in as <b><?php echo $_SESSION['username']; ?></b></h3>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <div align="center">
                        <a href="logout.php" class="btn btn-block btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/search.js"></script>
<script type="text/javascript" charset="utf-8" src="assets/js/dataTables.min.js"></script>
<script>
    $(document).ready(function() { $('#myTable').DataTable(); });
</script>
</body>
</html>
