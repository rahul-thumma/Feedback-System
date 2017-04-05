<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet"  href="StudentHomePage.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link href='http://fonts.googleapis.com/css?family=Inknut+Antiqua:400,600,500' rel='stylesheet' type='text/css'>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

    <script src="jquery.datetimepicker.full.js"></script>
    <script src="ListofPresentations.js"></script>

    <!--<link rel="stylesheet" type="text/css" href="jquery.datetimepicker.css"/>
    <link rel="stylesheet/less" type="text/css" href="timepicker.less.css">-->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />

    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
    <script>

        $(document).ready(function() {

            $('#datePicker')
                .datepicker({
                    format: 'yyyy/mm/dd'
                });
        });
    </script>
    <style type="text/css">


        #addFeedback .modal-dialog  {width:60%;}
        h1{
            left: 0;
            line-height: 200px;
            margin: auto;
            margin-top: -100px;
            position: absolute;
            top: 50%;
            width: 100%;
            color: red;
        }
        h3{
            color: black;
        }
        .navbar-default{
            background-color: seagreen;
        }
    </style>
    <title></title>
</head>

<body ng-app="myApp" ng-controller = "FeedbackController">
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
            </li>-->
            <li>
                <a href="profile.php">Profile</a>
            </li>
            <!--<li>
                <a href="history.html">History</a>
            </li>-->
            <li>
                <a href="Feedback.php">Feedback</a>
            </li>
            <li>
                <a href="viewFeedback.php">View Feedback</a>
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
<br>
<br>
<br>
<br><br>
<div style="margin-left: 17em">
    <div>
        <p id="userID" hidden>
            <?php echo $_SESSION['username']; ?>
        </p>
    </div>
    <div class="container">
        <!--<form>
            <label for="predicate">selected predicate:</label>
            <select class="form-control" id="predicate" ng-model="selectedPredicate" ng-options="predicate for predicate in predicates"></select>
        </form>-->

        <div>
            <table>
                <tr>

                    <th>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                    </th>
                    <th  style="font-size: 1.2em">
                        Search for presentation: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </th>
                    <th>
                        <!-- <div class="input-group input-append date" id="datePicker">
                             <input type="text" class="form-control" name="date" ng-model="searchbyDate" />
                             <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                         </div>-->
                        <!--<input st-search="Course" placeholder="search for Course" class="input-sm form-control" type="search"/>-->

                    </th>
                    <th  style="font-size: 1.2em">
                        <!--<input st-search="Course" placeholder="search for Course" class="input-sm form-control" type="search"/>-->
                        <!--<input id="datetimepicker" type="text" name="presentationTime" ng-model="searchbyDate"/>-->
                        <input type="text"  class="input-sm form-control" placeholder="search" ng-model="searchtext"/>
                    </th>
                </tr>
            </table>


        </div>
        <br><br>
        <table st-table="rowCollection" class="table table-striped">
            <thead>
            <tr>
                <th st-sort="Course" style="font-size: 1.2em">Course</th>
                <th st-sort="Presenter" style="font-size: 1.2em">Presenter</th>
                <th st-sort="Topic" style="font-size: 1.2em">Topic</th>
                <th st-sort="PresentationType" style="font-size: 1.2em">Presentation Type</th>
                <th st-sort="PresentationTime" st-sort-ascent="true" style="font-size: 1.2em">Presentation Time</th>

            </tr>

            </thead>
            <tbody>
            <tr ng-repeat="row in rowCollection | filter:searchtext">
                <td>{{row.course}}-{{row.sectionNum}}</td>
                <td>{{row.presenter}}
                    <span hidden>{{listofGroupPresenters}}</span></td>
                <td>{{row.topic}}</td>
                <td>{{row.pType}}</td>
                <td>{{row.pTime}}</td>
                <td>
                    <button type="button" data-toggle="modal" data-target="#addFeedback" ng-click="getFeedbackQuestions(row.assignmentId)">
                        &nbsp;&nbsp;submit Feedback
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="modal fade" id="addFeedback" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Submit Feedback</h4>
                    </div>

                    <form class="form-horizontal" name="addFeedbackForm">

                        <div style="margin-left: 1.2em; margin-right: 1.2em">
                            <div class="inner" id="questionsArea">



                            </div>
                        </div>

                        <div style="margin-left: 2em"><b>Your comments:</b><br>
                            <textarea ng-model="txtcomment" id="comments" rows ="6" placeholder="Your Comments(upto 100 characters)" style='width:660px;margin-left: 2em'></textarea><br>
                            <button class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#feedback" id="submitFeedback" ng-click="submitFeedback()"> Submit </button>
                        </div>
                        <br>
                        <div class="modal-footer">

                            <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div id="feedback" class="modal fade" role="dialog">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="titleArea"> Feedback submitted </h4>

                    </div>

                    <div class="modal-body" id="messageArea">

                        You have Successfully submitted your feedback

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>


                </div>

            </div>



        </div>

    </div>
</div></body>
</html>