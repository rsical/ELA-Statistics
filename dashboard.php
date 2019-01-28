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

<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>ELA Stats</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
        crossorigin="anonymous">

    <link rel="stylesheet" href="../css/dashboardStyle.css">
    <script src="../js/sidebar.js"></script>

</head>

<body>

    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <a class="sidebar-toggle text-light mr-3">
            <i class="fa fa-bars fa-fw"></i>
        </a>

        <a class="navbar-brand" href="#">
            </i>ELA Statistics Analyzer</a>

        <div class="navbar-collapse collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown">
                        <i class="fa fa-user-circle fa-fw"></i>Account
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ChangePass">
                            <i class="fa fa-lock fa-fw"></i>Change Password</a>
                        <a class="dropdown-item" href="logout.php">
                            <i class="fa fa-sign-out-alt fa-fw"></i>Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

		<div class="modal fade" id="ChangePass" role="dialog">
	 	<div class="modal-dialog">
	 		<div class="modal-content">
	 			<div class="modal-header">
	 				<button type="button" class="close" data-dismiss="modal">&times;</button>
	 			</div>
	 			<div class="modal-body">
	 				<?php include 'ChangePassword.php';?>
	 			</div>
	 		</div>
	 	</div>
	 	</div>


    <div class="d-flex align-items-stretch">
        <div class="sidebar bg-dark">
            <ul class="list-unstyled">
                <li>
                    <a href="#">
                        <i class="fa fa-home fa-fw"></i>Profiles</a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-file-alt fa-fw"></i>Exams</a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-chart-line fa-fw"></i>Student Statistics</a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-chart-area fa-fw"></i>Graphs</a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-users fa-fw"></i>Groups</a>
                </li>

                <li>
                    <a href="#" data-toggle="modal" data-target="#AddStudent">
                        <i class="fa fa-plus fa-fw"></i>Add Student</a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-plus fa-fw"></i>Add Results</a>
                </li>

                <li>
                    <a href="#adminMenu" data-toggle="collapse">
                        <i class="fa fa-user-cog fa-fw"></i>
                        <u>Admin</u>
                    </a>
                    <ul id="adminMenu" class="list-unstyled collapse">
                        <li>
                            <a href="#">
                                <i class="fa fa-edit fa-fw"></i>Exams &amp; Answer Keys</a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-edit fa-fw"></i>Teachers &amp; Classes</a>
                        </li>

                    </ul>
                </li>

            </ul>
        </div>

        <div class="content p-4">

            <h1 class="display-5 mb-4">Welcome!</h1>

            <p>PAGE CONTENT HERE</p>


        </div>
    </div>

		<div class="modal fade" id="AddStudent" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<?php include 'AddStudent.php';?>
				</div>
			</div>
		</div>
		</div>

</body>

</html>
