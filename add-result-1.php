<?php include('includes/config.php'); ?>
 <!DOCTYPE html>
<html lang="en" dir="ltr">
	<head> 
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SRMS Admin | Declare Result </title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">

	</head>
	<body>
    <body class="top-navbar-fixed">
<div class="main-wrapper">
    <!-- ========== TOP NAVBAR ========== -->
    <?php include('includes/topbar.php');?>
    <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
    <div class="content-wrapper">
        <div class="content-container">
            <!-- ========== LEFT SIDEBAR ========== -->
            <?php include('includes/leftbar-1.php');?>
            <!-- /.left-sidebar -->
            <div class="main-page">
                <div class="container-fluid">
                    <div class="row page-title-div">
                        <div class="col-md-6">
                            <h2 class="title"> Result Entry</h2>
                        </div>
                    </div>
                    <div class="row breadcrumb-div">
                        <div class="col-md-6">
                            <ul class="breadcrumb">
                                <li><a href="dashboard-teacher1.php"><i class="fa fa-home"></i> Home</a></li>
                                <li><a href="#">Results</a></li>
                                <li class="active"></li>
                            </ul>
                        </div>
                    </div>
                </div>
		<form class="" action="" method="post" enctype="multipart/form-data">
			<input type="file" name="excel" required value="">
			<button type="submit" name="import">Import</button>
		</form>
		<hr>
		<table border = 1>
			<tr>
				<td>#</td>
				<td>Student id </td>
				<td>Class Id </td>
				<td>Subject Id </td>
				<td>Marks</td>
			</tr>
			<?php
			$i = 1;
			$rows = mysqli_query($conn, "SELECT * FROM tb_data");
			foreach($rows as $row) :
			?>
			<tr>
				<td> <?php echo $i++; ?> </td>
				<td> <?php echo $row["StudentId"]; ?> </td>
				<td> <?php echo $row["ClassId"]; ?> </td>
				<td> <?php echo $row["SubjectId"]; ?> </td>
				<td> <?php echo $row["marks"]; ?> </td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php
		if(isset($_POST["import"])){
			$fileName = $_FILES["excel"]["name"];
			$fileExtension = explode('.', $fileName);
      $fileExtension = strtolower(end($fileExtension));
			$newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

			$targetDirectory = "uploads/" . $newFileName;
			move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

			error_reporting(0);
			ini_set('display_errors', 0);

			require 'excelReader/excel_reader2.php';
			require 'excelReader/SpreadsheetReader.php';

			$reader = new SpreadsheetReader($targetDirectory);
			foreach($reader as $key => $row){
				$studentid = $row[0];
				$classid= $row[1];
				$subjectid = $row[2];
				$marks=$row[3];
				mysqli_query($conn, "INSERT INTO tb_data VALUES('', '$Studentid', '$ClassId', '$Subjectid','$marks' )");
			}

			echo
			"
			<script>
			alert('Succesfully Imported');
			document.location.href = '';
			</script>
			";
		}
		?>
	</body>
</html>
