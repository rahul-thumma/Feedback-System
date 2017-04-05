/**
 * Created by S522612 on 11/9/2015.
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
var app = angular.module("myApp", ["xeditable"]);

//app.run(function (editableOptions) {
//    editableOptions.theme = 'bs3';
//});
app.controller('userCtrl', function ($scope, $filter, $q, $http){
//angular.module('myApp', []).controller('userCtrl', function($scope,$http) {
    $scope.fName = '';
    $scope.cName = '';
    $scope.lName = '';
    $scope.sec = '';
    $scope.startTiming = '';
    $scope.endTiming = '';
    $scope.users=[];
    $scope.studentList = [];
    var selectedCourseID = '';
    var selectedsectionNumber = '';

    $http.get('../../../../GDP_Backend/API/getAllSections.php').success( function(response) {
        console.log(response);
        var json_result = response;
        function1(json_result);
        $scope.students = response;
    });

    $http.get('../../../../GDP_Backend/API/getFacultyDetails.php?facultyid="All"').success( function(response) {
        console.log(response);
        var json_result = response;
        function2(json_result);
        //$scope.students = response;
    });

    function function1(json_result){
        for(var i in json_result.section){
            var info = {
                id:i,
                fName: json_result.section[i].CourseID,
                cName: json_result.section[i].CourseName,
                lName: json_result.section[i].facultyname,
                sec: json_result.section[i].SectionNumber,
                startTiming: json_result.section[i].starttime,
                endTiming: json_result.section[i].endtime
            };
            $scope.users.push(info);
        }
        $scope.$apply;
    }

    $scope.edit = true;
    $scope.error = false;
    $scope.incomplete = false;
    $scope.currentId='new';

    $scope.addClassDetails = function(){

        var stuList = [];
        var list = {};
        var ourObj = {};

        var f = document.getElementById('file').files[0],
            r = new FileReader();
        r.onloadend = function(e){
            var data = e.target.result;
            var x = data.split("\n");
            $.each(x,function(index,value){
                if(value!=""){
                    list["index"+index]=value;
                }

            });
            stuList.push(list);
            ourObj.file = stuList;
            console.log("final "+JSON.stringify(stuList));

            ourObj.course = [ {'CourseID': $("#courseid").val(),
                'FacultyName': $("#facultyName").val(),
                'SectionNumber': $("#section").val(),
                'CourseName' : $("#courseName").val(),
                'StartTime': $("#timepicker1").val(),
                'EndTime': $("#timepicker2").val()}];

            $.ajax({
                url:'../../../../GDP_Backend/API/CreateSection.php',
                type: 'POST',
                data:{
                    "info" : JSON.stringify(ourObj)
                },
                success: function (output) {
                    var json_result = JSON.parse(output);
                    console.log(json_result);
                    if(json_result.success == 1)
                    {
                        //  $route.reload();
                    }
                    if(json_result.message == "No user found")
                    {
                    }
                    if(json_result.message == "Required field is missing")
                    {
                    }

                    document.getElementById("messageArea").innerHTML ="Successfully created class.";
                    document.getElementById("titleArea").innerHTML ="Info";
                    $("#newclass").hide();
                    $("#classCreatedModal").modal('show');

                }

            });
        };

        r.readAsBinaryString(f);
        var d = new FormData();
        jQuery.each(jQuery('#file')[0].files, function(i, file) {
            d.append('file-'+i, file);
        });
        $scope.users.push({id:$scope.users.length+1,fName:$scope.fName,cName:$scope.cName, lName:$scope.lName,sec:$scope.sec,startTiming:$scope.startTiming,endTiming: $scope.endTiming });

        $scope.reset();
        $scope.$apply;

    };
    $scope.cancelAddClass = function(){

        $("#newclass").hide();
        $("#editclass").hide();
        $("#createclassBtn").show();
    };
    $scope.addClass = function(){
        $("#editclass").hide();
        $("#newclass").show();
        $("#createclassBtn").show();
        $scope.endTiming='';
        $scope.startTiming='';
        $scope.sec='';
        $scope.lName='';
        $scope.cName='';
        $scope.fName='';


    };
    $scope.editUser = function(id,sec){
        selectedCourseID = id;
        selectedsectionNumber = sec;
        $("#newclass").hide();
        $("#editclass").show();
        $("#createclassBtn").hide();

        $http.get('../../../../GDP_Backend/API/getSectionDetails.php?courseId='+id+'&SectionNumber='+sec+'').success( function(response) {
            $scope.currentId = id;
            $scope.edit = false;
            $scope.fName = response.section[0].CourseID;
            $scope.cName = response.section[0].CourseName;
            $scope.lName = response.section[0].facultyname;
            $scope.sec = response.section[0].SectionNumber;
            $scope.startTiming = response.section[0].starttime;
            $scope.endTiming = response.section[0].endtime;

        })
    };
    $scope.editClass = function() {

        //$("#newclass").show();
        //$("#addstudents").hide();
        //$("#editStudents").show();
        $("#newclass").hide();
        $("#editclass").show();
        $("#createclassBtn").hide();
        //$scope.currentId = 'new';
        //$scope.edit = true;
        //$scope.incomplete = true;

        var sendInfo = {
            CourseID: $("#courseid").val(),
            FacultyName: $("#facultyName").val(),
            SectionNumber: $("#section").val(),
            CourseName : $("#courseName").val(),
            StartTime: $("#timepicker1").val(),
            EndTime: $("#timepicker2").val(),

        };
        $.ajax({
            url:'../../../../GDP_Backend/API/updateClassDetails.php',
            type: 'POST',
            data:sendInfo,
            success: function (output) {

                var json_result = JSON.parse(output);
                if(json_result.success == 1)
                {
                    document.getElementById("messageArea").innerHTML ="Successfully updated class details.";
                    document.getElementById("titleArea").innerHTML ="Info";
                    $("#editclass").hide();
                    $("#classCreatedModal").modal('show');
                }
                if(json_result.message == "No user found")
                {
                }
                if(json_result.message == "Required field is missing")
                {
                }
                $("#createclassBtn").show();
            }


        });

    };

    $scope.$watch('fName', function() {$scope.test();});
    $scope.$watch('lName', function() {$scope.test();});

    $scope.test = function() {

        $scope.incomplete = false;
        if ($scope.edit && (!$scope.fName.length ||
            !$scope.lName.length )) {
            $scope.incomplete = true;
        }
    };


    //Written for the student insertion

    $scope.add = function(){
        var f = document.getElementById('file').files[0],
            r = new FileReader();
        r.onloadend = function(e){
            var data = e.target.result;

        };
        r.readAsBinaryString(f);
        var data = new FormData();
        jQuery.each(jQuery('#file')[0].files, function(i, file) {
            data.append('file-'+i, file);
        });

        //added for inserting students from CSV file
        $.ajax({

            url:'../../../../GDP_Backend/API/insertStudentsFromCSV.php',
            type: 'POST',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (output) {
                var json_result = JSON.parse(output);
                if(json_result.success == 1)
                {
                }
                if(json_result.message == "No user found")
                {
                }
                if(json_result.message == "Required field is missing")
                {
                }
            }

        });
    };

    $scope.loadStudents = function(){
        $scope.studentList = [];
        $http.get('../../../../GDP_Backend/API/getClassStudentList.php?courseId='+selectedCourseID+'&SectionNumber='+selectedsectionNumber+'').success( function(response) {
            console.log(response);
            var json_result = response;
            function2(json_result);
        });
    };

    function function2(json_result){
        for(var i in json_result.students){
            var info = {
                id:json_result.students[i].StudentID,
                firstname:json_result.students[i].firstname,
                lastname:json_result.students[i].lastname,
                email:json_result.students[i].email
            };
            $scope.studentList.push(info);

        }
        $scope.$apply;
    }

    // filter users to show
    $scope.filterStudent = function (student) {
        return student.isDeleted !== true;
    };

    // mark user as deleted
    $scope.deleteUser = function (id) {
        var filtered = $filter('filter')($scope.studentList, { id: id });
        if (filtered.length) {
            filtered[0].isDeleted = true;
        }

        var info = {
            StudentID:id,
            CourseID:selectedCourseID,
            SectionNumber:selectedsectionNumber
        };

        $.ajax({
            url:'../../../../GDP_Backend/API/deleteStudent.php',
            type: 'POST',
            data:info,
            success: function (output) {
                var json_result = JSON.parse(output);
                if(json_result.success == 1)
                {
                    //successfully deleted student
                }
                else
                {
                    //failed to delete student
                }

            }

        });
    };

    // add user
    $scope.addUser = function () {
        $scope.studentList.push({
            id: '',
            firstname: '',
            lastname: null,
            isNew: true
        });
    };

    // cancel all changes
    $scope.cancel = function () {
        for (var i = $scope.studentList.length; i--;) {
            var student = $scope.studentList[i];
            // undelete
            if (student.isDeleted) {
                delete student.isDeleted;
            }
            // remove new
            if (student.isNew) {
                $scope.studentList.splice(i, 1);
            }
        }
    };

    // save edits
    $scope.saveTable = function () {
        var results = [];
        for (var i = $scope.studentList.length; i--;) {
            var student = $scope.studentList[i];
            // actually delete user
            if (student.isDeleted) {
                $scope.studentList.splice(i, 1);
            }
            // mark as not new
            if (student.isNew) {
                student.isNew = true;
            }
            results.push(student);
            // send on server
            //  results.push($http.post('/saveUser', user));
        }
        console.log(results);

        var list = {};
        var tempArr = [];
        for (var i=0; i<results.length;i++){
            var temp = {};
            if(typeof results[i].isNew === 'undefined') {
                // does not existt
                temp.isNew = results[i].isNew;
            }
            else {
                // does exist
                temp.isNew = false;
            }
            temp={
                id : results[i].id,
                firstname : results[i].firstname,
                lastname : results[i].lastname,
                email : results[i].email,

            };
            tempArr.push(temp);
        }
        var info = {
            updatedStudentList : results,
            courseId: selectedCourseID,
            sectionNum : selectedsectionNumber
        };

        //   console.log(info);

        $.ajax({
            url:'../../../../GDP_Backend/API/updateStudentList.php',
            type: 'POST',
            data:{
                studentlist : JSON.stringify(info)
            },
            success: function (output) {
                var json_result = JSON.parse(output);
                if(json_result.success == 1)
                {
                }
                if(json_result.message == "No user found")
                {
                }
                if(json_result.message == "Required field is missing")
                {
                }
            }

        });

        return $q.all(results);
    };
    //app.run(function ($httpBackend) {
    //    $httpBackend.whenGET('/groups').respond([
    //        { id: 1, text: 'user' },
    //        { id: 2, text: 'customer' },
    //        { id: 3, text: 'vip' },
    //        { id: 4, text: 'admin' }
    //    ]);
    //
    //    $httpBackend.whenPOST(/\/saveUser/).respond(function (method, url, data) {
    //        data = angular.fromJson(data);
    //        return [200, { status: 'ok' }];
    //    });
    //});
    $("table.table tr th").bind("click", headerClick);
    $("table.table tr td").bind("click", dataClick);
    $("#saveButton").bind("click",saveButton);
    function headerClick(e) {
        console.log(e);
        $(e.currentTarget).css({
            color:"red"
        });
    }

    function dataClick(e) {
        console.log(e);
        if (e.currentTarget.innerHTML != "") return;
        if(e.currentTarget.contentEditable != null){
            $(e.currentTarget).attr("contentEditable",true);
        }
        else{
            $(e.currentTarget).append("<input type='text'>");
        }
    }
    function saveButton(){
        $("table.table tr td").each(function(td, index){
            console.log(td);
            console.log(index);
        });
    }
});


function saveChanges(){


}