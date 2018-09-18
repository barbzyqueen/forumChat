<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>

    <title>PHP-MySQL forum</title>
    <link rel="stylesheet" href="bootstrap.css">
   <link href="styles.css" rel="stylesheet"  type="text/css"> 
</head>
<body class=body_style>
<div>
<div class="bgcolor"><h1>Chat Forum Team Project</h1></div>
        <div id=heading>
            <nav id="navbar-col" class="navbar navbar-expand-sm navbar-dark bg-dark">
                <ul class="navbar-nav ">
                    <li class="nav-item"><a class="item" href="index.php">| Home</a> |</li>
                    <li class="nav-item "><a class="item" href="create_topic.php">Create a Topic</a> |</li>
                    <li class="nav-item "><a class="item" href="create_cat.php">Create a Category</a> |</li>
                </ul>
            
         

            <div id="signin_bar">
                <?php
               
                if(isset($_SESSION['signed_in']))
                {
                    
                    echo 'Hello ' . $_SESSION['user_name'] . '. Not you? <a href="signout.php">Sign out</a>';
                    
                }

                else
                {
                    echo '<a href="signin.php">Sign in</a> or<a href="signup.php">create an account</a>.';
                }

                

                ?>
            </div>

  
        </nav>
    </div>

</div>

<div id="main_content">