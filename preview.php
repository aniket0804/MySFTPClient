<?php

require 'database.php';
$filename = $_POST["filename"];
$Id = $_POST["uid"];
$user_dir = $basepath . "/download/" . $Id ."/";
$path = "$user_dir" . $filename;

?>
	<style type="text/css">
		.modal-content {
      		height: 100%;
      		width: 100%;
      		border-radius: 0;
      		color:black;
      		overflow:auto;
      		overflow-x: scroll;
      		overflow-y: scroll;
    	}
	</style>

<div class="container">

<?php if(file_exists($path)): ?>

	<table class="table table-bordered" align="center">
		<tbody>
			<?php
        $maxLines = 6;
				$CSVfp = fopen($path, "r");
        for ($i = 0; $i < $maxLines && !feof($CSVfp); $i++){
          $data = fgetcsv($CSVfp, 1024);
          echo "<tr>";
          if (is_array($data)) {
            foreach($data as $val){
              echo "<td>" . htmlspecialchars($val) . "</td>";
            }
          }
        }
        fclose($CSVfp);
			?>
		</tbody>
	</table>
<?php else: ?>
  <p>File not found please download first from FTP</p>
<?php endif; ?>

</div>