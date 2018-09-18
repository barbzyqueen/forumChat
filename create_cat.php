<?php
//create_cat.php
include 'connect.php';
include 'header.php';

// echo '<h2>Create a category</h2>';
if($_SESSION['signed_in'] == false | $_SESSION['user_level'] != 1 )
{
	//the user is not an admin
	echo '<div class="jumbotron jumbotron_style">';
		 echo'<h2>Create a Category</h2>';
		echo 'Sorry, you do not have sufficient rights to access this page.';
	echo'</div>';
}
else
{
	//the user has admin rights
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		//the form hasn't been posted yet, display it
		echo '<div class="jumbotron jumbotron_style">
			 
                <h2>Create a Category</h2>
				<form method="post" action="">
					<div class="form-group">
	                    <label>Category Name:</label>
	                    <input input type="text" name="cat_name" class="form-control"> 
                	</div>

					<label>Category Description:</label>
	                <div class="form-group">
	                     <textarea class="form-control" rows="5"  name="cat_description" /></textarea>
	                </div>

					<div class="form-group">
                    	<input type="submit" class="btn btn-primary" value="Create Category">
                	</div>
				 </form>
			  </div>';
	}
	else
	{
		//the form has been posted, so save it
		$sql = "INSERT INTO categories(cat_name, cat_description) VALUES('" . mysqli_real_escape_string($connection, $_POST['cat_name']) . "',
				 '" . mysqli_real_escape_string($connection,$_POST['cat_description']) . "')";
		$result = mysqli_query($connection, $sql);
		if(!$result)
		{
			//something went wrong, display the error
			echo 'Error' . mysqli_error($connection);
		}
		else
		{
			echo 'New category succesfully added.';
		}
	}
}

include 'footer.php';
?>
