<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="../../../../GDP_Backend/Client/changePassword.js"></script>
    <script>
        $( document ).ready(function() {
            console.log( "ready!" );
            jQuery.validator.setDefaults({
                debug: true,
                success: "valid"
            });

            $('#form1').validate({
                rules:{
                    Email:
                    {

                        required:true,
                        email:true
                    },
                    password:
                    {
                        required:true,
                        minlength:3,
                        maxlength:10
                    },
                    password_again:{
                        equalTo:"#password"

                    }
                },

                highlight: function(element) {
                    $(element).closest('.form-group').addClass('has-error');

                },
                unhighlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function(error, element) {
                    if(element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }

            })
        });
    </script>
    <title>Change password</title>
</head>
<body>
<?php
session_start();

if(!isset($_SESSION['username'])){
    header('Location: login.html');
}

?>
<div class="container">
    <h1 class="text-center">Welcome to Feedback System</h1>

    <div class="jquery-script-ads text-center"><script type="text/javascript">
        </script>
        <!--<script type="text/javascript"
                src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
        </script>-->
    </div>
    <form class="form-horizontal" id="form1">
        <fieldset>

            <!-- Form Name -->
            <legend>
                <center>
                    Change Password
                    <p id="userID" hidden>
                        <?php echo $_SESSION['username']; ?>
                    </p>
                </center>
            </legend>


            <!-- Password input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="Password">Password</label>
                <div class="col-md-3">
                    <div class="input-group"> <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                        <input id="password" name="password" type="password" placeholder="Enter Your Password" class="form-control input-md">

                    </div>
                </div>
            </div>

            <!-- Password input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="ConfirmPassword">Confirm Password</label>
                <div class="col-md-3">
                    <div class="input-group"> <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                        <input id="password_again" name="password_again" type="password" placeholder="Enter Your Password Again" class="form-control input-md">
                    </div>
                </div>
            </div>

            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="Submit"></label>
                <div class="col-md-4">
                    <button id="Submit" class="btn btn-success" type="Submit">submit</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>

</body>
</html>