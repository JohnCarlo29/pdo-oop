<?php 
	include_once 'include/header.php';

	if(Session::getSession('user') != 'student'){
		//header('location:login.php');
		include_once 'include/navbar.php'; 
	}
?>

<div class="container">
	<div class="col-md-12">
		<div class="myChartDiv">
			<canvas id="myChart1" width="400" height="400"></canvas>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 text-center">
			<h3><u>Subjects Description</u></h3>
			<h4>Criminal Jurisprudence and Procedure(CJP)</h4>
			<h4>Law Enforcement Administration(LEA)</h4>
			<h4>Crime Detection Investigation and Prevention(CDIP)</h4>
			<h4>Criminalistics(C)</h4>
			<h4>Correctional Administration(CA)</h4>
			<h4>Criminal Sociology Ethics and Human Relation(CSEHR)</h4>
		</div>
		<div class="col-md-6 text-center">
			<h3><u>Data Analysis</u></h3>
			<div id="analysis1">
			</div>
		</div>
	</div>
</div>
<div class="text-center" style="margin: 40px !important;">
<a href="javascript:printing()" class="btn btn-md btn-primary">print</a>
</div>

<?php include_once 'include/footer.php'; ?>
