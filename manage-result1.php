<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
{   
    header("Location: index.php"); 
}
else
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
<head> 
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SRMS Admin | Declare Result </title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">

	</head>
</head>
<body class="top-navbar-fixed">
    <!-- Main content here -->
    <?php include('includes/topbar.php');?> 
    <div class="content-wrapper">
        <div class="content-container">
            <?php include('includes/leftbar-1.php');?>  
            <div class="main-page">
                <div class="container-fluid">
                    <!-- Content section here -->
                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>View Students Result Info</h5>
                                            </div>
                                        </div>
                                        <?php if($msg){?>
                                        <div class="alert alert-success left-icon-alert" role="alert">
                                            <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                        </div>
                                        <?php } 
                                        else if($error){?>
                                            <div class="alert alert-danger left-icon-alert" role="alert">
                                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php } ?>
                                        <div class="panel-body p-20">
                                            <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>S.no</th>
                                                        <th>Student Name</th>
                                                        <th>Reg. No</th>
                                                        <th>Department</th>
                                                        <th>Marks</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $sql = "SELECT DISTINCT tblstudentss.StudentName, tblstudentss.RollId, tblstudentss.StudentId, tblclassess.ClassName, tblclassess.ClassNameNumeric, tblclassess.Section, tb_data.marks FROM tb_data JOIN tblstudentss ON tblstudentss.StudentId = tb_data.StudentId JOIN tblclassess ON tblclassess.id = tb_data.ClassId";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    $cnt = 1;
                                                    if($query->rowCount() > 0)
                                                    {
                                                        foreach($results as $result)
                                                        {   
                                                    ?>
                                                            <tr>
                                                                <td><?php echo htmlentities($cnt);?></td>
                                                                <td><?php echo htmlentities($result->StudentName);?></td>
                                                                <td><?php echo htmlentities($result->RollId);?></td>
                                                                <td><?php echo htmlentities($result->ClassName);?>&nbsp; Year-<?php echo htmlentities($result->ClassNameNumeric); ?> &nbsp; Section-<?php echo htmlentities($result->Section);?></td>
                                                                <td><?php echo htmlentities($result->marks);?></td>
                                                                <td>
                                                                    <a href="edit-result.php?stid=<?php echo htmlentities($result->StudentId);?>"><i class="fa fa-edit" title="Edit Record"></i></a> 
                                                                </td>
                                                            </tr>
                                                            <?php $cnt=$cnt+1;
                                                        }
                                                    } 
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php 
}
?>
