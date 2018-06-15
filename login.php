<?php 
	include_once 'include/header.php'; 
	
	if(Session::getSession('user') == 'admin'){
		header('location:index.php');
	}

	if(isset($_POST['btnLogin'])){
		$uname = $_POST['uname'];
		$pass = $_POST['pword'];

		$users = new Users($uname, $pass);
		$is_user = $users->checkUser();
		if($is_user == true){
			$users->login();
			if(Session::getSession('user') == 'admin'){
				header('location:index.php');
			}else if(Session::getSession('user') == 'student'){
				header('location:student.php');
			}
		}else{
			$error = "Username or Password is incorrect";
		}
	}

?>

<div class="adminContent container-fluid">
	<div class="col-md-4">
		<div class="misvis text-center">
			<h1>Plmun Mission & Vision</h1>
			<h1>Mission</h1>
			<p>To provide quality, affordable and relevant education responsive to the changing needs of the local and global communities through effective and efficient integration of instruction, research and extension; to develop productive and God-loving individuals in society.</p>

			<h1>Vision</h1>
			<p>A dynamic and highly competitive Higher Education Institution (HEI) committed to people empowerment towards building a humane society.</p>
		</div>
	</div>
	<div class="col-md-4">
		<img src="images/plmun-logo.png" id="plmunlogo">
		<div class="bg-warning text-center"><?php if(isset($error)){echo $error;}?></div>
		<div class="panel panel-primary ">
			<div class="panel-heading text-center">
				<img src="images/admin.png" id="admin">
				<img src="images/student.png" id="student">
			</div>
			<div class="panel-body">
				<form method="post">
					<div class="form-group">
						<label>Username</label>
						<input type="text" class="form-control" name="uname" placeholder="Username" id="uname" readonly="true">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="pword" placeholder="Password" id="pword">
					</div>
					<button type="submit" class="btn btn-primary" name="btnLogin">Login</button>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="misvis text-center">
			<h1>CCJ Mission & Vision</h1>
			<h1>Mission</h1>
			<p>The College of Criminal Justice has the obligation and mandate to perform its duties and responsibilities, by way of training, molding and guiding the students with the following objectives:<br />

			1. To reign God-oriented attitude with the utmost respect, honesty, and love to country, mankind and environment<br />

			2. To develop the knowledge and technical skills in the field of criminology and to be applied both in the public and private sector<br />

			3. To create an efficient and empowered graduates power-packed to become globally competitive and future leaders</p>

			<h1>Vision</h1>
			<p>The College of Criminal Justice will be known as respected and dignified academic institution in the society. Committed to provide quality education and Christian values. To become responsible, productive and competent professionals, all for the glory of Almighty God. 
			</p>
		</div>
		
	</div>
</div>

<?php include_once 'include/footer.php'; ?>