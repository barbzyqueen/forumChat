<?php
//signout.php
include 'connect.php';
include 'header.php';


//check if user if signed in
if($_SESSION['signed_in'] == true)
{
	//unset all variables
	$_SESSION['signed_in'] = NULL;
	$_SESSION['user_name'] = NULL;
	$_SESSION['user_id']   = NULL;

	header("location: signin.php");

	
}
else
{
	echo '<div class="jumbotron jumbotron_style">';
		echo 'You are not signed in. Would you <a href="signin.php">like to</a>?';
	echo '</div>';
}

include 'footer.php';
?>