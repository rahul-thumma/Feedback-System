/**
 * Created by S522626 on 11/12/2015.
 */



function verifyLogin() {
    var pwd = $("#password").val();
    var userID =  $('#userID').text().trim();
       $.ajax({
            url: '../../../../GDP_Backend/API/UpdatePassword.php',
            type: 'POST',
            data: {
                ID : userID,
                pwd : pwd
            },
            success: function (output) {
                var json_result = JSON.parse(output);
                console.log(json_result);
                if (json_result.success == "1") {
                    if(json_result.typeOfUser == "Admin"){
                        window.location.replace('AdminPage.php');
                    }
                    if(json_result.typeOfUser == "Faculty"){
                        window.location.replace('AdminPage.php');
                    }
                    if(json_result.typeOfUser == "Student"){
                        window.location.replace('studentHomePage.php');
                    }
                }
             else{
                    window.location.replace('login.html');
                }

            }

        });

}


window.onload = function() {
    document.getElementById("Submit").onclick = verifyLogin;
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
