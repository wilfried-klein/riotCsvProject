<script>

    var chartColors = {
        blue: 'rgb(54, 162, 235)'
    };

    var ctx = document.getElementById("graph5");

    var data = {
        labels: [
        <?php
        for ($i=1 ; $i<=count($result) ; $i++) {
            echo "\"" . "Game " . $i . "\"" ;
            echo ",";
        }
        ?>
        ],
        datasets: [
        {
            label: "Durée de la partie",
            fill: false,
            lineTension: 0,
            borderColor: chartColors.blue,
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: chartColors.blue,
            pointBackgroundColor: chartColors.blue,
            pointBorderWidth: 5,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: chartColors.blue,
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: [
            <?php
            foreach ($result as $gameData) {
                echo Util::msInMinAndSec($gameData['gameDuration'],'%u.%02u').",";

            }
            ?>
            ],
            spanGaps: true,
        }
        ]
    };

    var myChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            title: {
                display: true,
                text: 'Durée de la partie',
                fontColor: 'white'
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        color: 'rgba(255, 255, 255, 0.2)'
                    },
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>