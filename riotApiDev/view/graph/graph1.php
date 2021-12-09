<script>
var ctx = document.getElementById('graph1').getContext('2d');

var data = {
    labels: [
        'Défaites',
        'Victoires',
    ],
    datasets: [{
        label: 'My First Dataset',

        data: [
            <?php echo $loses ?>,
            <?php echo $wins ?>
        ],
        backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)'
        ],
        hoverOffset: 4
    }]
};

var config = {
    type: 'doughnut',
    data: data,
    options: {
        title: {
            display: true,
            text: 'Victoires / Défaites',
            fontColor: 'white'
        }
    }
};

var graph1 = new Chart(ctx, config);
</script>

