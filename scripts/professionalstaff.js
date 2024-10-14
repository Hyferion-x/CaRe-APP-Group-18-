document.addEventListener('DOMContentLoaded', function() {
    // Modal Variables
    const patientFormModal = document.getElementById('patientFormModal');
    const medicalHistoryModal = document.getElementById('medicalHistoryModal');
    const appointmentModal = document.getElementById('appointmentModal');
    
    // Close Buttons
    const closeButtons = document.querySelectorAll('.close');

    // Patient Actions Buttons
    const createPatientBtn = document.getElementById('createPatientBtn');
    const editPatientBtn = document.getElementById('editPatientBtn');
    const updateHistoryBtn = document.getElementById('updateHistoryBtn');
    const addAppointmentBtn = document.getElementById('addAppointmentBtn');
    const deletePatientBtn = document.getElementById('deletePatientBtn');

    // Ensure all buttons exist before adding event listeners
    if (createPatientBtn) {
        createPatientBtn.addEventListener('click', function() {
            openModal(patientFormModal, "Create New Patient");
        });
    }
    
    if (editPatientBtn) {
        editPatientBtn.addEventListener('click', function() {
            openModal(patientFormModal, "Edit Patient Details");
        });
    }
    
    if (updateHistoryBtn) {
        updateHistoryBtn.addEventListener('click', function() {
            openModal(medicalHistoryModal);
        });
    }
    
    if (addAppointmentBtn) {
        addAppointmentBtn.addEventListener('click', function() {
            openModal(appointmentModal);
        });
    }

    if (deletePatientBtn) {
        deletePatientBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this patient record?')) {
                console.log("Patient record deleted.");
            }
        });
    }

    // Close buttons for modals
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            closeModal(button.closest('.modal'));
        });
    });

    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            closeModal(event.target);
        }
    });

    // Helper Functions
    function openModal(modal, title) {
        if (modal) {
            modal.style.display = "block";
            const formTitle = modal.querySelector('h3');
            if (formTitle && title) formTitle.textContent = title;
        } else {
            console.error("Modal not found.");
        }
    }

    function closeModal(modal) {
        if (modal) {
            modal.style.display = "none";
        } else {
            console.error("Modal not found.");
        }
    }

    // Search Patients
    const searchButton = document.getElementById('search-button');
    if (searchButton) {
        searchButton.addEventListener('click', function() {
            const searchInput = document.getElementById('search-input').value;
            const filterByAge = document.getElementById('filter-by-age').checked;
            const filterByLocation = document.getElementById('filter-by-location').checked;
            
            console.log("Searching for:", searchInput, "Filter by Age:", filterByAge, "Filter by Location:", filterByLocation);

            // Update search results (placeholder for real results)
            const searchResults = document.getElementById('search-results');
            if (searchResults) {
                searchResults.innerHTML = `<p>Found patients matching: "${searchInput}"</p>`;
            }
        });
    }

    // Calendar Logic
    const monthYearDisplay = document.getElementById('monthYear');
    const daysContainer = document.getElementById('days');
    const daysOfWeekContainer = document.getElementById('daysOfWeek');
    const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

    let currentDate = new Date();
    renderCalendar(currentDate);

    function renderCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();

        if (monthYearDisplay) {
            monthYearDisplay.textContent = `${date.toLocaleString('default', { month: 'long' })} ${year}`;
        }

        // Render days of week
        if (daysOfWeekContainer) {
            daysOfWeekContainer.innerHTML = "";
            daysOfWeek.forEach(day => {
                const dayElem = document.createElement('div');
                dayElem.textContent = day;
                daysOfWeekContainer.appendChild(dayElem);
            });
        }

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        if (daysContainer) {
            daysContainer.innerHTML = "";

            // Render previous month's trailing days
            for (let i = 0; i < firstDay; i++) {
                const dayElem = document.createElement('div');
                dayElem.style.opacity = "0.5";
                daysContainer.appendChild(dayElem);
            }

            // Render current month's days
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElem = document.createElement('div');
                dayElem.textContent = day;

                // Highlight today
                if (year === new Date().getFullYear() && month === new Date().getMonth() && day === new Date().getDate()) {
                    dayElem.classList.add('today');
                }

                dayElem.addEventListener('click', function() {
                    alert(`You clicked on ${day}/${month + 1}/${year}`);
                });

                daysContainer.appendChild(dayElem);
            }
        }
    }

    // Form submissions (placeholder functionality)
    const patientForm = document.getElementById('patientForm');
    if (patientForm) {
        patientForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Patient information submitted!');
            closeModal(patientFormModal);
        });
    }

    const medicalHistoryForm = document.getElementById('medicalHistoryForm');
    if (medicalHistoryForm) {
        medicalHistoryForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Medical history updated!');
            closeModal(medicalHistoryModal);
        });
    }

    const appointmentForm = document.getElementById('appointmentForm');
    if (appointmentForm) {
        appointmentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Appointment scheduled!');
            closeModal(appointmentModal);
        });
    }
});
