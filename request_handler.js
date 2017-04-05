/**
 * Created by sahitya_pasnoor on 11/4/15.
 */

var BASE_URL ="http://feedbacksys-nwmissouri.rhcloud.com/";
function callService() {
    $.ajax({
        url: BASE_URL+'DataProcessor.php',

        type: 'get',
        success: function (output) {
            var json_result = JSON.parse(output);

            drawLineChart(json_result);
            drawPieChart(json_result);
            drawBarChart(json_result);


        }
    });
}

function drawLineChart(json_result) {
    var data = new google.visualization.DataTable();
    data.addColumn(json_result.Axis.date, Object.keys(json_result.Axis)[0]);
    data.addColumn(json_result.Axis.rating, Object.keys(json_result.Axis)[1]);
    var dataCh = [[]];

    for (var i = 0; i < json_result.Data.length; i++) {
        var arr = new Array(2);

        arr[0] = json_result.Data[i].date;
        arr[1] = json_result.Data[i].rate;
        dataCh.push(arr);
    }
    //Removing first empty element from 2d array
    dataCh.shift();
    data.addRows(dataCh);

    // Set chart options
    var options = {
        'title': json_result.Message,

        hAxis: {
            title: 'Date Presented'
        },
        vAxis: {
            title: 'Rating'
        },
        backgroundColor: '#f1f8e9'
    };

    // Instantiate and draw our chart, passing in some options.
    //var chart = new google.visualization.PieChart(document.getElementById('chart_div'));

    var chart = new google.visualization.LineChart(document.getElementById('chart_div_line'));
    chart.draw(data, options);

}

function drawPieChart(json_result) {
    var data = new google.visualization.DataTable();
    data.addColumn(json_result.Axis.date, Object.keys(json_result.Axis)[0]);
    data.addColumn(json_result.Axis.rating, Object.keys(json_result.Axis)[1]);
    var dataCh = [[]];

    for (var i = 0; i < json_result.Data.length; i++) {
        var arr = new Array(2);

        arr[0] = json_result.Data[i].date;
        arr[1] = json_result.Data[i].rate;
        dataCh.push(arr);
    }
    //Removing first empty element from 2d array
    dataCh.shift();
    data.addRows(dataCh);

    // Set chart options
    var options = {
        'title': json_result.Message,
        'width': 400,
        'height': 300
    };

    // Instantiate and draw our chart, passing in some options.
    //var chart = new google.visualization.PieChart(document.getElementById('chart_div'));

    var chart = new google.visualization.PieChart(document.getElementById('chart_div_pie'));
    chart.draw(data, options);

}


function drawBarChart(json_result) {
    var data = new google.visualization.DataTable();
    data.addColumn(json_result.Axis.date, Object.keys(json_result.Axis)[0]);
    data.addColumn(json_result.Axis.rating, Object.keys(json_result.Axis)[1]);
    var dataCh = [[]];

    for (var i = 0; i < json_result.Data.length; i++) {
        var arr = new Array(2);

        arr[0] = json_result.Data[i].date;
        arr[1] = json_result.Data[i].rate;
        dataCh.push(arr);
    }
    //Removing first empty element from 2d array
    dataCh.shift();
    data.addRows(dataCh);

    // Set chart options
    var options = {
        'title': json_result.Message,
        'width': 400,
        'height': 300
    };

    // Instantiate and draw our chart, passing in some options.
    //var chart = new google.visualization.PieChart(document.getElementById('chart_div'));

    var chart = new google.visualization.BarChart(document.getElementById('chart_div_bar'));
    chart.draw(data, options);

}
function loadCharts() {

    callService();
}



