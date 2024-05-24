import './chart';

const labels = [
    'I-A',
    'I-B',
    'I-C',
    'I-D',
    'I-D',
    'I-E    ',
];

const data = {
    labels: labels,
    datasets: [{
        label: 'Section',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [0, 10, 5, 2, 20, 30, 45],
    }]
};

const config = {
    type: 'bar',
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Average Score by Section'
            }
        }
    }
};

new Chart(
    document.getElementById('myChart'),
    config
);
