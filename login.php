<?php

session_start();
require 'database.php';

if( isset($_SESSION['user_id']) ){
	header("Location: /$foldername/index.php");
}


if(!empty($_POST['email']) && !empty($_POST['password'])):
	
	$records = $conn->prepare('SELECT id,email,password FROM users WHERE email = :email');
	$records->bindParam(':email', $_POST['email']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(count($results) > 0 && password_verify($_POST['password'], $results['password']) ){

		$_SESSION['user_id'] = $results['id'];

		$user_dir1 = $basepath . "/download/" . $results['id'] ."/*";
		$user_dir2 = $basepath . "/download/" . $results['id'] ."/";
		if (is_dir($user_dir2)){
			$files = glob($user_dir1); //get all file names
			foreach($files as $file){
    				if(is_file($file)){
    					unlink($file); //delete file
    				}
			}
		}

		header("Location: /$foldername/index.php");

	} else {
		$message = 'Sorry, those credentials do not match';
	}

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Below</title>

	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<div class="header">
		<a href="index.php">MY SFTP CLIENT</a>
	</div>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<p>Login</p>
	<!-- <span>or <a href="register.php">register here</a></span> -->

	<form action="login.php" method="POST">
		
		<input type="text" class="form-control" placeholder="Enter your email" name="email">
		<input type="password" class= "form-control" placeholder="and password" name="password">

		<button class="btn btn-info btn-md" type="submit">Submit</button>

	</form>

</body>
</html>
