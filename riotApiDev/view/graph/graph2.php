<?php
    foreach ($result as $matchData) {
        $matchType[] = $matchData['matchType'];
    }
    $matchType = array_count_values($matchType);
?>

<script>
var randomScalingFactor = function() {
    return Math.round(Math.random() * 100);
};
var chartColors = {
    red: 'rgb(255, 99, 132)',
    orange: 'rgb(255, 159, 64)',
    yellow: 'rgb(255, 205, 86)',
    green: 'rgb(75, 192, 192)',
    blue: 'rgb(54, 162, 235)',
    purple: 'rgb(153, 102, 255)',
    grey: 'rgb(231,233,237)'
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
            backgroundColor: color(chartColors.red).alpha(0.2).rgbString(),
            borderColor: chartColors.red,
            pointBackgroundColor: chartColors.red,
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
                fontColor: 'white', // labels such as 10, 20, etc
                showLabelBackdrop: false // hide square behind text
            },
            pointLabels: {
                fontColor: 'white' // labels around the edge like 'Running'
            },
            gridLines: {
                color: 'rgba(255, 255, 255, 0.2)'
            },
            angleLines: {
                color: 'white' // lines radiating from the center
            }
        }
    }
};

// A plugin to draw the background color
Chart.plugins.register({
    beforeDraw: function(chartInstance) {
        var ctx = chartInstance.chart.ctx;
        ctx.fillStyle = '#1d1d1d';
        ctx.fillRect(0, 0, chartInstance.chart.width, chartInstance.chart.height);
    }
})

window.myRadar = new Chart(document.getElementById("graph2"), config);
</script>