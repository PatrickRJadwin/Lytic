var finalData3;
var chart;
var data;
var options;
var time = 10;
var urlStrt = 'https://api.iextrading.com/1.0/stock/';
var urlEnd = '/chart/1d';
var valid;

function Get(yourUrl) {
  var Httpreq = new XMLHttpRequest(); // a new request
  Httpreq.open("GET", yourUrl, false);
  Httpreq.send(null);
  return Httpreq.responseText;
}

async function request(stock) {
  var url = 'https://api.iextrading.com/1.0/stock/' + stock + '/quote';
  var url2 = urlStrt + stock + urlEnd;
  var srchbx = document.getElementById("srchbx")
  try {
    var finalData = JSON.parse(Get(url));
    var finalData2 = JSON.parse(Get(url2));
  } catch (e) {
    valid = false;
    srchbx.classList.add("is-invalid");
    setTimeout(function(){ srchbx.classList.remove("is-invalid") }, 2000);
    return;
  }
  valid = true;
  var finalDataLngth = finalData2.length - 1;
  var sector = " / " + finalData['sector'];
  var goodValue = true;
  var realClosing;
  while (goodValue == true) {
    if (urlEnd == '/chart/1d') {
      realClosing = finalData2[finalDataLngth]['close'].toFixed(2);
    }
    else {
      realClosing = finalData2[finalDataLngth]['close'].toFixed(2);
    }
    if (realClosing == -1) {
      finalDataLngth -= 1;
    } else {
      goodValue = false;
    }
  }

  document.getElementById("closing").innerHTML = realClosing;
  document.getElementById("symbol").innerHTML = finalData['symbol'];
  document.getElementById("stckName").innerHTML = finalData['companyName'];
  if (sector != "") {
    document.getElementById("sector").innerHTML = sector;
  }

  if (finalData['change'] > 0) {
    document.getElementById("txtColor").style.color = "green";
    document.getElementById("arrow").className = "ion ion-md-arrow-dropup-circle display-4 text-primary";
  } else {
    document.getElementById("txtColor").style.color = "red";
    document.getElementById("arrow").className = "ion ion-md-arrow-dropdown-circle display-4 text-primary";
  }

  document.getElementById("pointChng").innerHTML = finalData['change'];
  document.getElementById("percChng").innerHTML = finalData['changePercent'];

  if (finalData['ytdChange'] > 0) {
    document.getElementById("ytdColor").style.color = "green";
    document.getElementById("ytd").innerHTML = '+' + finalData['ytdChange'].toFixed(2);
  } else {
    document.getElementById("ytdColor").style.color = "red";
    document.getElementById("ytd").innerHTML = finalData['ytdChange'].toFixed(2);
  }

  document.getElementById("preClose").innerHTML = finalData['close'].toFixed(2);
  finalData3 = JSON.parse(Get(url2));
  google.charts.load('current', {
    'packages': ['line']
  });
  google.charts.setOnLoadCallback(drawChart);
}

function drawChart() {
  data = new google.visualization.DataTable();
  data.addColumn('string', '');
  data.addColumn('number', 'Price');
  var arr = [];
  var timearr = [];
  if (urlEnd == '/chart/1d') {
    for (var i = 0; i < finalData3.length; i += time) {
      var prevValue = finalData3[i]['average'];
      if (prevValue != -1) {
        break;
      }
    }
    for (var i = 0; i < finalData3.length; i += time) {
      if (finalData3[i]['average'] != -1) {
        arr.push([finalData3[i]['minute'], finalData3[i]['average']]);
        prevValue = finalData3[i]['average'];
      } else {
        arr.push([finalData3[i]['minute'], prevValue]);
      }

    }
  }
  if (urlEnd == '/chart/1m' || urlEnd == '/chart/1y') {
    for (var i = 0; i < finalData3.length; i += time) {
      var prevValue = finalData3[i]['close'];
      if (prevValue != -1) {
        break;
      }
    }
    for (var i = 0; i < finalData3.length; i += time) {
      if (finalData3[i]['close'] != -1) {
        arr.push([finalData3[i]['label'], finalData3[i]['close']]);
        prevValue = finalData3[i]['close'];
      } else {
        arr.push([finalData3[i]['label'], prevValue]);
      }
    }
  }

  data.addRows(arr);

  var options = {
    legend: {
      position: 'right'
    },
    axes: {
      x: {
        0: {
          side: 'bottom'
        }
      }
    }
  };

  chart = new google.charts.Line(document.getElementById('curve_chart'));

  chart.draw(data, google.charts.Line.convertOptions(options));
}

var sessionStock = 'AAPL';

request(sessionStock);

function clickChange(newStock, increment) {
  request(newStock);
  sessionStock = newStock;
}

function search() {
  var srch = document.getElementById("srchbx").value
  request(srch);
  if (valid === true) {
    sessionStock = srch;
  } else {
    return;
  }
}

function timeChng(chng, increment) {
  if (increment == 'year') {
    urlEnd = '/chart/1y';
  }
  else if (increment == 'month') {
    urlEnd = '/chart/1m';
  }
  else {
    urlEnd = '/chart/1d';
  }
  time = chng;
  request(sessionStock);
}

$(window).resize(function() {
  chart.draw(data, google.charts.Line.convertOptions(options));
});

function addStock() {
  $.ajax({
    type: "POST",
    url: "php/newStock.php",
    data: {
      newStk: sessionStock
    }
  }).done(function(msg) {
    var stk = sessionStock;
    location.reload();
    request(stk);
  });
}

$(window).on('load', function() { // makes sure the whole site is loaded
  $('#status').fadeOut(); // will first fade out the loading animation
  $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
  $('body').delay(350).css({'overflow':'visible'});
})
