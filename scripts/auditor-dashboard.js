//weli0007
document.addEventListener("DOMContentLoaded", function () {
    const patientList = document.getElementById('patient-list');
    const saveAssignmentsBtn = document.getElementById('saveAssignmentsBtn');
    let patientData = [];

    // Fetch patients and therapists from the backend
    function fetchPatientsAndTherapists() {
        fetch('fetch_patients_and_therapists.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    patientData = data.patients.map(patient => ({
                        ...patient, 
                        assignedTherapist: patient.therapist_id  
                    }));
                    populatePatientList(patientData, data.therapists);
                } else {
                    alert('Failed to load patients and therapists.');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Populate the table with patients and therapist dropdowns
    function populatePatientList(patients, therapists) {
        patientList.innerHTML = ''; // Clear previous list
        patients.forEach((patient, index) => {
            const row = document.createElement('tr');
            const therapistDropdown = document.createElement('select');

            // Create the dropdown options for therapists
            therapists.forEach(therapist => {
                const option = document.createElement('option');
                option.value = therapist.id;
                option.text = therapist.name;
                if (therapist.id === patient.assignedTherapist) {
                    option.selected = true;
                }
                therapistDropdown.appendChild(option);
            });

            // Populate the row for each patient
            row.innerHTML = `
                <td>${patient.name}</td>
                <td>${patient.current_therapist || 'None'}</td>
            `;
            const therapistCell = document.createElement('td');
            therapistCell.appendChild(therapistDropdown);
            row.appendChild(therapistCell);
            patientList.appendChild(row);

            // Add listener for changes to update patient data
            therapistDropdown.addEventListener('change', () => {
                saveAssignmentsBtn.disabled = false;
                patientData[index].assignedTherapist = parseInt(therapistDropdown.value); 
                console.log(`Patient ${patient.name} assigned to therapist ${therapistDropdown.value}`);
            });
        });
    }

    // Save the assignments
    saveAssignmentsBtn.addEventListener('click', function () {
        const assignments = patientData.map(patient => ({
            patientId: patient.id,
            therapistId: patient.assignedTherapist || null  
        }));

        console.log('Sending assignments:', assignments);  

        fetch('assign_therapists.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ assignments })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Therapist assignments updated successfully!');
                    saveAssignmentsBtn.disabled = true;
                    fetchPatientsAndTherapists();  
                } else {
                    alert('Failed to update therapist assignments.');
                }
            })
            .catch(error => console.error('Error:', error));
    });

    
    fetchPatientsAndTherapists();
});
