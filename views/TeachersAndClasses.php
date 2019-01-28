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
  include ("dbConnection.php");
?>
<html lang="en">
  <head>
		<title>Teachers And Classes</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>

<body>
	<center><h2>Teachers & Clases</h2></center>
	

	<button type="button" data-toggle="modal" data-target="#createTeacher">Create Teacher</button>

	<?php
		$sqlTeachers= ("SELECT user.UserID, user.FName, user.LName, class.ClassYear, class.Grade, teachers.TeacherID
			FROM useraccount user
			INNER JOIN teacher teachers ON user.UserID= teachers.UserID
			INNER JOIN class ON teachers.teacherID= class.teacherID;");

	$result = $conn->query($sqlTeachers) or die('Could not run query: '.$conn->error);
	if ($result->num_rows > 0) {

		echo'<table width="50%" align="center">';
		echo'<tr>
			 <th>Current Teachers</th>
			 <th></th>
			 <th>Classroom</th>
			 <th>Year</th>
			 <th></th>
			 <th></th>
			 </tr>';

			 while($row = $result->fetch_assoc()){
				 echo'<form action="DeleteTeacher.php" method="POST">';
				 $UserId = $row["UserID"];
				 $TeacherId = $row["TeacherID"];
				 $FName = $row["FName"];
				 $LName = $row["LName"];
				 $classYear = $row["ClassYear"];
				 $grade = $row["Grade"];

				 echo '
				 <tr>
				 <td><input name="Name" type="text"   value="'.$FName.'  '.$LName.'" size="20"></td>
					<td><button  class="btn btn-default btn-sm" type="submit"  name="Delete" value=""><span class="glyphicon glyphicon-trash"></span> Delete</button></td>
					<td><input name="grade" type="text"   value="'.$grade.'" size="12"></td>
					<td><input name ="classYear" type="text" value="'.$classYear.'" size="12"></td>
					<td><button  class="btn btn-default btn-sm" type="submit"  name="UpadateClass" value=""><span class="glyphicon glyphicon-pencil"></span> Update Class</button></td>
					<td><input name="id" type="hidden" value="'.$UserId.'"  ></td>
					<td><input name="teacherId" type="hidden" value="'.$TeacherId.'"  ></td>
				</tr>';
				echo "</form>";
		}
		echo"</table>";
		}
		else {
			echo "0 results";
		}
		 ?>

		 <div class="modal fade" id="createTeacher" role="dialog">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Crate Teacher</h4>
	        </div>
	        <div class="modal-body">
	          <?php include 'AddTeacher.php';?>
	        </div>
	      </div>
	    </div>
	    </div>


</body>
</html>
