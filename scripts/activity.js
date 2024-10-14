//weli0007
document.addEventListener('DOMContentLoaded', function () {
    const activityForm = document.getElementById('activity-form');

    if (activityForm) {
        activityForm.addEventListener('submit', function(event) {
            event.preventDefault(); 

            const activityType = document.getElementById('activity-type').value;
            const date = document.getElementById('date').value;
            const time = document.getElementById('time').value;

            if (date && time) {
                const formData = new FormData();
                formData.append('activity-type', activityType);
                formData.append('date', date);
                formData.append('time', time);

                
                fetch('log_activity.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        fetchPastActivities(); // Fetch and update past activities
                        updateCharts(); 
                    } else {
                        alert('Error logging activity: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                alert('Please fill out all fields before logging the activity.');
            }
        });
    }

    
    fetchPastActivities();

    
    updateCharts();
});

// Fetch past activities and update the past-activity-log table
function fetchPastActivities() {
    fetch('fetch_activities.php')
    .then(response => response.text())
    .then(data => {
        const pastActivityLog = document.getElementById('past-activity-log');
        pastActivityLog.innerHTML = data;

        
        const activityRows = document.querySelectorAll('#past-activity-log tr');
        activityRows.forEach(row => {
            row.addEventListener('click', function() {
                const activityType = this.getAttribute('data-activity-type');
                const date = this.getAttribute('data-activity-date');
                const time = this.getAttribute('data-activity-time');
                displayActivityDetails(activityType, date, time); 
            });
        });
    })
    .catch(error => {
        console.error('Error fetching past activities:', error);
    });
}

// Display activity details in the details section
function displayActivityDetails(activityType, date, time) {
    const activityDetailContent = document.getElementById('activity-detail-content');
    activityDetailContent.innerHTML = `
        <div class="activity-details-box">
            <h4>Details for the Selected Activity:</h4>
            <p><strong>Activity Type:</strong> ${activityType}</p>
            <p><strong>Date:</strong> ${date}</p>
            <p><strong>Time:</strong> ${time}</p>
        </div>
    `;
}

// Data storage for chart
const activityData = {
    today: { sleeping: 1, eating: 2, exercise: 1 },
    week: { sleeping: 10, eating: 5, exercise: 7 }
};

// Update bar and pie charts
function updateCharts() {
    const todayBarChartElement = document.getElementById('todayBarChart');
    const weekBarChartElement = document.getElementById('weekBarChart');
    const todayPieChartElement = document.getElementById('todayPieChart');
    const weekPieChartElement = document.getElementById('weekPieChart');

    if (todayBarChartElement && weekBarChartElement && todayPieChartElement && weekPieChartElement) {
        const todayBarChart = todayBarChartElement.getContext('2d');
        const weekBarChart = weekBarChartElement.getContext('2d');
        const todayPieChart = todayPieChartElement.getContext('2d');
        const weekPieChart = weekPieChartElement.getContext('2d');

        const todayData = [activityData.today.sleeping, activityData.today.eating, activityData.today.exercise];
        const weekData = [activityData.week.sleeping, activityData.week.eating, activityData.week.exercise];

        
        drawBarChart(todayBarChart, 'Today\'s Activity', todayData);
        
        drawBarChart(weekBarChart, 'This Week\'s Activity', weekData);

        
        drawPieChart(todayPieChart, todayData, ['Sleeping', 'Eating', 'Exercise']);
        
        drawPieChart(weekPieChart, weekData, ['Sleeping', 'Eating', 'Exercise']);
    }
}

// Draw bar chart 
function drawBarChart(ctx, title, data) {
    const labels = ['Sleeping', 'Eating', 'Exercise'];
    const total = data.reduce((sum, value) => sum + value, 0); 
    const maxVal = Math.max(...data) + 1;

    const chartWidth = 300;
    const chartHeight = 150;
    const barWidth = 40;
    const padding = 30;

    ctx.clearRect(0, 0, chartWidth, chartHeight);

    ctx.font = '14px Arial';
    ctx.fillText(title, chartWidth / 2 - padding, padding / 2);

    labels.forEach((label, index) => {
        const percentage = ((data[index] / total) * 100).toFixed(1) + '%'; 
        const barHeight = (data[index] / maxVal) * (chartHeight - padding);

        ctx.fillStyle = '#4CAF50';
        ctx.fillRect(index * (barWidth + padding), chartHeight - barHeight - padding, barWidth, barHeight);

        ctx.fillStyle = '#000';
        ctx.fillText(label, index * (barWidth + padding), chartHeight - padding / 4);
        
        const textWidth = ctx.measureText(percentage).width;
        ctx.fillText(percentage, index * (barWidth + padding) + (barWidth - textWidth) / 2, chartHeight - barHeight - padding - 10); 
    });
}

// Draw pie chart with percentages and labels inside
function drawPieChart(ctx, data, labels) {
    const colors = ['#FF6384', '#36A2EB', '#FFCE56'];
    const total = data.reduce((sum, value) => sum + value, 0);
    let startAngle = 0;

    data.forEach((value, index) => {
        const sliceAngle = (value / total) * 2 * Math.PI;
        ctx.beginPath();
        ctx.moveTo(150, 75); 
        ctx.arc(150, 75, 75, startAngle, startAngle + sliceAngle);
        ctx.closePath();
        ctx.fillStyle = colors[index];
        ctx.fill();

        
        const textX = 150 + Math.cos(startAngle + sliceAngle / 2) * 50;
        const textY = 75 + Math.sin(startAngle + sliceAngle / 2) * 50;
        const percentage = ((value / total) * 100).toFixed(1) + '%';

        
        ctx.fillStyle = '#000';
        ctx.font = '12px Arial';
        const textWidth = ctx.measureText(percentage).width;
        ctx.fillText(percentage, textX - textWidth / 2, textY);

        startAngle += sliceAngle;
    });

    
    labels.forEach((label, index) => {
        ctx.fillStyle = colors[index];
        ctx.fillRect(10, 160 + index * 20, 10, 10); 
        ctx.fillStyle = '#000';
        ctx.fillText(label, 25, 170 + index * 20); 
    });
}
