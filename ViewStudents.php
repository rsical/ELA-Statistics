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
		<title>View Students</title>
		<?php include './includedFrameworks/bootstrapHead.html';?>
  </head>

<body>

<?php include './navigation/navBegin.html'; ?>

<div style="padding-top: 15px" class="container">

	<div class="row">
		<h2 >Students</h2>
  </div>
	<br>

	<?php
	if (isset($_POST['ViewStudents'])){
		$UserId = $_POST['UserId'];
		$studentId = $_POST['studentID'];
		$classId = $_POST['classID'];
		$teachersName = $_POST['teachersName'];
		$grade = $_POST['grade'];


		$sqlStudents= ("SELECT user.FName, user.UserID, user.LName AS userLName, user.FName AS userFName, student.StudentID, class.ClassYear, class.Grade, student.FName, student.LName, class.ClassID
			FROM useraccount user
      INNER JOIN  teacher ON user.UserID= teacher.UserID
			INNER JOIN class ON teacher.teacherID= class.teacherID
      INNER JOIN classhistory ON classhistory.ClassYear= class.ClassYear INNER JOIN student ON student.StudentID = classhistory.StudentID
			WHERE user.UserID = '$UserId' AND class.Grade= '$grade' AND class.ClassYear = YEAR(CURDATE())
			Group by student.studentID");

	$result = $conn->query($sqlStudents) or die('Could not run query: '.$conn->error);
}
	if ($result->num_rows > 0) { ?>
			<div class="row" style="width:600px; margin:0 auto;">
				<?php echo "<b>" .$teachersName." ".$grade. "</b>"; ?>
			</div>

			<div class="row" style="width:600px; margin:0 auto;">
			<table class="table">
			<tr>
			 <th  style="">STUDENTS</th>
			 </tr>

			<?php
			 while($row = $result->fetch_assoc()){
				 $studentId = $row["studentID"];
				 $FName = $row["FName"];
				 $LName = $row["LName"];
				 ?>


				 <tr>
				 			<td><input class="form-control" name="teachersName" type="text"   value="<?= $FName ?> <?= $LName ?>"></td>

				 			<td><input name="studentId" type="hidden" value="<?= $studentId ?>"  ></td>

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
