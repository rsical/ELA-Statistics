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
		<title>Matching Students</title>
		<?php include './includedFrameworks/bootstrapHead.html';?>
  </head>

<body>

<?php include './navigation/navBegin.html'; ?>

<div style="padding-top: 15px" class="container">
	<div class="row">
		<h2 >Matching Students</h2>
	</div>
  <br>
	<div class="row" style="width:800px; margin:0 auto;">
		<form action="MatchingStudents.php" method="POST">
			<table class="table">
			<tr align="center">
			 <th  style="">Exam Year</th>
			 <th style="">Scope</th>
			 <th  style="">Grade</th>
			 <th style="">Students</th>
			 <th style="">Select # of Students to Match</th>
			 </tr>
			<tr>
				<br>
				<td>	<select name="matchExamDate" id= "matchExamID" required>
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
							$GLOBALS['dResult'] = $conn->query($sqlexamY) or die('Error showing exam year'.$conn->error);
						}
					}
					if (isset($_SESSION['isAdmin'])) {
						if ($_SESSION['isAdmin']) {
								$sqlexamYear="SELECT  *
								FROM assessment Group by Date;" ;
								$GLOBALS['dResult'] =$conn->query($sqlexamYear) or die('Error showing exam year'.$conn->error);

							}
						}
								echo '<option value="">Exam Year</option>';
								while ( $row = mysqli_fetch_array ($dResult) ) {
									$date = $row["Date"];
									$year = intval($date);
									echo '<option value="'.$row["ExamID"].'|'.$row["Date"].'">'.$year.'</option>';
								}
				?>
						 </select>
				</td>

				<td>	<select name="matchScope" id="matchScope" required>
								<option value="">Select Scope</option>
							</select>
				</td>
				<br>

				<br>
				<td>	<select name="matchGrade" id="matchGrade" required>
								<option value="">Select Grade</option>
							</select>
				</td>
				<br>

				<td>	<select name="matchStudent" id="matchStudent" required>
								<option value="">Select Student</option>
							</select>
				</td>

				<td>	<select name="matchNumber" id="matchNumber" required>
								<option value="">Select Number</option>
							</select>
				</td>
			</tr>
			<th style="" width="18%">Match Criteria:</th>
			<tr>
				<td>	Final Score: <input type="radio" name="matchCriteria" value="finalScore" id="finaScore" disabled=true onclick="checkbox()" required>
				</td>
				<td>	Category Percentage: <input type="radio" name="matchCriteria" value="percentage"id="percentage" disabled=true onclick="checkbox()" required>
				</td>
			</tr>
			<tr>
				<td>	Category I: <input type="checkbox" name="check_list[]" value="1" disabled=true>
				</td>
				<td>	Category II: <input type="checkbox" name="check_list[]" value="2" disabled=true>
				</td>
				<td>	Category III: <input type="checkbox" name="check_list[]" value="3" disabled=true>
				</td>
				<td>
					<center><button class="btn btn-info" type ="submit" name="FindMatch" >Find Match</button></center>
				</td>
			</tr>
		 </table>
		 <br><br>
	 </form>
	</div>


	<?php
// Getting values from selection
				if(isset($_POST['FindMatch'])){
		  	$examIdAndDate= $_POST['matchExamDate'];
		  	$scopeData = $_POST['matchScope'];
				$classData = $_POST['matchGrade'];
				$GLOBALS['student'] = $_POST['matchStudent'];
				$GLOBALS['numberOfStudents'] = $_POST['matchNumber'];
				$GLOBALS['matchCriteria'] = $_POST['matchCriteria'];
				$GLOBALS['myCategories'] = $_POST['check_list'];

				$examData = explode('|', $examIdAndDate);
				$examId= $examData[0];
				$GLOBALS['examDate']= $examData[1];

				$myScopeData = explode('|', $scopeData);
				$GLOBALS['scope']= $myScopeData[0];

				$myClassData = explode('|', $classData);
				$GLOBALS['scopeId']= $myClassData[3]; //this can be schoolId or classID

				$GLOBALS['categories'] = array();

				for($i=0; $i<3; $i++){
					$values=$myCategories[$i];
					if($values != null){
							$categories[]= $values;

					}
				}
			}

	?>

		<div class="row" style="width:800px; margin:0 auto;">
				<table class="table">
					<tr>
						<th><h2>Exam Information</h2></th>
					</tr>
				 <?php
									$sqlResp="SELECT   assessment.Date, assessment.ExamID, school.School_Name, class.classID, class.Grade
									FROM assessment
									INNER JOIN book book ON book.BookID = assessment.BookID
									INNER JOIN classhistory ON classhistory.ClassHistoryID= assessment.ClassHistoryID
									INNER JOIN student ON student.StudentID = classhistory.StudentID
									INNER JOIN class ON class.ClassID = classhistory.ClassID
									INNER JOIN teacher ON teacher.TeacherID = class.TeacherID
									INNER JOIN school ON school.SchoolID = teacher.SchoolID
									WHERE assessment.Date= '$examDate' and student.StudentId= '$student';" ;
									$result = $conn->query($sqlResp) or die('Error showing information'.$conn->error);

									while ( $row = mysqli_fetch_array ($result) ) {
										$schoolName= $row["School_Name"];
										$mygrade=$row["Grade"];
										$GLOBALS['examId']= $row["ExamID"];
					?>
					<tr>
									<th>School Name</th>
									<td><input  style="border:none" name="respondents" type="text"   value="<?= $schoolName?>" size="35" readonly></td>
					</tr>
					<tr>
									<th>Exam Year</th>
									<td><input  style="border:none" name="respondents" type="text"   value="<?= $year?>" size="4" readonly></td>
        	</tr>
					<tr>
									<th>Grade</th>
									<td><input  style="border:none" name="respondents" type="text"   value="<?= $mygrade?>" size="4" readonly></td>
				  </tr>
					<?php
							}
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
						<?php
//Getting number of questions and total points for each category
// Getting values for each category selected
						foreach($categories as $category) {
							$sqlExamPoints="SELECT COUNT(studentanswers.QuestionID) AS NumberOfQuestions,  COUNT(question.Points) as totalPoints,
							categories.Category
							FROM categories
							INNER JOIN question ON question.Indicator = categories.Indicator
							INNER JOIN studentanswers ON  studentanswers.QuestionID= question.QuestionID
							INNER JOIN  assessment exam ON studentanswers.ExamID= exam.ExamID
							INNER JOIN book book ON exam.BookID= book.BookID
							INNER JOIN classhistory history ON history.ClassHistoryID= exam.ClassHistoryID
							INNER JOIN  student ON student.StudentID= history.StudentID
							WHERE student.StudentID='$student' AND exam.BookID=(SELECT BookID FROM assessment
							WHERE ExamID= '$examId') AND categories.Category = '$category';" ;


							$result = $conn->query($sqlExamPoints) or die('Error showing category data'.$conn->error);
							while ( $row = mysqli_fetch_array ($result) ) {

							$GLOBALS['ePoints']= $row["totalPoints"];
							$GLOBALS['numQuestions']= $row["NumberOfQuestions"];
						}

		 								$sqlCanswers="SELECT studentanswers.QuestionID, COUNT(studentanswers.LetterAnswer) as cAnswers, question.CorrectAnswer, COUNT(question.Points) as Tpoints,
										categories.Category
										FROM categories
										INNER JOIN question ON question.Indicator = categories.Indicator
										INNER JOIN studentanswers ON  studentanswers.QuestionID= question.QuestionID
										INNER JOIN  assessment exam ON studentanswers.ExamID= exam.ExamID
										INNER JOIN book book ON exam.BookID= book.BookID
										INNER JOIN classhistory history ON history.ClassHistoryID= exam.ClassHistoryID
										INNER JOIN  student ON student.StudentID= history.StudentID
										WHERE student.StudentID='$student' AND exam.BookID=(SELECT BookID FROM assessment
	                  WHERE ExamID= '$examId') AND studentanswers.LetterAnswer = question.CorrectAnswer AND categories.Category = '$category';" ;

		 								$result = $conn->query($sqlCanswers) or die('Error showing results for category'.$conn->error);

		 								while ( $row = mysqli_fetch_array ($result) ) {
		 									$correctA = $row["cAnswers"];
		 							    $points= $row["Tpoints"];

//Calculating values according to criteria selected-- Percentage or Final score
											if($matchCriteria == "finalScore"){
												$GLOBALS["studentResult"]= $points;
												$GLOBALS["studentPts"]= $points;
												$studentResult .= "/";
												$studentResult .= $numQuestions;
												$studentResult .= " Points";
											}
											if($matchCriteria == "percentage"){
													$GLOBALS["studentPts"]= $points;
													$GLOBALS["studentResult"]= round(($correctA / $numQuestions)*100);
													$studentResult .= " %";
											}
													if($category == 1){
							              $GLOBALS["catOneToCompare"]= $studentPts;
														$GLOBALS["numQuestionsOne"]= $numQuestions;
							            }
							            if($category ==2){
							              $GLOBALS["catTwoToCompare"]= $studentPts;
														$GLOBALS["numQuestionsTwo"]= $numQuestions;
							            }
							            if($category ==3){
							              $GLOBALS["catThreeToCompare"]= $studentPts;
														$GLOBALS["numQuestionsThree"]= $numQuestions;
							            }


											$categoryNumber= "Category ";
											$categoryNumber .= $category;
		 				?>

		 								<td><input style="border:none" name="correctA" type="text"   value="<?= $categoryNumber.': '.$studentResult?>" size="19" readonly></td>
										<?php
										}
									}
									?>
					</tr>
					<tr>
					<th><h2>Closest Matches This Year</h2></th>
					</tr>
						<tr>
						<th></th>
						<?php

						//getting Category 1 results for all students
							foreach($categories as $category) {
								if($scope == "school"){
								$sqlEanswer="SELECT student.StudentID, COUNT(question.Points) as categoryPoints,
								categories.Category, school.SchoolID
								FROM categories
								INNER JOIN question ON question.Indicator = categories.Indicator
								INNER JOIN studentanswers ON  studentanswers.QuestionID= question.QuestionID
								INNER JOIN  assessment exam ON studentanswers.ExamID= exam.ExamID
								INNER JOIN book book ON exam.BookID= book.BookID
								INNER JOIN classhistory history ON history.ClassHistoryID= exam.ClassHistoryID
								INNER JOIN  student ON student.StudentID= history.StudentID
								INNER JOIN class ON class.classID= history.classID
								INNER JOIN teacher ON teacher.TeacherID = class.TeacherID
								INNER JOIN useraccount ON useraccount.UserID = teacher.UserID
								INNER JOIN school ON school.SchoolID = useraccount.SchoolID
								WHERE exam.BookID=(SELECT BookID FROM assessment
								WHERE ExamID= '$examId') AND school.SchoolID='$scopeId' AND studentanswers.LetterAnswer = question.CorrectAnswer AND categories.Category = '$category' and exam.Date = '$examDate'
								GROUP BY student.StudentID
								ORDER BY categoryPoints ASC;" ;

										$GLOBALS['categoryResult']= $conn->query($sqlEanswer) or die('Error showing matched category one'.$conn->error);
							}
								if($scope == "class"){
								$sqlEanswer="SELECT student.StudentID, COUNT(question.Points) as categoryPoints,
								categories.Category
								FROM categories
								INNER JOIN question ON question.Indicator = categories.Indicator
								INNER JOIN studentanswers ON  studentanswers.QuestionID= question.QuestionID
								INNER JOIN  assessment exam ON studentanswers.ExamID= exam.ExamID
								INNER JOIN book book ON exam.BookID= book.BookID
								INNER JOIN classhistory history ON history.ClassHistoryID= exam.ClassHistoryID
								INNER JOIN  student ON student.StudentID= history.StudentID
								INNER JOIN class ON class.classID= history.classID
								WHERE exam.BookID=(SELECT BookID FROM assessment
								WHERE ExamID= '$examId') AND class.classID='$scopeId' AND studentanswers.LetterAnswer = question.CorrectAnswer AND categories.Category = '$category' and exam.Date = '$examDate'
								GROUP BY student.StudentID
								ORDER BY categoryPoints ASC;" ;

										$GLOBALS['categoryResult']= $conn->query($sqlEanswer) or die('Error showing matched category one'.$conn->error);
							}

										while ( $row = mysqli_fetch_array ($categoryResult) ) {
											$studentId= $row["StudentID"];
											$studentPoints= $row["categoryPoints"];

										if($category == 1){
										$GLOBALS['ArrayCatOne'][]= array($studentPoints, $studentId);

										}

										if($category == 2){
											$GLOBALS['ArrayCatTwo'][]= array($studentPoints, $studentId);
										}


										if($category == 3){
											$GLOBALS['ArrayCatThree'][]= array($studentPoints, $studentId);
										}
									}
								}

											$resultMatchesFound= totalMatchPercentageCalc($student, $ArrayCatOne, $ArrayCatTwo, $ArrayCatThree, $catOneToCompare, $catTwoToCompare, $catThreeToCompare);

									  	$matchesFound=findMatch($resultMatchesFound, $numberOfStudents);

//Getting matched Students
foreach ($matchesFound as $match) {
			 	$showName=1;
				if($match !=null){
			  	foreach($categories as $category) {
							if($scope == "school"){
								$sqlMatchesFound="SELECT studentanswers.QuestionID, COUNT(studentanswers.LetterAnswer) as cAnswers, question.CorrectAnswer, COUNT(question.Points) as Tpoints,
								categories.Category, student.FName, student.LName, school.SchoolID
								FROM categories
								INNER JOIN question ON question.Indicator = categories.Indicator
								INNER JOIN studentanswers ON  studentanswers.QuestionID= question.QuestionID
								INNER JOIN  assessment exam ON studentanswers.ExamID= exam.ExamID
								INNER JOIN book book ON exam.BookID= book.BookID
								INNER JOIN classhistory history ON history.ClassHistoryID= exam.ClassHistoryID
								INNER JOIN class ON class.classID= history.classID
								INNER JOIN  student ON student.StudentID= history.StudentID
								INNER JOIN teacher ON teacher.TeacherID = class.TeacherID
								INNER JOIN useraccount ON useraccount.UserID = teacher.UserID
								INNER JOIN school ON school.SchoolID = useraccount.SchoolID
								WHERE student.StudentID='$match' AND exam.BookID=(SELECT BookID FROM assessment
								WHERE ExamID= '$examId') AND school.SchoolID='$scopeId' AND studentanswers.LetterAnswer = question.CorrectAnswer AND categories.Category = '$category';" ;

									$GLOBALS['matchResult'] = $conn->query($sqlMatchesFound) or die('Error showing matches results'.$conn->error);
					   }
					if($scope == "class"){
					$sqlMatchesFound="SELECT studentanswers.QuestionID, COUNT(studentanswers.LetterAnswer) as cAnswers, question.CorrectAnswer, COUNT(question.Points) as Tpoints,
					categories.Category, student.FName, student.LName
					FROM categories
					INNER JOIN question ON question.Indicator = categories.Indicator
					INNER JOIN studentanswers ON  studentanswers.QuestionID= question.QuestionID
					INNER JOIN  assessment exam ON studentanswers.ExamID= exam.ExamID
					INNER JOIN book book ON exam.BookID= book.BookID
					INNER JOIN classhistory history ON history.ClassHistoryID= exam.ClassHistoryID
					INNER JOIN class ON class.classID= history.classID
					INNER JOIN  student ON student.StudentID= history.StudentID
					WHERE student.StudentID='$match' AND exam.BookID=(SELECT BookID FROM assessment
					WHERE ExamID= '$examId') AND class.classID='$scopeId' AND studentanswers.LetterAnswer = question.CorrectAnswer AND categories.Category = '$category';" ;

						$GLOBALS['matchResult'] = $conn->query($sqlMatchesFound) or die('Error showing matches results'.$conn->error);
					}
						while ( $row = mysqli_fetch_array ($matchResult) ) {
							$GLOBALS['Questions']=0;
							$correctAns = $row["cAnswers"];
							$totalPoints= $row["Tpoints"];
							$FName= $row["FName"];
							$LName= $row["LName"];
//Calculating values according to criteria selected
							if($category == 1){
								$Questions = $numQuestionsOne;
							}
							if($category == 2){
							$Questions = $numQuestionsTwo;
							}
							if($category == 3){
							$Questions = $numQuestionsThree;
							}

             $GLOBALS["pStudentMatched"];
					  	if($matchCriteria == "finalScore"){
							$pStudentMatched= $totalPoints;
							$pStudentMatched .= "/";
							$pStudentMatched .= $Questions;
							$pStudentMatched .= " Points";
						}

						if($matchCriteria == "percentage"){
							$pStudentMatched= round(($totalPoints / $Questions)*100);
							$pStudentMatched .= "%";
						}


						$categoryNumber= "Category ";
						$categoryNumber .= $category;

						if($showName == 1){
							?>
							<tr>
								<th><h3><input style="border:none" name="Name" type="text"   value="<?= $FName ?> <?= $LName ?>" size="25" readonly></h3></th>
							</tr>
							<?php
							$showName =0;
						}
						?>
						<td><input style="border:none" type="text"   value="<?= $categoryNumber.': '.$pStudentMatched?>" size="19" readonly></td>
					</tr>
					<?php
			   }
			  }
			 }
			}

	?>

	</table>
	</div>
	<?php

//This function will go through match percentage values and find the best match id
	function findMatch($matchingArray, $numStudents){
	$matchListFound = array();
	$matchListFound[]="string";											// added a string value, so the array won't be empty when comparing the first value
	$GLOBALS['$myMatch']=array();										// this array will be returned with students id that are the best matches
		$numToCompare=0;

  sort($matchingArray);

	for($i=0; $i<$numStudents; $i++){								// will look for number of students indicated by user in selection option
			$closest = null;
		$GLOBALS['oneMatchFound'] = 0;
		foreach ($matchingArray as $value) {
			$item= $value[0];															//match percentage value
			$id= $value[1];																// student id
			$equal= 1;

			$arrLength= count($matchListFound);
			 for($x=0; $x <$arrLength; $x++) {
				 $val= $matchListFound[$x];
			 if($id == $val || $id == $idToCompare){			//checking if id is not in the matches alredy found or if is not equal to student being compared
				 $equal = 0;
			 }
		 }
		 // finding the match percentage closest to zero, which is the best match
			 if ($closest === null && $equal === 1|| abs($numToCompare - $closest) > abs($item - $numToCompare) && $equal === 1) {
					$closest = $item;
					$oneMatchFound= $id;
					if($matchListFound[0] == "string"){
					$matchListFound[0]=$id;							//replacing "string" from matchListFound array with the first best match id found
				}
				else{
					$matchListFound[]=$id;							//adding best match id if more than one
				}
				}
	     }
   $myMatch[]=$oneMatchFound;									//adding best match id to the array that will be returned
	}
	return $myMatch;
}



	function matchPercentageCalc($categoryArray, $numToCompare, $idToCompare){
		$closest = null;
		$match = null;
		$zero= 0;
    $GLOBALS['percentageArray']=array();				//contains match percentages and id for each student

		foreach ($categoryArray as $value) {
			$item= $value[0];
			$id= $value[1];

			if($id != $idToCompare){
				 if($numToCompare == 0){
					 $compareNumber = 1;
					 //$item += 1;
					 $matchPercentage=abs($item/$compareNumber);	      //calc match percentage
					 $percentageArray[]= array($matchPercentage, $id);
				 }
				 else{
				 $matchPercentage=abs(abs($item/$numToCompare)-1);	      //calc match percentage
		 	   $percentageArray[]= array($matchPercentage, $id);   //push into array
	  	}
		 }
		}
		return $percentageArray;
	}

	//This function will calculate the match percentage (StudentTotalPoints/ StudentTotalPointsToCompare)
	//It will also add all match percentages by category if category was selected by user.
	function totalMatchPercentageCalc($idToCompare, $catOne, $catTwo, $catThree, $numToCompareOne, $numToCompareTwo,$numToCompareThree){
		$closest = null;
		$match = null;
		$zero= 0;

	$FpercentageArray=array();						//percentage array for category One
	$SpercentageArray=array();						//percentage array for category Two
	$TpercentageArray=array();						//percentage array for category Three

// CATEGORY I --------------------------------------------
if($numToCompareOne != null){						//Do, if category One was selected by user
	foreach ($catOne as $value) {
		$item= $value[0];
		$id= $value[1];
		$add =0;

			if($id != $idToCompare){					//checking if student in the array is different to student being compared
				 if($numToCompareOne == 0){			// if the value to compare is zero, add one. (ie. 3/0 = Error) instead do (3\1)
					 $compareOne = 1;
					 //$item += 1;
					 $matchPercentage=abs($item/$compareOne);     //calculate match percentage
			   }
				 else{
				 $matchPercentage=abs(abs($item/$numToCompareOne)-1);    //calculate match percentage
			 }
			 	 $FpercentageArray[]=array($matchPercentage, $id);			// add match percentage to percentageArray for Category one
   	}
	}
}


		// CATEGORY II ---------------------------------------------
		if($numToCompareTwo != null && $numToCompareOne != null){				//if Category one and two were selected by user
		foreach ($catTwo as $value) {
			$item= $value[0];
			$id= $value[1];

			if($id != $idToCompare){
				 if($numToCompareTwo == 0){
					 $compareTwo = 1;
					// $item += 1;
					 $matchPercentage=abs($item/$compareTwo);	      //calc match percentage
				 }
				 else{
				 $matchPercentage=abs(abs($item/$numToCompareTwo)-1);	      //calc match percentage
			}
			foreach ($FpercentageArray as $val) {													//add $FpercentageArray values and $SpercentageArray
				$addVal =$val[1];
				if($addVal == $id){
				$value= $val[0];
				$total = $value + $matchPercentage;
		  	$SpercentageArray[]= array($total, $id);
			}
		 }
		}
	}
}

//if Category one was selected but not category two, copy percentage Array for category one into percentage array for category two
elseif($numToCompareOne != null && $numToCompareTwo ==null){
	foreach ($FpercentageArray as $val) {
		$value= $val[0];
		$id =$val[1];
		$SpercentageArray[]= array($value, $id);
	}
}
//if Category two was selected but not category one,
//calculate match percentage for category two array using percentage calculation function
elseif($numToCompareOne == null && $numToCompareTwo !=null){
		$SpercentageArray= matchPercentageCalc($catTwo, $numToCompareTwo, $idToCompare);
}


	// CATEGORY III ---------------------------------------------------
//if Category one and two were not selected
//calculate match percentage for category three array using percentage calculation function
	if($numToCompareOne == null && $numToCompareTwo== null){
	$TpercentageArray= matchPercentageCalc($catThree, $numToCompareThree, $idToCompare);
}

//if Category three, copy percentage Array for category two into percentage array for category three
elseif($numToCompareThree == null){
	foreach ($SpercentageArray as $val) {
		$value= $val[0];
		$id =$val[1];

		$TpercentageArray[]= array($value, $id);
	}
}

//if category three was selected
	else{
	foreach ($catThree as $value) {
		$item= $value[0];
		$id= $value[1];

		if($id != $idToCompare){
			 if($numToCompareThree == 0){
				 $compareThree = 1;
				// $item += 1;
				 $matchPercentage=abs($item/$compareThree);	      //calc match percentage
			 }
			 else{
			 $matchPercentage=abs(abs($item/$numToCompareThree)-1);	      //calc match percentage
		}
		foreach ($SpercentageArray as $val) {													//add $SpercentageArray values and $TpercentageArray
			$addVal =$val[1];
			if($addVal == $id){
			$value= $val[0];
			$total = $value + $matchPercentage;
			$TpercentageArray[]= array($total, $id);
		}
	 }
	}
 }
}
		return $TpercentageArray;
	}
		 ?>
<?php include './navigation/navEnd.html'; ?>

</body>
</html>
