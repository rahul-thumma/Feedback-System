/**
 * Created by S522626 on 12/10/2015.
 */

var myApp = angular.module('myApp',['chart.js']).controller('ViewFeedbackController', function($scope, $http) {

    var userID = $('#userID').text().trim();
    Object.toparams = function ObjecttoParams(obj) {
        var p = [];
        for (var key in obj) {
            p.push(key + '=' + encodeURIComponent(obj[key]));
        }
        return p.join('&');
    };

    var info = {
        'StudentID': userID
    };

    $scope.questions = [];

    $scope.commentsData = [];


    $scope.labels = ['1', '2', '3'];
    $scope.series = ['Series A'];
    $scope.data = [[300, 500, 100]];


    $scope.barFlag = false;
    $scope.pieFlag = false;
    $scope.dummyFlag = false;

    $scope.responseData = [];


    $scope.selectedTopicName = "";
    $scope.showFeedback = function (topicName) {


        $scope.pieFlag = false;
        $scope.barFlag = false;
        $scope.dummyFlag = false;


        $(".js-example-basic-multiple").select2(
            {
                data: []
            });
        //$(".js-example-basic-multiple").val(null).trigger("change");


        $scope.selectedTopicName = topicName;

        var questions = {};

        for (var i = 0; i < $scope.responseData.length; i++) {
            if ($scope.responseData[i].TopicName == $scope.selectedTopicName) {

                if($scope.responseData[i].QuestionType != "Comment")
                    questions[$scope.responseData[i].Question] = $scope.responseData[i].QuestionType;
                else if($scope.responseData[i].QuestionType == "Comment")
                {
                    $scope.commentsData.push($scope.responseData[i].QuestionResponse);
                }
            }

        }

        var myQuestion = [];

        var questionsArr = Object.keys(questions);

        for (var i = 0; i < questionsArr.length; i++) {

            myQuestion.push({

                Question: questionsArr[i],
                QuestionType: questions[questionsArr[i]]


            })
        }

        $scope.questions = myQuestion;
        $('#details').modal('show');


    };

    $scope.feedbacks = [];
    $http({
        url: '../../../../GDP_Backend/API/getStudentFeedback.php?StudentID=' + userID,
        method: "GET",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
        .then(function (response) {
                if (response.data.success == 1) {

                    $scope.responseData = response.data.feedback;

                    var myFeedbacks = {};
                    var questions = {};

                    for (var i = 0; i < response.data.feedback.length; i++) {


                        myFeedbacks[response.data.feedback[i].TopicName] = response.data.feedback[i].CourseID;


                        if (response.data.feedback[i].TopicName == $scope.selectedTopicName) {
                            questions[response.data.feedback[i].Question] = response.data.feedback[i].QuestionType
                        }

                    }

                    var myQuestion = [];

                    var questionsArr = Object.keys(questions);

                    for (var i = 0; i < questionsArr.length; i++) {

                        myQuestion.push({

                            Question: questionsArr[i],
                            QuestionType: questions[questionsArr[i]]


                        })
                    }

                    var topicName = Object.keys(myFeedbacks);

                    var Feedbacks = [];

                    for (var i = 0; i < topicName.length; i++) {

                        Feedbacks.push({

                            "CourseID": myFeedbacks[topicName[i]],
                            "TopicName": topicName[i]

                        });

                    }

                    $scope.feedbacks = Feedbacks;

                    $scope.questions = myQuestion;

                } else {

                    // alert('There are no assignments under selected course and section'); //TODO change to new UI

                }

            },
            function (response) { // optional
                // failed
            });


    function processJson(jsonObject){



    }

    $scope.updateQuestion = function (){


        console.log($scope.selectedQuestionModel);

        var one=0,two=0,three=0,four=0,five=0;
        var yes=0,no=0;
        $scope.data1=[0,0];
        document.getElementById("doughnut").innerHTML ="";
        document.getElementById("doughnut1").innerHTML ="";
        document.getElementById("bar").innerHTML ="";
        for (var i =0 ; i< $scope.responseData.length ;i++){

            if($scope.responseData[i].TopicName == $scope.selectedTopicName && $scope.responseData[i].Question == $scope.selectedQuestionModel && ($scope.responseData[i].QuestionType == "rating" || $scope.responseData[i].QuestionType == "MultipleChoice")){

                if($scope.responseData[i].QuestionResponse == "1"){

                    one++;

                }if($scope.responseData[i].QuestionResponse == "2"){

                    two++;

                }if($scope.responseData[i].QuestionResponse == "3"){
                    three++;

                }if($scope.responseData[i].QuestionResponse == "4"){

                    four++;

                }if($scope.responseData[i].QuestionResponse == "5"){

                    five++;
                }
                $scope.barFlag = true;
                $scope.pieFlag = false;
                $scope.dummyFlag = false;
                $scope.labels=["one","two","three","four","five"];
                $scope.series = ['Series A'];
                $scope.data=[];
                $scope.data = [[one, two, three,four,five]];

            } else if($scope.responseData[i].TopicName == $scope.selectedTopicName && $scope.responseData[i].Question == $scope.selectedQuestionModel && $scope.responseData[i].QuestionType == "SingleWord") {

                if($scope.responseData[i].QuestionResponse == "No"){

                    no++;

                }else if($scope.responseData[i].QuestionResponse == "Yes"){

                    yes++;
                }
                $scope.pieFlag = true;
                $scope.barFlag = false;
                $scope.dummyFlag = true;
                $scope.labels1=["no","yes"];
                $scope.labels=["no","yes"];
                $scope.data=[no,yes];

            }

        }

    }



});