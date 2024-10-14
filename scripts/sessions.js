//weli0007
document.addEventListener('DOMContentLoaded', function () {
    
    fetchSessions();

    
    fetchGroups();
});


function fetchSessions() {
    fetch('fetch_sessions.php')
        .then(response => response.json())
        .then(data => {
            const sessionListEl = document.getElementById('session-list');
            sessionListEl.innerHTML = ''; 

            if (data.status === 'success' && Array.isArray(data.sessions)) {
                data.sessions.forEach(session => {
                    const li = document.createElement('li');
                    li.innerHTML = `
                        ${session.id} - ${session.date} at ${session.time}
                        <button class="remove-session-btn" onclick="removeSession(${session.id})">Remove</button>
                    `;
                    li.addEventListener('click', () => loadSessionDetails(session.id));
                    sessionListEl.appendChild(li);
                });
            } else {
                sessionListEl.textContent = 'No sessions found.';
            }
        })
        .catch(error => console.error('Error fetching sessions:', error));
}



// Fetch all groups 
function fetchGroups() {
    fetch('fetch_sessions_groups.php')
        .then(response => response.json())
        .then(data => {
            const groupSelect = document.getElementById('group-select');
            groupSelect.innerHTML = ''; // Clear previous groups

            if (data.groups && Array.isArray(data.groups)) {
                data.groups.forEach(group => {
                    const option = document.createElement('option');
                    option.value = group.id;
                    option.textContent = group.group_name;
                    groupSelect.appendChild(option);
                });
            } else {
                groupSelect.innerHTML = '<option>No groups available.</option>';
            }
        })
        .catch(error => console.error('Error fetching groups:', error));
}

// Load session details when a session is selected
function loadSessionDetails(sessionId) {
    fetch(`fetch_session_details.php?session_id=${sessionId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                
                document.getElementById('session-id').textContent = `Session ID: ${data.id}`;
                document.getElementById('session-date').textContent = data.session_date;
                document.getElementById('session-time').textContent = data.session_time;
                document.getElementById('session-status').textContent = data.status;
                
                // Display group members
                const groupMembers = data.group_members.length > 0 ? data.group_members.join(', ') : 'No group members';
                document.getElementById('group-members').textContent = groupMembers;

                // Display session notes
                document.getElementById('session-notes').value = data.notes || 'No notes available';
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch(error => {
            console.error('Error fetching session details:', error);
            alert('Error fetching session details. Please try again.');
        });
}

// Save session notes
function saveSessionNotes() {
    const sessionId = document.getElementById('session-id').textContent.split(' ')[2]; // Extract session ID
    const notes = document.getElementById('session-notes').value;

    fetch('save_session_notes.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `session_id=${sessionId}&notes=${encodeURIComponent(notes)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Notes saved successfully.');
        } else {
            alert('Error saving notes.');
        }
    })
    .catch(error => console.error('Error saving notes:', error));
}

// Remove session function
function removeSession(sessionId) {
    if (confirm('Are you sure you want to remove this session?')) {
        fetch('remove_session.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `session_id=${sessionId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Session removed successfully.');
                fetchSessions(); 
            } else {
                alert('Error removing session: ' + data.message);
            }
        })
        .catch(error => console.error('Error removing session:', error));
    }
}



function openCreateSessionModal() {
    const modal = document.getElementById('create-session-modal');
    modal.style.display = 'block';
}


function closeCreateSessionModal() {
    const modal = document.getElementById('create-session-modal');
    modal.style.display = 'none';
}


window.onclick = function(event) {
    const modal = document.getElementById('create-session-modal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

// Handle the creation of a new session
function createNewSession(event) {
    event.preventDefault();

    const groupId = document.getElementById('group-select').value;
    const date = document.getElementById('session-date-input').value;
    const time = document.getElementById('session-time-input').value;
    const notes = document.getElementById('session-notes-input').value || ''; 
    const status = document.getElementById('session-status-input').value;

    if (!groupId || !date || !time || !status) {
        alert("Please fill all the fields to create a session.");
        return;
    }

    fetch('create_session.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `group_id=${groupId}&date=${date}&time=${time}&notes=${encodeURIComponent(notes)}&status=${status}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Session created successfully.');
            closeCreateSessionModal();
            fetchSessions(); 
        } else {
            alert('Error creating session: ' + data.message);
        }
    })
    .catch(error => console.error('Error creating session:', error));
}
