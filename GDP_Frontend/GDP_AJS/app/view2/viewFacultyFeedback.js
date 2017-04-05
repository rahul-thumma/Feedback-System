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
    $("#singleword").hide();
    $("#legend").hide();
    $("#rating").hide();

    $scope.responseData = [];
    $scope.responseAll = [];

    $scope.selectedTopicName = "";
    $scope.showFeedback = function (topicName,courseID,presentationName) {

        $scope.pieFlag = false;
        $scope.barFlag = false;
        $scope.dummyFlag = true;
        $scope.commentsData = [];

        $(".js-example-basic-multiple").select2(
            {
                data: []
            });

        //$(".js-example-basic-multiple").val(null).trigger("change");

        $scope.selectedTopicName = topicName;

        var myQuestion = [];
        var questions = {};
        var feeddata = [];
        for (var i = 0,j=0; i <  $scope.responseAll.length; i++) {
            if($scope.responseAll[i].PresentationName == presentationName && $scope.responseAll[i].TopicName == topicName &&
                $scope.responseAll[i].CourseID == courseID) {
                if($scope.responseAll[i].QuestionType != "Comment")
                    questions[$scope.responseAll[i].Question] = $scope.responseAll[i].QuestionType;
                else if($scope.responseAll[i].QuestionType == "Comment")
                {
                    $scope.commentsData.push($scope.responseAll[i].QuestionResponse);
                }

                feeddata[j] = $scope.responseAll[i];
                j++;
            }

        }
        $scope.responseData = feeddata;
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
        url: '../../../../GDP_Backend/API/getAllFeedback.php',
        method: "GET",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
        .then(function (response) {
                if (response.data.success == 1) {
                    $scope.responseData = response.data.feedback;
                    $scope.feedbacks = $scope.responseData;
                } else {

                    // alert('There are no assignments under selected course and section'); //TODO change to new UI
                }
            },
            function (response) { // optional
                // failed
            });

    $http({
        url: '../../../../GDP_Backend/API/getFeedback.php',
        method: "GET",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
        .then(function (response) {
                if (response.data.success == 1) {

                    $scope.responseAll = response.data.feedback;

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
        $scope.data = [[]];
        $scope.labels = [];
        document.getElementById("doughnut").innerHTML ="";
        document.getElementById("doughnut1").innerHTML ="";
        document.getElementById("bar").innerHTML ="";

        for (var i =0 ; i< $scope.responseData.length ;i++){

            if($scope.responseData[i].Question == $scope.selectedQuestionModel && ($scope.responseData[i].QuestionType == "rating" || $scope.responseData[i].QuestionType == "MultipleChoice")){

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

                $scope.series = ['Series A'];


            } else if($scope.responseData[i].Question == $scope.selectedQuestionModel && $scope.responseData[i].QuestionType == "SingleWord") {

                if($scope.responseData[i].QuestionResponse == "No"){

                    no++;

                }else if($scope.responseData[i].QuestionResponse == "Yes"){

                    yes++;
                }
                $scope.pieFlag = true;
                $scope.barFlag = false;

            }

        }
         if($scope.barFlag == true){
            $("#singleword").hide();
            $("#legend").hide();
            $("#rating").show();
            $scope.data = [[one, two, three,four,five]];
            $scope.labels=["one","two","three","four","five"];
            $scope.labels1=[];
            $scope.dummyFlag = false;
        }else if( $scope.pieFlag == true){
            $("#singleword").show();
            $("#legend").show();
            $("#rating").hide();
            $scope.data=[no,yes];
            $scope.labels=["no","yes"];
            $scope.labels1=["no","yes"];
            $scope.dummyFlag = true;
        }

    }



});