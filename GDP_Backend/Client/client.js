/**
 * Created by S522626 on 11/12/2015.
 */

function verifyLogin() {
    var id = $("#username").val();
    var pwd = $("#password").val();
    console.log(id+" "+pwd);
    var sendInfo = {
        ID: id,
        Password: pwd
   };
    if(id == "" && pwd == ""){
        document.getElementById("error").innerHTML = "All fields are required to fill in";
    }else {
        $.ajax({
            url: '../../../../GDP_Backend/API/getStudentById.php',
            type: 'POST',
            data: sendInfo,
            success: function (output) {
                console.log(output);
                var json_result = JSON.parse(output);
                console.log(json_result);
                if (json_result.message == "No user found") {
                    document.getElementById("error").innerHTML = "Incorrect UserName or Password";
                    // alert("wrong user");
                }
                 if(json_result.user[0].isFirstTime == "1"){
                    window.location.replace('changePasswordForm.php');
                }else {
                     if (json_result.user[0].typeOfUser == "Admin") {

                         window.location.replace('AdminPage.php')
                     }
                     if (json_result.user[0].typeOfUser == "Faculty") {
                         //  alert("correct");
                         window.location.replace('AdminPage.php');
                         // alert("correct");
                     }
                     if (json_result.user[0].typeOfUser == "Student") {
                         window.location.replace('studentHomePage.php');
                         // alert("correct");
                     }
                 }
              }

        });
    }
}


window.onload = function() {
    document.getElementById("signin").onclick = verifyLogin;
};

/*
function register() {
    var id = $("#id").val();
    var pwd = $("#pwd").val();
    var fname = $("#fname").val();
    var lname = $("#lanme").val();
    var contact = $("#contact").val();

    var sendInfo = {
        ID: id,
        Password: pwd,
        FirstName: fname,
        LastName: lname,
        Contact: contact
    };

    $.ajax({
        url:'StudentService/Register.php',
        type: 'POST',
         data:sendInfo,
        success: function (output) {
          //  var json_result = JSON.parse(output);
            console.log(output);
           // function2(json_result);
        }

    });
}

function function2(json_result)
{
    //alert(json_result.toString);
   // document.getElementById("output").innerHTML=json_result.message;

    console.log(json_result);
}*/
