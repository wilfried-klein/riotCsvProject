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

window.myRadar = new Chart(document.getElementById("graph3"), config);


</script>