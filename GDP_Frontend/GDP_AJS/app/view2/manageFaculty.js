/**
 * Created by S522612 on 11/9/2015.
 */

var arrayList = [];
$(document).ready(function () {
    var trigger = $('.hamburger'),
        overlay = $('.overlay'),
        isClosed = false;
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
myApp.controller('departmentCtrl', function($scope) {
    $scope.items = [
        { id: 1, name: 'CSIS' },
        { id: 2, name: 'Agricultural Sciences' },
        { id: 3, name: 'School of Business' },
        { id: 4, name: 'Communication and Mass Media' },
        { id: 5, name: 'English and Modern Languages' },
        { id: 6, name: 'Fine and Performing Arts' },
        { id: 7, name: ' Humanities and Social Sciences' },
        { id: 8, name: 'Natural Sciences' },
        { id: 9, name: 'Behavioral Sciences' },
        { id: 10, name: 'Professional Education' },
        { id: 11, name: 'Health Science and Wellness' }
    ];
});
myApp.controller('facultyCtrl', function($scope, $http){
//angular.module('myApp', []).controller('facultyCtrl', function($scope,$http) {

    //angular.module('myApp').controller('facultyCtrl', ['$scope', '$http', '$timeout', function ($scope, $http, $timeout){
    //
    //    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

    $scope.facultyid = '';
    $scope.firstName = '';
    $scope.lastName = '';
    $scope.facultydepartment = '';
    $scope.users=[];
   // $(document.body).mask('loading ...');
    $http.get('../../../../GDP_Backend/API/getFacultyDetails.php?facultyid="All"').success( function(response) {
        console.log(response);
        var json_result = response;
        function1(json_result);
        //$scope.students = response;
    });

    function function1(json_result){
        for(var i in json_result.faculty){
           // console.log(json_result.faculty);
            var info = {
                facultyid: json_result.faculty[i].facultyId,
                facultyfirstName: json_result.faculty[i].firstName,
                facultylastName: json_result.faculty[i].lastName,
                facultydepartment: json_result.faculty[i].department,
              };
            $scope.users.push(info);
        }
        $scope.$apply;
      //  $(document.body).unmask();
    }

    $scope.edit = true;
    $scope.error = false;
    $scope.incomplete = false;
    $scope.currentId='new';


    $scope.updateOrAdd = function() {

        console.log("loaded......");

        if ($scope.currentId == 'new') {

            //$scope.facultyid;
            //$scope.facultyName;
            //$scope.facultydepartment;

          //  $('#facultydepartment :selected').text()
            var info = {
                facultyid: $scope.facultyid,
                facultyfirstName:  $scope.firstName,
                facultylastName:  $scope.lastName,
                facultydepartment:  $scope.facultydepartment
            };

            console.log(info);
            $.ajax({
                url: '../../../../GDP_Backend/API/AddFaculty.php',
                type: 'POST',
                data: info,
                success: function (output) {
                    var json_result = JSON.parse(output);
                    console.log(json_result);
                    if (json_result.success == 1) {
                        document.getElementById("messageArea").innerHTML = "Successfully Added Faculty";
                        document.getElementById("titleArea").innerHTML = "Info";
                    }

                    if (json_result.success == 0) {
                        document.getElementById("messageArea").innerHTML = "Failed to add Faculty";
                        document.getElementById("titleArea").innerHTML = "Info";
                    }

                    $("#newclass").hide();
                    $("#classCreatedModal").modal('show');

                }

            });

            $scope.users.push({id:$scope.users.length+1,facultyid:$scope.facultyid,facultyfirstName:$scope.firstName,facultylastName:$scope.lastName, facultydepartment:$scope.facultydepartment})

        }else {

            $scope.users[$scope.currentId - 1].fName = $scope.facultyid;
            $scope.users[$scope.currentId - 1].cName = $scope.firstName;
            $scope.users[$scope.currentId - 1].cName = $scope.lastName;
            $scope.users[$scope.currentId - 1].lName = $scope.facultydepartment;
        }
       // $scope.reset;
        $scope.$apply;
        $("#newclass").hide();
        $scope.facultyid = '';
        $scope.firstName = '';
        $scope.lastName = '';
        $scope.facultydepartment = '';

    };
    $scope.cancelAddFaculty = function(){

        $("#newclass").hide();
        $scope.facultyid = '';
        $scope.firstName = '';
        $scope.lastName = '';
        $scope.facultydepartment = '';

    };
    $scope.editUser = function(id) {

        $("#newclass").show();

        if (id == 'new') {
            $scope.currentId = 'new';
            $scope.edit = true;
            $scope.incomplete = false;
            //if($scope.facultyid.length != 0 && $scope.facultyName.length != 0 && $scope.facultydepartment.length != 0){
            //    console.log("not null");
            //    $scope.incomplete = false;
            //}



        } else {
            $scope.currentId = id;
            $scope.edit = false;


        }
    };

});



function saveChanges(){


}