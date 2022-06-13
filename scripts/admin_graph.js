var ctx = document.getElementById('myChart').getContext('2d');
var barChart = document.getElementById('barChart').getContext('2d');

var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Benzin', 'Dízel', 'Elektromos'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3],
            backgroundColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        respnsive: true,
    }
});

var myChart = new Chart(barChart, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Márc', 'Ápr', 'Máj', 'Jun', 'Jul'],
        datasets: [{
            label: 'Autók száma',
            data: [12, 19, 3, 5, 17, 10, 15],
            backgroundColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)'
            ],
        }]
    },
    options: {
        responsive: true,
    }
});