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
    <script src="angular-mocks.js"></script>
    <script src="xeditable.js"></script>
    <script src="xeditable.min.js"></script>
    <script src="test.js"></script>
    <link rel="stylesheet" href="Addclass.css">
    <link rel="stylesheet/less" type="text/css" href="timepicker.less.css">
    <link rel="stylesheet" type="text/css" href="xeditable.css">
    <style type="text/css" id="less:bootstrap-timepicker-less-timepicker">
        div[ng-app] { margin: 10px; }

        #Edit .modal-dialog  {width:75%;}

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
    <title>Manage Class</title>
</head>
<body ng-app="myApp" ng-controller="userCtrl">

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
            <!--<li>
                <a href="moderate.html" id="link4">Moderate</a>
            </li>-->
            <li>
                <a href="viewFacultyFeedback.php">View Feedback </a>
            </li>
            <li>
                <a href="AdminProfile.php" id="link5">Profile</a>
            </li>
            <li>
                <a href="login.html">Log out</a>
            </li>
        </ul>
    </nav>
    <br>
    <br>
    <br>
    <div class="container">

        <div class="col-sm-10">

            <h3>Set Up Class</h3>


            <table class="table table-striped" ng-table="tableParams2">
                <thead><tr>
                    <th>Course Name</th>
                    <th>Course Id</th>
                    <th>Faculty Name</th>
                    <th>Section Num</th>
                    <th>Timings</th>
                    <th>Edit</th>



                </tr></thead>
                <tbody><tr ng-repeat="user in users">
                    <td>{{user.cName}}</td>
                    <td>{{ user.fName }}</td>
                    <td>{{ user.lName }}</td>
                    <td>{{user.sec}}</td>
                    <td> {{user.startTiming}} to {{user.endTiming}} </td>
                    <td>
                        <button class="btn" ng-click="editUser(user.fName,user.sec)">
                            <span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Edit
                        </button>
                    </td>

                </tr></tbody>
            </table>

            <hr>
            <div id="createclassBtn">
                <button class="btn btn-success" ng-click="addClass()">
                    <span class="glyphicon glyphicon-user"></span> Create New Class
                </button>
            </div>
            <br>
            <div class="collapse"  id="editclass">

                <h3><span class="label label-pill label-success">Edit Class</span></h3>
                <!--  <h3 ng-hide="edit">Edit Course id:</h3>-->

                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Course Name:</label>
                        <div class="col-sm-10">
                            <input type="text" ng-model="cName" id="editcourseName"  placeholder="Course Name" disabled>
                            <label>Course Id</label>
                            <input type="text" ng-model="fName" id="editcourseid"  placeholder="Course Id" disabled>
                            <label>Section:</label>
                            <input type="text" ng-model="sec" id="editsection" placeholder="Section" disabled>

                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Faculty Name:</label>
                        <div class="col-sm-10">
                            <input type="text" ng-model="lName" id="editfacultyName"   placeholder="Faculty Name">
                        </div>
                    </div>
                    <div class="form-group">

                        <label class="col-sm-2 control-label">Start Timing:</label>
                        <div class="input-group bootstrap-timepicker timepicker col-md-5">
                            <input id="edittimepicker1" class="form-control input-small" ng-model="startTiming" type="text"><span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        </div>
                    </div>
                    <div class="form-group">

                        <label class="col-sm-2 control-label">End Timings:</label>
                        <div class="input-group bootstrap-timepicker timepicker col-md-5">
                            <input id="edittimepicker2" class="form-control input-small" ng-model="endTiming" type="text"><span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        </div>
                    </div>


                    <div id="editStudents" class="form-group">
                        <label class="col-sm-2 control-label">Students:</label>
                        <div class="col-sm-10">
                            <button type="button" class="btn btn-success btn" data-toggle="modal" data-target="#Edit" ng-click="loadStudents()">Add/Edit students</button>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-10">
                            <button class="btn btn-success" ng-disabled="error || incomplete"  id="addid" ng-click="editClass()">
                                <!--data-toggle="modal" data-target="#myModal"-->
                                <span class="glyphicon glyphicon-success"></span> Save
                            </button>

                            <button class="btn btn-danger"  ng-click="cancelAddClass()">
                                <span class="glyphicon glyphicon-danger"></span> Cancel
                            </button>
                        </div>
                    </div>

                </form>

                <hr>

            </div>
            <div class="collapse"  id="newclass">


                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Course Name:</label>
                        <div class="col-sm-10">
                            <input type="text" ng-model="cName" id="courseName"  placeholder="Course Name">
                            <label>Course Id</label>
                            <input type="text" ng-model="fName" id="courseid"  placeholder="Course Id">
                            <label>Section:</label>
                            <input type="text" ng-model="sec" id="section" placeholder="Section">

                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Faculty Name:</label>
                        <div class="col-sm-10">
                            <input type="text" ng-model="lName" id="facultyName"   placeholder="Faculty Name">
                        </div>
                    </div>
                    <div class="form-group">

                        <label class="col-sm-2 control-label">Start Timing:</label>
                        <div class="input-group bootstrap-timepicker timepicker col-md-5">
                            <input id="timepicker1" class="form-control input-small" ng-model="startTiming" type="text"><span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        </div>
                    </div>
                    <div class="form-group">

                        <label class="col-sm-2 control-label">End Timings:</label>
                        <div class="input-group bootstrap-timepicker timepicker col-md-5">
                            <input id="timepicker2" class="form-control input-small" ng-model="endTiming" type="text"><span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        </div>
                    </div>

                    <div id="addstudents" class="form-group">
                        <label class="col-sm-2 control-label">Add Students:</label>
                        <div class="col-sm-10">
                            <!--<input type="text" ng-model="addstudents"   placeholder="Add File">-->
                            <input class="btn btn-primary" ng-model="addFile" ng-disabled="error || incomplete" type="file" id="file" name="file" />

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10">
                            <button class="btn btn-success" ng-disabled="error || incomplete"  id="id" ng-click="addClassDetails()">
                                <!--data-toggle="modal" data-target="#myModal"-->
                                <span class="glyphicon glyphicon-success"></span> Save
                            </button>

                            <button class="btn btn-danger"  ng-click="cancelAddClass()">
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
                        <h4 class="modal-title" id="titleArea"> Class Created </h4>

                    </div>

                    <div class="modal-body" id="messageArea">

                        Successfully created class.

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>


                </div>

            </div>

        </div>

        <div class="modal fade" id="Edit" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Students</h4>
                    </div>


                    <form editable-form name="tableform" onaftersave="saveTable()" oncancel="cancel()">
                        <div style="margin-left:1.5em;margin-right:4em;margin-bottom: 2em; ">

                            <!-- table -->
                            <table class="table table-bordered table-hover table-condensed">
                                <tr style="font-weight: bold">
                                    <td>Student Id</td>
                                    <td>First Name</td>
                                    <td>Last Name</td>
                                    <td>Email</td>
                                    <td><span ng-show="tableform.$visible">Action</span></td>
                                </tr>
                                <tr ng-repeat="student in studentList| filter:filterStudent">
                                    <td>
                                        <!-- editable username (text with validation) -->
          <span editable-text="student.id" e-form="tableform">
            {{ student.id}}
          </span>
                                    </td>
                                    <td>
                                 <span editable-text="student.firstname" e-form="tableform">
            {{ student.firstname}}
          </span>
                                    </td>
                                    <td>
                                 <span editable-text="student.lastname" e-form="tableform">
            {{ student.lastname}}
          </span>
                                    </td>
                                    <td>
                                 <span editable-text="student.email" e-form="tableform">
            {{ student.email}}
          </span>
                                    </td>
                                    <!--<td>
                                        &lt;!&ndash; editable status (select-local) &ndash;&gt;
              <span editable-select="student.firstname" e-form="tableform" e-ng-options="s.value as s.text for s in statuses">
                {{ showStatus(student) }}
              </span>
                                    </td>
                                    <td>
                                        &lt;!&ndash; editable group (select-remote) &ndash;&gt;
              <span editable-select="student.lastname" e-form="tableform" onshow="loadGroups()" e-ng-options="g.id as g.text for g in groups">
                {{ showGroup(student) }}
              </span>
                                    </td>-->
                                    <td><button type="button" ng-show="tableform.$visible" ng-click="deleteUser(student.id)" class="btn btn-danger pull-right">Del</button></td>
                                </tr>
                            </table>
                        </div>

                        <div style="margin-bottom: 2em;margin-left: 2em;">
                            <!-- buttons -->
                            <div class="btn-edit">
                                <button type="button" class="btn btn-default" ng-show="!tableform.$visible" ng-click="tableform.$show()">
                                    edit
                                </button>
                            </div>
                            <div class="btn-form" ng-show="tableform.$visible">
                                <div style="margin-right: 3em"><button type="button" ng-disabled="tableform.$waiting" ng-click="addUser()" class="btn btn-default pull-right">add row</button></div>
                                <button type="submit" ng-disabled="tableform.$waiting" class="btn btn-primary">save</button>
                                <button type="button" ng-disabled="tableform.$waiting" ng-click="tableform.$cancel()" class="btn btn-default">cancel</button>
                            </div>
                        </div>
                    </form>

                    <!--<form class="form-horizontal" name="addAssignmentForm">
                        <br>


                        <table id="users" class="table table-bordered">
                            <thead class="mbhead">
                            <tr class="mbrow">
                                <th>Select</th>
                                <th>Student ID</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Email</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="student in studentList">
                                <td>
                                    <input type="checkbox" id="{{student.id}}"/>
                                </td>
                                <td>{{student.id}}</td>
                                <td>{{student.firstname}}</td>
                                <td>{{student.lastname}}</td>
                                <td>{{student.email}}</td>
                            </tr>

                            </tbody>
                        </table>
                       <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="updateStudents()">Update</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="deleteStudents()">Delete</button>
                        </div>

                    </form>-->
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