<?php
$addARAM = 0;
$roles = array(
    "TOP" => 0,
    "JUNGLE" => 0,
    "MIDDLE" => 0,
    "BOTTOM" => 0,
    "UTILITY" => 0,
    "ARAM" => 0
);
foreach ($result as $value) {
    if($value['role'] != null){
        ++$roles[$value['role']]; 
    }else{
        $addARAM = 1;
        ++$roles['ARAM'];
    }
}

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
            "TOP","JUNGLE","MID","ADC","SUPPORT"
            <?php
            if($addARAM == 1){
                echo ",".'"ARAM"';
            }
            ?>
            ],
            datasets: [{
                label: "Rôle",
                backgroundColor: color(chartColors.blue).alpha(0.2).rgbString(),
                borderColor: chartColors.blue,
                pointBackgroundColor: chartColors.blue,
                data: [
                <?php
                    foreach ($roles as $value) {
                        echo "$value,";
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
                text: 'Rôle',
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

// // A plugin to draw the background color
// Chart.plugins.register({
//     beforeDraw: function(chartInstance) {
//         var ctx = chartInstance.chart.ctx;
//         ctx.fillStyle = '#1d1d1d';
//         ctx.fillRect(0, 0, chartInstance.chart.width, chartInstance.chart.height);
//     }
// })

window.myRadar = new Chart(document.getElementById("graph3"), config);


</script>