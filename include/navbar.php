<?php 
	include_once '__autoload.php';

	Session::start();

	if(Session::getSession('user') != 'admin'){
		header('location:login.php');
	}

	if(isset($_POST['btnLogout'])){
		Session::unset_session('user');
		Session::destroy();
		header('location:login.php');
	}
?>
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php">CCJ</a>
		</div>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="index.php">Home</a></li>
			<li><a href="queries.php">Queries</a></li>
			<li class="examinees"><a href="examinees.php">Examinees</a></li>
			<li class="results"><a href="results.php">Results</a></li>
			<li>
				<form method="post">
				<button type="submit" class="btn btn-sm btn-primary" id="btnlogout" onclick="return confirm('Logout now?');" name="btnLogout"><?php echo Session::getSession('user'); ?> <i class="fa fa-arrow-circle-right"></i></span></button>
				</form>
			</li>
		</ul>
	</div>
</nav>
