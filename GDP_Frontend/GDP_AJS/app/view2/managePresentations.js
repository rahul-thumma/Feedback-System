/**
 * Created by S522626 on 12/3/2015.
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


angular.module('myApp', ['ngTouch', 'xeditable','ui.grid', 'ui.grid.selection','scrollable-table']).controller('tagsCtrl', ['$scope', '$http', '$log', '$timeout', '$filter','$q','uiGridConstants', function ($scope, $http, $log, $timeout,$filter,$q, uiGridConstants){

    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

    var selectedCourseID;
    var selectedSection;
    $scope.cName = '';
    $scope.id = '';
    $scope.course = [];
    $scope.sections = [];
    $scope.feedbackquestion=[];
    $scope.pType = '';
    var tempfeedbackquestion = [];
    var selectedAssignmentId = '';
    $scope.typeOfAssignment = "";

    $scope.data = {};
    $(document.body).mask('loading ...');

    $http.get('../../../../GDP_Backend/API/getAllSections.php').success( function(response) {
        // console.log(response);
        var json_result = response;
        function1(json_result);
    });

    function function1(json_result){

        var courseObjArr = [];
        var couserObj = {};

        for(var i in json_result.section){
            var info = {
                id: json_result.section[i].CourseID,
                cName: json_result.section[i].CourseName
            };
            couserObj[json_result.section[i].CourseID] = json_result.section[i].CourseName;
        }
        for (value in couserObj){
            var tempCourse = {};
            tempCourse["id"] = value;
            tempCourse["cName"] = couserObj[value];
            $scope.course.push(tempCourse);
            tempCourse ={};
        }
        $scope.$apply;
        $(document.body).unmask();
    }


    $scope.updateBasedOnPresentationType = function(){


    };


    $scope.returnSectionNumber= function(section){



        return "section "+section.split("_")[1];
    };

    $scope.searchsections = function() {
        $(document.body).mask('loading ...');
        $scope.sections= [];
        $scope.assignments = [];
        var cid = $("#courseid").val();
        var courseid = {
            CourseID: cid
        };
        Object.toparams = function ObjecttoParams(obj) {
            var p = [];
            for (var key in obj) {
                p.push(key + '=' + encodeURIComponent(obj[key]));
            }
            return p.join('&');
        };
        var sectionObj = {};
        $http({
            url: '../../../../GDP_Backend/API/getSections.php',
            method: "POST",
            data: Object.toparams(courseid),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
            .then(function(response) {
                    selectedCourseID = $scope.courseid;
                    if (response.data.success == 1) {
                        // var count = parseInt(response.data.section);
                        var count =  response.data.section.length;
                        for(var i=0; i<count; i++) {
                            sectionObj= {
                                section: 'section_'+response.data.section[i].SectionNumber
                            };
                            $scope.sections.push(sectionObj);
                        }
                    }


                    // to load assignments
                    if (response.status == 200) {
                        var myarr = $scope.sections;
                        var myarr2 = [];
                        var assignmentObj = {};
                        var count = JSON.stringify($scope.sections.length);
                        for(var i=0;i<count;i++){
                            myarr2.push(myarr[i].section.split("_")[1])
                        }

                        var ourObj = {};
                        var cid = $("#courseid").val();
                        var info = {
                            'Course' : cid,
                            'Section' : myarr2
                        };
                        $http({
                            url: '../../../../GDP_Backend/API/assignment.php',
                            method: "POST",
                            data: Object.toparams(info),
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        })
                            .then(function(response) {
                                    console.log(response);
                                    if (response.data.success == 1) {
                                        // var count = parseInt(response.data.section);
                                        var count =  response.data.assignment.length;

                                        for(var i=0; i<count; i++) {
                                            assignmentObj= {
                                                id:response.data.assignment[i].AssignmentID,
                                                sid: response.data.assignment[i].CourseID,
                                                type: response.data.assignment[i].AssignmentType,
                                                fname: response.data.assignment[i].TopicName,
                                                ptime: response.data.assignment[i].PresentationTime,
                                                tname: response.data.assignment[i].SectionNumber,
                                                cName : response.data.assignment[i].CourseName

                                            };
                                            $scope.assignments.push(assignmentObj);
                                        }
                                    }else {

                                        document.getElementById("messageArea").innerHTML ="There are no assignments under selected course and section";
                                        document.getElementById("titleArea").innerHTML ="Info";

                                        $("#classCreatedModal").modal('show');

                                        //  alert('There are no assignments under selected course and section'); //TODO change to new UI
                                    }
                                    $(document.body).unmask();
                                },
                                function(response) { // optional
                                    // failed
                                });
                    }

                    $scope.$apply;

                    document.getElementById("list").style.display = 'block';
                    var ref_this = $('ul.tabs').find('li.active').data('id');
                },
                function(response) { // optional
                    // failed
                });
    };

    $scope.gridOptions = {
        enableRowSelection: true,
        enableSelectAll: true,
        selectionRowHeaderWidth: 35,
        rowHeight: 35,
        showGridFooter:true
    };


    $scope.loadAddPresentationForm= function (){


        $scope.pquestions = '';
        $scope.ptime='';
        $scope.tname = '';
        $scope.sid = '';

        var selectedSection = $("ul#navlist li.active").text().trim().split(' ')[1];

        $http.get('../../../../GDP_Backend/API/getStudentByIdAndSection.php?CourseID='+selectedCourseID+'&SectionNumber='+selectedSection)
            .success(function(data) {
                console.log(data);
                $scope.gridOptions.data = data.student;

            });

    };

    $scope.gridOptions.columnDefs = [
        { name: 'ID' },
        { name: 'FirstName',
            name:'LastName'}

    ];

    $scope.gridOptions.multiSelect = true;



    $scope.info = {};



    $scope.selectAll = function() {
        $scope.gridApi.selection.selectAllRows();
    };

    $scope.clearAll = function() {
        $scope.gridApi.selection.clearSelectedRows();
    };

    $scope.toggleRow1 = function() {
        $scope.gridApi.selection.toggleRowSelection($scope.gridOptions.data[0]);
    };

    $scope.toggleFullRowSelection = function() {
        $scope.gridOptions.enableFullRowSelection = !$scope.gridOptions.enableFullRowSelection;
        $scope.gridApi.core.notifyDataChange( uiGridConstants.dataChange.OPTIONS);
    };

    $scope.setSelectable = function() {
        $scope.gridApi.selection.clearSelectedRows();
        $scope.gridApi.core.notifyDataChange(uiGridConstants.dataChange.OPTIONS);
        $scope.gridOptions.data[0].age = 31;
        $scope.gridApi.core.notifyDataChange(uiGridConstants.dataChange.EDIT);
    };

    $scope.gridOptions.onRegisterApi = function(gridApi){
        //set gridApi on scope
        $scope.gridApi = gridApi;
        gridApi.selection.on.rowSelectionChanged($scope,function(row){

            if(row.isSelected){
                $scope.addAssignmentForm.studentTable.$invalid = false;
            }else{
                $scope.addAssignmentForm.studentTable.$invalid = true;
            }
            var msg = 'row selected ' + row.isSelected;
            $log.log(msg);
        });

        gridApi.selection.on.rowSelectionChangedBatch($scope,function(rows){

            if(rows.length == 0){
                $scope.addAssignmentForm.studentTable.$invalid = true;
            }else{
                $scope.addAssignmentForm.studentTable.$invalid = false;
            }
            var msg = 'rows changed ' + rows.length;
            $log.log(msg);
        });
    };



    $scope.addPresentation = function() {
        $(document.body).mask('loading ...');

        var stuList = [];
        var list = {};
        var ourObj = {};

        var sec = $('#navlist .active').text();
        var courseID = $("#courseid").val();
        var selectedStudents;
        var selectionType = $scope.selection;
        var topicName = $scope.tname;
        var teamName =  $("#teamname").val();
        var presentationTime = $scope.ptime;
        var section = sec.trim().split(" ")[1];
        var studentid = $scope.sid;
        var student = "";
        var info;
        if (selectionType == 'Group') {

            selectedStudents = $scope.gridApi.selection.getSelectedRows();
            $.each(selectedStudents, function (index, value) {

                student = student + value.ID + ",";
            });
            student = student.substr(0, student.length - 1);
            info = {
                'CourseID': courseID,
                'AssignmentType': selectionType,
                'TopicName': topicName,
                'PresentationTime': presentationTime,
                'StudentList': student,
                'SectionNumber': section,
                'TeamName' : teamName
            }

        } else if(selectionType == 'Individual') {

            selectedStudents = $scope.sid;
            student = selectedStudents;
            info = {
                'CourseID': courseID,
                'AssignmentType': selectionType,
                'TopicName': topicName,
                'PresentationTime': presentationTime,
                'StudentList': student,
                'SectionNumber': section
            }
        }else{
            selectedStudents = "Class";
            student = selectedStudents;
            info = {
                'CourseID': courseID,
                'AssignmentType': selectionType,
                'TopicName': topicName,
                'PresentationTime': presentationTime,
                'StudentList': courseID,
                'SectionNumber': section
            }
        }


        var assignments = [];

        var f = document.getElementById('questionsList').files[0],
            r = new FileReader();
        r.onloadend = function(e){
            var csvval=e.target.result.split("\n");
            for(var j=0;j<csvval.length-1;j++){
                var csvvalue=csvval[j].split(",");

                var assignment = {
                    type:csvvalue[0],
                    question:csvvalue[1],
                    response:csvvalue[2]
                };
                assignments.push(assignment);
            }
        };
        r.readAsText(f);
        var questions = {
            assignments : assignments
        };

        Object.toparams = function ObjecttoParams(obj) {
            var p = [];
            for (var key in obj) {
                p.push(key + '=' + encodeURIComponent(obj[key]));
            }
            return p.join('&');
        };
        $http({
            url: '../../../../GDP_Backend/API/AddAssignment.php',
            method: "POST",
            data: Object.toparams(info),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
            .then(function (response) {

                    console.log(response);
                    if (response.data.success == 1) {
                        addFeedbackQuestions(response);

                        assignmentObj = {
                            sid: info.CourseID,
                            type: info.AssignmentType,
                            fname: info.TopicName,
                            ptime: info.PresentationTime,
                            tname: info.SectionNumber,

                        };
                        console.log(assignmentObj);
                        $scope.assignments.push(assignmentObj);
                        $('#Add').modal('hide');
                        document.getElementById("messageArea").innerHTML ="Successfully added presentation.";
                        document.getElementById("titleArea").innerHTML ="Info";

                        //   }
                    }else if(response.data.success == 0){
                        if(response.data.message == "Failed to Create New Assignment"){
                            //failed to create new assignment

                            document.getElementById("messageArea").innerHTML ="Failed to Create New Assignment.";
                            document.getElementById("titleArea").innerHTML ="Info";
                        }
                        if(response.data.message == "Presentation Already Exists"){
                            // presentation already exist
                            document.getElementById("messageArea").innerHTML ="Presentation Already Exists";
                            document.getElementById("titleArea").innerHTML ="Info";
                        }
                        $('#Add').modal('hide');


                    }
                    $("#classCreatedModal").modal('show');
                    $(document.body).unmask();
                },
                function (response) { // optional
                    // failed
                });


        function addFeedbackQuestions(response){

            questions.assignmentid  = response.data.assignmentID;
            Object.toparams = function ObjecttoParams(obj) {
                var p = [];
                for (var key in obj) {
                    p.push(key + '=' + encodeURIComponent(obj[key]));
                }
                return p.join('&');
            };
            $http({
                url: '../../../../GDP_Backend/API/addFeedbackQuestions.php',
                method: "POST",
                data:  JSON.stringify(questions),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
                .then(function (response) {
                        console.log(response);
                        if (response.data.success == 1) {

                            //successfully added feedback questions

                        }

                    },
                    function (response) { // optional
                        // failed
                    });
        }

    };

    $scope.loadEditPresentation = function(id){

        selectedAssignmentId = id;
        $scope.typeOfAssignment = "";
        $http.get('../../../../GDP_Backend/API/getAssignemtDetails.php?id='+id+'').success( function(response) {
            // var json_result = response;
            // function1(json_result);

            $scope.pType = response.assignemt[0].AssignmentType;
           // $scope.typeOfAssignment = trim(response.assignemt[0].AssignmentType);
            if(response.assignemt[0].AssignmentType.trim()=='Individual'){
                $scope.typeOfAssignment = 1;
            }
            $scope.tname = response.assignemt[0].TopicName;
            $scope.ptime = response.assignemt[0].PresentationTime;

            if(response.assignemt[0].AssignmentType.trim() == 'Individual'){
                $scope.pName = response.assignemt[0].StudentList;
                $scope.data.pName =  $scope.pName;
            }else{
                $scope.StudentList = response.assignemt[0].StudentList;
            }
            $scope.data = {
                pType : response.assignemt[0].AssignmentType,
                tname : response.assignemt[0].TopicName,
                ptime : response.assignemt[0].PresentationTime,
            };
            tempfeedbackquestion = response;
        });
        $scope.$apply;
    };

    $scope.loadFeedbackquestions = function(){
        $scope.feedbackquestion = [];
        //$("#EditFeedbackQuestions").show();

        for(var i in tempfeedbackquestion.feedbackquestions){
            var temp = tempfeedbackquestion.feedbackquestions[i].QuestionType;
            if(temp=='SingleWord'){
                temp = 1;
            }else if(temp=='MultipleChoice'){
                temp = 3;
            }else{
                temp = 2;
            }
            var info = {
                QuestionID:tempfeedbackquestion.feedbackquestions[i].QuestionID,
                Question:tempfeedbackquestion.feedbackquestions[i].Question,
                questionType:temp,
                Responses:tempfeedbackquestion.feedbackquestions[i].Responses
            };
            $scope.feedbackquestion.push(info);

        }
        console.log("scodep");
        console.log($scope.feedbackquestion);
        $scope.$apply;
    };
    //Edit presentation

    $scope.editPresentation = function(){




    };

    //update feeback questions

    // filter users to show
    $scope.filterQuestions = function(question) {
        return question.isDeleted !== true;
    };

    $scope.questionTypes = [
        {value: 1, text: 'SingleWord'},
        {value: 2, text: 'rating'},
        {value: 3, text: 'MultipleChoice'},
    ];
    $scope.showQuestionTypes = function(type) {
        var selected = [];
        if(type.questionType) {
            selected = $filter('filter')($scope.questionTypes, {value: type.questionType});
        }
        return selected.length ? selected[0].text : 'Not set';
    };
    // mark user as deleted
    $scope.deleteUser = function (id) {
        console.log("hi"+id);
        var filtered = $filter('filter')($scope.feedbackquestion, { QuestionID: id });
        if (filtered.length) {
            filtered[0].isDeleted = true;
        }

        console.log($scope.feedbackquestion);
        var info = {
            id:id,
         };

         $.ajax({
         url:'../../../../GDP_Backend/API/deleteFeedbackQuestions.php',
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
        $scope.feedbackquestion.push({
            Question: '',
            questionType: null,
            Responses : '',
            isNew: true
        });
    };

    // cancel all changes
    $scope.cancel = function () {
        for (var i = $scope.feedbackquestion.length; i--;) {
            var question = $scope.feedbackquestion[i];
            // undelete
            if (question.isDeleted) {
                delete question.isDeleted;
            }
            // remove new
            if (question.isNew) {
                $scope.feedbackquestion.splice(i, 1);
            }
        }
    };

    // save edits
    $scope.saveTable = function () {
        var results = [];
        for (var i = $scope.feedbackquestion.length; i--;) {
            var question = $scope.feedbackquestion[i];
            // actually delete user
            if (question.isDeleted) {
                $scope.feedbackquestion.splice(i, 1);
            }
            // mark as not new
            if (question.isNew) {
                question.isNew = true;
            }
            results.push(question);
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
                Question : results[i].Question,
                QuestionType : results[i].QuestionType,
                Responses : results[i].Responses,

            };
            tempArr.push(temp);
        }
         var info = {
            updatedQuestionsList : results,
            assignmentID : selectedAssignmentId
          };
            console.log(info);

         $.ajax({
         url:'../../../../GDP_Backend/API/updateFeedbackQuestions.php',
         type: 'POST',
         data:{
         questionslist : JSON.stringify(info)
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
    //end of update feedback questions

}]);
