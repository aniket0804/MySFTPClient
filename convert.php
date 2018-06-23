<?php
ini_set('memory_limit','16M');

function respondOK($text = null)
{
    // check if fastcgi_finish_request is callable
    if (is_callable('fastcgi_finish_request')) {
        if ($text !== null) {
            echo $text;
        }
        session_write_close();
        fastcgi_finish_request();
        return;
    }

    ignore_user_abort(true);
    ob_start();

    if ($text !== null) {
        echo $text;
    }
 
    $serverProtocol = filter_input(INPUT_SERVER, 'SERVER_PROTOCOL', FILTER_SANITIZE_STRING);
    header($serverProtocol . ' 200 OK');
    // Disable compression (in case content length is compressed).
    header('Content-Encoding: none');
    header('Content-Length: ' . ob_get_length());
 
    // Close the connection.
    header('Connection: close');
 
    ob_end_flush();
    ob_flush();
    flush();
}

function checkfile($fname){
    $message=shell_exec("/usr/bin/python2.7 chkcsv.py $fname 2>&1");
    if(!$message){
        return true;
    }else{
        return false;
    }
}

function sendmail($to,$content,$frmaddr,$smtphost){
    $message=shell_exec("/usr/bin/python2.7 sendmail.py \"$to\" \"$content\" \"$frmaddr\" \"$smtphost\" 2>&1");
}

function convertfile($sourcepath,$destpath,$to,$content,$temp1path,$JobId,$frmaddr,$smtphost,$filedownloadserver){
    rename($sourcepath,$temp1path);
    $message=shell_exec("/usr/bin/python2.7 convert.py \"$temp1path\" \"$destpath\" \"$to\" \"$content\" \"$JobId\" \"$frmaddr\" \"$smtphost\" \"$filedownloadserver\"");
}

function handleEvent()
{
	require 'database.php';
    $Id = $_POST["uid"];
	$filename = $_POST["fn"];
    $emailId = $_POST["eid"];
	$path = $basepath . "/download/$Id/" . $filename;
    
    $path_parts = pathinfo($filename);
    $fileid = uniqid();
    $destpath = $basepath . "/download/$Id/convert/" . $path_parts['filename'] . "-converted-$fileid" . "." . $path_parts['extension'];
    $temppath = $basepath . "/download/$Id/temp/" . $path_parts['filename'] . "-$fileid" . "." . $path_parts['extension'];

	if(file_exists($path)){
		respondOK($_POST['fn'] . " : Your conversion request in process with Job Id : $fileid. Download link will be sent to your email id.<br>");
        if(checkfile($path)){
            convertfile($path,$destpath,$emailId,"FILE OK",$temppath,$fileid,$frmaddr,$smtphost,$filedownloadserver);
            unlink($temppath);
        }else{
            sendmail($emailId,"FILE NOT OK",$frmaddr,$smtphost);
            unlink($path);
        }
	}else{
		respondOK($_POST['fn'] . " : File not found. Please download file from server.<br>");
	}
    // Execute Rest of code Here ...
}
handleEvent();
?>