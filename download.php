	<?php

	$fname = $_POST["fname"];
	echo "Requested Download File" . $fname;
	$sftp->get("$fname", "$user_dir/$fname");

	$path = "$user_dir" . $fname;
	$path_parts = pathinfo($fname);
	echo "Path is " . $path . "Extension is" . $path_parts['extension'];

	$err = '<p style="color:#990000">Sorry, the file you are requesting is unavailable.</p>';

	if (!$fname) {
		// if variable $fname is NULL or false display the message
		echo $err;
	} else {
		// define the path to your download folder plus assign the file name
		$path = "$user_dir" . $fname;

		// check that file exists and is readable
		if (file_exists($path) && is_readable($path)) {
			// get the file size and send the http headers
			$size = filesize($path);
			if ($path_parts['extension'] == "zip"){
				header("Content-type: application/zip"); 
			} elseif ($path_parts['extension'] == "xls") {
				ob_clean();
				header('Content-type: application/vnd.ms-excel');	
			} elseif ($path_parts['extension'] == "xlsx"){
				ob_clean();
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			}
			else {
				#header('Content-Type: application/octet-stream');
				header("Content-Type: text/csv");	
			}
			
			header('Content-Length: '.$size);
			header('Content-Disposition: attachment; filename='.$fname);
			header('Content-Transfer-Encoding: binary');
			// open the file in binary read-only mode
			// display the error message if file can't be opened
			ob_end_clean();
			$file = @ fopen($path, 'rb');
			if ($file) {
				// stream the file and exit the script when complete
				fpassthru($file);
				exit;
			} else {
				echo $err;
			}
		} else {
			echo $err;
		}
	}
	
?>