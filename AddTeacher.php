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

<html lang="en">
  <head>
    	<meta charset="utf-8">
</head>

<body>

		<?php
  include ("./db/connection/dbConnection.php");

  if (isset($_POST['CreateTeacher']))
  {
		$password = random_password(8);
		$fName = $_POST['fname'];
		$lName = $_POST['lname'];
		$email = $_POST['email'];
		$school = $_POST['school'];
		$class = $_POST['class'];

		$iona="@iona.edu";
		$teachersEmail= $email . $iona;
		$CreateTeacherinUsersTable =("INSERT INTO useraccount (SchoolID, FName, LName, Email, Password, AccountType, RecoveryPassword) VALUES ('$school', '$fName', '$lName', '$teachersEmail', '$password', 'teacher-new', 0)");

		if($conn->query($CreateTeacherinUsersTable) == TRUE){
	  	$sqlId="SELECT UserID from useraccount
			where UserID=(SELECT max(UserID) from useraccount) ;" ;
			$result = $conn->query($sqlId) or die('Could not find user id: '.$conn->error);
			$row = $result->fetch_assoc();
			$userId=$row["UserID" ];

			$CreateTeacherinTeachersTable =("INSERT INTO teacher (SchoolID, UserID) VALUES ('$school', $userId)");
		}
			if($conn->query($CreateTeacherinTeachersTable) == TRUE){
				$sqlId="SELECT TeacherID from teacher
				where TeacherID=(SELECT max(TeacherID) from teacher) ;" ;
				$result = $conn->query($sqlId) or die('Could not find user id: '.$conn->error);
				$row = $result->fetch_assoc();
				$teacherId=$row["TeacherID" ];

				$sqlUpdateClass= "UPDATE class SET TeacherID= $teacherId
		    WHERE ClassID='$class';";
			 }

		    if ($conn->query($sqlUpdateClass) == TRUE) {
			echo "<meta http-equiv='refresh' content='0'>";
			}
					else{
 	 					echo "Error:";
 	 				}
					header("refresh:2; url=TeachersAndClasses.php");
    }

  ?>

	<form method="post">
	<center><h3> Create Teacher</h3></center>
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
	<tr>
	<td style='color:black;'>Email  </td>
	 <td><input style='color:black;' type="text" name="email" required >@iona.edu</td>
	</tr>
	<tr>
		<td style='color:black;'>Select School</td>
		<td>	<select name="school">
			<?php
			$sqlSchool="SELECT  * FROM school ;" ;
			$result = $conn->query($sqlSchool) or die('Error showing school names'.$conn->error);

			//incorporate into drop down list
					while ( $row = mysqli_fetch_array ($result) ) {
							echo '<option value="'.$row["SchoolID"].'">'.$row["School_Name"].'</option>';
					}
		?>
	</select>
		</td>
	</tr>
	<tr>
		<td style='color:black;'>Assign Class</td>
		<td>	<select name="class">
			<?php
			$sqlClass="SELECT  * FROM class
								 WHERE TeacherID=0 AND
								 ClassYear = YEAR(CURDATE());";
			$result = $conn->query($sqlClass) or die('Error showing school names'.$conn->error);

			//incorporate into drop down list
					while ( $row = mysqli_fetch_array ($result) ) {
							echo '<option value="'.$row["ClassID"].'">'.$row["Grade"].'</option>';
					}
  $conn->close();
		?>
	</select>
		</td>
	</tr>
	</table>
	<br>
	<center><button class="button suggestion suggestionsButton" type ="submit" name="CreateTeacher" >Create </button></center>
</form>


<?php
function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}
?>


</body>
</html>
