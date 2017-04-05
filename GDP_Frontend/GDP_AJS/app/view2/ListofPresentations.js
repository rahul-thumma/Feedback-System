/**
 * Created by S522626 on 11/29/2015.
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


// declare a module
var app = angular.module('myApp',[]);

// add the controller's constructor function to the module
app.controller('FeedbackController', function ($scope,$http){

    $scope.courses=[];
    $scope.sections = [];
    $scope.questions = [];

    $scope.course = [];
    $scope.SectionNumber = "";
    $scope.presenter = "";
    $scope.presenters = "";
    $scope.presentationType = "";
    $scope.topic = [];
    $scope.pType = [];
    $scope.pTime = [];
    $scope.rowCollection = [];
    var assignmentId = "";
    var userID =  $('#userID').text().trim();
    var sectionArr =[];
    $http.get('../../../../GDP_Backend/API/getPresentations.php').success( function(response) {

        var json_result = response;

        console.log(response);
        $scope.presenter="";
        for(var i=0; i<response.assignments.length;i++){

            info = {
                course : response.assignments[i].CourseID,
                pType : response.assignments[i].AssignmentType,
                pTime : response.assignments[i].PresentationTime,
                topic : response.assignments[i].TopicName,
                assignmentId : response.assignments[i].AssignmentID
            };
            var info = {};
            info.listofGroupPresenters = "";
                if(response.assignments[i].AssignmentType.trim() == "Individual"){
                    info.presenter = response.assignments[i].StudentList;

                }else if(response.assignments[i].AssignmentType.trim() == "Class"){
                    info.presenter =  response.assignments[i].CourseID+"- 0"+response.assignments[i].SectionNumber;
                    }else{
                    info.presenter = "Group";
                    info.listofGroupPresenters = response.assignments[i].StudentList;
                }
                info.course =  response.assignments[i].CourseID;
                info.sectionNum = response.assignments[i].SectionNumber,
                info.pType =   response.assignments[i].AssignmentType;
                info.pTime =   response.assignments[i].PresentationTime;
                info.topic =   response.assignments[i].TopicName;
                info.assignmentId = response.assignments[i].AssignmentID;

            $scope.rowCollection.push(info);
        }

        $scope.apply;

    });

    $http.get('../../../../GDP_Backend/API/getFeedbackQuestions.php').success( function(response) {

        var json_result = response;
        var tempCourse = [];

        var questions = [];
        $scope.questions = [];
        for(var i in json_result.question){
            var info = {
                QuestionId: json_result.question[i].QuestionID,
                QuestionType : json_result.question[i].QuestionType,
                QuestionText : json_result.question[i].Question,
                QuestionResponse: json_result.question[i].Responses,
            };
            $scope.questions.push(info);
        }
        $scope.apply;
        $scope.apply;
    });



    $scope.submitFeedback = function(){

        var totalValue = {};
        var response = {};
        var feedbackresponse = [];

        var studentID = userID;
        var comments = $('#comments').val();

        var ratingQuestions =   $('[questiontype="rating"]');
        var mutlipleResponseQuestions =$('[questiontype="MultipleChoice"]');
        var singlewordQuestions = $('[questiontype="SingleWord"]');

            if(comments != ""){
                response.PresentationName = $scope.updatedPresenterNameModal;
                response.Question = "Comment";
                response.QuestionType = "Comment";
                response.QuestionResponse = comments;
                feedbackresponse.push(response);
                response={};

            }
        for(var i=0; i< ratingQuestions.length; i++){

            if(ratingQuestions[i].checked){

                response.PresentationName = $scope.topic;
                response.Question = ratingQuestions[i].getAttribute('question');
                response.QuestionType = ratingQuestions.attr('questiontype');
                response.QuestionResponse = ratingQuestions[i].value;


                feedbackresponse.push(response);
                response={};

            }

        }


        for(var i=0; i< mutlipleResponseQuestions.length; i++){

            if(mutlipleResponseQuestions[i].checked){

                response.PresentationName = $scope.topic;
                response.Question = mutlipleResponseQuestions[i].getAttribute("question");
                response.QuestionType = mutlipleResponseQuestions.attr("questiontype");
                response.QuestionResponse = mutlipleResponseQuestions[i].value;
                feedbackresponse.push(response);
                response={};

            }

        }

        for(var i=0; i< singlewordQuestions.length; i++){

            if(singlewordQuestions[i].checked){

                response.PresentationName = $scope.topic;
                response.Question = singlewordQuestions[i].getAttribute("question");
                response.QuestionType = singlewordQuestions.attr("questiontype");
                response.QuestionResponse = singlewordQuestions[i].value;
                feedbackresponse.push(response);
                response={};

            }

        }

        console.log(feedbackresponse);
        totalValue.assignments=feedbackresponse;
        totalValue.studentID = studentID;
       /* totalValue.courseId = $scope.course;*/
        totalValue.comments = comments;
        /*totalValue.presentationType = $scope.presentationType;*/
        totalValue.assignmentId = assignmentId;
        /*totalValue.StudentID = $scope.presenter;*/
        Object.toparams = function ObjecttoParams(obj) {
            var p = [];
            for (var key in obj) {
                p.push(key + '=' + encodeURIComponent(obj[key]));
            }
            return p.join('&');
        };

        $http({
            url: '../../../../GDP_Backend/API/addFeedback.php',
            method: "POST",
            data:  JSON.stringify(totalValue),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
            .then(function (response) {
                console.log(response);
                if (response.data.success == 1) {


                    document.getElementById("messageArea").innerHTML ="Successfully submitted your feedback.";
                    document.getElementById("titleArea").innerHTML ="Info";

                    $("#classCreatedModal").modal('show');

                    $scope.updatedPresenterNameModal= '';
                    $scope.updatedTopicNameModel='';
                    $scope.updatedSectionModel='';
                    $scope.courseModel='';
                    $( ".inner").empty();
                    $("#feedbackDIv").hide();
                    //$(".js-example-basic-multiple").select2().val(null).trigger("change");
                    $(".js-example-basic-multiple").val(null).trigger("change");

                    $scope.apply;


                }else{


                    document.getElementById("messageArea").innerHTML ="You have already submitted feedback.";
                    document.getElementById("titleArea").innerHTML ="Info";

                    $("#classCreatedModal").modal('show');
                }

            },
            function (response) { // optional
                // failed
            });

    };

    $scope.getFeedbackQuestions = function (assignmentid) {

        assignmentId = assignmentid;

        //console.log(assignmentid);
        //$("#feedbackDIv").show();
       // $( ".inner").empty();
      /*  $scope.presenter = "";
        $scope.presentationType = "";
        $scope.presenters = "";
        $scope.course = "";
        $scope.topic = "";
        $scope.SectionNumber = "";
        var courseName = course;
        var section = sectionNum;
        var presenterName = presenter;
        var presentationType = pType;
        var topic = pTopic;
        if(presentationType.trim()=="Individual"){
            $scope.presenter = presenterName;
        }else if(presentationType=="Group"){
            $scope.presenter = listofGroupPresenters;
        }else{
            $scope.presenter = course+"-"+sectionNum;
        }

        $scope.presentationType = presentationType;
        $scope.SectionNumber = sectionNum;
        $scope.course = course;
        $scope.topic = pTopic;*/
        /*var info = {
            courseName: courseName,
            sectionNumber: section,
            presentationType: presentationType,
            presenterName: presenterName,
            topicName: topic,

        };*/
        var info = {
            assignmentId : assignmentid
        };

        console.log(info);
      /*  Object.toparams = function ObjecttoParams(obj) {
            var p = [];
            for (var key in obj) {
                p.push(key + '=' + encodeURIComponent(obj[key]));
            }
            return p.join('&');
        };*/

        $http({
            url: '../../../../GDP_Backend/API/getFeedbackQuestions.php',
            method: "POST",
            data:  info,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
            .then(function (response) {
        /*$http.get('../../../../GDP_Backend/API/getFeedbackQuestions.php?assignmentid='+assignmentid)
            .success(function(response) {*/
        /*$http({
            url: '../../../../GDP_Backend/API/getFeedbackQuestions.php?assignmentid='+assignmentid,
            method: "GET",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
            .then(function (response) {*/
                if (response.data.success == 1) {
                    // var count = parseInt(response.data.section);
                    var questions = [];
                    for(var i in response.data.question){
                        var info = {
                            QuestionId: response.data.question[i].QuestionID,
                            QuestionType : response.data.question[i].QuestionType,
                            QuestionText : response.data.question[i].Question,
                            QuestionResponse: response.data.question[i].Responses,
                        };
                        $scope.questions.push(info);
                    }
                    displayQuestions();

                } else {


                }
                $(document.body).unmask();
            },
            function (response) { // optional
                // failed
            });


    };

    $scope.showQuestions = function () {

        $("#feedbackDIv").show();
        $( ".inner").empty();
        var courseName = $scope.courseModel;
        var section = $scope.updatedSectionModel;
        var presenterName = $scope.updatedPresenterNameModal;
        var topic = $scope.updatedTopicNameModel;

        var info = {
            courseName: courseName,
            sectionNumber: section,
            presenterName: presenterName,
            topicName: topic
        };

        Object.toparams = function ObjecttoParams(obj) {
            var p = [];
            for (var key in obj) {
                p.push(key + '=' + encodeURIComponent(obj[key]));
            }
            return p.join('&');
        };
        $http({
            url: '../../../../GDP_Backend/API/getFeedbackQuestions.php',
            method: "POST",
            data: Object.toparams(info),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
            .then(function (response) {
                if (response.data.success == 1) {
                    // var count = parseInt(response.data.section);
                    var questions = [];
                    for(var i in response.data.question){
                        var info = {
                            QuestionId: response.data.question[i].QuestionID,
                            QuestionType : response.data.question[i].QuestionType,
                            QuestionText : response.data.question[i].Question,
                            QuestionResponse: response.data.question[i].Responses,
                        };
                        $scope.questions.push(info);
                    }
                    displayQuestions();

                } else {


                }
                $(document.body).unmask();
            },
            function (response) { // optional
                // failed
            });


    };

    function displayQuestions(){
        $scope.txtcomment = "";
        console.log($scope.questions);
        document.getElementById("questionsArea").innerHTML = "";
        $( ".inner").empty();
      $( ".inner" ).append("1=Strongly Disagree   5=Strongly Agree<br/>");

        var count = $scope.questions.length;

        for(var i in $scope.questions){

            if($scope.questions[i].QuestionType == "SingleWord"){
                var questionType = $scope.questions[i].QuestionType;
                var question = $scope.questions[i].QuestionText.replace(/ /g, '@@!!@@');
                var q = '&nbsp;&nbsp;&nbsp;<label id=  "singleword'+i+'">'+$scope.questions[i].QuestionText+'</label>&nbsp;&nbsp;&nbsp;';
                if(count>=1){
                    $( ".inner" ).append('</br>')
                }
                $( ".inner" ).append(q +
                        /* "&nbsp;<input type='text' id='singlewordresponse"+i+"'/>" */
                    "&nbsp;<label>Yes<input type='radio' value='Yes' question="+question+" questiontype="+ questionType+"  name='singlewordresponse"+i+"'> &nbsp;</label>" +
                    "&nbsp;<label>No <input type='radio' value='No' question="+question+" questiontype="+questionType+"  name='singlewordresponse"+i+"'>&nbsp;</label>"
                );
                count++;
            }
            if($scope.questions[i].QuestionType == "rating"){

                var questionType = $scope.questions[i].QuestionType;
                var question = $scope.questions[i].QuestionText.replace(/ /g, '@@!!@@');

                var q = '&nbsp;&nbsp;&nbsp;<label id="rating'+i+'">'+$scope.questions[i].QuestionText+'</label>&nbsp;&nbsp;&nbsp;';
                if(count>=1){
                    $( ".inner" ).append('</br>')
                }
                $( ".inner" ).append(q +
                    "&nbsp;<label> 1<input type='radio' value='1' question="+question+" questiontype="+ questionType+" name='ratingresponse"+i+"'> &nbsp;</label>" +
                    "&nbsp;<label>2 <input type='radio' value='2' question="+question+" questiontype="+ questionType+" name='ratingresponse"+i+"'>&nbsp;</label>" +
                    "&nbsp;<label>3 <input type='radio' value='3' question="+question+" questiontype="+ questionType+" name='ratingresponse"+i+"'>&nbsp;</label>" +
                    "&nbsp;<label> 4<input type='radio' value='4' question="+question+" questiontype="+ questionType+"  name='ratingresponse"+i+"'>&nbsp;</label>" +
                    "&nbsp;<label> 5<input type='radio' value='5' question="+question+" questiontype="+ questionType+"  name='ratingresponse"+i+"'>&nbsp;</label>");
            }
            if($scope.questions[i].QuestionType == "MultipleChoice"){

                var questionType = $scope.questions[i].QuestionType;
                var question = $scope.questions[i].QuestionText.replace(/ /g, '@@!!@@');

                var q = '&nbsp;&nbsp;&nbsp;<label id="multiplequestion'+i+'">'+$scope.questions[i].QuestionText+'</label>&nbsp;&nbsp;&nbsp;';
                if(count>=1){
                    $( ".inner" ).append('</br>')
                }
                var ele = "";
                var resp = $scope.questions[i].QuestionResponse.split(",");
                for(var j in resp){
                    // resp[j] = resp[j].replace(/ /g,'@@!!@@');
                    ele+=  "<input type='checkbox' question="+question+" questiontype="+ questionType+" name= 'multipleresponse"+i+"' value="+resp[j].replace(/ /g,'@@!!@@')+"> &nbsp;"+resp[j]+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                }
                $( ".inner" ).append(q+ele);
            }

        }
       /* var q = '<br><br>&nbsp;&nbsp;&nbsp;<b>Your Comments </b><br> ' +
            '&nbsp;&nbsp;&nbsp;<textarea ng-model="txtcomment" id="comments" rows ="6" placeholder="Your Comments" style="width:660px"></textarea>&nbsp;&nbsp;&nbsp;';
        $(".inner").append(q);*/
      /*  var item = '<br><br>&nbsp;&nbsp;&nbsp;<b>Your Comments </b><br> ' +
            '&nbsp;&nbsp;&nbsp; <button class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#feedback" id="submitFeedback" ng-click="submitFeedback()"> Submit </button>&nbsp;&nbsp;&nbsp;';

        $(".inner").append(item);*/

        $scope.questions = [];
    }

});


