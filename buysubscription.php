<?php
require './conn.php';
session_start();
if (!isset($_SESSION['ID']) || !isset($_SESSION['expire'])) {
    header("location: index.php");
}
$user = $_SESSION['ID'];
if(isset($_POST['btnProceed'])) {
    $SqlQuery = $conn->query("Select * from users where ID = $user");
    $fetchNow = $SqlQuery->fetch_array();
    
    $SubscriberID = $fetchNow['ID'];
    $TIMESTAMP = date("Y-m-d");
    $_SESSION['SubscriptionStatus'] = $fetchNow['Subscription'];
    if($_SESSION['SubscriptionStatus'] == "Dead") {
	$updatingSub = $conn->query("Update users set Subscription = 'Alive', TIMESTAMP = CURRENT_TIMESTAMP Where ID = $SubscriberID");
	$_SESSION['PaymentSuccess'] = '<h2 style="color: green;">Payment Successful, Subscription is now Alive.</h2><br /><input id="btnProceed" type="submit" onclick="afterBuy()" value="Login Again" />';
    } else {
	$_SESSION['AlreadyAlive'] = '<h2 style="color: yellow;">Subscription Already Alive !</h2>';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script>
	    function afterBuy() {
		window.location = "login.php";
	    }
	</script>
    </head>
    <style>
	#container {
	    width: 65%;
	    background-color: windowframe;
	    border-top: 5px solid;
	    border-bottom: 5px solid;
	    background-image: none;
	    padding-bottom: 20px;
	    margin-top: 5.5%;
	    margin-left: 250px;
	    border-radius: 10px;
	    border-color: #009688;
	    height: fit-content;
	    box-shadow: inset 0 3px 3px rgba(255,255,255,0.3), inset 0 -3px 3px rgba(0,0,0,0.3);
	}
	#userName {
	    margin-top: 15px;
	    color: whitesmoke;
	    border: 2px solid;
	    border-color: #009688;
	}
	select {
	    width: 25.5%;
	}
	option {
	    background-color: #009688;
	}
	#userName.mon {
	    width: 6.5%;
	}
	#userName.year {
	    width: 9%;
	}
	#userName.cvv {
	    margin-left: 18%;
	}
	#btnProceed {
	    background-color: #009688;
	    border: 0px solid;
	    color: whitesmoke;
	    cursor: pointer;
	    font-size: larger;
	    margin-top: 20px;
	    margin-left: 20px;
	    padding: 15px;
	}
	#btnProceed:hover {
	    background-color: #006666;
	    color: white;
	    box-shadow:inset 0 2px 3px rgba(255,255,255,0.3), inset 0 -2px 3px rgba(0,0,0,0.3), 0 1px 1px rgba(255,255,255,0.9);
	}
    </style>
    <body>
	<div id="container" align="center">
	    <div class="msgs">
		<?php
		if(isset($_SESSION['PaymentSuccess'])) {
		    echo $_SESSION['PaymentSuccess'];
		    unset($_SESSION['PaymentSuccess']);
		}
		if(isset($_SESSION['AlreadyAlive'])) {
		    echo $_SESSION['AlreadyAlive'];
		    unset($_SESSION['AlreadyAlive']);
		}
		?>
	    </div>
	    <div id="payment-form">
		<h2>Pay Secure</h2>
		<form action="" method="post">
		    <select title="Choose your preferred type of card" id="userName" name="select-card" required>
			<option value="">Choose Card Type: </option>
			<option value="Visa">Visa</option>
			<option value="Mastero">Mastero</option>
			<option value="American">American</option>
			<option value="Global">Global</option>
		    </select><br />
		    <input id="userName" title="Enter Card Holder Name as mentioned on the card" type="text" name="chname" placeholder="Card Holder Name" required /><br />
		    <input id="userName" title="Enter Your Card Number" type="number" name="cdnumber" placeholder="Enter Card Number" required /><br />
		    <input id="userName" class="cvv" title="Enter CVV Number, Flip your card and you will find 3 digit number" type="number" min="100" max="999" name="cvv" placeholder="CVV" /><br />
		    <input id="userName" min="1" max="12" class="mon" title="Enter Expiry Month" type="number" name="expmon" placeholder="MM" required />
		    <input id="userName" min="2000" max="2030" class="year" title="Enter Expiry Year" type="number" name="expyr" placeholder="YYYY" required /><br />
		    <hr />
		    <input id="btnProceed" type="submit" name="btnProceed" value="Proceed" />
		</form>
	    </div>
	</div>
    </body>
</html>
