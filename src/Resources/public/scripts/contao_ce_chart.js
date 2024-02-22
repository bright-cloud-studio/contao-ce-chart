var ctx = document.getElementById('myChart'); // node
var ctx = document.getElementById('myChart').getContext('2d'); // 2d context
var ctx = $('#myChart'); // jQuery instance
var ctx = 'myChart'; // element id

var myChart = new Chart(ctx, {
  type: 'line',
  data: {/* Data here */},
  options: {/* Options here */}
});
