
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
$GLOBALS['exam']= $_POST['selectExamYear'];
$date = $row["Date"];
$year = intval($date);
  if (isset($_SESSION['isAdmin'])) {
      if ($_SESSION['isAdmin']) {
  $school = "school";
        echo '<option value=""> Select Scope</option>';
        echo '<option value='.$school.'>School</option>';
        echo '<option value='.$exam.'>Class</option>';
}
}
if (isset($_SESSION['isTeacher'])) {
    if ($_SESSION['isTeacher']) {
        echo '<option value=""> Select Scope</option>';
        echo '<option value='.$exam.'>Class</option>';
  }
 }
}


if(isset($_POST['examScope'])){
$GLOBALS['scope']= $_POST['examScope'];
//$scope = $_POST['examScope'];

if($scope == "school"){
  echo '<option value='.$school.'>Select School</option>';
  $schools="SELECT School_Name
  FROM School;";

  $result = $conn->query($schools) or die('Error showing students'.$conn->error);
    while ( $row = mysqli_fetch_array ($result) ) {
	  echo '<option value="'.$row["SchoolID"].'">'.$row["School_Name"].'</option>';
    }

}

else {
	echo '<option value='.$school.'>Select Class</option>';
  $classes="select distinct Class.ClassID from Class, Assessment where Class.Size=Assessment.ClassSize and Class.ClassYear=(SELECT distinct year(date) FROM Assessment
						WHERE Assessment.BookID=(SELECT BookID FROM Assessment
						WHERE ExamID= '$scope')) order by Class.ClassID;";

  $result = $conn->query($classes) or die('Error showing students'.$conn->error);
    while ( $row = mysqli_fetch_array ($result) ) {
	  echo '<option value="'.$row["ClassID"].'">'.$row["ClassID"].'</option>';
    }
}
}



if(isset($_POST['examClass'])){
$GLOBALS['class']=$_POST['examClass'];

//$year = substr("'.$class.'", -4, 4);
//$school = substr("'.$class.'", 0, -4);

/*
$sqlstudent="select Student.StudentID, Student.FName, Student.LName from Student, ClassHistory where Student.StudentID=ClassHistory.StudentID and ClassHistory.ClassID='$class' order by Student.FName;";

    $result = $conn->query($sqlstudent) or die('Error showing students'.$conn->error);
    echo '<option value=""> Select Student</option>';
    while ( $row = mysqli_fetch_array ($result) ) {
      $studentName= $row["FName"]." ".$row["LName"];
      echo '<option value="'.$row["StudentID"].'">'.$studentName.'</option>';
    }
*/

$school="SELECT Student.FName, Student.LName, Student.StudentID
    FROM Student, School, Teacher, ClassHistory, Class
    WHERE School.SchoolID=Teacher.SchoolID and Teacher.TeacherID=Class.TeacherID and Class.ClassID=ClassHistory.ClassID and ClassHistory.StudentID=Student.StudentID
	and	School.School_Name='$class'
    Group by Student.FName;";

    $result = $conn->query($school) or die('Error showing students'.$conn->error);
	if($row = mysqli_fetch_array ($result)){
		echo '<option value=""> Select Student</option>';
		echo '<option value="ALL">ALL</option>';
		while($row = mysqli_fetch_array ($result)){
	  $studentName= $row["FName"]." ".$row["LName"];
		 echo '<option value="'.$row["StudentID"].'">'.$studentName.'</option>';
		}
	}
	else
	{
		$sqlstudent="select Student.StudentID, Student.FName, Student.LName from Student, ClassHistory where Student.StudentID=ClassHistory.StudentID and ClassHistory.ClassID='$class' order by Student.FName;";

		$result = $conn->query($sqlstudent) or die('Error showing students'.$conn->error);
		echo '<option value=""> Select Student</option>';
		echo '<option value="ALL">ALL</option>';
		while ( $row = mysqli_fetch_array ($result) ) {
		  $studentName= $row["FName"]." ".$row["LName"];
		  echo '<option value="'.$row["StudentID"].'">'.$studentName.'</option>';
		}
	}

}


?>
