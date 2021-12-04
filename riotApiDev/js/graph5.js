var ctx = document.getElementById('graph5').getContext('2d');

var data = {
    labels: ['lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche'],
    datasets: [
        {
            backgroundColor: '#654321',
            data: [15,3,12,25,4,14,12],
        },
        {
            backgroundColor: '#123456',
            data: [20,5,40,23,12,16,30],
        }
    ]
};

var options

var config = {
    type: 'line',
    data: data,
    options: options,
};
var graph1 = new Chart(ctx, config);