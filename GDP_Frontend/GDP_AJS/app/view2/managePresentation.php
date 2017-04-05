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
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-touch.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-animate.js"></script>
    <script src="angular-mocks.js"></script>
    <script src="xeditable.js"></script>
    <script src="xeditable.min.js"></script>
    <script src="http://ui-grid.info/docs/grunt-scripts/csv.js"></script>
    <script src="http://ui-grid.info/docs/grunt-scripts/pdfmake.js"></script>
    <script src="http://ui-grid.info/docs/grunt-scripts/vfs_fonts.js"></script>
    <script src="http://ui-grid.info/release/ui-grid.js"></script>
    <script src="angular-scrollable-table.js"></script>
    <script src="angular-scrollable-table.min.js"></script>
    <link rel="stylesheet" href="scrollable-table.css" type="text/css">
    <link rel="stylesheet" href="http://ui-grid.info/release/ui-grid.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="jquery.datetimepicker.css"/>
    <link rel="stylesheet" type="text/css" href="xeditable.css">
    <script src="jquery.datetimepicker.full.js"></script>
    <link href="jquery.loadmask.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="jquery.loadmask.js"></script>

    <!-- for auto complete -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/css/select2.min.css" rel="stylesheet" />
    <script src="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/js/select2.min.js"></script>
    <style>

        #Edit .modal-dialog  {width:75%;}
        div[ng-app] { margin: 10px; }

        #EditFeedbackQuestions .modal-dialog  {width:75%;}
        .grid {
            width: 100%;
            height: 400px;
        }


    </style>

    <link rel="stylesheet" href="Addclass.css">
    <link rel="stylesheet/less" type="text/css" href="timepicker.less.css">
    <style>

        #navlist li
        {
            display: inline;
            list-style-type: none;
            padding-right: 20px;
        }

    </style>
</head>
<body ng-app="myApp" ng-controller="tagsCtrl">
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



    <div class="col-sm-10">

        <div>

            <h3>Manage Presentations</h3>
        </div>
        <br><br>
        <div>
            <div class="form-horizontal" style="margin-left: 1em;"  >
                <div class="container">
                    <div class="form-group" >
                        <label class="col-sm-5 control-label">Course Name:</label>
                        <select name="courseid" ng-model="courseid" id="courseid" class="col-sm-2 js-example-basic-multiple" >
                            <option ng-repeat="c in course"  value="{{c.id}}">{{c.cName}}</option>
                        </select>
                    </div>


                    <div class="row">
                        <div class="col-md-5"></div>

                        <button type="button" class="btn btn-info collapsed col-md-1 col-sm-2"   ng-click="searchsections()" >
                            Search   </button>
                    </div>
                </div>
            </div>


            <div class="collapse" id="list" style="display: none;">
                <div class="container">

                    <ul class="nav nav-tabs" id="navlist">
                        <li ng-class="{active: $index == 0}"  ng-repeat="ca in sections" >
                            <a data-toggle="tab"  href="#tab{{$index + 1}}">{{returnSectionNumber(ca.section)}}</a>
                        </li>
                    </ul>
                </div>
                <br>
                <div class="tab-content" style="margin-left: 7em;">
                    <!--  <div class="tab-pane fade in active" id="home">
                          <h3> Welcome </h3>

                  </div>-->
                    <div class="tab-pane fade in" ng-repeat="ca in sections" id="tab{{$index + 1}}" ng-class="{active: $index == 0}">

                        <table class="table table-stripped" id="{{ca.section}}">

                            <thead>

                            <th>Course ID</th>
                            <th>Presentation Topic</th>
                            <th>Type of Presentation</th>
                            <th>Date</th>
                            <th>Edit</th>

                            <!--  <th>Edit</th>-->
                            </tr></thead>

                            <tbody><tr ng-repeat="assignment in assignments" ng-if="'section_'+assignment.tname == ca.section">

                                </td>
                                <td>{{ assignment.sid }}</td>
                                <td>{{ assignment.fname }}</td>
                                <td>{{ assignment.type }}</td>
                                <td>{{ assignment.ptime }}</td>
                                <td>
                                    <button class="btn" data-toggle="modal" data-target="#Edit" ng-click="loadEditPresentation(assignment.id)">
                                        <span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Edit
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>




                        <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#Add" ng-click="loadAddPresentationForm()"  >Add Presentations</button>
                        <!--<button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#myModal">Delete Presentation</button>-->



                    </div>

                    <div class="modal fade" id="Add" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Add Presentation</h4>
                                </div>

                                <form class="form-horizontal" name="addAssignmentForm">
                                    <br>

                                    <div class="form-group">
                                        <div class="col-md-10" >
                                            <label class="col-sm-4 control-label">Presentation Type:</label>
                                            <select class="js-example-basic-multiple"
                                                    style="width: 13em;"
                                                    ng-model="selection"
                                            >
                                                <option value="Individual" selected >Individual</option>
                                                <option value="Group">Group</option>
                                                <option value="Class">Class</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="animate-switch-container"
                                             ng-switch on="selection">

                                            <div class="animate-switch" ng-switch-default>

                                                <div class="col-md-10">
                                                    <label class="col-md-4 control-label">Sid:</label>
                                                    <input type="text" ng-model="$parent.sid"  placeholder="Student Id" name="studentId"  required>
                                                    <div role="alert">
                                                    <span class="error" ng-show="addAssignmentForm.studentId.$error.required && addAssignmentForm.studentId.$touched">
                                                    Required!</span>
                                                    </div>
                                                </div>


                                            </div>


                                            <div class="animate-switch" ng-switch-when="Individual">
                                                <div class="col-md-10">
                                                    <label class="col-md-4 control-label">Sid:</label>
                                                    <input type="text" ng-model="$parent.sid"  placeholder="Student Id" name="studentId" required>
                                                    <div role="alert">
                                                    <span class="error" ng-show="addAssignmentForm.studentId.$error.required && addAssignmentForm.studentId.$touched">
                                                    Required!</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="animate-switch" ng-switch-when="Class">

                                            </div>
                                            <div>
                                                <div class="animate-switch" ng-switch-when="Group">

                                                    <div class="form-group">
                                                        <div class="col-sm-10">
                                                            <label class="col-md-4 control-label">Team Name:</label>
                                                            <input type="text" ng-model="teamname"  id="teamname"  placeholder="Team Name" required>
                                                            <div role="alert">
                                              <span class="error" ng-show="addAssignmentForm.teamname.$error.required && addAssignmentForm.teamname.$touched">
                                               Required!</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-10">
                                                        <div>
                                                            <span style="margin-left: 2em;">Select students by selecting tick mark </span>
                                                            <div  id="mydatatable" ui-grid="gridOptions" name="studentTable" ui-grid-selection class="grid" style="width: 500px; height: 290px;margin-left: 2em;"></div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <label class="col-md-4 control-label">Topic Name:</label>
                                            <input type="text" ng-model="tname"  name="topicName"  placeholder="Topic Name" required>
                                            <div role="alert">
                                              <span class="error" ng-show="addAssignmentForm.topicName.$error.required && addAssignmentForm.topicName.$touched">
                                               Required!</span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <label class="col-md-4 control-label">Presentation Time:</label>
                                            <input id="datetimepicker" type="text" name="presentationTime" ng-model="ptime" required>
                                            <div role="alert">
                                              <span class="error" ng-show="addAssignmentForm.presentationTime.$error.required && addAssignmentForm.presentationTime.$touched">
                                               Required!</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <label class="col-md-4 control-label">Add Feedback Questions:</label>
                                            <input class="btn btn-primary" ng-model="pquestions" ng-disabled="error || incomplete" type="file" id="questionsList" name="questions" required>
                                            <!-- <input id="questionsList" type="text" name="questions" ng-model="pquestions" required>-->
                                            <div role="alert">
                                              <span class="error" ng-show="addAssignmentForm.questions.$error.required && addAssignmentForm.questions.$touched">
                                               </span>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="addPresentation()" ng-disabled=" addAssignmentForm.studentId.$invalid || addAssignmentForm.presentationTime.$invalid || addAssignmentForm.topicName.$invalid || addAssignmentForm.studentTable.$invalid">Add</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>


                    <!--Edit presentation-->

                    <div class="modal fade" id="Edit" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit Presentation</h4>
                                </div>

                                <form class="form-horizontal" name="addAssignmentForm">
                                    <br>

                                    <div class="form-group">
                                        <div class="col-md-10" >
                                            <label class="col-sm-4 control-label">Presentation Type:</label>
                                            <input type="text" ng-model="pType" disabled>
                                        </div>
                                    </div>

                                    <!-- ng-if="student.studentID!='class'"-->
                                    <div class="form-group" ng-if="typeOfAssignment===1">
                                        <div class="col-md-10" >
                                            <label class="col-sm-4 control-label">Presenters:</label>
                                            <input type="text" ng-model="pName" disabled>
                                        </div>
                                    </div>

                                    <div style="margin-left: 15em;margin-right: 5em">
                                        <div class="form-group" ng-if="typeOfAssignment!==1">
                                            <label style="margin-left: -5em">Presenters:</label><br>
                                            <scrollable-table watch="feedbackquestion">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th sortable-header col="facility">Student ID</th>
                                                        <th sortable-header col="facility">Name</th>
                                                        <th sortable-header col="facility">Email Id</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr ng-repeat="student in StudentList" row-id="{{ student.studentID}}"
                                                        ng-class="{info: selected == student.studentID}" ng-if="student.studentID!='class'">
                                                        <td>{{ student.studentID }}</td>
                                                        <td>{{ student.firstname +' '+ student.lastname}}</td>
                                                        <td>{{ student.email}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </scrollable-table>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <label class="col-md-4 control-label">Topic Name:</label>
                                            <input type="text" ng-model="tname"  name="topicName" disabled>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <label class="col-md-4 control-label">Presentation Time:</label>
                                            <input id="editdatetimepicker" type="text" name="presentationTime" ng-model="ptime" disabled>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <label class="col-md-4 control-label">Update Feedback Questions:</label>
                                            <button type="button" class="btn btn-success btn" data-toggle="modal" data-target="#EditFeedbackQuestions" ng-click="loadFeedbackquestions()">Update feedback questions</button>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="modal-footer">
                                        <!--         <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="addPresentation()" ng-disabled=" addAssignmentForm.studentId.$invalid || addAssignmentForm.presentationTime.$invalid || addAssignmentForm.topicName.$invalid || addAssignmentForm.studentTable.$invalid">Add</button>-->
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="EditFeedbackQuestions" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit Feedback Questions</h4>
                                </div>


                                <form editable-form name="tableform" onaftersave="saveTable()" oncancel="cancel()">
                                    <div style="margin-left:1.5em;margin-right:4em;margin-bottom: 2em; ">

                                        <!-- table -->
                                        <table class="table table-bordered table-hover table-condensed">
                                            <tr style="font-weight: bold">
                                                <td>Question</td>
                                                <td>Question Type</td>
                                                <td>Question Responses</td>
                                                <td><span ng-show="tableform.$visible">Action</span></td>
                                            </tr>
                                            <tr ng-repeat="question in feedbackquestion | filter:filterQuestions">

                                                <td>
                                                    <!-- editable username (text with validation) -->
          <span editable-text="question.Question" e-form="tableform">
            {{ question.Question}}
          </span>
                                                </td>
                                                <td>
                                 <span editable-select="question.questionType" e-form="tableform" e-ng-options="s.value as s.text for s in questionTypes">
            {{ showQuestionTypes(question)}}
          </span>
                                                </td>
                                                <td title="Enter question responses seperated by ( , ) or ( @ )">
                                 <span editable-text="question.Responses" e-form="tableform">
            {{ question.Responses}}
          </span>
                                                </td>


                                                <td><button type="button" ng-show="tableform.$visible" ng-click="deleteUser(question.QuestionID)" class="btn btn-danger pull-right">Del</button></td>
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


                            </div>
                        </div>
                    </div>

                    <!--End of edit presentation-->

                </div>

            </div>
            <script type="text/javascript">
                $('select').select2();
                $(".js-example-basic-multiple").select2();

            </script>

        </div>
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

<script src="managePresentations.js"></script>
<script>

    $.datetimepicker.setLocale('en');
    $('#datetimepicker').datetimepicker();

</script>
</body>
</html>