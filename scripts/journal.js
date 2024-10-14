//weli0007
document.getElementById('new-journal-entry').addEventListener('click', function() {
    document.getElementById('modal-title').textContent = 'New Journal Entry';
    clearModalFields();
    document.getElementById('journal-modal').style.display = 'flex';
    document.getElementById('delete-entry').style.display = 'none'; 
});

document.getElementById('cancel-entry').addEventListener('click', function() {
    document.getElementById('journal-modal').style.display = 'none';
});

document.getElementById('save-entry').addEventListener('click', function() {
    const isEditing = document.getElementById('modal-title').textContent === 'Edit Journal Entry';
    
    const id = document.getElementById('entry-id').value;
    const mood = document.getElementById('mood').value;
    const energy = document.getElementById('energy').value;
    const entry = document.getElementById('entry').value;
    const date = document.getElementById('entry-date').value;
    
    const body = `id=${id}&mood=${mood}&energy=${energy}&entry=${encodeURIComponent(entry)}&date=${date}`;
    
    const url = isEditing ? 'update-journal.php' : 'save-journal.php';
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: body
    }).then(response => response.text()).then(data => {
        if (data.trim() === 'success') {
            document.getElementById('journal-modal').style.display = 'none';
            loadJournalEntries(); // Refresh entries after saving or updating
            loadMoodGraph(); // Refresh the mood graph
            loadEnergyGraph(); // Refresh the energy graph
            loadCustomMoodGraph(); // Refresh the custom mood graph
        } else {
            alert('Error saving journal entry: ' + data);
        }
    });
});

document.getElementById('delete-entry').addEventListener('click', function() {
    const id = document.getElementById('entry-id').value;
    fetch('delete-journal.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}`
    }).then(response => response.text()).then(data => {
        if (data.trim() === 'success') {
            document.getElementById('journal-modal').style.display = 'none';
            loadJournalEntries(); // Refresh entries after deleting
            loadMoodGraph(); // Refresh the mood graph
            loadEnergyGraph(); // Refresh the energy graph
            loadCustomMoodGraph(); // Refresh the custom mood graph
        } else {
            alert('Error deleting journal entry: ' + data);
        }
    });
});

// Function to load journal entries
function loadJournalEntries(searchKeyword = '', fromDate = '', toDate = '', targetTable = 'journal-entries') {
    let url = 'fetch-journal-entries.php';

    if (searchKeyword || fromDate || toDate) {
        url += `?keyword=${encodeURIComponent(searchKeyword)}&from=${fromDate}&to=${toDate}`;
    }

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const targetContainer = document.getElementById(targetTable === 'journal-entries' ? 'journal-entries' : 'past-journal-entries');
            targetContainer.innerHTML = ''; 

            data.forEach((entry, index) => {
                const row = document.createElement('tr');
                
                if (targetTable === 'journal-entries') {
                    row.addEventListener('click', () => editJournalEntry(entry));
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${entry.date}</td>
                        <td>${entry.mood}</td>
                        <td>${entry.energy_level}</td>
                        <td>${entry.entry}</td>
                    `;
                } else {
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${entry.date}</td>
                        <td>${entry.mood}</td>
                        <td>${entry.energy_level}</td>
                        <td>${entry.entry}</td>
                    `;
                }

                targetContainer.appendChild(row);
            });

            if (targetTable === 'past-journal-entries') {
                loadCustomMoodGraph(data); // Load custom mood graph with filtered data
            }
        });
}

// Function to handle editing of a journal entry
function editJournalEntry(entry) {
    document.getElementById('modal-title').textContent = 'Edit Journal Entry';
    document.getElementById('entry-id').value = entry.id;
    document.getElementById('entry-date').value = entry.date;
    document.getElementById('mood').value = entry.mood;
    document.getElementById('energy').value = entry.energy_level;
    document.getElementById('entry').value = entry.entry;
    
    document.getElementById('journal-modal').style.display = 'flex';
    document.getElementById('delete-entry').style.display = 'block';
}

// Function to clear modal fields
function clearModalFields() {
    document.getElementById('entry-id').value = '';
    document.getElementById('entry-date').value = '';
    document.getElementById('mood').value = 'happy';
    document.getElementById('energy').value = 5;
    document.getElementById('entry').value = '';
    document.getElementById('delete-entry').style.display = 'none';
}

// Function to load mood graph
function loadMoodGraph() {
    fetch('fetch-mood-data.php')
        .then(response => response.json())
        .then(data => {
            const canvas = document.getElementById('mood-chart');
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height); 

            const moodCounts = {};
            data.forEach(entry => {
                moodCounts[entry.mood] = entry.count;
            });

            const moods = Object.keys(moodCounts);
            const counts = Object.values(moodCounts);

            const maxCount = Math.max(...counts);
            const barWidth = 40;
            const gap = 30;
            const chartHeight = canvas.height - 50; 

            moods.forEach((mood, index) => {
                const x = index * (barWidth + gap) + 60;
                const barHeight = (moodCounts[mood] / maxCount) * chartHeight;
                const y = canvas.height - barHeight - 30;

                ctx.fillStyle = '#004b8d';
                ctx.fillRect(x, y, barWidth, barHeight);

                ctx.fillStyle = '#333';
                ctx.font = '14px Arial';
                ctx.fillText(mood, x + barWidth / 2 - ctx.measureText(mood).width / 2, canvas.height - 10);

                ctx.fillStyle = '#fff';
                ctx.fillText(moodCounts[mood], x + barWidth / 2 - ctx.measureText(moodCounts[mood]).width / 2, y - 5);
            });
        });
}

// Function to load energy graph
function loadEnergyGraph() {
    fetch('fetch-energy-data.php')
        .then(response => response.json())
        .then(data => {
            const canvas = document.getElementById('energy-chart');
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height); 

            const dates = data.map(entry => entry.date);
            const energyLevels = data.map(entry => entry.energy_level);

            const maxEnergy = Math.max(...energyLevels);
            const minEnergy = Math.min(...energyLevels);
            const chartHeight = canvas.height - 50; 

            ctx.beginPath();
            ctx.moveTo(50, canvas.height - ((energyLevels[0] - minEnergy) / (maxEnergy - minEnergy)) * chartHeight - 30);

            energyLevels.forEach((energy, index) => {
                const x = (index / (energyLevels.length - 1)) * (canvas.width - 100) + 50;
                const y = canvas.height - ((energy - minEnergy) / (maxEnergy - minEnergy)) * chartHeight - 30;
                ctx.lineTo(x, y);
            });

            ctx.strokeStyle = '#ff5733';
            ctx.lineWidth = 2;
            ctx.stroke();

            
            energyLevels.forEach((energy, index) => {
                const x = (index / (energyLevels.length - 1)) * (canvas.width - 100) + 50;
                const y = canvas.height - ((energy - minEnergy) / (maxEnergy - minEnergy)) * chartHeight - 30;

                ctx.beginPath();
                ctx.arc(x, y, 4, 0, Math.PI * 2);
                ctx.fillStyle = '#ff5733';
                ctx.fill();
            });
        });
}

// Function to load custom mood graph
function loadCustomMoodGraph(data = []) {
    const canvas = document.getElementById('custom-mood-chart');
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height); 

    const moodMap = {
        '😄': 'happy',
        '😃': 'excited',
        '😰': 'anxious',
        '😣': 'sad'
    };

    const colors = ['#00f5d4', '#00bbf9', '#f7845c', '#ff006e'];
    const moodCounts = { 'happy': 0, 'excited': 0, 'anxious': 0, 'sad': 0 };
    const totalEntries = data.length;

    
    data.forEach(entry => {
        if (moodCounts.hasOwnProperty(entry.mood)) {
            moodCounts[entry.mood]++;
        }
    });

    const moods = Object.keys(moodCounts);
    const percentages = moods.map(mood => totalEntries ? (moodCounts[mood] / totalEntries) * 100 : 0);

    
    const spacing = canvas.width / (moods.length + 1);

    // Draw mood icons and percentage bars
    moods.forEach((mood, index) => {
        const emoji = Object.keys(moodMap).find(key => moodMap[key] === mood);
        const percentage = percentages[index];
        const xPos = (index + 1) * spacing; // Calculate x position based on index and spacing

        // Draw mood emoji
        ctx.font = '30px Arial';
        ctx.fillText(emoji, xPos - 15, 40); 

        // Draw percentage bar
        ctx.fillStyle = colors[index];
        ctx.fillRect(xPos - 25, 50, 50, percentage * 1.5); 

        // Draw percentage text
        ctx.fillStyle = '#333';
        ctx.font = '14px Arial';
        ctx.fillText(`${Math.round(percentage)}%`, xPos - 15, 95); 
    });
}


document.getElementById('search-button').addEventListener('click', function() {
    const searchKeyword = document.getElementById('search-keyword').value;
    loadJournalEntries(searchKeyword);
});


document.getElementById('filter-button').addEventListener('click', function() {
    const fromDate = document.getElementById('from-date').value;
    const toDate = document.getElementById('to-date').value;
    loadJournalEntries('', fromDate, toDate, 'past-journal-entries'); 
});

// Load journal entries and graphs on page load
document.addEventListener('DOMContentLoaded', function() {
    loadJournalEntries();
    loadMoodGraph(); 
    loadEnergyGraph(); 
    loadCustomMoodGraph(); 
});
