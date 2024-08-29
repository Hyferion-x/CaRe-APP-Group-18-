document.querySelector('form').addEventListener('submit', function(event) {
   
    var userType = 'patient'; 

    if (userType === 'patient') {
        window.location.href = 'patient-dashboard.html';
    }
    
});
