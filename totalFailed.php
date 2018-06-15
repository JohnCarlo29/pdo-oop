<?php 
	include_once 'include/header.php';

	if(Session::getSession('user') != 'student'){
		//header('location:login.php');
		include_once 'include/navbar.php'; 
	}

	$examinees = new Examinees();
	$totalFailed = $examinees->getTotalFailed();
?>

<div class="container" <?php if(Session::getSession('user') == 'student'){echo 'style="margin-top:30px;"';} ?>>
	<div class="panel panel-default">
		<div class='panel-heading'>
			<h2><span class="fa fa-thumbs-o-up" aria-hidden="true"></span> Failed Per Year</h2>
		</div>
		<div class="panel-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="col-md-3 text-center">Year</th>
						<th class="col-md-3 text-center">First Batch</th>
						<th class="col-md-3 text-center">Second Batch</th>
						<th class="col-md-3 text-center">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($totalFailed as $key=>$value){ ?>
					<tr>
						<td class="col-md-3 text-center"><?php echo $key ?></td>
						<td class="col-md-3 text-center"><?php echo $value[0]?></td>
						<td class="col-md-3 text-center"><?php echo $value[1]?></td>
						<td class="col-md-3 text-center"><?php echo $value[2]?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php include_once 'include/footer.php'; ?>
