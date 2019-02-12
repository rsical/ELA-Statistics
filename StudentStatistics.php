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
		<title>Student Statistics</title>
		<?php include './includedFrameworks/bootstrapHead.html';?>
  </head>

<body>

<?php include './navigation/navBegin.html'; ?>

<div style="padding-top: 15px" class="container">

	<div class="row">
		<h2 >Student Statistics</h2>
	</div>
  <br>
	<div class="row" style="width:800px; margin:0 auto;">
		<form action="ShowStudentStatistics.php" method="POST">
			<table class="table">
			<tr align="center">
			 <th  style="">Exam Year</th>
			 <th style="">Grade</th>
			 <th  style="">Scope</th>
			 <th style="">Students</th>
			 </tr>

			<tr>
				<br>
				<td>	<select name="ExamID" id="ExamID" required>
				<?php
								$sqlexamYear="SELECT  *
								FROM assessment Group by Date;" ;
								$result = $conn->query($sqlexamYear) or die('Error showing exam year'.$conn->error);
								echo '<option value="">Exam Year</option>';
								while ( $row = mysqli_fetch_array ($result) ) {
									$date = $row["Date"];
									$year = intval($date);
									echo '<option value="'.$row["ExamID"].'">'.$year.'</option>';
								}
				?>
						 </select>
				</td>

				<br>
				<td>	<select name="grade" id="Grade" required>
								<option value="">Select Grade</option>
							</select>
				</td>
				<br>

				<td>	<select name="scope" id="scope" required>
				      	<option value="">Select Scope</option>
							</select>
				</td>
				<br>

				<td>	<select name="student" id="student" required>
								<option value="">Select Student</option>
							</select>
				</td>

				<td>
					<center><button class="btn btn-info" type ="submit" name="ViewStatistics" >View Statistics </button></center>
				</td>
			</tr>
		 </table>
		 <br><br>
	 </form>
	</div>


	<?php
		$sqlTeachers= ("SELECT user.FName, user.UserID, user.LName AS userLName, user.FName AS userFName, student.StudentID, class.ClassYear, student.FName, student.LName, class.ClassID
			FROM useraccount user
            INNER JOIN  teacher ON user.UserID= teacher.UserID
			INNER JOIN class ON teacher.teacherID= class.teacherID
            INNER JOIN classhistory ON classhistory.ClassYear= class.ClassYear INNER JOIN student ON student.StudentID = classhistory.StudentID
WHERE classhistory.ClassYear = YEAR(CURDATE())
Group by student.StudentID");

	$result = $conn->query($sqlTeachers) or die('Could not run query: '.$conn->error);
	if ($result->num_rows > 0) { ?>

			<div class="row">
			<table class="table">
			<tr>
			 <th  style="">Student</th>
			 <th style="">Teacher</th>
			 </tr>

			<?php
			 while($row = $result->fetch_assoc()){
				 $UserId = $row["UserID"];
				 $studentId = $row["studentID"];
				 $userFName = $row["userFName"];
				 $userLName = $row["userLName"];
				 $studentFName = $row["FName"];
 				 $studentLName = $row["LName"];
				 ?>


				 <tr>
				 <td><input class="form-control" name="Name" type="text"   value="<?= $studentFName ?> <?= $studentLName ?>"></td>

				 <td><input class="form-control" name="teachersName" type="text"   value="<?= $userFName ?> <?= $userLName ?>"></td>

					<td><input name="teacherId" type="hidden" value="<?= $UserId ?>"  ></td>

					<td><input name="studentId" type="hidden" value="<?= $studentId ?>"  ></td>
				</tr>
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
