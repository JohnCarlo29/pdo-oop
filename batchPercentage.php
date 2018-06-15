<?php 
	include_once 'include/header.php';
	Session::start();

	if(Session::getSession('user') != 'student'){
		//header('location:login.php');
		include_once 'include/navbar.php'; 
	} 
?>

<div class="container">
	<div class="col-md-12">
		<h3 class="text-center">Percentage of Batch per year</h3>
		<div class="myChartDiv">
			<canvas id="myChart3" width="400" height="400"></canvas>
		</div>
	</div>
	<div class="col-md-12 text-center">
		<h3><u>Data Analysis</u></h3>
		Batch 1 (outer circle) || Batch 2 (inner circle)
		<div id="analysis3">
		</div>
	</div>
</div>
<div class="text-center" style="margin-top: 40px !important;">
<a href="javascript:printing()" class="btn btn-primary">print</a>
</div>

<?php include_once 'include/footer.php'; ?>
