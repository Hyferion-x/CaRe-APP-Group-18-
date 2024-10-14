//weli0007
document.addEventListener('DOMContentLoaded', function () {
    const patientList = document.getElementById('patient-list');
    const patientNameEl = document.getElementById('patient-name');
    const patientAgeEl = document.getElementById('patient-age');
    const patientIdEl = document.getElementById('patient-id');
    const patientPhoneEl = document.getElementById('patient-phone');
    const patientAddressEl = document.getElementById('patient-address');
    const patientGenderEl = document.getElementById('patient-gender');
    const patientBirthdayEl = document.getElementById('patient-birthday');
    const patientAllergiesEl = document.getElementById('patient-allergies');
    const patientPhotoEl = document.getElementById('patient-photo');
    

    // Load patients
    function loadPatients() {
        fetch('fetch_patients.php') 
            .then(response => response.json())
            .then(data => {
                patientList.innerHTML = ''; 

                if (data.error) {
                    patientList.innerHTML = `<li>${data.error}</li>`;
                } else {
                    data.forEach(patient => {
                        const li = document.createElement('li');
                        li.textContent = patient.name;
                        li.dataset.userId = patient.id; 
                        li.addEventListener('click', () => loadPatientDetails(patient.id));
                        patientList.appendChild(li);
                    });
                }
            })
            .catch(error => console.error('Error fetching patients:', error));
    }

    // Load patient details and charts
    function loadPatientDetails(userId) {
        fetch(`fetch_patient_details.php?user_id=${userId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                // Update patient profile
                patientNameEl.textContent = data.name;
                patientAgeEl.textContent = data.age;
                patientIdEl.textContent = data.id;
                patientPhoneEl.textContent = data.phone
                patientAddressEl.textContent = data.address
                patientGenderEl.textContent = data.gender 
                patientBirthdayEl.textContent = data.birthday
                patientAllergiesEl.textContent = data.allergies
                patientPhotoEl.src = data.photo ? `../${data.photo}` : 'path/to/default/image.jpg';
                

                // Load journal entries and activity log charts
                loadJournalEntries(userId);
                updateActivityCharts(userId); 
            })
            .catch(error => {
                console.error('Error fetching patient details:', error);
            });
    }

    // Load journal entries and graphs
    function loadJournalEntries(userId) {
        fetch(`fetch_journal_entries.php?user_id=${userId}`)
            .then(response => response.json())
            .then(data => {
                
                const journalContainer = document.getElementById('journal-entries');
                journalContainer.innerHTML = '';

                
                loadMoodGraph(data);
                loadEnergyGraph(data);
                loadCustomMoodGraph(data);
            })
            .catch(error => {
                console.error('Error fetching journal entries:', error);
            });
    }

    // Load mood graph
    function loadMoodGraph(data) {
        const canvas = document.getElementById('mood-chart');
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    
        const moodCounts = {};
        data.forEach(entry => {
            moodCounts[entry.mood] = (moodCounts[entry.mood] || 0) + 1;
        });
    
        const moods = Object.keys(moodCounts);
        const counts = Object.values(moodCounts);
        const maxCount = Math.max(...counts);
    
        const barWidth = 40;
        const padding = 30;
        
        // Calculate the total width required 
        const totalBarWidth = moods.length * barWidth + (moods.length - 1) * padding;
        
        const leftPadding = (canvas.width - totalBarWidth) / 2;
    
        moods.forEach((mood, index) => {
            const x = index * (barWidth + padding) + leftPadding;
            const barHeight = (moodCounts[mood] / maxCount) * (canvas.height - 50);
            const y = canvas.height - barHeight - 30;
    
            ctx.fillStyle = '#4CAF50';
            ctx.fillRect(x, y, barWidth, barHeight);
    
            ctx.fillStyle = '#000';
            ctx.fillText(mood, x + barWidth / 2 - ctx.measureText(mood).width / 2, canvas.height - 10);
        });
    }
    

    // Load energy graph
    function loadEnergyGraph(data) {
        const canvas = document.getElementById('energy-chart');
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        const dates = data.map(entry => entry.date);
        const energyLevels = data.map(entry => entry.energy_level);
        const maxEnergy = Math.max(...energyLevels);

        ctx.beginPath();
        ctx.moveTo(50, canvas.height - (energyLevels[0] / maxEnergy) * (canvas.height - 50));

        energyLevels.forEach((energy, index) => {
            const x = (index / (energyLevels.length - 1)) * (canvas.width - 100) + 50;
            const y = canvas.height - (energy / maxEnergy) * (canvas.height - 50);
            ctx.lineTo(x, y);
        });

        ctx.strokeStyle = '#ff5733';
        ctx.lineWidth = 2;
        ctx.stroke();
    }

    // Load custom mood graph with emojis
    function loadCustomMoodGraph(data) {
        const canvas = document.getElementById('custom-mood-chart');
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        const moodMap = {
            '😄': 'happy',
            '😃': 'excited',
            '😰': 'anxious',
            '😣': 'sad'
        };

        const moodCounts = {
            happy: 0,
            excited: 0,
            anxious: 0,
            sad: 0,
        };

        data.forEach(entry => {
            moodCounts[entry.mood]++;
        });

        const moods = Object.keys(moodCounts);
        const percentages = moods.map(mood => (moodCounts[mood] / data.length) * 100);

        const barWidth = 40;
        moods.forEach((mood, index) => {
            const emoji = Object.keys(moodMap).find(key => moodMap[key] === mood);
            const percentage = percentages[index];

            const x = (index + 1) * (canvas.width / (moods.length + 1));
            ctx.font = '30px Arial';
            ctx.fillText(emoji, x - 15, 40); 
            ctx.fillStyle = '#4CAF50';
            ctx.fillRect(x - 25, 50, 50, percentage * 2); 
        });
    }

    // Update activity charts
    function updateActivityCharts(userId) {
        fetch(`fetch_activities.php?user_id=${userId}`)
            .then(response => response.json())
            .then(data => {
                const activityCounts = {};
                data.forEach(entry => {
                    activityCounts[entry.activity_type] = (activityCounts[entry.activity_type] || 0) + 1;
                });

                const labels = Object.keys(activityCounts);
                const values = Object.values(activityCounts);
                drawPieChart(labels, values); 
            })
            .catch(error => {
                console.error('Error fetching activity data:', error);
            });
    }

    // Draw pie chart
    function drawPieChart(labels, data) {
        const canvas = document.getElementById('activity-chart');
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        const total = data.reduce((sum, value) => sum + value, 0);
        const colors = ['#FF6384', '#36A2EB', '#FFCE56'];
        let startAngle = 0;

        data.forEach((value, index) => {
            const sliceAngle = (value / total) * 2 * Math.PI;
            ctx.beginPath();
            ctx.moveTo(150, 75); 
            ctx.arc(150, 75, 75, startAngle, startAngle + sliceAngle);
            ctx.closePath();
            ctx.fillStyle = colors[index % colors.length];
            ctx.fill();

            // Calculate percentage text placement
            const textX = 150 + Math.cos(startAngle + sliceAngle / 2) * 50;
            const textY = 75 + Math.sin(startAngle + sliceAngle / 2) * 50;
            const percentage = ((value / total) * 100).toFixed(1) + '%';

            ctx.fillStyle = '#000';
            ctx.font = '12px Arial';
            const textWidth = ctx.measureText(percentage).width;
            ctx.fillText(percentage, textX - textWidth / 2, textY);

            startAngle += sliceAngle;
        });

        // Draw the legend
        labels.forEach((label, index) => {
            ctx.fillStyle = colors[index % colors.length];
            ctx.fillRect(10, 160 + index * 20, 10, 10); 
            ctx.fillStyle = '#000';
            ctx.fillText(label, 25, 170 + index * 20); 
        });
    }

    
    loadPatients();
});
