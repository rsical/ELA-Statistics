
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

include ("./db/connection/dbConnection.php");



if(isset($_POST['selectExamYear'])){
  $grade =$_POST['selectExamYear'];
  if (isset($_SESSION['isAdmin'])) {
      if ($_SESSION['isAdmin']) {
  $school = "school";
        echo '<option value=""> Select Scope</option>';
        echo '<option value='.$school.'>School</option>';
        echo '<option value='.$grade.'>Class</option>';
}
}
if (isset($_SESSION['isTeacher'])) {
    if ($_SESSION['isTeacher']) {
        echo '<option value=""> Select Scope</option>';
        echo '<option value='.$grade.'>Class</option>';
  }
 }
}


if(isset($_POST['examScope'])){
$scope = $_POST['examScope'];

if($scope == "school"){
  echo '<option value='.$school.'>Select Students</option>';
  echo '<option value='.$school.'>ALL</option>';
}
  else{
    $sqlstudent="SELECT class.ClassID, student.StudentID, student.FName, student.LName, assessment.Date, assessment.ExamID, assessment.BookID,
    book.BookID, useraccount.UserID
    FROM useraccount
    INNER JOIN teacher teacher ON teacher.UserID= useraccount.UserID
    INNER JOIN class class ON class.TeacherID = class.TeacherID
    INNER JOIN classhistory history ON class.ClassYear = history.ClassYear
    INNER JOIN student student ON student.StudentID= history.StudentID
    INNER JOIN assessment assessment ON assessment.ClassHistoryID= history.ClassHistoryID
    INNER JOIN book book ON assessment.BookID = book.BookID
    WHERE assessment.BookID=(SELECT BookID FROM assessment
						WHERE ExamID= '$scope')
    Group by student.StudentID;";

    $result = $conn->query($sqlstudent) or die('Error showing students'.$conn->error);
    echo '<option value=""> Select Student</option>';
    while ( $row = mysqli_fetch_array ($result) ) {
      $studentName= $row["FName"]." ".$row["LName"];
      echo '<option value="'.$row["StudentID"].'">'.$studentName.'</option>';
    }
}
}


?>
