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

			if(isset($_POST['ViewStatistics'])){
	  	$GLOBALS['examId']= $_POST['ExamID'];
	  	$GLOBALS['grade'] = $_POST['grade'];
			$GLOBALS['scope'] = $_POST['scope'];
			$GLOBALS['student'] = $_POST['student'];
	  	//$scope = $_POST['scope'];
	  	//$student = $_POST['student'];
			echo $student;
			echo $scope;
}
?>
<html lang="en">
  <head>
		<title>Statistics</title>
		<?php include './includedFrameworks/bootstrapHead.html';?>
  </head>

<body>
<?php include './navigation/navBegin.html'; ?>

<div style="padding-top: 15px" class="container">

	<div class="row">
		<h2 >Statistics</h2>
	</div>
	<br>

	<div class="row" style="width:800px; margin:0 auto;">
			<table class="table">
		 	<tr>
			 				<th>Number of Respondents</th>
			 <?php
								$sqlResp="SELECT  Count(assessment.BookID) as respondents, book.NumberOfQuestions
								FROM assessment
								INNER JOIN book book ON book.BookID = assessment.BookID
								WHERE assessment.BookID=(SELECT BookID FROM assessment
                                                      WHERE ExamID= '$examId');" ;
								$result = $conn->query($sqlResp) or die('Error showing exam year'.$conn->error);
								echo '<option value="">Exam Year</option>';
								while ( $row = mysqli_fetch_array ($result) ) {
									$GLOBALS['resp'] = $row["respondents"];
									$GLOBALS ['numQuestions']= $row["NumberOfQuestions"];

				?>

								<td><input  style="border:none" name="respondents" type="text"   value="<?= $resp?>" size="4" readonly></td>
			</tr>
				<tr>
								<th>Number of Questions</th>
								<td><input style="border:none" name="numQuestions" type="text"  size="4" value="<?= $numQuestions?>"></td>

				</tr>

					<?php
						}
				 if($scope != "school"){ ?>
					<tr>
					<th>Correct Answers</th>
					<?php
	 								$sqlCanswers="SELECT studentanswers.QuestionID, COUNT(studentanswers.LetterAnswer) as cAnswers, question.CorrectAnswer, COUNT(question.Points) as Tpoints
									FROM studentanswers
									INNER JOIN question question ON studentanswers.QuestionID= question.QuestionID
									INNER JOIN  assessment exam ON studentanswers.ExamID= exam.ExamID
									INNER JOIN book book ON exam.BookID= book.BookID
									INNER JOIN classhistory history ON history.ClassHistoryID= exam.ClassHistoryID
									INNER JOIN  student ON student.StudentID= history.StudentID
									WHERE student.StudentID='$student' AND exam.BookID=(SELECT BookID FROM assessment
                  WHERE ExamID= '$examId') AND studentanswers.LetterAnswer = question.CorrectAnswer;" ;

	 								$result = $conn->query($sqlCanswers) or die('Error showing exam year'.$conn->error);
	 								echo '<option value="">Exam Year</option>';
	 								while ( $row = mysqli_fetch_array ($result) ) {
	 									$correctA = $row["cAnswers"];
										$Percentage= ($correctA / $numQuestions)*100;
	 							    $points= $row["Tpoints"];

	 				?>

	 								<td><input style="border:none" name="correctA" type="text"   value="<?= round($Percentage)?>" size="2" readonly>%</td>

				</tr>
				<tr>
					<th>Grade</th>
					<td><input style="border:none" name="points" type="text"   value="<?= $points?>" size="2" readonly>Points</td>

				</tr>
			<?php }
					}
					else{	?>

							<tr>
							<th>Highest Grade</th>
							<?php
											$sqlEanswer="SELECT count(studentanswers.QuestionID), studentanswers.LetterAnswer, question.CorrectAnswer, COUNT(question.Points) as Highest, exam.ExamID
											FROM studentanswers
											INNER JOIN question question ON studentanswers.QuestionID= question.QuestionID
											INNER JOIN  assessment exam ON studentanswers.ExamID= exam.ExamID
											INNER JOIN book book ON exam.BookID= book.BookID
											INNER JOIN classhistory history ON history.ClassHistoryID= exam.ClassHistoryID
											INNER JOIN  student ON student.StudentID= history.StudentID
											WHERE exam.BookID=(SELECT BookID FROM assessment
                    	WHERE ExamID= '$examId') AND studentanswers.LetterAnswer = question.CorrectAnswer
											GROUP BY exam.ExamID
											ORDER BY Highest DESC limit 1;" ;

											$result = $conn->query($sqlEanswer) or die('Error showing exam year'.$conn->error);
											echo '<option value="">Exam Year</option>';
											while ( $row = mysqli_fetch_array ($result) ) {
												$highest = $row["Highest"];

							?>
											<td><input style="border:none" name="Average" type="text"   value="<?=$highest?>" size="2" readonly> Points</td>
						</tr>
				<?php	 }
				?>

				<th>Lowest Grade</th>
				<?php
								$sqlEanswer="SELECT count(studentanswers.QuestionID), studentanswers.LetterAnswer, question.CorrectAnswer, COUNT(question.Points) as Highest, exam.ExamID
								FROM studentanswers
								INNER JOIN question question ON studentanswers.QuestionID= question.QuestionID
								INNER JOIN  assessment exam ON studentanswers.ExamID= exam.ExamID
								INNER JOIN book book ON exam.BookID= book.BookID
								INNER JOIN classhistory history ON history.ClassHistoryID= exam.ClassHistoryID
								INNER JOIN  student ON student.StudentID= history.StudentID
								WHERE exam.BookID=(SELECT BookID FROM assessment
								WHERE ExamID= '$examId') AND studentanswers.LetterAnswer = question.CorrectAnswer
								GROUP BY exam.ExamID
								ORDER BY Highest ASC limit 1;" ;



								$result = $conn->query($sqlEanswer) or die('Error showing exam year'.$conn->error);
								echo '<option value="">Exam Year</option>';
								while ( $row = mysqli_fetch_array ($result) ) {
									$highest = $row["Highest"];

				?>
								<td><input style="border:none" name="Average" type="text"   value="<?=$highest?>" size="2" readonly> Points</td>
			</tr>
	<?php	 }
	?>

	<tr>
	<th>Mean</th>
	<?php
					$sqlCanswers="SELECT studentanswers.QuestionID, studentanswers.LetterAnswer as cAnswers, question.CorrectAnswer, COUNT(question.Points) as Tpoints
FROM studentanswers
INNER JOIN question question ON studentanswers.QuestionID= question.QuestionID
INNER JOIN  assessment exam ON studentanswers.ExamID= exam.ExamID
INNER JOIN book book ON exam.BookID= book.BookID
INNER JOIN classhistory history ON history.ClassHistoryID= exam.ClassHistoryID
INNER JOIN  student ON student.StudentID= history.StudentID
WHERE exam.BookID=(SELECT BookID FROM assessment
					WHERE ExamID= '$examId') AND studentanswers.LetterAnswer = question.CorrectAnswer;" ;

					$result = $conn->query($sqlCanswers) or die('Error showing exam year'.$conn->error);
					echo '<option value="">Exam Year</option>';
					while ( $row = mysqli_fetch_array ($result) ) {
						$correctA = $row["cAnswers"];
						$points= $row["Tpoints"];
						$Average = $points / $resp;

	?>
					<td><input style="border:none" name="Average" type="text"   value="<?= number_format((float)$Average,2, '.', ' ')?>" size="4" readonly>Points</td>
</tr>

<?php }
		?>

		<tr>
		<th>Median</th>
		<?php
						$sqlCanswers="SELECT count(studentanswers.QuestionID), studentanswers.LetterAnswer, question.CorrectAnswer, COUNT(question.Points) as grades, exam.ExamID
						FROM studentanswers
						INNER JOIN question question ON studentanswers.QuestionID= question.QuestionID
						INNER JOIN  assessment exam ON studentanswers.ExamID= exam.ExamID
						INNER JOIN book book ON exam.BookID= book.BookID
						INNER JOIN classhistory history ON history.ClassHistoryID= exam.ClassHistoryID
						INNER JOIN  student ON student.StudentID= history.StudentID
						WHERE exam.BookID=(SELECT BookID FROM assessment
						WHERE ExamID= '$examId') AND studentanswers.LetterAnswer = question.CorrectAnswer
						GROUP BY exam.ExamID;" ;

						$result = $conn->query($sqlCanswers) or die('Error showing exam year'.$conn->error);
						echo '<option value="">Exam Year</option>';
						while ( $row = mysqli_fetch_array ($result) ) {

						//	$Grades= $row["grades"];
							$GLOBALS ['GradesArray'] = [];
							array_push($GradesArray, $row["grades"]);
				 }
									//	print_r($GradesArray);
						//	$GLOBALS['Median']= $GradesArray[round(count($GradesArray)/2)];
							$GLOBALS['Median']=$GradesArray[9];
							echo $GradesArray[round(count($GradesArray)/2)];
						//	$Average = $points / $resp;

		?>
						<td><input style="border:none" name="Average" type="text"   value="<?= $Median?>" size="4" readonly>Points</td>
	</tr>




					<tr>
							<th>Easiest Question</th>
	  					<?php
	  	 								$sqlEanswer="SELECT count(studentanswers.QuestionID) as total, studentanswers.LetterAnswer as cAnswers, question.CorrectAnswer, studentanswers.QuestionNumber
											FROM studentanswers
INNER JOIN question question ON studentanswers.QuestionID= question.QuestionID
INNER JOIN  assessment exam ON studentanswers.ExamID= exam.ExamID
INNER JOIN book book ON exam.BookID= book.BookID
INNER JOIN classhistory history ON history.ClassHistoryID= exam.ClassHistoryID
INNER JOIN  student ON student.StudentID= history.StudentID
WHERE exam.BookID=(SELECT BookID FROM assessment
                    WHERE ExamID= '$examId') AND studentanswers.LetterAnswer = question.CorrectAnswer
GROUP BY studentanswers.QuestionID
ORDER BY COUNT(studentanswers.QuestionID) DESC LIMIT 1;" ;

	  	 								$result = $conn->query($sqlEanswer) or die('Error showing exam year'.$conn->error);
	  	 								echo '<option value="">Exam Year</option>';
	  	 								while ( $row = mysqli_fetch_array ($result) ) {
	  	 									$question = $row["QuestionNumber"];
												$total= $row["total"];

												$Percentage= ($total / $resp) * 100;


	  	 				?>

											<td>Question Number <input style="border:none" name="Average" type="text"   value="<?= $question?>" size="3" readonly>
											<br>
											<input style="border:none" name="Average" type="text"   value="<?= round($Percentage)?>" size="2" readonly>% of Students Got It Right</td>
	  				</tr>
	 		<?php	 }
		 ?>
		 <tr>
		 <th>Hardest Question</th>
		 <?php
		 				$sqlEanswer="SELECT count(studentanswers.QuestionID) as total, studentanswers.LetterAnswer as cAnswers, question.CorrectAnswer, studentanswers.QuestionNumber
		 				FROM studentanswers
		 INNER JOIN question question ON studentanswers.QuestionID= question.QuestionID
		 INNER JOIN  assessment exam ON studentanswers.ExamID= exam.ExamID
		 INNER JOIN book book ON exam.BookID= book.BookID
		 INNER JOIN classhistory history ON history.ClassHistoryID= exam.ClassHistoryID
		 INNER JOIN  student ON student.StudentID= history.StudentID
		 WHERE exam.BookID=(SELECT BookID FROM assessment
		 			WHERE ExamID= '$examId') AND studentanswers.LetterAnswer = question.CorrectAnswer
		 GROUP BY studentanswers.QuestionID
		 ORDER BY COUNT(studentanswers.QuestionID) ASC LIMIT 1;" ;

		 				$result = $conn->query($sqlEanswer) or die('Error showing exam year'.$conn->error);
		 				echo '<option value="">Exam Year</option>';
		 				while ( $row = mysqli_fetch_array ($result) ) {
		 					$question = $row["QuestionNumber"];
		 					$total= $row["total"];
							$Percentage= ($total / $resp) * 100;


		 ?>

		 				<td>Question Number <input style="border:none" name="Average" type="text"   value="<?= $question?>" size="2" readonly>
		 				<br>
		 				<input style="border:none" name="Average" type="text"   value="<?= round($Percentage)?>" size="2" readonly>% of Students Got It Right</td>
			 </tr>
		 <?php	 }
		 }?>

</table>
</div>

<?php include './navigation/navEnd.html'; ?>



   </body>
   </html>
