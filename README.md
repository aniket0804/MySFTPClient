# MySFTPClient
Portable SFTP Client php-mysql

Requirements :

Please install php7 apache2 and mysql

Installation :

Just download and keep in /var/www/html/ and provide chmod to project folder name as it will create one directory with www-data user once you first logged in to interface.

Run database.sql file and do valid email and choose any password just to login through interface.

Update database.php file with respective localserver and database name and table.
Also, put valid smtp server as this servlet performs operation on files which are available on remote sftp server do some operations on files and email you with download link. [ You can customise the same as per your requirements. ]

Update your sftp server details and choose directory of sftp server.

If any key sftp server asks for auth then keep the .pem file in project folder and assign its file name in database.php file.




