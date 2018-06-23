<?php

session_start();

require 'database.php';

if( isset($_SESSION['user_id']) ){

	$records = $conn->prepare('SELECT id,email,password FROM users WHERE id = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$user = NULL;

	if( count($results) > 0){
		$user = $results;
	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>MY SFTP CLIENT</title>

	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
  
</head>
<body>

	<div class="header">
		<a href="index.php">My SFTP CLIENT</a>
	</div>

	<?php if( !empty($user) ): ?>

		<br />Welcome <?= $user['email']; ?>
		<?php
			$user_dir = $basepath . "/download/" . $user['id'] ."/";
			if (!is_dir($user_dir)) {
				mkdir($user_dir, 0777, true);
				mkdir($user_dir . "/convert/", 0777, true);
				mkdir($user_dir . "/temp/", 0777, true);
			}
		?>
		<br /><br />You are successfully logged in!
		<br /><br />

	<div class="container">
		<table class="table table-bordered" align="center">
		<thead>
			<tr>
    			<th> File ID </th>
    			<th> FileName </th>
				<th> File Download </th>
				<th> File Preview </th> 
			</tr>
		</thead>
		<tbody>
				<?php include('connectftp.php') ?>
		</tbody>
		</table>
	</div>

		<br /><br />
		<a href="logout.php">Logout?</a>

	<?php else: ?>

		<h1>Please Login</h1>
		<a href="login.php">Login</a> <!-- or
		<a href="register.php">Register</a> -->

	<?php endif; ?>

</body>
</html>
