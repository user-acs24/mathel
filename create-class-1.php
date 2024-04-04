<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == "") {   
    header("Location: index.php"); 
    exit();
} else {
    $msg = "";
    $error = "";

    if(isset($_POST['submit'])) {
        $classname = $_POST['classname'];
        $classnamenumeric = $_POST['classnamenumeric']; 
        $section = $_POST['section'];

        $sql = "INSERT INTO tblclassess(ClassName, ClassNameNumeric, Section) VALUES(:classname, :classnamenumeric, :section)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':classname', $classname, PDO::PARAM_STR);
        $query->bindParam(':classnamenumeric', $classnamenumeric, PDO::PARAM_STR);
        $query->bindParam(':section', $section, PDO::PARAM_STR);
      
        if ($query->execute()) {
            $msg = "Department Created successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Department</title>
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
    <style>
        /* Your custom styles here */
    </style>
</head>
<body class="top-navbar-fixed">
<div class="main-wrapper">
    <!-- ========== TOP NAVBAR ========== -->
    <?php include('includes/topbar.php'); ?>   
    <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
    <div class="content-wrapper">
        <div class="content-container">
            <!-- ========== LEFT SIDEBAR ========== -->
            <?php include('includes/leftbar-1.php'); ?>                   
            <!-- /.left-sidebar -->

            <div class="main-page">
                <div class="container-fluid">
                    <div class="row page-title-div">
                        <div class="col-md-6">
                            <h2 class="title">Create Department</h2>
                        </div>
                    </div>
                    <!-- /.row -->
                    <div class="row breadcrumb-div">
                        <div class="col-md-6">
                            <ul class="breadcrumb">
                                <li><a href="dashboard-teacher1.php"><i class="fa fa-home"></i> Home</a></li>
                                <li><a href="#">Departments</a></li>
                                <li class="active">Select Department</li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->

                <section class="section">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5>Select Department</h5>
                                        </div>
                                    </div>
                                    <?php if($msg) { ?>
                                        <div class="alert alert-success left-icon-alert" role="alert">
                                            <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                        </div>
                                    <?php } elseif($error) { ?>
                                        <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                    <?php } ?>
                                    <div class="panel-body">
                                        <form method="post">
                                            <div class="form-group has-success">
                                                <label for="success" class="control-label">Select Department</label>
                                                <div class="">
                                                    <select name="classname" class="form-control" id="default" required="required">
                                                        <option value="">Select Department</option>
                                                        <?php 
                                                        $sql = "SELECT * FROM tblclasses";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        if($query->rowCount() > 0) {
                                                            foreach($results as $result) {   
                                                        ?>
                           <option value="<?php echo htmlentities($result->ClassName); ?>" class="<?php echo htmlentities($result->ClassNameNumeric); ?>" Year="<?php echo htmlentities($result->ClassNameNumeric); ?>" section="<?php echo htmlentities($result->Section); ?>"><?php echo htmlentities($result->ClassName); ?>&nbsp; Year-<?php echo htmlentities($result->ClassNameNumeric); ?>&nbsp; Section-<?php echo htmlentities($result->Section); ?></option>

                                                        <?php 
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <label for="classnamenumeric" class="control-label">Year</label>
<input type="text" name="classnamenumeric" id="classnamenumeric" class="form-control" required="required">

<label for="section" class="control-label">Section</label>
<input type="text" name="section" id="section" class="form-control" required="required">

                                            
                                            <div class="form-group has-success">
                                                <div class="">
                                                   <button type="submit" name="submit" class="btn btn-success btn-labeled">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.main-page -->
        </div>
        <!-- /.content-container -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer-->
    <?php include('includes/footer.php'); ?>
</div>
<!-- /.main-wrapper -->

<!-- ========== COMMON JS FILES ========== -->
<script src="js/jquery/jquery-2.2.4.min.js"></script>
<script src="js/jquery-ui/jquery-ui.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/pace/pace.min.js"></script>
<script src="js/lobipanel/lobipanel.min.js"></script>
<script src="js/iscroll/iscroll.js"></script>

<!-- ========== PAGE JS FILES ========== -->
<script src="js/prism/prism.js"></script>

<!-- ========== THEME JS ========== -->
<script src="js/main.js"></script>

<!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
</body>
</html>
