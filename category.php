<?php
//category.php
include 'connect.php';
include 'header.php';

//first select the category based on $_GET['cat_id']
$sql = "SELECT
			cat_id,
			cat_name,
			cat_description
		FROM
			categories
		WHERE
			cat_id = " . mysqli_real_escape_string($connection,$_GET['id']);

$result = mysqli_query($connection,$sql);

if(!$result)
{
	echo 'The category could not be displayed, please try again later.' . mysqli_error($connection);
}
else
{
	if(mysqli_num_rows($result) == 0)
	{
		echo 'This category does not exist.';
	}
	else
	{
		//display category data
		while($row = mysqli_fetch_assoc($result))
		{
			echo '<h3 class="h3_align">Topics in ' . $row['cat_name'] . ' category</h3>';
		}
	
		//do a query for the topics
		$sql = "SELECT	
					topic_id,
					topic_subject,
					topic_date,
					topic_cat
				FROM
					topics
				WHERE
					topic_cat = " . mysqli_real_escape_string($connection, $_GET['id']);
		
		$result = mysqli_query($connection, $sql);
		
		if(!$result)
		{
			echo 'The topics could not be displayed, please try again later.';
		}
		else
		{
			if(mysqli_num_rows($result) == 0)
			{
				echo 'There are no topics in this category yet.';
			}
			else
			{
				
				//prepare the table
				echo '<table class="table table-bordered table-sm table-hover center">
						<thead>
						  <tr>
							<th>Topic</th>
							<th>Created at</th>
						  </tr>
						  </thead>
						  <tbody>';	
					
				while($row = mysqli_fetch_assoc($result))
				{				
					echo '<tr>';
						echo '<td class="leftpart">';
							echo '<h3><a href="topic.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a><br /><h3>';
						echo '</td>';
						echo '<td class="rightpart">';
							echo date('d-m-Y', strtotime($row['topic_date']));
						echo '</td>';
					echo '</tr>';
				}

				echo '</tbody>';
				echo '</table>';
			}
		}
	}
}

include 'footer.php';
?>
