<?php
require './conn.php';
require './function.php';
session_start();

if (!isset($_SESSION['ID'])) {
    header("location: login.php");
}
$id = $_SESSION['ID'];
$fetch = $conn->query("Select * from users where ID = '$id';");
$ress = $fetch->fetch_array();

$_SESSION['Uid'] = $ress['ID'];
$_SESSION['Uname'] = $ress['Username'];
$_SESSION['About'] = $ress['About'];
$_SESSION['pic'] = $ress['ProfileExt'];
$_SESSION['lockedUsers'] = $ress['Status'];

if ($_SESSION['lockedUsers'] == "Locked") {
    header("location: locked.php");
}
?>
<?php
if (isset($_POST['Update'])) {
    if (isset($_SESSION['ID'])) {
	if (isset($_FILES['propic'])) {

	    $UploadName = $_FILES['propic']['name'];
	    $UploadTmp = $_FILES['propic']['tmp_name'];
	    $UploadName = preg_replace("#[^a-z0-9.]#i", "", $UploadName);
	    $_SESSION['File'] = $UploadName;

	    if (!$UploadTmp) {
		$_SESSION['File'] = $ress['ProfileExt'];
	    } else {
		move_uploaded_file($UploadTmp, "images/avatars/$UploadName");
	    }
	}

	$UpUname = $_POST['uname'];
	$UpPass = $_POST['pass'];
	$UpProPic = $_SESSION['File'];
	$UpAbout = $_POST['about'];
	if ($UpPass == "" || $UpPass == null) {
	    $EncPass = $ress['Password'];
	} else {
	    $EncPass = password_hash($UpPass, PASSWORD_BCRYPT, array('cost' => 10));
	}
	$sql = $conn->query("Update users set Username = '$UpUname', Password = '$EncPass', ProfileExt = '$UpProPic', About = '$UpAbout' where ID = $id;");
	if ($sql == true) {
	    $location = "http://localhost/ProfileSystem/account.php";
	    echo '<meta http-equiv="refresh" content="0;URL=' . $location . '">';
	    $_SESSION['msgUpdated'] = '<h2 style="color: green">Profile Updated Successfully</h2>';
	} else {
	    $_SESSION['msgUpdateFailed'] = '<h2 style="color: red">Profile Updating Failed</h2>';
	}
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Update Account</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<link rel="stylesheet" type="text/css" href="font-awesome-4.6.3/css/font-awesome.min.css" />
	<script src="jquery/jquery-3.1.0.min.js"></script>
	<script>
	    $(document).ready(function () {
		$("#profileImage").dblclick(function () {
		    $("#profileImage").animate({width: "400px", height: "400px"}, 500);
		    $("#profileImage").css("border-radius", "0px").fadeTo(500, 1);
		    $("#profileImage").after(function () {
			$("#profileImage").mouseleave(function () {
			    $("#profileImage").animate({width: "240px", height: "240px"}, 500);
			    $("#profileImage").css("border-radius", "30px 0 75px 0").fadeTo(500, 0.6);
			    $("#profileImage").slideUp(750);
			    $("#afterText").show(1500).css("display", "block");
			});
		    });
		});
		$("#afterText").click(function () {
		    $("#afterText").slideDown(1000).css("display", "none");
		    $("#profileImage").slideDown(550);
		});
		$("#refreshIcon").click(function () {
		    $("#refreshIcon").attr("src=''");
		    document.location.reload();
		});
	    });
	</script>
    </head>
    <body>
	<div class="top-nav" align="center">
	    <nav>
		<ul>
		    <li><a href="index.php">Home</a></li>
		    <li><a href="photos.php">Photos</a></li>
		    <li class="active"><a href="account.php">Update Profile</a></li>
		    <li><a href="about.php">About</a></li>
		</ul>
	    </nav>
	</div>
	<div id="container" style="background-image: none;">
	    <form id="updateForm" action="" method="post"enctype="multipart/form-data" name="UpdateForm">
		<h1>Update Account</h1>
		<input class="inputStyle" type="text" name="uname" placeholder="Username" autofocus="true" value="<?php echo $_SESSION['Uname']; ?>" /><br />
		<input class="inputStyle" type="password" name="pass" placeholder="Password" /><br />
		<input class="inputStyle" type="text" name="about" placeholder="About" value="<?php echo $_SESSION['About']; ?>"/><br />
		<input class="inputStyle" type="file" name="propic" id="uppropic" /><br />
		<input id="btnLogin" type="submit" name="Update" value="Update" /><br />
		<span id="icon-update-space">
		    <i id="refreshIcon" title="Click to refresh page" class="fa fa-spin fa-2x fa-refresh"></i>
		</span>
	    </form>
	    <div id="profile">
		<img id="profileImage" title="[Double Click to Zoom in] | [Move the mouse from the image to zoom out]" src="images/avatars/<?php echo $_SESSION['pic']; ?>" /><br />
		<h2 id="afterText">haww! Click here to see Image Again</h2>
	    </div>
	    <?php
	    if (isset($_SESSION['msgUpdated'])) {
		echo $_SESSION['msgUpdated'];
		//unset($_SESSION['msgUpdated']);
	    }
	    if (isset($_SESSION['msgUpdateFailed'])) {
		echo $_SESSION['msgUpdateFailed'];
		unset($_SESSION['msgUpdateFailed']);
	    }
	    ?>
	</div>
    </body>
</html>
