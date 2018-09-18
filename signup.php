<?php
//signup.php
include 'connect.php';
include 'header.php';

// echo '<h3>Sign up</h3><br />';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it
	  note that the action="" will cause the form to post to the same page it is on */
    echo '<div class="jumbotron jumbotron_style">
        	<div>
	            <h4>Sign Up</h4>
	            <p>Please fill this form to create an account.</p>
			    <form method="post" action="">
			 	 	<div class="form-group">
	                    <label>Username</label>
	                    <input type="text" name="user_name" class="form-control">
                    </div> 

			 		<div class="form-group">
	                    <label>Password:</label>
	                    <input type="password" name="user_pass" class="form-control">
                    </div>

					<div class="form-group">
	                    <label>Confirm Password:</label>
	                    <input type="password" name="user_pass_check" class="form-control">
                    </div>

					<div class="form-group">
	                    <label>E-mail:</label>
	                    <input type="text" name="user_email" class="form-control">
                    </div>

			 		<div class="form-group">
                    	<input type="submit" name="submit" class="btn btn-primary" value="Submit">
                    </div>
                    
			 	 </form>';
}
else
{
    /* so, the form has been posted, we'll process the data in three steps:
		1.	Check the data
		2.	Let the user refill the wrong fields (if necessary)
		3.	Save the data 
	*/
	$errors = array(); /* declare the array for later use */
	
	if(isset($_POST['user_name']))
	{
		//the user name exists
		if(!ctype_alnum($_POST['user_name']))
		{
			$errors[] = 'The username can only contain letters and digits.';
		}
		if(strlen($_POST['user_name']) > 30)
		{
			$errors[] = 'The username cannot be longer than 30 characters.';
		}
	}
	else
	{
		$errors[] = 'The username field must not be empty.';
	}
	
	
	if(isset($_POST['user_pass']))
	{
		if($_POST['user_pass'] != $_POST['user_pass_check'])
		{
			$errors[] = 'The two passwords did not match.';
		}
	}
	else
	{
		$errors[] = 'The password field cannot be empty.';
	}
	
	if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
	{
		echo '<div class="jumbotron jumbotron_style">';
			echo 'Uh-oh.. a couple of fields are not filled in correctly..<br /><br />';
			echo '<ul>';
			foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
			{
				echo '<li>' . $value . '</li>'; /* this generates a nice error list */
			}
			echo '</ul>';
		echo '</div>';
	}
	else
	{
		//the form has been posted without, so save it
		//notice the use of mysql_real_escape_string, keep everything safe!
		//also notice the sha1 function which hashes the password
		$sql = "INSERT INTO
					users(user_name, user_pass, user_email ,user_date, user_level)
				VALUES('" . mysqli_real_escape_string($connection,$_POST['user_name']) . "',
					   '" . sha1($_POST['user_pass']) . "',
					   '" . mysqli_real_escape_string($connection,$_POST['user_email']) . "',
						NOW(),
						0)";
						
		$result = mysqli_query($connection,$sql);
		if(!$result)
		{
			//something went wrong, display the error
			echo '<div class="jumbotron jumbotron_style">';
				echo 'Something went wrong while registering. Please try again later.';
			echo'</div>';
			//echo mysql_error(); //debugging purposes, uncomment when needed
		}
		else
		{
			echo '<div class="jumbotron jumbotron_style">';
				echo 'Succesfully registered. You can now <a href="signin.php">sign in</a> and start posting! :-)';
			echo '</div>';
		}
	}
}

include 'footer.php';
?>
