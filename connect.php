<?php 
define('server', 'localhost');
	 define('username', 'root');
	 define('password', '');
	define('database', 'forumChat');
// $server	    = 'localhost';
// $username	= 'root';
// $password	= '';
// $database	= 'forumChat';
$connection = mysqli_connect(server, username, password, database);

if($connection === false){
	    die("ERROR: Could not connect. " . mysqli_connect_error($connection));
	}
?>