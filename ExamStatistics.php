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
		<title>Exam Statistics</title>
		<?php include './includedFrameworks/bootstrapHead.html';?>
  </head>

<body>

<?php include './navigation/navBegin.html'; ?>

<div style="padding-top: 15px" class="container">

	<div class="row">
		<h2 >Exam Statistics</h2>
	</div>
  <br>
	<div class="row" style="width:800px; margin:0 auto";>

      <form action="ExamStatistics.php" method="POST">
			<table class="table">
			<tr align="center">
			<th  style="">Exam Year</th>
			 <th  style="">Scope</th>
			 <th style="">Students</th>
			 </tr>

			<tr>
				<td>	<select name="ExamY" id="selectExamYear" required>
					<?php
					$sqlexamY="SELECT  *
					FROM assessment Group by Date;" ;
					$result = $conn->query($sqlexamY) or die('Error showing exam year'.$conn->error);
							echo '<option value="">Exam Year</option>';
							while ( $row = mysqli_fetch_array ($result) ) {
							 $date = $row["Date"];
							$year = intval($date);
									echo '<option value="'.$row["ExamID"].'">'.$year.'</option>';

							}
				?>
			</select>
	  	</td>

				<td>	<select name="examScope" id="examScope" required>
				      	<option value="">Select Scope</option>
						  </select>
				</td>
				<br>

				<td>	<select name="examtStudent" id="examStudent" required>
								<option value="">Select Student</option>
							</select>
				</td>
				<td>
					<center><button class="btn btn-info" type ="submit" name="ViewExamStatistics" >View Statistics </button></center>
				</td>
			</tr>
		 </table>
		 <br><br>
	 </form>
	</div>


	<?php
	if (isset($_POST['ViewExamStatistics']))
  {
		$examYear= $_POST['exam'];
		$sqlTeachers= ("SELECT * FROM assessment WHERE ExamID = '$examYear'");

	$result = $conn->query($sqlTeachers) or die('Could not run query: '.$conn->error);

if ($result->num_rows > 0) { ?>

			<div class="row">
			<table class="table">
			<tr>
			 <th  style="">Question Number</th>
			 <th style="">Indicator</th>
			 <th  style="">Question</th>
			 <th style="">Answer</th>
			 </tr>

			<?php
			 while($row = $result->fetch_assoc()){
				 echo'<form action="DeleteTeacher.php" method="POST">';
				 $examId = $row["ExamID"];
				 $date = $row["Date"];
				 $size = $row["ClassSize"];
				 $csize = $row["ClassSize"];
				 ?>

				 <tr>
				 <td><input class="form-control" name="Name" type="text"   value="<?= $examId?>"></td>

				 <td><input class="form-control" name="teachersName" type="text"   value="<?= $date ?>"></td>

					<td><input name="teacherId" type="text" value="<?= $size ?>"  ></td>

					<td><input name="studentId" type="text" value="<?= $csize ?>"  ></td>
				</tr>
				</form>
		<?php } ?>
		</table>
			 </div>
		<?php }

	}
		 ?>

<?php include './navigation/navEnd.html'; ?>



</body>
</html>
