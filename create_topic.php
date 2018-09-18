<?php
//create_topic.php
include 'connect.php';
include 'header.php';

// echo '<h2>Create a topic</h2>';
if($_SESSION['signed_in'] == false)
{
	//the user is not signed in
	echo '<div class="jumbotron jumbotron_style">';
		echo'<h2>Create a Topic</h2>';
		echo 'Sorry, you have to be <a href="signin.php">signed in</a> to create a topic.';
	echo'</div>';
}
else
{
	//the user is signed in
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{	
		//the form hasn't been posted yet, display it
		//retrieve the categories from the database for use in the dropdown
		$sql = "SELECT
					cat_id,
					cat_name,
					cat_description
				FROM
					categories";
		
		$result = mysqli_query($connection, $sql);
		
		if(!$result)
		{
			//the query failed, uh-oh :-(
			echo '<div class="jumbotron jumbotron_style">';
				echo 'Error while selecting from database. Please try again later.';
			echo'</div>';
		}
		else
		{
			if(mysqli_num_rows($result) == 0)
			{
				//there are no categories, so a topic can't be posted
				if($_SESSION['user_level'] == 1)
				{
					echo 'You have not created categories yet.';
				}
				else
				{
					echo 'Before you can post a topic, you must wait for an admin to create some categories.';
				}
			}
			else
			{
		
				echo '<div class="jumbotron jumbotron_style">
                        <div>';

                        echo'<h2>Create a Topic</h2>';
						echo'<form method="post" action="">

							<div class="form-group">
								<label>Subject:</label>
								 <input type="text" name="topic_subject" />
								<label>Category:</label>'; 
							
							echo '<select name="topic_cat">';
								while($row = mysqli_fetch_assoc($result))
								{
									echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
								}
							echo '</select>
							</div> ';


							
						echo '<label>Message:</label>

							<div class="form-group">
                                  <textarea class="form-control" rows="5" name="post_content" /></textarea>
                            </div>
						
							<div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Create Topic">
                            </div>
						 </form>';
				echo'</div>   
                </div>';
			}
		}
	}
	else
	{
		//start the transaction
		$query  = "BEGIN WORK;";
		$result = mysqli_query($connection,$query);
		
		if(!$result)
		{
			//Damn! the query failed, quit
			echo 'An error occured while creating your topic. Please try again later.';
		}
		else
		{
	
			//the form has been posted, so save it
			//insert the topic into the topics table first, then we'll save the post into the posts table
			$sql = "INSERT INTO 
						topics(topic_subject,
							   topic_date,
							   topic_cat,
							   topic_by)
				   VALUES('" . mysqli_real_escape_string($connection, $_POST['topic_subject']) . "',
							   NOW(),
							   " . mysqli_real_escape_string($connection, $_POST['topic_cat']) . ",
							   " . $_SESSION['user_id'] . "
							   )";
					 
			$result = mysqli_query($connection, $sql);
			if(!$result)
			{
				//something went wrong, display the error
				echo 'An error occured while inserting your data. Please try again later.<br /><br />' . mysqli_error($connection);
				$sql = "ROLLBACK;";
				$result = mysqli_query($connection, $sql);
			}
			else
			{
				//the first query worked, now start the second, posts query
				//retrieve the id of the freshly created topic for usage in the posts query
				$topicid = mysqli_insert_id($connection);
				
				$sql = "INSERT INTO
							posts(post_content,
								  post_date,
								  post_topic,
								  post_by)
						VALUES
							('" . mysqli_real_escape_string($connection, $_POST['post_content']) . "',
								  NOW(),
								  " . $topicid . ",
								  " . $_SESSION['user_id'] . "
							)";
				$result = mysqli_query($connection, $sql);
				
				if(!$result)
				{
					//something went wrong, display the error
					echo 'An error occured while inserting your post. Please try again later.<br /><br />' . mysql_error();
					$sql = "ROLLBACK;";
					$result = mysqli_query($connection, $sql);
				}
				else
				{
					$sql = "COMMIT;";
					$result = mysqli_query($connection,$sql);
					
					//after a lot of work, the query succeeded!
					echo 'You have succesfully created <a href="topic.php?id='. $topicid . '">your new topic</a>.';
				}
			}
		}
	}
}

include 'footer.php';
?>
