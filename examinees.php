<?php 
	include_once 'include/header.php';
	include_once 'include/navbar.php'; 
	require 'vendor/autoload.php';

	ini_set('max_execution_time', 300);

	if(Session::getSession('user') != 'admin'){
		header('location:login.php');
	}

	if(isset($_POST['test'])){
		if(isset($_FILES['file'])){
			$upload = new Upload($_FILES['file']);
			$upload->checkExtension();
			$upload->uploadFile();
			if($upload->addToDatabase()){
				header('refresh:1');	
			}
		}
	}
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading bg-primary">
			<div id="examineeYear" class="row">
				<div class="form-inline pull-left col-md-6">
					<label>Year</label>
					<select class="form-control" id="examyear"></select>
				</div>

				<div class="col-md-6">
					<div class="input-group pull-right col-md-6">
						<input type="text" class="form-control txtExamNum" placeholder="Examinee #">
						<span class="input-group-btn">
						    <button class="btn btn-default" type="button" id="examSearchBtn">Go!</button>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<div>
				<table class="table table-stripped" id="examineeInfo">
					<thead>
						<tr>
							<th>Examinee No.</th>
							<th>Lastname</th>
							<th>Firstname</th>
							<th>M.I</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		<div class="panel-footer clearfix">
			<button class="btn btn-warning showAll">Show All</button>
			<ul class="pagination pull-right" id="examPagination">
				<li>
					<span aria-hidden="true" id="examPreviosBtn">&laquo;</span>
				</li>		
				<li><a class="currentPage">1</a></li>
				<li>
					<span aria-hidden="true" id="examNextBtn">&raquo;</span>
				</li>
			</ul>
		</div>
	</div>

	<div id="fileUpload" class="col-md-12">
		<form method="POST" enctype="multipart/form-data">
	         <input type="file" name="file" />
	         <input type="submit" name="test"/>
	    </form>
	</div>
</div>

<?php include_once 'include/footer.php'; ?>