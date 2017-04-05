<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link type="text/css" rel="stylesheet"  href="StudentHomePage.css">
    <link href='http://fonts.googleapis.com/css?family=Inknut+Antiqua:400,600,500' rel='stylesheet' type='text/css'>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="AdminPage.js"></script>

    <style type="text/css">
        body
        {

            background-size: cover;
            padding: 0;
            margin: 0;
            background-color:white;


            opacity: 1.0;
        }
        h3
        {
            color: black;
            font-size: medium;

        }
        .navbar-default{
            background-color: seagreen;
        }
    </style>
    <title></title>
</head>
<body>
<?php
session_start();

if(!isset($_SESSION['username'])){
    header('Location: login.html');
}

?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" color="#B2EBF2">
    <div class="container-fluid">

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <h4 align="center" style="color: white"> <b>Feedback System</b>
                <p align="right" style="color: white"> <b>Welcome <?php echo $_SESSION['FirstName']; ?> (  <?php echo $_SESSION['typeOfUser']; ?> )</b></p>
            </h4>
        </div>
    </div>

</nav>
<div class="container">
    <div class="row vertical-offset-100">
        <div id="wrapper">
            <div class="overlay"></div>

            <!-- Sidebar -->
            <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
                <ul class="nav sidebar-nav">
                    <li class="sidebar-brand">
                        <a href="#">
                            StudentHome Page
                        </a>
                    </li>
                    <!--<li>
                        <a href="Calendar.html">Calendar</a>
                    </li>
                    <li>
                        <a href="listOfPresentations.html">List of Presentations</a>
                    </li> -->
                    <li>
                        <a href="profile.php">Profile</a>
                    </li>
                   <!-- <li>
                        <a href="history.html">History</a>
                    </li>-->
                    <li>
                        <a href="Feedback.php">Feedback</a>
                    </li>
                    <li>
                        <a href="viewFeedback.php">View Feedback </a>
                    </li>
                    <li>
                        <a href="logout.php">Log out</a>
                    </li>
                </ul>
            </nav>
            <!-- /#sidebar-wrapper -->

            <!-- Page Content -->

        </div>
        <!-- /#page-content-wrapper -->
    </div>
</div>
</body>
</html>