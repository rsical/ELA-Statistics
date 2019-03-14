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
		<form action="StudentStatistics.php" method="POST">
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

				if (isset($_SESSION['isTeacher'])) {
						if ($_SESSION['isTeacher']) {
							$sqlexamY="SELECT assessment.Date, assessment.ExamID, useraccount.UserID
							FROM assessment
							INNER JOIN classhistory ON classhistory.ClassHistoryID= assessment.ClassHistoryID
							INNER JOIN class ON class.ClassID = classhistory.ClassID
							INNER JOIN teacher ON teacher.TeacherID= class.TeacherID
							INNER JOIN useraccount ON useraccount.UserID = teacher.UserID
							WHERE useraccount.UserID=$currUserID
							GROUP BY DATE;" ;
							$GLOBALS['Yresult'] = $conn->query($sqlexamY) or die('Error showing exam year'.$conn->error);
						}
					}
					if (isset($_SESSION['isAdmin'])) {
						if ($_SESSION['isAdmin']) {
								$sqlexamYear="SELECT  *
								FROM assessment Group by Date;" ;
								$GLOBALS['Yresult'] =$conn->query($sqlexamYear) or die('Error showing exam year'.$conn->error);

							}
						}

								echo '<option value="">Exam Year</option>';
								while ( $row = mysqli_fetch_array ($Yresult) ) {
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

				if(isset($_POST['ViewStatistics'])){
		  	$GLOBALS['examId']= $_POST['ExamID'];
		  	$GLOBALS['grade'] = $_POST['grade'];
				$GLOBALS['scope'] = $_POST['scope'];
				$GLOBALS['student'] = $_POST['student'];


	?>

		<div class="row" style="width:800px; margin:0 auto;">
				<table class="table">
					<tr>
						<th><h2>Exam Information</h2></th>
					</tr>


				 <?php
									$sqlResp="SELECT  Count(assessment.BookID) as respondents, book.NumberOfQuestions, assessment.Date
									FROM assessment
									INNER JOIN book book ON book.BookID = assessment.BookID
									WHERE assessment.BookID=(SELECT BookID FROM assessment
	                                                      WHERE ExamID= '$examId');" ;
									$result = $conn->query($sqlResp) or die('Error showing exam year'.$conn->error);
									echo '<option value="">Exam Year</option>';
									while ( $row = mysqli_fetch_array ($result) ) {
										$GLOBALS['resp'] = $row["respondents"];
										$GLOBALS ['numQuestions']= $row["NumberOfQuestions"];
										$date = $row["Date"];
										$year = intval($date);

										$myresult= explode('|', $grade);
										$mygrade=$myresult[1];

					?>
					<tr>
									<th>Exam Year</th>
									<td><input  style="border:none" name="respondents" type="text"   value="<?= $year?>" size="4" readonly></td>
        	</tr>
					<tr>
									<th>Grade</th>
									<td><input  style="border:none" name="respondents" type="text"   value="<?= $mygrade?>" size="4" readonly></td>
				  </tr>
					<tr>
									<th>Number of Respondents</th>
									<td><input  style="border:none" name="respondents" type="text"   value="<?= $resp?>" size="4" readonly></td>
				</tr>
					<tr>
									<th>Number of Questions</th>
									<td><input style="border:none" name="numQuestions" type="text"  size="4" value="<?= $numQuestions?>"></td>

					</tr>

						<?php
							}
					 if($scope != "school"){ ?>


							 <?php
	 		 								$sqlStudent="SELECT * FROM student
																		WHERE StudentID = '$student';" ;

	 		 								$result = $conn->query($sqlStudent) or die('Error showing exam year'.$conn->error);
	 		 								echo '<option value="">Exam Year</option>';
	 		 								while ( $row = mysqli_fetch_array ($result) ) {
	 		 									$FName = $row["FName"];
												$LName = $row["LName"];


	 		 				?>
										<tr>
	 		 							<th><h3>Student:<input style="border:none" name="Name" type="text"   value="<?= $FName ?> <?= $LName ?>" size="25" readonly></h3></th>

						 </tr>
					 <?php } ?>
						<tr>
						<th>Grade</th>
						<?php
							$sqlExamPoints="SELECT COUNT(question.points) as totalPoints
							FROM question
							INNER JOIN studentanswers ON studentanswers.QuestionID= question.QuestionID
							INNER JOIN assessment ON assessment.ExamID= studentanswers.ExamID
							WHERE assessment.BookID= (SELECT BookID FROM assessment WHERE ExamID= '$examId');" ;

							$result = $conn->query($sqlExamPoints) or die('Error showing exam year'.$conn->error);
							while ( $row = mysqli_fetch_array ($result) ) {

							$GLOBALS['EPoints']= $row["totalPoints"];
						}

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

											$Mresult= PassRateSingle($points, $EPoints, $resp);
		 				?>

		 								<td><input style="border:none" name="correctA" type="text"   value="<?= round($Percentage)?>" size="3" readonly>%</td>

					</tr>
					<tr>
						<th>Correct Answers</th>
						<td><input style="border:none" name="points" type="text"   value="<?= $points?>   <?= "Points    -".$Mresult ?>" size="36" readonly></td>

					</tr>
				<?php }
						}
						else{	?>
							<tr>
							<th><h2>Statistics</h2></th>
							</tr>
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
									$sqlEanswer="SELECT count(studentanswers.QuestionID), studentanswers.LetterAnswer, question.CorrectAnswer, COUNT(question.Points) as Lowest, exam.ExamID
									FROM studentanswers
									INNER JOIN question question ON studentanswers.QuestionID= question.QuestionID
									INNER JOIN  assessment exam ON studentanswers.ExamID= exam.ExamID
									INNER JOIN book book ON exam.BookID= book.BookID
									INNER JOIN classhistory history ON history.ClassHistoryID= exam.ClassHistoryID
									INNER JOIN  student ON student.StudentID= history.StudentID
									WHERE exam.BookID=(SELECT BookID FROM assessment
									WHERE ExamID= '$examId') AND studentanswers.LetterAnswer = question.CorrectAnswer
									GROUP BY exam.ExamID
									ORDER BY Lowest ASC limit 1;" ;



									$result = $conn->query($sqlEanswer) or die('Error showing exam year'.$conn->error);
									echo '<option value="">Exam Year</option>';
									while ( $row = mysqli_fetch_array ($result) ) {
										$Lowest = $row["Lowest"];
								

					?>
									<td><input style="border:none" name="Average" type="text"   value="<?=$Lowest?>" size="2" readonly> Points</td>
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
						<td><input style="border:none" name="Average" type="text"   value="<?= number_format((float)$Average,2, '.', ' ')?>" size="5" readonly>Points</td>
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
							GROUP BY exam.ExamID
							ORDER BY grades ASC;" ;

							$result = $conn->query($sqlCanswers) or die('Error showing exam year'.$conn->error);
							echo '<option value="">Exam Year</option>';
								$GLOBALS ['GradesArray'] = array();
							while ( $row = mysqli_fetch_array ($result) ) {

								$GradesArray[]=$row["grades"];
					 }

							Arsort($GradesArray);

								$GLOBALS['sdv']=Stand_Deviation($GradesArray);
								$GLOBALS['Median']=FindMedian($GradesArray);
								$GLOBALS['myMode']=FindMode($GradesArray);

								//copying mode array in a variable
											$s= ", ";
											foreach ($myMode as $val){
												if(count($myMode)> 1)
											$GLOBALS['Mode'] = $val.$s.$Mode ;
											else
											$GLOBALS['Mode'] = $val;
										 }
			?>
							<td><input style="border:none" name="Median" type="text"   value="<?= $Median?>" size="4" readonly>Points</td>
		</tr>
		<tr>
			<th>Mode</th>
			<td><input style="border:none" name="Mode" type="text"   value="<?= $Mode?>" size="4" readonly>Points</td>
		</tr>
		<tr>
			<th>Standard Deviation, σ</th>
			<td><input style="border:none" name="Mode" type="text"   value="<?= number_format((float)$sdv,2, '.', ' ')?>" size="4" readonly></td>
		</tr>




		<tr>
				<th>Pass Rate    (Minimum Passing Percentage 60%)</th>
				<?php
								$sqlExamPoints="SELECT COUNT(question.points) as totalPoints
								FROM question
								INNER JOIN studentanswers ON studentanswers.QuestionID= question.QuestionID
								INNER JOIN assessment ON assessment.ExamID= studentanswers.ExamID
								WHERE assessment.BookID= (SELECT BookID FROM assessment WHERE ExamID= '$examId');" ;

								$result = $conn->query($sqlExamPoints) or die('Error showing exam year'.$conn->error);
								while ( $row = mysqli_fetch_array ($result) ) {

									$GLOBALS['ExamPoints']= $row["totalPoints"];
								}


								$pass= PassRate($GradesArray, $ExamPoints, $resp);
								$Percentage= ($pass/$resp) * 100;


				?>

								<td><input style="border:none" name="Average" type="text"   value="<?= round($Percentage)?>" size="2" readonly>% Of Students Passed The Test</td>
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
			 }
		 }?>

	</table>
	</div>
	<?php
	function Stand_Deviation($arr)
	    {
	        $num_of_elements = count($arr);

	        $variance = 0.0;

	                // calculating mean using array_sum() method
	        $average = array_sum($arr)/$num_of_elements;

	        foreach($arr as $i)
	        {
	            // sum of squares of differences between
	                        // all numbers and means.
	            $variance += pow(($i - $average), 2);
	        }

	        return (float)sqrt($variance/$num_of_elements);
	    }


			function FindMedian($arr) {
			    $count = count($arr); //total numbers in array
			    $midNumber = floor(($count-1)/2); // find the middle value, or the lowest middle value
			    if($count % 2) { // odd number, middle is the median
			        $median = $arr[$midNumber];
			    } else { // even number, calculate avg of 2 medians
			        $low = $arr[$midNumber];
			        $high = $arr[$midNumber+1];
			        $median = (($low+$high)/2);
			    }
			    return $median;
			}

			function FindMode($arr) {
			  $values = array();
			  foreach ($arr as $v) {
			    if (isset($values[$v])) {
			      $values[$v] ++;
			    } else {
			      $values[$v] = 1;  // counter of appearance
			    }
			  }
			  arsort($values);  // sort the array by values, in non-ascending order.
			  $modes = array();
			  $x = $values[key($values)]; // get the most appeared counter
			  reset($values);
			  foreach ($values as $key => $v) {
			    if ($v == $x) {   // if there are multiple 'most'
			      $modes[] = $key;  // push to the modes array
			    } else {
			      break;
			    }
			  }
			  return $modes;
			}

	function PassRate($arr, $Epoints, $respondents){

		echo 'items in array ';
		echo count($arr);
		echo '</br>';
		echo 'respondents ';
		echo $respondents;

		$total= 0;
		$grade= ($Epoints/$respondents);
		$passGrade = $grade * 0.60;
	  $arrLength = count($arr);

		for($x=0; $x<$arrLength; $x++){
			if($arr[$x] > $passGrade)
				$total= $total +1;
		}
		return $total;
	}

	function PassRateSingle($StudentGrade, $Allpoints, $respondents){
		$mygrade= ($Allpoints/$respondents);
		$passGrade = $mygrade * 0.60;
	 	$result= "Student's Grade Is Unsatisfactory";
			if($StudentGrade >= $passGrade){
				$result= "Student's Grade Is Satisfactory";
				//return $result;
		}

		return $result;

	}
		 ?>

<?php include './navigation/navEnd.html'; ?>



</body>
</html>
