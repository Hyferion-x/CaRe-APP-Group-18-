document.getElementById('activity-log-btn').addEventListener('click', function() {
    alert('Activity logged successfully!');
    // Logic for logging activity goes here
});

// Event listeners for menu navigation
document.querySelectorAll('nav ul li a').forEach(function(link) {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const target = e.target.getAttribute('href');
        if (target) {
            window.location.href = target;
        }
    });
});
