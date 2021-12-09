<?php
foreach ($result as $key => $value) {
    $kdapergame[]=($value['kills']+$value['assists'])/max(1,$value['deaths']);
}
$highest = number_format(max($kdapergame), 2);
?>
<script>

var ctx = document.getElementById("graph4").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Game 1", "Game 2", "Game 3", "Game 4", "Game 5", "Game 6", "Game 7", "Game 8", "Game 9", "Game 10", "Game 11", "Game 12", "Game 13", "Game 14", "Game 15", "Game 16", "Game 17", "Game 18", "Game 19", "Game 20"],
        datasets: [{
            label: "KDA",
            pointBackgroundColor: chartColors.red,
            data: [
                <?php echo number_format($kdapergame[0], 2) ?>,
                <?php echo number_format($kdapergame[1], 2) ?>,
                <?php echo number_format($kdapergame[2], 2) ?>,
                <?php echo number_format($kdapergame[3], 2) ?>,
                <?php echo number_format($kdapergame[4], 2) ?>,
                <?php echo number_format($kdapergame[5], 2) ?>,
                <?php echo number_format($kdapergame[6], 2) ?>,
                <?php echo number_format($kdapergame[7], 2) ?>,
                <?php echo number_format($kdapergame[8], 2) ?>,
                <?php echo number_format($kdapergame[9], 2) ?>,
                <?php echo number_format($kdapergame[10], 2) ?>,
                <?php echo number_format($kdapergame[11], 2) ?>,
                <?php echo number_format($kdapergame[12], 2) ?>,
                <?php echo number_format($kdapergame[13], 2) ?>,
                <?php echo number_format($kdapergame[14], 2) ?>,
                <?php echo number_format($kdapergame[15], 2) ?>,
                <?php echo number_format($kdapergame[16], 2) ?>,
                <?php echo number_format($kdapergame[17], 2) ?>,
                <?php echo number_format($kdapergame[18], 2) ?>,
                <?php echo number_format($kdapergame[19], 2) ?>
            ],
            backgroundColor: [
                <?php
                foreach ($kdapergame as $kda){
                    if(number_format($kda, 2)==$highest){
                        echo "'rgba(75, 192, 192, 0.2)'";
                    }else{
                        echo "'rgba(255, 99, 132, 0.2)'";
                    }
                    echo ",";
                }
                ?>

            ],
            borderColor: [
                <?php
                foreach ($kdapergame as $kda){
                    if(number_format($kda, 2)==$highest){
                        echo "'rgba(39, 253, 255, 1)'";
                    }else{
                        echo "'rgba(255,99,132,1)'";
                    }
                    echo ",";
                }
                ?>
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