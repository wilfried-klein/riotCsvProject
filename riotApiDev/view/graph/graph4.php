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
        labels: [
            <?php
                for ($i=1 ; $i<=count($result) ; $i++) {
                    echo "\"" . "Game " . $i . "\"" ;
                    echo ",";
                }
            ?>
        ],
        datasets: [{
            label: "KDA",
            pointBackgroundColor: chartColors.red,
            data: [
                <?php
                    foreach ($kdapergame as $kda) {
                        echo number_format($kda, 2);
                        echo ",";
                    }
                ?>
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
            angleLines: {
                color: 'white'
            },
            yAxes: [{
                gridLines: {
                    color: 'rgba(255, 255, 255, 0.2)'
                },
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    },


    onClick:function(e){

    }
});

document.getElementById("graph4").onclick = function (evt) {
    var activePoints = myChart.getElementsAtEventForMode(evt, 'point', myChart.options);
    var firstPoint = activePoints[0];
    var label = myChart.data.labels[firstPoint._index];
    var value = myChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
    alert(label + ": " + value);
};
</script>