<?php
require './conn.php';
session_start();
if (!isset($_SESSION['ID'])) {
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <title>Photos of <?php echo $_SESSION['Username']; ?></title>
	<link rel="stylesheet" type="text/css" href=style.css />
	<script src="script.js"></script>
	<style>
	    #main {
		background-color: teal;
		color: whitesmoke;
		width: 1000px;
		height: 450px;
		margin-left: 175px;
	    }
	    #left-content {
		float: left;
		width: 30%;
		height: 450px;
		border-right: 4px solid #444;
		background-color: yellowgreen;
	    }
	    #create-album {
		background-image: url(images/img_avatar3.png);
		background-repeat: no-repeat;
		background-size: contain;
		background-position-x: 50%;
		margin-top: 35px;
		width: 60%;
		height: 100px;
		background-color: #888;
		transition: 0.2s ease-in-out;
	    }
	    #create-album a {
		color: whitesmoke;
	    }
	    #create-album:hover {
		box-shadow: 2px 3px 4px 2px rgba(0,0,0,0.20) , -1px 3px 4px 2px rgba(0,0,0,0.20);
		transform: rotateX(20deg);
		text-decoration: underline;
	    }
	    header {
		background-color: #444;
	    }
	    #main-panel {
		background-color: yellowgreen;
		border-radius: 10px;
		border: 4px double;
		border-color: #444;
		float: right;
		margin-right: 23.5px;
		margin-top: 25px;
		height: 400px;
		width: 650px;
	    }
	</style>
    </head>
    <body>
	<div class="top-nav" align="center">
	    <nav>
		<ul>
		    <li><a href="index.php">Home</a></li>
		    <li class="active"><a href="photos.php">Photos</a></li>
		    <li><a href="account.php">Update Profile</a></li>
		    <li><a href="about.php">About</a></li>
		</ul>
	    </nav>
	</div>
	<div id="main" align="center">
	    <div id="main-panel">
		
	    </div>
	    <div id="left-content">
		<div id="create-album">
		    <a href="create-album.php"><header>Create Album</header></a>
		</div>
		<hr />
		<div id="create-album">
		    <a href="profile-pictures.php"><header>Profile Pictures</header></a>
		</div>
		<hr />
		<div id="create-album">
		    <a href="cover.php"><header>Cover</header></a>
		</div>
	    </div>
	</div>
    </body>
</html>
