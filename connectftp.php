<?php

require 'database.php';
require "vendor/autoload.php";
use phpseclib\Crypt\RSA;
use phpseclib\Net\SFTP;
	
$sftp = new SFTP($ftpserver);
$privatekey = new RSA();
$privatekey->loadKey(file_get_contents( $basepath . $ftppemfile));

#if (!$sftp->login('user', $privatekey) && !$sftp->login('user', 'password')) {
if (!$sftp->login('ubuntu', $privatekey)) {
	throw new Exception('SFTP login failed');
	echo "Login Failed Due To Unknown Network Error";
}

$sftp->chdir($ftpdir);

$user_dir = $basepath . "/download/" . $user['id'] ."/";

if(isset($_POST['download'])){
	include('download.php');
}

$id = 1;

foreach ($sftp->nlist() as $value){
	echo "<tr>
	<form action=\"\" method=\"POST\">
	<input type=\"hidden\" name=\"fname\" class=\"fname\" value=\"$value\"/>
	<td width=10%>$id</td>
	<td align=left>$value</td>
	<td><button type=\"submit\" class=\"btn btn-info btn-sm\" name=\"download\" value=\"$value\">Download</button></td>	
	<td><button type=\"button\" class=\"btn btn-info btn-sm\" data-toggle=\"modal\" data-target=\"uploadModal$id\" id=\"uploadModal$id\" onclick=preview(this)>Preview File</button>

    </td>

	</form>
	</tr>";
	$id = $id + 1;
}

?>

<div id="aniket"></div>

<script type='text/javascript'>

    var email = "<?php echo $user['email'] ?>";
    var uid1 = "<?php echo $user['id'] ?>";

	function preview(button){
		var fd=button.id;
		let row = $(button).closest('tr');
		if(!row)
			return alert("row not found");
		let hiddenCell = $(row).find(".fname");
        $.ajax({
            url: 'preview.php',
            type: 'post',
            contentType: 'application/x-www-form-urlencoded',
            data: { filename : $(hiddenCell).val(),
                    uid : uid1 },
            success: function(response){
                if(response != 0){
                    if($('.preview-file-' + button.id) && $('.preview-file-' + button.id).length){
                        $('.preview-file-' + button.id).remove();
                    }
                    $('#aniket').append('<div id="' + button.id + '" class="modal fade centered preview-file-' + button.id + '" role="dialog"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">File Preview</h4></div><div class="modal-body"><div class="preview">' + response + '</div></div><div class="modal-footer"><button type="button" id="submitForm" class="btn btn-default" value="' + $(hiddenCell).val() + '" onclick=convert(this)>Convert</button><button type="button" class="btn btn-default" id="btnclose" data-dismiss="modal">Close</button></div></div></div></div>');
                    $("#"+button.id).modal();
                }else{
                    alert('Error');
                }
            },
            error: () => {
                console.log(arguments);
                alert("error occured");
            }
        });
	}

	function convert(button1){
		//alert("clicked" + $(button1).val());
		$.ajax({
            url: 'convert.php',
            type: 'post',
            contentType: 'application/x-www-form-urlencoded',
            data: { fn : $(button1).val(),
                    eid : email,
                    uid : uid1 
                     },
            success: function(response1){
                if(response1 != 0){
                	$(button1).closest(".modal").find('.preview').append(response1);
                }else{
                    alert('Error');
                }
            },
            error: () => {
                console.log(arguments);
                alert("error occured");
            }
        });
	}
</script>
