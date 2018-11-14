var finalData3;
var chart;
var data;
var options;
var name;

function Get(yourUrl){
    var Httpreq = new XMLHttpRequest(); // a new request
    Httpreq.open("GET",yourUrl,false);
    Httpreq.send(null);
    return Httpreq.responseText;
}

async function request(stock) {
   var url = 'https://api.iextrading.com/1.0/stock/' + stock + '/quote';
   var url2 = 'https://api.iextrading.com/1.0/stock/' + stock + '/chart/1d';
   var finalData = JSON.parse(Get(url));
   var finalData2 = JSON.parse(Get(url2));
   var finalDataLngth = finalData2.length - 1;
   var sector = " / " + finalData['sector'];

   document.getElementById("closing").innerHTML = finalData2[finalDataLngth]['average'].toFixed(2);
   document.getElementById("symbol").innerHTML = finalData['symbol'];
   document.getElementById("stckName").innerHTML = finalData['companyName'];
   name = finalData['companyName'].replace(/.Inc\./g, "");;

   if (sector != "") {
     document.getElementById("sector").innerHTML = sector;
   }

   if (finalData['change'] > 0) {
      document.getElementById("txtColor").style.color = "green";
      document.getElementById("arrow").className = "ion ion-md-arrow-dropup-circle display-4 text-primary";
   }

   else {
      document.getElementById("txtColor").style.color = "red";
      document.getElementById("arrow").className = "ion ion-md-arrow-dropdown-circle display-4 text-primary";
   }

   document.getElementById("pointChng").innerHTML = finalData['change'];
   document.getElementById("percChng").innerHTML = finalData['changePercent'];

   if (finalData['ytdChange'] > 0) {
     document.getElementById("ytdColor").style.color = "green";
     document.getElementById("ytd").innerHTML = '+' + finalData['ytdChange'].toFixed(2);
   }

   else {
     document.getElementById("ytdColor").style.color = "red";
     document.getElementById("ytd").innerHTML = finalData['ytdChange'].toFixed(2);
   }

   document.getElementById("preClose").innerHTML = finalData['close'].toFixed(2);
   //document.getElementById("open").innerHTML = finalData['open'];
   finalData3 = JSON.parse(Get(url2));
   console.log(typeof finalData3['0']['minute']);
   google.charts.load('current', {'packages':['line']});
   google.charts.setOnLoadCallback(drawChart);
}

function drawChart() {
   data = new google.visualization.DataTable();
   data.addColumn('string', '');
   data.addColumn('number', '');
   var arr = [];
   var timearr = [];
   for (var i = 0; i < finalData3.length; i += 10) {
      arr.push([finalData3[i]['minute'], finalData3[i]['average']]);
   }
   data.addRows(arr);

   options = {
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

   chart = new google.charts.Line(document.getElementById('curve_chart'));

   chart.draw(data, google.charts.Line.convertOptions(options));
}

function chngTwt(stock) {
  var twitURL = "https://twitter.com/";
  var profile = twitURL + stock;
  console.log(name);
  document.getElementById("twitter").href = profile;

}

chngTwt(name);

var sessionStock = 'AAPL';

request(sessionStock);

function clickChange(newStock) {
  request(newStock);
  sessionStock = newStock;
  chngTwt(name);
}

function search() {
  var srch = document.getElementById("srchbx").value
  request(srch);
  chngTwt(name);
}

$(window).resize(function(){
    chart.draw(data, google.charts.Line.convertOptions(options));
});
