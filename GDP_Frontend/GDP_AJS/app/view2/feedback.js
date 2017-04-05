/**
 * Created by S522626 on 11/29/2015.
 */
$(document).ready(function()
{



});


// declare a module
var app = angular.module('feedbackApp',[]);
/*app.controller('TabController', function () {
 //alert("hil;l;");
 this.tab = 1;

 this.setTab = function (tabId) {
 this.tab = tabId;
 };

 this.isSet = function (tabId) {
 return this.tab === tabId;
 };
 });*/

// add the controller's constructor function to the module
app.controller('FeedbackController', function ($scope,$http){

    $scope.courses=[];
    $scope.sections = [];
    $scope.questions = [];

    var userID =  $('#userID').text().trim();
    var sectionArr =[];
    $http.get('../../../../GDP_Backend/API/getAllSections.php').success( function(response) {

        var json_result = response;
        var tempCourse = [];

        var courseSections = [];
        var courseSection = {};
        var tsections = [];
        var tsection = {};

        for(var i in json_result.section){
            courseSection[json_result.section[i].CourseID] = json_result.section[i].CourseName;
        }

        for (var key in  courseSection){
            var courses = {
                courseId : key,
                courseName :  courseSection[key]
            };
            tempCourse.push(courses);
        }

        $scope.courses = tempCourse;
        $scope.apply;

        var courses = Object.keys(courseSection);

        courseSection={};

        for( var i in courses){
            for (var j in json_result.section){
                if(json_result.section[j].CourseID == courses[i]){
                    tsection.section = json_result.section[j].SectionNumber;
                    tsections.push(tsection);
                    tsection = {};
                }
            }
            courseSection.courseId = courses[i];
            courseSection.sections = tsections;
            tsections = [];
            courseSections.push(courseSection);
            courseSection = {};
        }

        $scope.sections = courseSections;

        $scope.apply;


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

    Object.toparams = function ObjecttoParams(obj) {
        var p = [];
        for (var key in obj) {
            p.push(key + '=' + encodeURIComponent(obj[key]));
        }
        return p.join('&');
    };

    $scope.topicNames = [];

    // filtered value
    $scope.updatedSection = [];
    $scope.updatedPresenterNames = [];
    $scope.updatedTopicNames = [];

    $scope.presenterNames =[];

    // update section based on selection of course
    $scope.updateSection = function(){




        $scope.updatedSection=[];
// iterating array
        angular.forEach($scope.sections, function(value, index) {
            if(value.courseId == $scope.courseModel){
                $scope.updatedSection.push(value.sections);
            }
        });
        $scope.updatedSection= $scope.updatedSection[0];





    };




    $scope.updatePresenterName = function(){


        $(document.body).mask('loading ...');

        var info = {
            'Course' : $scope.courseModel,
            'Section' : $scope.updatedSectionModel
        };

        $http({
            url: '../../../../GDP_Backend/API/assignment.php',
            method: "POST",
            data: Object.toparams(info),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
            .then(function(response) {
                if (response.data.success == 1) {

                    var noOfAssignments = response.data.assignment.length;
                    var sectionObj = [];
                    for(var i =0; i<noOfAssignments;i++){
                        var studentsCount = response.data.assignment[i].StudentList.split(",").length;
                        for(var j=0; j< studentsCount;j++) {
                            sectionObj.push(
                                {
                                    PresenterId: response.data.assignment[i].StudentList.split(",")[j],
                                    PresenterName: response.data.assignment[i].StudentNames.split(",")[j],
                                    Presenter: response.data.assignment[i].StudentList.split(",")[j],
                                    TopicName: response.data.assignment[i].TopicName,
                                    AssignmentType:response.data.assignment[i].AssignmentType

                                })
                        }
                    }
                    $scope.presenterNames.push(
                        {
                            section: info.Section,
                            presenters : sectionObj
                        }
                    );

                    console.log("loading......");
                    console.log($scope.presenterNames);
                    for (var i =0 ; i< $scope.presenterNames[0].presenters.length; i++){
                        var presenterId = $scope.presenterNames[0].presenters[i].PresenterId;
                        var topicNameObj = $scope.presenterNames[0].presenters[i].TopicName;

                        var alreadyExists = false;
                        var count =0;
                        for( var j=0; j< $scope.topicNames.length ;j++) {
                            insideForLoop = true;
                            if ($scope.topicNames[j]["presenterId"] == presenterId) {
                                alreadyExists = true;
                                count =j;
                                $scope.topicNames[j]["topicNames"].push({topicName: topicNameObj});
                            }
                        }
                        if(alreadyExists){
                            $scope.topicNames[count]["topicNames"].push({topicName: topicNameObj});
                        }
                        else{
                            $scope.topicNames.push({presenterId: presenterId, topicNames: [{topicName: topicNameObj}]})
                        }
                        alreadyExists = false;
                    }
                }else {

                }

                $scope.updatedPresenterNames = [];
                //iterating array
                angular.forEach($scope.presenterNames, function(value, index){

                    if(value.section == $scope.updatedSectionModel){

                        var presentes = {};
                        angular.forEach(value.presenters, function(value1, index1){

                            presentes[value1.PresenterId] = "1"

                        });

                        var tempPresenters = [];
                        var presentsArr = Object.keys(presentes);
                        var presenternames = {};
                        angular.forEach(value.presenters, function(value2, index2){
                        if(presenternames[value2.PresenterId] != "1") {
                            presenternames[value2.PresenterId] = "1";
                            tempPresenters.push({PresenterId: value2.PresenterId, Presenter: value2.PresenterName})
                        }

                        });

                        $scope.updatedPresenterNames.push(tempPresenters);
                    }

                });

                $scope.updatedPresenterNames = $scope.updatedPresenterNames[0];

               // $scope.updatedSectionModel = "";
                $scope.$apply;

            },
            function(response) { // optional
                // failed
            });


        $(document.body).unmask();



    };



    $scope.updateTopicName = function (){



        $scope.updatedTopicNames = [];

        //iterating array
        angular.forEach($scope.topicNames, function(value, index){

            if(value.presenterId == $scope.updatedPresenterNameModal){


                var topics = {};
                angular.forEach(value.topicNames, function(value1, index1){

                    topics[value1.topicName] = "1"

                });

                var tempTopics = [];
                var topicsArr = Object.keys(topics);

                angular.forEach(topicsArr, function(value2, index2){

                    tempTopics.push({topicName : value2})

                });


                $scope.updatedTopicNames.push(tempTopics);
            }

        });

        $scope.updatedTopicNames = $scope.updatedTopicNames[0];

       // $scope.updatedPresenterNameModal = "";
        $scope.$apply;



    };

        $scope.submitFeedback = function(){




       /* var question1 = $("#singleword0").val();
        var response1 = $("#singlewordresponse0").val();
        var question2 = $("#rating1").val();
        var response2 = $("#rate1").val();
        var question3 = $("#multiplequestion2").val();
        var response3 = $("#multipleresponse2").val();
        var question4 = $("#multiplequestion3").val();
        var response4 = $("#multipleresponse3").val();
        var question5 = $("#singleword4").val();
        var response5 = $("#singlewordresponse4").val();
        alert(question1+response1);*/

        var totalValue = {};
        var response = {};
        var feedbackresponse = [];

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

                response.PresentationName = $scope.updatedPresenterNameModal;
                response.Question = ratingQuestions[i].getAttribute('question');
                response.QuestionType = ratingQuestions.attr('questiontype');
                response.QuestionResponse = ratingQuestions[i].value;


                feedbackresponse.push(response);
                response={};

            }

        }


            for(var i=0; i< mutlipleResponseQuestions.length; i++){


            if(mutlipleResponseQuestions[i].checked){

                response.PresentationName = $scope.updatedPresenterNameModal;
                response.Question = mutlipleResponseQuestions[i].getAttribute("question");
                response.QuestionType = mutlipleResponseQuestions.attr("questiontype");
                response.QuestionResponse = mutlipleResponseQuestions[i].value;
                feedbackresponse.push(response);
                response={};

            }

        }

        for(var i=0; i< singlewordQuestions.length; i++){

            if(singlewordQuestions[i].checked){

                response.PresentationName = $scope.updatedPresenterNameModal;
                response.Question = singlewordQuestions[i].getAttribute("question");
                response.QuestionType = singlewordQuestions.attr("questiontype");
                response.QuestionResponse = singlewordQuestions[i].value;
                feedbackresponse.push(response);
                response={};

            }

        }


        totalValue.assignments=feedbackresponse;
        totalValue.topicName = $scope.updatedTopicNameModel;
            totalValue.courseId = $scope.courseModel;

        totalValue.StudentID = userID;
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
        console.log($scope.questions);
      document.getElementById("questionsArea").innerHTML = "";
        $( ".inner").empty();
      $( ".inner" ).append("1=Strongly Disagree   5=Strongly Agree<br/>");

        var count = $scope.questions.length;

        for(var i in $scope.questions){

            if($scope.questions[i].QuestionType == "SingleWord"){
                var questionType = $scope.questions[i].QuestionType;
                var question = $scope.questions[i].QuestionText.replace(/ /g, '@@!!@@');
                var q = '<label id=  "singleword'+i+'">'+$scope.questions[i].QuestionText+'</label>&nbsp;&nbsp;&nbsp;';
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

                var q = '<label id="rating'+i+'">'+$scope.questions[i].QuestionText+'</label>&nbsp;&nbsp;&nbsp;';
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

                var q = '<label id="multiplequestion'+i+'">'+$scope.questions[i].QuestionText+'</label>&nbsp;&nbsp;&nbsp;';
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

        $scope.questions = [];
    }

});


