<?php
	session_start();
	if (isset($_SESSION['UserID']))
	{
		$currUserID = $_SESSION['UserID'];
	}
	else
	{
		header("Location: logout.php");
	}
?>


<!DOCTYPE html>
<html>
	<head>
		<title>User Interface</title>
		<meta charset="UTF-8">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	</head>

	<body>
		<div class="titleArea">
			<h1><center> USER INTERFACE</center></h1>
		</div>

<div class="clearfix">
		<ul>
			<div class="menu">
			<li><center><button class="button suggestion suggestionsButton" type="button" data-toggle="modal" data-target="#ChangePass">Change Password</button></center></li>
			<li><center><button class="button suggestion suggestionsButton" type="button" data-toggle="modal" data-target="#RecoverPass">Recover Password </button></center></li>
			<li><center><a class="button suggestion suggestionsButton" href="logout.php">Log Out</a></center</li>
			</div>
		</ul>
</div>



	<div class="modal fade" id="ChangePass" role="dialog">
 	<div class="modal-dialog">
 		<div class="modal-content">
 			<div class="modal-header">
 				<button type="button" class="close" data-dismiss="modal">&times;</button>
 				<h4 class="modal-title">Change Password</h4>
 			</div>
 			<div class="modal-body">
 				<?php include 'ChangePassword.php';?>
 			</div>
 		</div>
 	</div>
 	</div>

	<div class="modal fade" id="RecoverPass" role="dialog">
 	<div class="modal-dialog">
 		<div class="modal-content">
 			<div class="modal-header">
 				<button type="button" class="close" data-dismiss="modal">&times;</button>
 				<h4 class="modal-title">Recover Password</h4>
 			</div>
 			<div class="modal-body">
 				<?php include 'RecoverPassword.php';?>
 			</div>
 		</div>
 	</div>
 	</div>
	</body>
</html>
