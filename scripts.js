var stocks = new Stocks('GFZ0ZX7VRU63YMVX'); // Replace with your own

async function request () {
  var result = await stocks.timeSeries({
    symbol: 'AAPL',
    interval: 'daily',
    amount: 1  
   });

   document.body.innerHTML = JSON.stringify(result);
}

request();
