<?php 
	include_once 'include/header.php';
	include_once 'include/navbar.php'; 


	$results = new Results();
	if(isset($_POST['addNPR'])){
		$year = Cleaner::clean($_POST['yearRate']);
		$batch = Cleaner::clean($_POST['batch']);
		$rate = Cleaner::clean($_POST['rate']);

		$results->addNPR($year, $batch, $rate);
	}
?>

<div class="container">
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
			<a class="list-group-item active">Results and Reports</a>
			<a type="button" class="list-group-item" data-toggle="modal" data-target="#myModal">Input NPR</a>
			<a href="update_results.php" class="list-group-item">Update Examinees Result</a>
			<a href="report.php" target="_blank" class="list-group-item">Reports</a>
		</div>
	</div>

	<!--modal-->

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<form method="post">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">National Passing Rate</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Year</label>
							<input type="number" class="form-control" name="yearRate" placeholder="Year" value="" />
						</div>
						<div class="form-group">
							<label>Batch</label>
							<select class='form-control' name='batch'>
								<option value="0">1st Batch</option>
								<option value="1">2st Batch</option>
							</select>
						</div>
						<div class="form-group">
							<label>Rating</label>
							<input type="text" class="form-control" name="rate" placeholder="Rating" value="" />
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" name="addNPR">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php include_once 'include/footer.php'; ?>

