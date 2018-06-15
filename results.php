<?php 
	include_once 'include/header.php';
	include_once 'include/navbar.php'; 
	require 'vendor/autoload.php';

	if(Session::getSession('user') != 'admin'){
		header('location:login.php');
	}

?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div id="resultYear" class="row">
				<div class="form-inline pull-left col-md-6">
					<label>Year</label>
					<select class="form-control" id="resultyear"></select>
				</div>

				<div class="col-md-6">
					<div class="input-group pull-right col-md-6">
						<input type="text" class="form-control txtResultNum" placeholder="Examinee #">
						<span class="input-group-btn">
						    <button class="btn btn-default" type="button" id="resultSearchBtn">Go!</button>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<div>
				<table class="table table-stripped" id="resultsInfo">
					<thead>
						<tr>
							<th>Examinee No.</th>
							<th>Lastname</th>
							<th>Firstname</th>
							<th>M.I</th>
							<th>CJP</th>
							<th>LEA</th>
							<th>CDIP</th>
							<th>C</th>
							<th>CA</th>
							<th>CSEHR</th>
							<th>Ave</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		<div class="panel-footer clearfix">
			<button class="btn btn-warning showAll">Show All</button>
			<ul class="pagination pull-right" id="resultPagination">
				<li>
					<span aria-hidden="true" id="resultPreviosBtn">&laquo;</span>
				</li>		
				<li><a class="currentPage">1</a></li>
				<li>
					<span aria-hidden="true" id="resultNextBtn">&raquo;</span>
				</li>
			</ul>
		</div>
	</div>
</div>
<?php include_once 'include/footer.php'; ?>