


		<?php
  include ("dbConnection.php");

  if (isset($_POST['Create']))
  {
		$fName = $_POST['fname'];
		$lName = $_POST['lname'];
		$CreateStudent =("INSERT INTO student (FName, LName) VALUES ('$fName', '$lName')");

		  if($conn->query($CreateStudent) == TRUE){
  echo "<script>alert('Student Created Succesfully');</script>";
}
else
	echo "<script>alert('Student Could Not Be Created');</script>";

}


  $conn->close();
  ?>

	<form method="post">
	<center><h3> Add Student</h3></center>
	<table align='center'>
	<br>
  <tr>
  <td style='color:black;'>First Name  </td>
  <td><input style='color:black;' type="text" name="fname" required></td>
  </tr>
  <tr>
	<td style='color:black;'>Last Name  </td>
	<td><input style='color:black;' type="text" name="lname" required></td>
	</tr>
	</table>
	<br>
	<center><button class="button suggestion suggestionsButton" type ="submit" name="Create" >Create </button></center>
</form>

