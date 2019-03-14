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
			 <th style="">Class</th>
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
									echo '<option value='.$row["ExamID"].'>'.$year.'</option>';

							}
				?>
			</select>
	  	</td>

				<td>	<select name="examScope" id="examScope" required>
				      	<option value="">Select Scope</option>
						  </select>
				</td>
				<br>

				<td>	<select name="examClass" id="examClass" required>
								<option value="">Select Class</option>
							</select>
				</td>
				<br>
				<td>	<select name="examStudent" id="examStudent" required>
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
		$exam= $_POST['ExamY'];
		$sqlTeachers= ("SELECT * FROM assessment WHERE ExamID = '$exam'");
		$GLOBALS['scope']= $_POST['examScope'];
		$GLOBALS['class']= $_POST['examClass'];
		$GLOBALS['student']= $_POST['examStudent'];
		$info=("select Question.QuestionNumber, Question.Indicator, Question.QuestionText, Question.CorrectAnswer
				from Question
				inner join StudentAnswers on Question.QuestionID=StudentAnswers.QuestionID
				inner join Assessment on StudentAnswers.ExamID=Assessment.ExamID
				inner join Book on Assessment.BookID=Book.BookID
				where Assessment.ExamID='$exam'");					//return exam info

	$result = $conn->query($info) or die('Could not run query: '.$conn->error);

if ($result->num_rows > 0) { ?>

			<div class="row">
			<table class="table">
			<style>
				table{border-collapse: collapse; }

				tr:nth-child(odd)
				{background-color: #f2f2f2;}

				th {
				background: #3498db;
				color: white;
				font-weight: bold;
				}

				td, th {
					padding: 10px;
					border: 1px solid #ccc;
					text-align: left;
					font-size: 18px;
					}

				.labels tr td {
					background-color: #2cc16a;
					font-weight: bold;
					color: #fff;
				}

				.label tr td label {
					display: block;
				}


				[data-toggle="toggle"] {
					display: none;
				}

				tr
				{
					cursor:pointer;
				}
				<script type="text/javascript">$(document).ready(function() {
				$('[data-toggle="toggle"]').change(function(){
					$(this).parents().next('.hide').toggle();
				});
				});</script>
			</style>
			<tr>
			 <th  style="width:10%">Question Number</th>
			 <th style="width:15%">Indicator</th>
			 <th  style="width:65%">Question</th>
			 <th style="width:10%">Answer</th>
			 </tr>

			<?php
			 while($row = $result->fetch_assoc()){
				 $GLOBALS['qNum'] = $row["QuestionNumber"];
				 $GLOBALS['indicator'] = $row["Indicator"];
				 $GLOBALS['question'] = $row["QuestionText"];
				 $GLOBALS['cAnswer'] = $row["CorrectAnswer"];
				 ?>

				 <tr class="labels">
					<td><input  style="border:none" name="qNum" type="text"   value="<?= $qNum?>" size="4" readonly></td>
					<td><input  style="border:none" name="indicator" type="text"   value="<?= $indicator?>" readonly></td>
					<td><input  style="border:none" name="question" type="text"   value="<?= $question?>" size="90" readonly></td>
					<td><input  style="border:none" name="cAnswer" type="text"   value="<?= $cAnswer?>" size="4" readonly></td>
				</tr>

				 <?php
				//$percentArr = getPercentage();					//return array of 4 percentages, 1 for each letter answer
				//$test=sum(2,6);									//doesn't work either
				$GLOBALS['test']=sum(2,6);

				for($i=0; $i<4; $i++)
				{
					//$percentVal= $percentArr[i];
				?>
				<tr class="hide">
					<td><input style="border:none" name="letter" type="text"   value="<?=A?>" size="4" readonly></td>
					<td><input style="border:none" name="letter" type="text"   value="<?=$test?>" size="4" readonly></td>
				</tr>
				<?php
				}
				?>
			<?php
			}
		}
	}?>
		</table>
			 </div>

<?php
function sum($x, $y) {
    $z = $x + $y;
    return $z;
}
?>




<?php include './navigation/navEnd.html'; ?>



</body>
</html>
