

/**
 * Created by S522626 on 12/6/2015.
 */
var arrayList = [];
$(document).ready(function () {

    var trigger = $('.hamburger'),
        overlay = $('.overlay'),
        isClosed = false;

    trigger.removeClass('is-closed');
    trigger.addClass('is-open');
    $('#wrapper').toggleClass('toggled');

    trigger.click(function () {

        hamburger_cross();
    });

    function hamburger_cross() {

        if (isClosed == true) {
            //overlay.hide();
            trigger.removeClass('is-open');
            trigger.addClass('is-closed');
            isClosed = false;
        } else {
            //overlay.show();
            trigger.removeClass('is-closed');
            trigger.addClass('is-open');
            isClosed = true;
        }
    }

    $('[data-toggle="offcanvas"]').click(function () {

        $('#wrapper').toggleClass('toggled');
    });

});


var myApp = angular.module('myApp',[]);


myApp.controller('profileCtrl', function($scope, $http){

    var userID =  $('#userID').text().trim();
   // var userID =  "Admin";
    // current password
    var oldpwd = "";
    var info = {
        ID : userID
    };

    Object.toparams = function ObjecttoParams(obj) {
        var p = [];
        for (var key in obj) {
            p.push(key + '=' + encodeURIComponent(obj[key]));
        }
        return p.join('&');
    };

    $http({
        url: '../../../../GDP_Backend/API/getUserByID.php',
        method: "POST",
        data: Object.toparams(info),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
        .then(function(response) {
            if (response.data.success == 1) {

                console.log(response.data);
                oldpwd = response.data.user[0].Password;
                $('#fName').attr('value',response.data.user[0].FirstName);
                $('#lName').attr('value',response.data.user[0].LastName);
                $('#studentId').attr('value',response.data.user[0].UserID);
                $('#emailId').attr('value',response.data.user[0].Email);
            }
        },
        function(response) { // optional
            // failed
        });

    console.log("old password "+oldpwd);

    $scope.errorMessageBoolean = false;
    $scope.successMessageBoolean = false;
    $scope.errorMessage="";
    $scope.successMessage= "";

    $scope.updatePassword = function(){
        setTimeout(function() {
            $scope.$apply(function(){
                console.log('old password in db '+ oldpwd);
                console.log('old password '+ $scope.pw0);
                console.log('new  password '+ $scope.pw1);
                console.log('confirm password '+ $scope.pw2);


                if(userID != $scope.newusername){

                    $scope.successMessageBoolean = false;
                    $scope.errorMessageBoolean = true;
                    $scope.errorMessage="user name did not match";

                }else if(oldpwd != $scope.pw0){

                    $scope.successMessageBoolean = false;
                    $scope.errorMessageBoolean = true;
                    $scope.errorMessage="old password did not match";

                }else if($scope.pw1 != $scope.pw2){

                    $scope.successMessageBoolean = false;
                    $scope.errorMessageBoolean = true;
                    $scope.errorMessage="Password did not match";

                }else{


                    // update database for password.

                    var info = {
                        ID : userID,
                        Password : $scope.pw1
                    };
                    $http({
                        url: '../../../../GDP_Backend/API/updateUser.php',
                        method: "POST",
                        data: Object.toparams(info),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    })
                        .then(function(response) {

                            console.log(response);

                            if (response.data.success == 1) {

                                $scope.errorMessageBoolean = false;
                                $scope.successMessageBoolean = true;

                                $scope.successMessage ="Successfully updated. ";

                                setTimeout(function() {
                                    $('#details').modal('hide');},1000);
                            }
                        },
                        function(response) { // optional
                            // failed
                        });


                }


                // to hide the modal



            });},2);

    }



});
