<script>
<?php
    $ranked5v5 = 0;
    $rankedSoloDuo = 0;
    $normal = 0;
    $aram = 0;
    foreach ($result as $value) {

        if ($value['matchType']=='Ranked Flex games'){
            $ranked5v5 += 1;
        }elseif ($value['matchType']=='5v5 Ranked Solo games'){
            $rankedSoloDuo += 1;
        }elseif ($value['matchType']=='5v5 Draft Pick games'){
            $normal += 1;
        }else{
            $aram += 1;
        }
    }
?>
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
            "ARAM", "Normal game", "Ranked Solo", "Ranked Flex"
        ],
        datasets: [{
            label: "",
            backgroundColor: color(chartColors.blue).alpha(0.2).rgbString(),
            borderColor: chartColors.blue,
            pointBackgroundColor: chartColors.blue,
            data: [
                <?php echo $aram ?>,
                <?php echo $normal ?>,
                <?php echo $rankedSoloDuo ?>,
                <?php echo $ranked5v5 ?>,
            ]
        },
        ]
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