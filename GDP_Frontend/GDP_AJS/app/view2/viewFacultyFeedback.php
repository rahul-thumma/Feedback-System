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
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-touch.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-animate.js"></script>
    <script src="AdminPage.js"></script>
    <script src="Chart.js"></script>
    <script src="angular-chart.js"></script>
    <link href="angular-chart.css" rel="stylesheet"/>
    <script src="viewFacultyFeedback.js"></script>


    <link href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/css/select2.min.css" rel="stylesheet" />
    <script src="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/js/select2.min.js"></script>
    <style type="text/css">
        h1{
            left: 0;
            line-height: 200px;
            margin: auto;
            margin-top: -100px;
            position: absolute;
            top: 50%;
            width: 100%;
            color: #ff0000;
        }
        h3{
            color: #000000;
        }
        .navbar-default{
            background-color: seagreen;
        }
    </style>
    <title></title>
</head>
<body ng-app="myApp" ng-controller="ViewFeedbackController">
<?php
session_start();

if(!isset($_SESSION['username'])){
    header('Location: login.html');
}

?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" color="#B2EBF2">
    <h4 align="center" style="color: white"> <b>Feedback System</b>
        <p align="right" style="color: white"> <b>Welcome <?php echo $_SESSION['FirstName']; ?> (  <?php echo $_SESSION['typeOfUser']; ?> )</b></p>
    </h4>
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

            <!-- Page Content -->
            <div class="container">
                <h2 style="margin-top: 3.5em">Student Feedback</h2>
                <p id="userID" hidden>
                    <?php echo $_SESSION['username']; ?>
                </p>
                </center>
                <br>
                <div style="margin-right: 15em">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Presenter ID</th>
                            <th>Course ID</th>
                            <th>Topic Name</th>
                            <th>Feedback</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="success" ng-repeat="feedback in feedbacks" >
                            <td>{{feedback.PresentationName}}</td>
                            <td>{{feedback.CourseID}}</td>
                            <td>{{feedback.TopicName}}</td>
                            <td><a ng-click="showFeedback(feedback.TopicName,feedback.CourseID,feedback.PresentationName)" >View Feedback</a></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="details" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">View Feedback</h4>
                            </div>
                            <br>
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#home">Ratings</a></li>
                                <li><a data-toggle="tab" href="#menu1">Comments</a></li>

                            </ul>

                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active">
                                    <form class="form-horizontal" role="form" name="updatePasswordForm">
                                        <br>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Select the questions</label>
                                        </div>

                                        <div class="form-group" style="margin-left: 2em;">
                                            <select id="questions"
                                                    ng-model="selectedQuestionModel"
                                                    class="col-md-4 js-example-basic-multiple"
                                                    style="width: 35em;"
                                                    ng-change="updateQuestion()"
                                            >
                                                <option ng-repeat="a in questions" value="{{a.Question}}" > {{a.Question}}</option>

                                            </select>
                                        </div>

                                        <div id ="singleword">
                                        <canvas id="doughnut" class="chart chart-doughnut" ng-init="pieFlag = false" ng-show="pieFlag"
                                                chart-data="data" chart-labels="labels">
                                        </canvas>
                                        </div>

                                        <div id ="rating">
                                        <canvas id="bar" class="chart chart-bar" style="margin-left: 0.5em;" ng-init="barFlag = false" ng-show="barFlag"
                                                chart-data="data" chart-labels="labels"> chart-series="series"
                                        </canvas>
                                            </div>

                                            <div id ="legend">
                                            <canvas id="doughnut1" class="chart chart-doughnut" chart-legend=true ng-init="dummyFlag = false" ng-show="dummyFlag"
                                                    chart-labels="labels1" chart-data="data1">
                                            </canvas>
                                                </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                                        </div>
                                    </form>
                                </div>
                                <div id="menu1" class="tab-pane fade">

                                    <div class="table-responsive">
                                        <table class="table" >

                                            <thead> <tr> <th> Comments </th></tr> </thead>

                                            <tbody>
                                            <tr ng-repeat="comment in commentsData">

                                                <td> {{comment}} </td>

                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>



            </div>

        </div>
        <!-- /#page-content-wrapper -->
    </div>
</div>
<script>

    $(".js-example-basic-multiple").select2(
        {
            allowClear: true});

</script>
</body>
</html>