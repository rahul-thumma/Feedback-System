<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet"  href="AdminPage.css">
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="AdminPage.js" type="application/javascript" rel="script"></script>
    <link rel="stylesheet" href="Addclass.css">
    <link rel="stylesheet/less" type="text/css" href="timepicker.less.css">
    <title>Admin Home</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>
<body>
<?php
session_start();

if(!isset($_SESSION['username'])){
    header('Location: login.html');
}
?>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <h4 align="center" style="color: white"> <b>Feedback System</b>
    <p align="right" style="color: white"> <b>Welcome <?php echo $_SESSION['FirstName']; ?> (  <?php echo $_SESSION['typeOfUser']; ?> )</b></p>
    </h4>
</nav>
<div id="wrapper">
    <div class="overlay"></div>

    <!-- Sidebar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
        <ul class="nav sidebar-nav">
            <li class="sidebar-brand">
                <a href="#">
                    AdminPage
                </a>
            </li>
            <li>
                <a href="class.php" id="link1">Manage Classes</a>
            </li>
            <?php $type =  $_SESSION['typeOfUser'];
            $type = trim($type);
            if($type == "Admin"){
                ?>
                <li>
                    <a href="manageFaculty.php" id="link2">Manage Faculty</a>
                </li>
            <?php
            }
            ?>


            <li>
                <a href="managePresentation.php" id="link3">Manage Presentation</a>
            </li>
           <!-- <li>
                <a href="moderate.html" id="link4">Moderate</a>
            </li>-->
            <li>
                <a href="viewFacultyFeedback.php">View Feedback </a>
            </li>
            <li>
                <a href="AdminProfile.php" id="link5">Profile</a>
            </li>
            <li>
                <a href="logout.php">Log out</a>
            </li>
        </ul>
    </nav>
    <!-- /#sidebar-wrapper -->


    <!-- /#page-content-wrapper -->

</div>
</body>
</html>