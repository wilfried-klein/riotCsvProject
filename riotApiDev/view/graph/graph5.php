<script>
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
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#000",
            pointBorderWidth: 5,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
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
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>