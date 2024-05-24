import './chart';

var average = document.getElementById('sectionAverage').value;
average = JSON.parse(average);

const labels = Object.keys(average);
const values = Object.values(average);

const data = {
    labels: labels,
    datasets: [{
        label: 'Section',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: values,
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
    document.getElementById('sectionAverageChart'),
    config
);