
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

//DEPENDENT DROPDOWN FOR STUDENT STATISTICS

if(isset($_POST['ExamID'])){
  $exam_id = $conn->real_escape_string($_POST['ExamID']);

  if (isset($_SESSION['isTeacher'])) {
      if ($_SESSION['isTeacher']) {
     $sqlgrade="SELECT  class.Grade, assessment.ExamID, class.ClassID, useraccount.UserID
          FROM useraccount
          INNER JOIN teacher ON useraccount.UserID= teacher.UserID
          INNER JOIN class ON class.TeacherID = teacher.TeacherID
          INNER JOIN classhistory history ON class.ClassYear=history.ClassYear
          INNER JOIN assessment assessment ON assessment.ClassHistoryID= history.ClassHistoryID
          WHERE assessment.ExamID= '$exam_id' AND useraccount.UserID= '$currUserID'
          Group by class.ClassID;";
          $GLOBALS['myCresult']= $conn->query($sqlgrade) or die('Error showing grades'.$conn->error);
        }
      }

      if (isset($_SESSION['isAdmin'])) {
        if ($_SESSION['isAdmin']) {
          $sqlgrade="SELECT  class.Grade, assessment.ExamID, class.ClassID
          FROM class class
          INNER JOIN classhistory history ON class.ClassYear=history.ClassYear
          INNER JOIN assessment assessment ON assessment.ClassHistoryID= history.ClassHistoryID
          WHERE assessment.ExamID='$exam_id'
          Group by class.ClassID;";
          $GLOBALS['myCresult'] = $conn->query($sqlgrade) or die('Error showing grades'.$conn->error);
        }
      }

      echo '<option value=""> Select Grade</option>';
      while ( $row = mysqli_fetch_array ($myCresult) ) {
          echo '<option value="'.$row["ClassID"].'|'.$row["Grade"].'">'.$row["ClassID"].'</option>';
      }
}



if(isset($_POST['Grade'])){
  $grade =$_POST['Grade'];
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

if(isset($_POST['scope'])){
$scope = $_POST['scope'];
$myresult= explode('|', $scope);

$classId=$myresult[0];
$grade=$myresult[1];


if($scope == "school"){
  echo '<option value='.$school.'>Select Students</option>';
  echo '<option value='.$school.'>ALL</option>';
}
  else{
    $sqlstudent="SELECT class.ClassID, student.StudentID, student.FName, student.LName, assessment.Date, assessment.ExamID, assessment.BookID,
    book.BookID
    FROM class class
    INNER JOIN classhistory history ON class.ClassYear = history.ClassYear
    INNER JOIN student student ON student.StudentID= history.StudentID
    INNER JOIN assessment assessment ON assessment.ClassHistoryID= history.ClassHistoryID
    INNER JOIN book book ON assessment.BookID = book.BookID
    WHERE class.ClassID= '$classId'
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
