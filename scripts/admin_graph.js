$(document).ready(function (){
    var ctx = document.getElementById('myChart').getContext('2d');
    var barChart = document.getElementById('barChart').getContext('2d');
    let array_1 = JSON.parse(array1);
    let array_2 = JSON.parse(array2);

    var myChart = new Chart(ctx, {
        type: 'doughnut',
        datatype: "json",
        data: {
            labels: ['Benzin', 'Dízel', 'Hybrid', 'Elektromos'],
            datasets: [{
                label: 'Rendelések száma',
                data: array_1,
                backgroundColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(81,173,47, 1)',
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
        }
    });
    var myChart = new Chart(barChart, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Márc', 'Ápr', 'Máj', 'Jun', 'Jul', 'Agu', 'Szep', 'Okt', 'Nov', 'Dec'],
            datasets: [{
                label: 'Autók száma',
                data: array_2,
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
});