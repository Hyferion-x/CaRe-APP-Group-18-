//weli0007
document.addEventListener('DOMContentLoaded', function () {
    
    fetchMoodData();
    fetchEnergyData();
    fetchFeelingData();

    
    fetchUpcomingAppointments();

    
    document.getElementById('new-journal-entry').addEventListener('click', function() {
        window.location.href = '../Patient Dashboard/journal.html'; 
    });

    document.getElementById('log-activity').addEventListener('click', function() {
        window.location.href = '../Patient Dashboard/activity.html'; 
    });
});

// Fetch mood data
function fetchMoodData() {
    fetch('../Patient Dashboard/dash-fetch-mood-data.php')
        .then(response => response.json())
        .then(data => generateMoodGraph(data))
        .catch(error => console.error('Error fetching mood data:', error));
}

// Fetch energy data
function fetchEnergyData() {
    fetch('../Patient Dashboard/dash-fetch-energy-data.php')
        .then(response => response.json())
        .then(data => generateEnergyGraph(data))
        .catch(error => console.error('Error fetching energy data:', error));
}

// Fetch feeling data
function fetchFeelingData() {
    fetch('../Patient Dashboard/dash-fetch-feeling-data.php')
        .then(response => response.json())
        .then(data => generateFeelingGraph(data))
        .catch(error => console.error('Error fetching feeling data:', error));
}

// Fetch upcoming appointments
function fetchUpcomingAppointments() {
    fetch('../Patient Dashboard/dash-fetch-appointments.php')
        .then(response => response.json())
        .then(data => {
            const appointmentsList = document.getElementById('appointments-list');
            appointmentsList.innerHTML = '';

            if (data.length === 0) {
                appointmentsList.textContent = "No upcoming appointments.";
            } else {
                data.forEach(appointment => {
                    const p = document.createElement('p');
                    p.textContent = `${appointment.date} - ${appointment.description}`;
                    appointmentsList.appendChild(p);
                });
            }
        })
        .catch(error => console.error('Error fetching appointments:', error));
}

// Function to generate the Mood Graph (Bar Chart)
function generateMoodGraph(data) {
    const canvas = document.getElementById('moodGraph');
    const ctx = canvas.getContext('2d');

    const moodCounts = {};
    data.forEach(entry => {
        moodCounts[entry.mood] = (moodCounts[entry.mood] || 0) + 1;
    });

    const moods = Object.keys(moodCounts);
    const counts = Object.values(moodCounts);

    const barWidth = 60;
    const gap = 20;
    const maxCount = Math.max(...counts);
    const chartHeight = canvas.height - 50;

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    moods.forEach((mood, index) => {
        const x = index * (barWidth + gap) + 50;
        const barHeight = (moodCounts[mood] / maxCount) * chartHeight;
        const y = canvas.height - barHeight - 30;

        ctx.fillStyle = '#004b8d';
        ctx.fillRect(x, y, barWidth, barHeight);

        ctx.fillStyle = '#333';
        ctx.font = '14px Arial';
        ctx.fillText(mood, x + barWidth / 2 - ctx.measureText(mood).width / 2, canvas.height - 10);
        ctx.fillText(moodCounts[mood], x + barWidth / 2 - ctx.measureText(moodCounts[mood]).width / 2, y - 5);
    });
}

// Function to generate the Energy Level Graph (Line Chart)
function generateEnergyGraph(data) {
    const canvas = document.getElementById('energyGraph');
    const ctx = canvas.getContext('2d');

    const dates = data.map(entry => entry.date);
    const energyLevels = data.map(entry => entry.energy_level);

    const maxEnergy = Math.max(...energyLevels);
    const minEnergy = Math.min(...energyLevels);
    const chartHeight = canvas.height - 50;

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    ctx.strokeStyle = '#ff5733';
    ctx.beginPath();
    ctx.moveTo(50, scaleY(energyLevels[0], maxEnergy, minEnergy, chartHeight));

    energyLevels.forEach((energy, index) => {
        const x = (index / (energyLevels.length - 1)) * (canvas.width - 100) + 50;
        const y = scaleY(energy, maxEnergy, minEnergy, chartHeight);
        ctx.lineTo(x, y);
    });

    ctx.stroke();

    // Draw points
    energyLevels.forEach((energy, index) => {
        const x = (index / (energyLevels.length - 1)) * (canvas.width - 100) + 50;
        const y = scaleY(energy, maxEnergy, minEnergy, chartHeight);

        ctx.beginPath();
        ctx.arc(x, y, 4, 0, Math.PI * 2);
        ctx.fillStyle = '#ff5733';
        ctx.fill();
    });
}


function generateFeelingGraph(data) {
    const canvas = document.getElementById('feelingGraph');
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height); 

    
    const moodMap = {
        'Happy': '😄',
        'Excited': '😃',
        'Anxious': '😰',
        'Sad': '😣'
    };

    
    const moodCounts = {
        Happy: 0,
        Excited: 0,
        Anxious: 0,
        Sad: 0
    };

    
    data.forEach(entry => {
        if (moodCounts.hasOwnProperty(entry.mood)) {
            moodCounts[entry.mood]++;
        }
    });

    const moods = Object.keys(moodCounts); 
    const totalEntries = data.length;
    const percentages = moods.map(mood => (totalEntries > 0 ? (moodCounts[mood] / totalEntries) * 100 : 0)); 

    const spacing = canvas.width / (moods.length + 1); 

    
    moods.forEach((mood, index) => {
        const emoji = moodMap[mood]; 
        const percentage = percentages[index];
        const xPos = (index + 1) * spacing; 

        // Draw the mood emoji
        ctx.font = '30px Arial';
        ctx.fillText(emoji, xPos - 15, 40);

        // Draw the percentage bar
        ctx.fillStyle = '#4CAF50'; 
        ctx.fillRect(xPos - 25, 50, 50, percentage * 2);

        // Display percentage text
        ctx.fillStyle = '#333'; 
        ctx.font = '14px Arial';
        ctx.fillText(`${Math.round(percentage)}%`, xPos - 15, 120); 
    });
}



// Utility function to scale Y-axis values for the line chart
function scaleY(value, maxValue, minValue, height) {
    return height - 30 - ((value - minValue) / (maxValue - minValue)) * (height - 50);
}
