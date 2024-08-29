document.getElementById('new-journal-entry').addEventListener('click', function() {
    document.getElementById('journal-modal').style.display = 'flex';
});

document.getElementById('cancel-entry').addEventListener('click', function() {
    document.getElementById('journal-modal').style.display = 'none';
});

document.getElementById('save-entry').addEventListener('click', function() {
    // Collect data
    const mood = document.getElementById('mood').value;
    const energy = document.getElementById('energy').value;
    const entry = document.getElementById('entry').value;
    const date = document.getElementById('entry-date').value; // Collect date

    // Send data to PHP to save to the database
    fetch('save-journal.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `mood=${mood}&energy=${energy}&entry=${encodeURIComponent(entry)}&date=${date}`
    }).then(response => response.text()).then(data => {
        if (data.trim() === 'success') {
            document.getElementById('journal-modal').style.display = 'none';
            loadJournalEntries(); // Refresh entries after saving
        } else {
            alert('Error saving journal entry: ' + data);
        }
    });
});

// Function to load journal entries
function loadJournalEntries(searchKeyword = '', fromDate = '', toDate = '') {
    let url = 'fetch-journal-entries.php';

    if (searchKeyword || fromDate || toDate) {
        url += `?keyword=${encodeURIComponent(searchKeyword)}&from=${fromDate}&to=${toDate}`;
    }

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const journalEntriesContainer = document.getElementById('journal-entries');
            journalEntriesContainer.innerHTML = ''; // Clear previous entries

            data.forEach((entry, index) => {
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${entry.date}</td>
                    <td>${entry.mood}</td>
                    <td>${entry.energy_level}</td>
                    <td>${entry.entry}</td>
                `;

                journalEntriesContainer.appendChild(row);
            });
        });
}

// Search button functionality
document.getElementById('search-button').addEventListener('click', function() {
    const searchKeyword = document.getElementById('search-keyword').value;
    loadJournalEntries(searchKeyword);
});

// Filter button functionality
document.getElementById('filter-button').addEventListener('click', function() {
    const fromDate = document.getElementById('from-date').value;
    const toDate = document.getElementById('to-date').value;
    loadJournalEntries('', fromDate, toDate);
});

// Load journal entries on page load
document.addEventListener('DOMContentLoaded', function() {
    loadJournalEntries();
});
