<?php
	include_once'__autoload.php';

	if(Session::getSession('user') != 'student'){
		header('location:login.php');
	}

	if(isset($_POST['btnLogoutStud'])){
		Session::unset_session('user');
		Session::destroy();
		header('location:login.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<title>CCJ Assesment</title>
</head>
<body>
	<div class="container" style="margin-top:40px;">
	<div class="col-md-offset-3 col-md-6">
		<div class="list-group text-center">
			<a class="list-group-item active">Graphical Queries</a>
			<a href="yearlyResult.php" class="list-group-item">Percentage of Yearly Result</a>
			<a href="yearlyPassing.php" class="list-group-item">Percentage of Yearly Passing</a>
			<a href="batchPercentage.php" class="list-group-item">Percentage of Batch per year</a>
			<a href="npr.php" class="list-group-item">National Passing Rate Percentage</a>
			<a class="list-group-item active">Tabular Queries</a>
			<a href="totalExaminees.php" class="list-group-item">Total Examinees Table</a>
			<a href="totalPassed.php" class="list-group-item">Total Passed Table</a>
			<a href="totalFailed.php" class="list-group-item">Total Failed Table</a>
			<a href="correlation.php" class="list-group-item">Examinee and Result Correlation</a>
		</div>
		<form method='post'>
			<button type="submit" onclick="return confirm('Logout now?');" class="btn btn-warning" name="btnLogoutStud">Logout <i class="fa fa-arrow-circle-right"></i></span></button>
		</form>
	</div>
</div>

<?php include_once 'include/footer.php'; ?>