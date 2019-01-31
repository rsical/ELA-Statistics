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
		<title>Teachers And Classes</title>
		<?php include './includedFrameworks/bootstrapHead.html';?>



  </head>

<body>

<?php include './navigation/navBegin.html'; ?>

<div style="padding-top: 15px" class="container">

	<div class="row">
		<h2 >Teachers &amp; Classes</h2>
	</div>
	
	<div class="row form-group">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#createTeacher"><span class="fa fa-plus"></span> Create Teacher</button>
	</div>

	<?php
		$sqlTeachers= ("SELECT user.UserID, user.FName, user.LName, class.ClassYear, class.Grade, teachers.TeacherID
			FROM useraccount user
			INNER JOIN teacher teachers ON user.UserID= teachers.UserID
			INNER JOIN class ON teachers.teacherID= class.teacherID;");

	$result = $conn->query($sqlTeachers) or die('Could not run query: '.$conn->error);
	if ($result->num_rows > 0) { ?>

			<div class="row">
			<table class="table">
			<tr>
			 <th  style="">Current Teachers</th>
			 <th></th>
			 <th style="">Classroom</th>
			 <th style="">Year</th>
			 <th></th>
			 <th></th>
			 </tr>

			<?php
			 while($row = $result->fetch_assoc()){
				 echo'<form action="DeleteTeacher.php" method="POST">';
				 $UserId = $row["UserID"];
				 $TeacherId = $row["TeacherID"];
				 $FName = $row["FName"];
				 $LName = $row["LName"];
				 $classYear = $row["ClassYear"];
				 $grade = $row["Grade"];
				 ?>

				 
				 <tr>
				 <td><input class="form-control" name="Name" type="text"   value="<?= $FName ?> <?= $LName ?>"></td>

					<td><button  class="btn btn-danger" type="submit"  name="Delete" value=""><span class="fa fa-trash-alt"></span> Delete</button></td>

					<td><input class="form-control" name="grade" type="text"   value="<?= $grade ?>" size="12"></td>

					<td><input class="form-control"name ="classYear" type="text" value="<?= $classYear ?>" size="12"></td>

					<td><button  class="btn btn-info" type="submit"  name="UpdateClass" value=""><span class="fa fa-edit"></span> Update Class</button></td>

					<td><input name="id" type="hidden" value="<?= $UserId ?>"  ></td>

					<td><input name="teacherId" type="hidden" value="<?= $TeacherId ?>"  ></td>
				</tr>
				</form>
		<?php } ?> 
		</table>
			 </div>
		<?php } 
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
			
</div>

<?php include './navigation/navEnd.html'; ?>



</body>
</html>
