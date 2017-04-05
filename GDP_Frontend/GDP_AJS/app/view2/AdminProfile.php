<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    session_start();

    if(!isset($_SESSION['username'])){
        header('Location: login.html');
    }

    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="adminProfile.js" type="application/javascript" rel="script"></script>
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet"  href="AdminPage.css">
    <link rel="stylesheet" href="Addclass.css">
    <link rel="stylesheet/less" type="text/css" href="timepicker.less.css">
    <title>Profile</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>
<body ng-app="myApp" ng-controller="profileCtrl">


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
                <a href="logout.php">Log out</a>
            </li>
        </ul>
    </nav>
    <!-- /#sidebar-wrapper -->
    <br>
    <br>
    <br>
    <br><br>
    <div class="container">


        <div>
            <h3  ><b>Account Details</b></h3>
            <p id="userID" hidden>
                <?php echo $_SESSION['username']; ?>
            </p>
            <br><br>
            <br><br>
            <form role="form" class="form-horizontal" >
                <div class="form-group">
                    <label for="fName" class="col-sm-3" >Firstname</label>
                    <div class="col-sm-3">
                        <input id="fName" type="text" disabled="true" class="form-control" value=""/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lName" class="col-sm-3">Lastname</label>
                    <div class="col-sm-3">
                        <input type="text" id="lName" disabled="true" class="form-control" value=""/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="studentId" class="col-sm-3">User Name</label>
                    <div class="col-sm-3">
                        <input type="text" id="studentId" disabled="true" class="form-control" value=""/>
                    </div>
                </div>

                <div class="form-group">

                    <div class="col-sm-3" ></div>
                    <div class="col-sm-3" >
                        <button class="btn btn-primary" ng-click="editUser(user.id)" data-target="#details" data-toggle="modal">
                            <span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Change Password
                        </button>
                    </div>

                </div>
            </form>

            <div class="modal fade" id="details" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">

                        <form class="form-horizontal" role="form" name="updatePasswordForm">
                            <br>

                            <div class="form-group">

                                <label class="col-md-4 control-label" for="pw0">Current Password:</label>
                                <div class="col-md-4">
                                    <input type="password" id="pw0" name="pw0" class="form-control"
                                           ng-model="pw0" required/>
                                    <span ng-show="updatePasswordForm.pw0.$error.required && updatePasswordForm.pw0.$touched"> Current Password
                                    is required.</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="pw1">New Password:</label>
                                <div class="col-md-4">
                                    <input type="password" id="pw1" name="pw1" class="form-control"
                                           ng-model="pw1" required/>
                                    <span ng-show="updatePasswordForm.pw1.$error.required && updatePasswordForm.pw1.$touched"> New Password
                                    is required.</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="pw2">Confirm Password:</label>
                                <div class="col-md-4">
                                    <input type="password" id="pw2" name="pw2" class="form-control"
                                           ng-model="pw2" required pw-check="pw1">
                                    <span ng-show="updatePasswordForm.pw2.$error.required && updatePasswordForm.pw2.$touched">
                                        Confirm Password is required.
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" ></label>
                                <div class="col-md-4">
                                    <span ng-show="errorMessageBoolean" style="color: #ec1b5a;"> {{errorMessage}} </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" ></label>
                                <div class="col-md-4">
                                    <span ng-show="successMessageBoolean" style="color: #00dd1c;"> {{successMessage}} </span>
                                </div>
                            </div>


                            <div class="modal-footer">
                                <button type="submit" ng-disabled=" updatePasswordForm.pw0.$dirty && updatePasswordForm.pw0.$invalid ||
                                updatePasswordForm.pw1.$dirty && updatePasswordForm.pw1.$invalid ||
                                updatePasswordForm.pw2.$dirty && updatePasswordForm.pw2.$invalid" class="btn btn-primary"  ng-click="updatePassword()">Update</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>



                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /#page-content-wrapper -->

</div>
</body>
</html>