<!DOCTYPE html>
<html>
<head>
    <?php
    session_start();

    if(!isset($_SESSION['username'])){
        header('Location: login.html');
    }

    ?>

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
<script src="manageFaculty.js"></script>
<link rel="stylesheet" href="Addclass.css">
<link rel="stylesheet/less" type="text/css" href="timepicker.less.css">
<style type="text/css" id="less:bootstrap-timepicker-less-timepicker">

    .bootstrap-timepicker {
        position: relative;
    }
    .bootstrap-timepicker.pull-right .bootstrap-timepicker-widget.dropdown-menu {
        left: auto;
        right: 0;
    }
    .bootstrap-timepicker.pull-right .bootstrap-timepicker-widget.dropdown-menu:before {
        left: auto;
        right: 12px;
    }
    .bootstrap-timepicker.pull-right .bootstrap-timepicker-widget.dropdown-menu:after {
        left: auto;
        right: 13px;
    }
    .bootstrap-timepicker .input-group-addon {
        cursor: pointer;
    }
    .bootstrap-timepicker .input-group-addon i {
        display: inline-block;
        width: 16px;
        height: 16px;
    }
    .bootstrap-timepicker-widget.dropdown-menu {
        padding: 4px;
    }
    .bootstrap-timepicker-widget.dropdown-menu.open {
        display: inline-block;
    }
    .bootstrap-timepicker-widget.dropdown-menu:before {
        border-bottom: 7px solid rgba(0, 0, 0, 0.2);
        border-left: 7px solid transparent;
        border-right: 7px solid transparent;
        content: "";
        display: inline-block;
        position: absolute;
    }
    .bootstrap-timepicker-widget.dropdown-menu:after {
        border-bottom: 6px solid #FFFFFF;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        content: "";
        display: inline-block;
        position: absolute;
    }
    .bootstrap-timepicker-widget.timepicker-orient-left:before {
        left: 6px;
    }
    .bootstrap-timepicker-widget.timepicker-orient-left:after {
        left: 7px;
    }
    .bootstrap-timepicker-widget.timepicker-orient-right:before {
        right: 6px;
    }
    .bootstrap-timepicker-widget.timepicker-orient-right:after {
        right: 7px;
    }
    .bootstrap-timepicker-widget.timepicker-orient-top:before {
        top: -7px;
    }
    .bootstrap-timepicker-widget.timepicker-orient-top:after {
        top: -6px;
    }
    .bootstrap-timepicker-widget.timepicker-orient-bottom:before {
        bottom: -7px;
        border-bottom: 0;
        border-top: 7px solid #999;
    }
    .bootstrap-timepicker-widget.timepicker-orient-bottom:after {
        bottom: -6px;
        border-bottom: 0;
        border-top: 6px solid #ffffff;
    }
    .bootstrap-timepicker-widget a.btn,
    .bootstrap-timepicker-widget input {
        border-radius: 4px;
    }
    .bootstrap-timepicker-widget table {
        width: 100%;
        margin: 0;
    }
    .bootstrap-timepicker-widget table td {
        text-align: center;
        height: 30px;
        margin: 0;
        padding: 2px;
    }
    .bootstrap-timepicker-widget table td:not(.separator) {
        min-width: 30px;
    }
    .bootstrap-timepicker-widget table td span {
        width: 100%;
    }
    .bootstrap-timepicker-widget table td a {
        border: 1px transparent solid;
        width: 100%;
        display: inline-block;
        margin: 0;
        padding: 8px 0;
        outline: 0;
        color: #333;
    }
    .bootstrap-timepicker-widget table td a:hover {
        text-decoration: none;
        background-color: #eee;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        border-color: #ddd;
    }
    .bootstrap-timepicker-widget table td a i {
        margin-top: 2px;
        font-size: 18px;
    }
    .bootstrap-timepicker-widget table td input {
        width: 25px;
        margin: 0;
        text-align: center;
    }
    .bootstrap-timepicker-widget .modal-content {
        padding: 4px;
    }
    @media (min-width: 767px) {
        .bootstrap-timepicker-widget.modal {
            width: 200px;
            margin-left: -100px;
        }
    }
    @media (max-width: 767px) {
        .bootstrap-timepicker {
            width: 100%;
        }
        .bootstrap-timepicker .dropdown-menu {
            width: 100%;
        }
    }
</style>
    <title>Manage Faculty</title>
</head>
<body ng-app="myApp" ng-controller="facultyCtrl">

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
    <br>
    <br>
    <br>
    <br><br>
    <!-- /#sidebar-wrapper -->


    <!-- /#page-content-wrapper -->


    <!--<form class="form-horizontal" style="margin-left: 1em;"  >-->
    <div class="container">

        <div class="col-sm-10">

            <h3>Manage Faculty</h3>

            <p id="userID" hidden>
                <?php echo $_SESSION['username']; ?>
            </p>
            <br><br>

            <table class="table table-striped" ng-table="tableParams2">
                <thead><tr>
                    <th>Faculty Id</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Department</th>




                </tr></thead>
                <tbody><tr ng-repeat="user in users">
                    <td>{{user.facultyid}}</td>
                    <td>{{ user.facultyfirstName }}</td>
                    <td>{{ user.facultylastName }}</td>
                    <td>{{ user.facultydepartment }}</td>


                </tr></tbody>
            </table>

            <hr>
            <button class="btn btn-success" ng-click="editUser('new')">
                <span class="glyphicon glyphicon-user"></span> Add Faculty
            </button>
            <hr>
            <div class="collapse"  id="newclass">

                <h3 ng-show="edit">Add Faculty:</h3>
                <h3 ng-hide="edit">Edit Faculty:</h3>

                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Faculty id:</label>
                        <div class="col-sm-10">
                            <input type="text" ng-model="facultyid" id="facultyid"   placeholder="Faculty id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">First Name:</label>
                        <div class="col-sm-10">
                            <input type="text" ng-model="firstName" id="firstName"   placeholder="First Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Last Name:</label>
                        <div class="col-sm-10">
                            <input type="text" ng-model="lastName" id="lastName"   placeholder="Last Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Department:</label>
                     <!--      <div class="col-sm-10" ng-controller = "departmentCtrl">
                                <select ng-model="facultydepartment" id="facultydepartment" ng-options="item.id as item.name for item in items">
                           </div>-->

                        <div class="col-sm-10">
                        <select  ng-model="facultydepartment" id="facultydepartment">
                           <option selected="true" value="">Choose Department</option>
                            <option value="CSIS">CSIS</option>
                            <option value="Agricultural Sciences">Agricultural Sciences</option>
                            <option value="School of Business">School of Business</option>
                            <option value="Communication and Mass Media">Communication and Mass Media</option>
                            <option value="English and Modern Languages">English and Modern Languages</option>
                            <option value="Fine and Performing Arts">Fine and Performing Arts</option>
                            <option value="Humanities and Social Sciences">Humanities and Social Sciences</option>
                            <option value="Natural Sciences">Natural Sciences</option>
                            <option value="Behavioral Sciences">Behavioral Sciences</option>
                            <option value="Professional Education">Professional Education</option>
                            <option value="Health Science and Wellness">Health Science and Wellness</option>
                        </select>
                        </div>

                   <!-- <input type="text" ng-model="facultydepartment" id="facultydepartment"   placeholder="Department">-->

                    </div>



                    <div class="form-group">
                        <div class="col-sm-10">
                            <button class="btn btn-success" ng-disabled="error || incomplete"  id="id" ng-click="updateOrAdd(user.id)">
                                <!--data-toggle="modal" data-target="#myModal"-->
                                <span class="glyphicon glyphicon-success"></span> Save
                            </button>


                            <button class="btn btn-danger"  ng-click="cancelAddFaculty()">
                                <span class="glyphicon glyphicon-danger"></span> Cancel
                            </button>
                        </div>
                    </div>

                </form>

                <hr>

            </div>
        </div>

        <div id="classCreatedModal" class="modal fade" role="dialog">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="titleArea"> Faculty is added </h4>

                    </div>

                    <div class="modal-body" id="messageArea">

                        Successfully Added New Faculty.

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>


                </div>

            </div>

        </div>


        <script type="text/javascript" src="bootstrap-timepicker.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#timepicker1').timepicker();
                $('#timepicker2').timepicker();


            });
        </script>
    </div>
</div>
</body>
</html>