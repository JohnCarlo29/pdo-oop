<?php 
	include_once 'include/header.php';
	include_once 'include/navbar.php'; 
	require 'vendor/autoload.php';

	if(Session::getSession('user') != 'admin'){
		header('location:login.php');
	}

	$examinees = new Examinees();
	$examineesId = $examinees->getExamineesNo();

?>
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">
				<h3>Update Result</h3>
			</div>
		</div>
		<div class="panel-body">
			<form id="updateResultForm">
				<div class="row resultPanel">
					<div class="col-md-6">
						<div class="form-group">
							<label for="studno" class="col-md-3 control-label">Student No.</label>
							<div class="col-md-9">
								<select id="studno" name="studNo" class="form-control choosen">
									<option value="0" read-only>Select Examinee No</option>
									<?php foreach ($examineesId as $examineeId) { ?>
										<option value="<?php echo $examineeId->id ?>"><?php echo $examineeId->examinee_no ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<table class="table table-bordered text-center">
					<thead>
						<tr>
							<th width="70%" class="text-center">Subjects</th>
							<th width="15%" class="text-center">Weights</th>
							<th width="15%" class="text-center">Ratings</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Criminal Jurisprudence and Procedure</td>
							<td>20</td>
							<td><input type="number" class="form-control text-center" id="test1" name="test1"></td>
						</tr>
						<tr>
							<td>Law Enforcement Administration</td>
							<td>20</td>
							<td><input type="number" class="form-control text-center" id="test2" name="test2" maxlength="2"></td>
						</tr>
						<tr>
							<td>Crime Detection Investigation and Prevention</td>
							<td>15</td>
							<td><input type="number" class="form-control text-center" id="test3" name="test3" maxlength="2"></td>
						</tr>
						<tr>
							<td>Criminalistics</td>
							<td>20</td>
							<td><input type="number" class="form-control text-center" id="test4" name="test4" maxlength="2"></td>
						</tr>
						<tr>
							<td>Correctional Administration</td>
							<td>10</td>
							<td><input type="number" class="form-control text-center" id="test5" name="test5" maxlength="2"></td>
						</tr>
						<tr>
							<td>Criminal Sociology Ethics and Human Relation</td>
							<td>15</td>
							<td><input type="number" class="form-control text-center" id="test6" name="test6" maxlength="2"></td>
						</tr>
					</tbody>
				</table>
			</form>
				<button class="btn btn-primary pull-right" id="submitResult" onclick="updateResult();">Submit</button>
		</div>
	</div>
</div>

<?php include_once 'include/footer.php'; ?>