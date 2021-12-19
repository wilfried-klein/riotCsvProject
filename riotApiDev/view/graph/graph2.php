<?php
    foreach ($result as $matchData) {
        $matchType[] = $matchData['matchType'];
    }
    $matchType = array_count_values($matchType);
?>

<script>

var chartColors = {
    blue: 'rgb(54, 162, 235)'
};

var color = Chart.helpers.color;
var config = {
    type: 'radar',
    data: {
        labels: [
            <?php
                foreach ($matchType as $key => $value) {
                    echo "'".$key."',";
                }
            ?>
        ],
        datasets: [{
            label: "Type de partie",
            backgroundColor: color(chartColors.blue).alpha(0.2).rgbString(),
            borderColor: chartColors.blue,
            pointBackgroundColor: chartColors.blue,
            data: [
                <?php
                    foreach ($matchType as $key => $value) {
                        echo "'".$value."',";
                    }
                ?>
            ]
        }, ]
    },
    options: {
        legend: {
            position: 'top',
            labels: {
                fontColor: 'white'
            }
        },
        title: {
            display: true,
            text: 'Type de partie',
            fontColor: 'white'
        },
        scale: {
            ticks: {
                beginAtZero: true,
                fontColor: 'white',
                showLabelBackdrop: false
            },
            pointLabels: {
                fontColor: 'white'
            },
            gridLines: {
                color: 'rgba(255, 255, 255, 0.2)'
            },
            angleLines: {
                color: 'white'
            }
        }
    }
};

// Chart.plugins.register({
//     beforeDraw: function(chartInstance) {
//         var ctx = chartInstance.chart.ctx;
//         ctx.fillStyle = '#1d1d1d';
//         ctx.fillRect(0, 0, chartInstance.chart.width, chartInstance.chart.height);
//     }
// })

window.myRadar = new Chart(document.getElementById("graph2"), config);
</script>