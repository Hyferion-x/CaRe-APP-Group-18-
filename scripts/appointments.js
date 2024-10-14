//weli0007
document.addEventListener("DOMContentLoaded", function () {
    
    fetchSessions();
});

function fetchSessions() {
    fetch('dash-fetch-sessions.php')
        .then(response => response.json()) 
        .then(data => {
            console.log(data); 

            if (data.error) {
                console.error("Error fetching session data:", data.error);
                return;
            }

            const appointmentsList = document.getElementById('appointments-list');

            
            appointmentsList.innerHTML = '';

            // Loop through the session data and create table rows
            data.forEach(session => {
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>${session.session_date}</td>
                    <td>${session.session_time}</td>
                    <td>${session.notes ? session.notes : 'No Description'}</td>
                    <td>${session.status}</td>
                `;

                
                appointmentsList.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error fetching session data:', error);
        });
}
