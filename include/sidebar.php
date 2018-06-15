<?php include_once '__autoload.php'; 
	Session::start();

	if(isset($_POST['btnLogout'])){
		Session::unset_session('user');
		Session::destroy();
	}
?>

<div class="wrapper">
		<div class="sideBar">
			<img src="images/ccj-logo.png" class="logo">
			<ul class="sidebar-nav">
				<li id="dashboard"><i class="fa fa-home" aria-hidden="true"></i><a href="index.php">&nbsp&nbspDashboard</a></li>
				<li id="examinees"><i class="fa fa-user-circle" aria-hidden="true"></i><a href="examinees.php">&nbsp&nbspExaminees</a></li>
				<li id="results"><i class="fa fa-newspaper-o" aria-hidden="true"></i><a href="results.php">&nbsp&nbspResults</a></li>
			</ul>
		</div>
		<div class="Content">
			<div class="divLogout col-md-12 bg-primary">
				<div class="pull-right">
					<form method='post'>
						<button type="submit" onclick="return confirm('Logout now?');" class="btn btn-info" name="btnLogout"><?php echo Session::getSession('user'); ?> <i class="fa fa-arrow-circle-right"></i></span></button>
					</form>
				</div>
			</div>
			<div class="mainContent">