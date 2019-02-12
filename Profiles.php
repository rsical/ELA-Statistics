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
<?php
  include ("./db/connection/dbConnection.php");
?>
<html lang="en">
  <head>
		<title>Profiles</title>
		<?php include './includedFrameworks/bootstrapHead.html';?>
  </head>

<body>

<?php include './navigation/navBegin.html'; ?>

<div style="padding-top: 15px" class="container">

	<div class="row">
		<h2 >Profiles</h2>
  </div>
	<br>

	<?php
		$sqlTeachers= ("SELECT user.FName, user.UserID, user.LName AS userLName, user.FName AS userFName, student.StudentID, class.ClassYear, class.Grade, student.FName, student.LName, class.ClassID
			FROM useraccount user
            INNER JOIN  teacher ON user.UserID= teacher.UserID
			INNER JOIN class ON teacher.teacherID= class.teacherID
            INNER JOIN classhistory ON classhistory.ClassYear= class.ClassYear INNER JOIN student ON student.StudentID = classhistory.StudentID
WHERE classhistory.ClassYear = 2008
Group by user.UserID");

	$result = $conn->query($sqlTeachers) or die('Could not run query: '.$conn->error);
	if ($result->num_rows > 0) { ?>

			<div class="row" style="width:800px; margin:0 auto;">
			<table class="table">
			<tr>
			 <th  style="">Teacher</th>
			 <th style="">Class</th>
			 <th style="">Students</th>
			 </tr>

			<?php
			 while($row = $result->fetch_assoc()){
				 echo'<form action="ViewStudents.php" method="POST">';
				 $UserId = $row["UserID"];
				 $studentId = $row["studentID"];
				 $classId = $row["ClassID"];
				 $userFName = $row["userFName"];
				 $userLName = $row["userLName"];
				 $grade = $row["Grade"];
				 $grades= ["Grade"];
				 ?>


				 <tr>
				 			<td><input class="form-control" name="teachersName" type="text"   value="<?= $userFName ?> <?= $userLName ?>"></td>

				 			<td><input class="form-control" name="grade" type="text"   value="<?= $grade ?> <?= $grades ?>" size="12"></td>

				 			<td><button  class="btn btn-info" type="submit"  name="ViewStudents" value=""><span class="fa fa-eye"></span> View Students</button></td>

				 			<td><input name="UserId" type="hidden" value="<?= $UserId ?>"  ></td>

				 			<td><input name="studentId" type="hidden" value="<?= $studentId ?>"  ></td>

				 <td><input name="classId" type="hidden" value="<?= $classId ?>"  ></td>
				</tr>
				</form>
		<?php } ?>
		</table>
			 </div>
		<?php }
		else {
			echo "0 results";
		}
		 ?>

<?php include './navigation/navEnd.html'; ?>



</body>
</html>
