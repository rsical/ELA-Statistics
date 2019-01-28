<?php
	session_start();
	unset($_SESSION['UserID']);
	session_destroy();
	 echo "<script>window.close();</script>";
	header("Location: index.php")
?>
