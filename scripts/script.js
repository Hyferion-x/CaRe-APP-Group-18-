//weli0007
document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); 

    
    var formData = new FormData(this);

    
    fetch('login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.role) {
            
            var userType = data.role;  

            if (userType === 'patient') {
                window.location.href = 'Patient Dashboard/patient-dashboard.html';
            } else if (userType === 'therapist') {
                window.location.href = 'Therapist Dashboard/therapist-dashboard.html';
            } else if (userType === 'staff') {
                window.location.href = 'Staff Dashboard/staff-dashboard.html';
            } else if (userType === 'auditor') {
                window.location.href = 'Auditor Dashboard/auditor-dashboard.html';
            } else {
                console.error('Unknown user type');
            }
        } else {
            
            alert(data.error || 'An error occurred.');
        }
    })
    .catch(error => console.error('Error:', error));
});
