<?php

#Database Config
$server = '127.0.0.1';
$username = 'root';
$password = 'root';
$database = 'SMS';

#Project Folder Config
$foldername = 'CheckSFTPClient';
$basepath = "/var/www/html/$foldername";

#Existance of download directory is must in project folder.
#Ftp Configs
$ftpserver = "ec2-xx-xx-xxx-xx.us-east-x.compute.amazonaws.com";
$ftpdir = "XXX/OUT/";
#must be kept in project folder /var/www/html/folderName/*.pem
#SFTP sevrver access pub key
$ftppemfile = "/xxx.pem";

#to address will be the username using which you will login, please do entry in database.sql file
#SMTP Server Config for sending mail
$smtphost = "mail.smtp.com";
$frmaddr = "noreply@xxx.com";
$filedownloadserver = "http://127.0.0.1/";

try{
	$conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch(PDOException $e){
	die( "Connection failed: " . $e->getMessage());
}
