
var finalData;
var stock = 'TSLA';
var url = 'https://api.iextrading.com/1.0/stock/' + stock + '/chart/1d';

function Get(yourUrl){
    var Httpreq = new XMLHttpRequest(); // a new request
    Httpreq.open("GET",yourUrl,false);
    Httpreq.send(null);
    return Httpreq.responseText;
}

async function request () {
   finalData = JSON.parse(Get(url));
   console.log(typeof finalData['0']['minute']);
   google.charts.load('current', {'packages':['line']});
   google.charts.setOnLoadCallback(drawChart);
}

function drawChart() {

   var data = new google.visualization.DataTable();
   data.addColumn('string', '');
   data.addColumn('number', '');
   var arr = [];
   var timearr = [];
   for (var i = 0; i < finalData.length; i += 10) {
      arr.push([finalData[i]['minute'], finalData[i]['average']]);
   }
   data.addRows(arr);

   var options = {
     legend: {
       position: 'none'
     },
     axes: {
        x: {
           0: {side: 'top'}
        }
     },
     width: '100%',
     height: '100%'
   };

   var chart = new google.charts.Line(document.getElementById('curve_chart'));

   chart.draw(data, google.charts.Line.convertOptions(options));
}

request();
