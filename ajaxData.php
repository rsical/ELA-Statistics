
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

  $sqlgrade="SELECT  class.Grade, assessment.ExamID, class.ClassID
   FROM class class
   INNER JOIN classhistory history ON class.ClassYear=history.ClassYear
   INNER JOIN assessment assessment ON assessment.ClassHistoryID= history.ClassHistoryID
  WHERE assessment.ExamID='$exam_id'
   Group by class.ClassID;";
  $result = $conn->query($sqlgrade) or die('Error showing grades'.$conn->error);
      echo '<option value=""> Select Grade</option>';
      while ( $row = mysqli_fetch_array ($result) ) {
          echo '<option value="'.$row["ClassID"].'|'.$row["Grade"].'">'.$row["ClassID"].'</option>';
      }
}

if(isset($_POST['Grade'])){
  $grade =$_POST['Grade'];
  $school = "school";
        echo '<option value=""> Select Scope</option>';
        echo '<option value='.$school.'>School</option>';
        echo '<option value='.$grade.'>Class</option>';

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



//DEPENDENT DROPDOWN FOR EXAM STATISTICS

if(isset($_POST['examScope'])){
$scope = $conn->real_escape_string($_POST['examScope']);


if($scope == "school"){
  echo '<option value="ALL">ALL</option>';
}
else{
    echo '<option value="ALL">Class</option>';
}
}

?>
