<script>
var ctx = document.getElementById("graph4").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        },

            {
                label: '# of Votes2',
                data: [24,38, 6, 10, 4, 6],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            },


        ]
    },
    options: {
        title: {
            display: true,
            text: 'KDA',
            fontColor: 'white'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    },



    onClick:function(e){
        /*var activePoints = myChart.getElementsAtEvent(e);
        var selectedIndex = activePoints[0]._index; */
        /* alert(this.data.datasets[0].data[selectedIndex]);
        console.log(this.data.datasets[0].data[selectedIndex]);
        */
    }
});

/* https://github.com/chartjs/Chart.js/issues/2292 */
document.getElementById("graph4").onclick = function (evt) {
    var activePoints = myChart.getElementsAtEventForMode(evt, 'point', myChart.options);
    var firstPoint = activePoints[0];
    var label = myChart.data.labels[firstPoint._index];
    var value = myChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
    alert(label + ": " + value);
};
</script>