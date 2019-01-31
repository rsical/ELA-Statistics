

	<?php
  include ("dbConnection.php");

if (isset($_POST['Change']))
{
$oldPass = sha1($conn->real_escape_string($_POST['oldPass']));
//$oldPass = $conn->real_escape_string($_POST['oldPass']);
$pwd = sha1($conn->real_escape_string($_POST['pwd']));
$pwd2 = sha1($conn->real_escape_string($_POST['pwd2']));


		$user ="SELECT * FROM useraccount WHERE UserID='$currUserID';";
		$result=$conn->query($user);

		if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$userId = $row["UserID"];
		$currentPass = $row["Password"];

		if(($oldPass == $currentPass) && ($pwd2==$pwd)){
		$update="UPDATE useraccount SET Password='$pwd' WHERE UserID='$userId';";
		$conn->query($update);

		echo "<script>alert('Password Updated Succesfully');</script>";
	}
	elseif(($oldPass == $currentPass) && ($pwd2 != $pwd)){
		echo "<script>alert('Passwords must match');</script>";
	}}

	elseif(($oldPass != $currentPass) && ($pwd2 == $pwd)){
		echo "<script>alert('Old password is incorrect');</script>";
	}


}
	$conn->close();

?>

<form method="post">
<center><h3> Change Password</h3></center>
<table align='center'>
<br>
<tr>
<td style='color: black;'>Old Password</td>
<td><input style='color:black;' type="password" name="oldPass" required></td>
</tr>
<tr>
<td style='color: black;'>New Password </td>
<td><input style='color:black;' type="password" name="pwd" required></td>
</tr>
<tr>
<td style='color: black;'>Confirm Password</td>
<td><input style='color:black;' type="password" name="pwd2" required></td>
</tr>
</table>
<br>
<center ><button class="button suggestion suggestionsButton" type ="submit" name="Change" >Update</button></center>

</form>


