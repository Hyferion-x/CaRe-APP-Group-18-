document.addEventListener("DOMContentLoaded", function() {
  const searchButton = document.getElementById('search-button');
  const searchInput = document.getElementById('search-input');
  const searchResults = document.getElementById('search-results');
  const editPatientBtn = document.getElementById('editPatientBtn');
  const updatePatientBtn = document.getElementById('updatePatientBtn');

  let selectedPatientId = null;  // To keep track of the selected patient

  // Function to fetch patient data based on search query
  function searchPatients(query = '') {
      fetch(`fetch-patient.php?query=${query}`)
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  searchResults.innerHTML = ''; // Clear previous results
                  data.patients.forEach(patient => {
                      const patientDiv = document.createElement('div');
                      patientDiv.classList.add('patient-item');
                      patientDiv.innerText = `${patient.name} - ${patient.id}`;
                      patientDiv.addEventListener('click', () => fetchPatientDetails(patient.id));
                      searchResults.appendChild(patientDiv);
                  });
              } else {
                  searchResults.innerHTML = 'No patients found.';
              }
          })
          .catch(error => {
              console.error('Error fetching patients:', error);
              searchResults.innerHTML = 'Error fetching patients.';
          });
  }

  // Fetch patient details
  function fetchPatientDetails(patientId) {
      fetch(`fetch-patient.php?id=${patientId}`)
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  selectedPatientId = patientId;  // Set selected patient ID
                  document.getElementById('patient-name').value = data.name;
                  document.getElementById('patient-age').value = data.age;
                  document.getElementById('patient-gender').value = data.gender;
                  document.getElementById('patient-email').value = data.email;
                  document.getElementById('patient-phone').value = data.phone;
                  document.getElementById('patient-mobile').value = data.mobile;
                  document.getElementById('patient-address').value = data.address;
                  document.getElementById('patient-birthday').value = data.birthday;
                  document.getElementById('patient-allergies').value = data.allergies;
                  document.getElementById('patient-blood-type').value = data.blood_type;
                  document.getElementById('patient-insurance-id').value = data.insurance_id;
                  document.getElementById('patient-bio').value = data.bio;
              } else {
                  alert('No patient found.');
              }
          })
          .catch(error => {
              console.error('Error fetching patient details:', error);
          });
  }

  // Search button event
  searchButton.addEventListener('click', function() {
      const query = searchInput.value;
      searchPatients(query);
  });

  // Enable form editing
  editPatientBtn.addEventListener('click', function() {
      document.querySelectorAll('.patient-details input, .patient-details select, .patient-details textarea').forEach(field => {
          field.disabled = false;
      });
      updatePatientBtn.disabled = false;
  });

  // Update patient details in the database
  updatePatientBtn.addEventListener('click', function() {
      if (!selectedPatientId) {
          alert('Please select a patient first.');
          return;
      }

      const formData = new FormData();
      formData.append('id', selectedPatientId);  // Add patient ID
      formData.append('name', document.getElementById('patient-name').value);
      formData.append('age', document.getElementById('patient-age').value);
      formData.append('gender', document.getElementById('patient-gender').value);
      formData.append('email', document.getElementById('patient-email').value);
      formData.append('phone', document.getElementById('patient-phone').value);
      formData.append('mobile', document.getElementById('patient-mobile').value);
      formData.append('address', document.getElementById('patient-address').value);
      formData.append('birthday', document.getElementById('patient-birthday').value);
      formData.append('allergies', document.getElementById('patient-allergies').value);
      formData.append('blood_type', document.getElementById('patient-blood-type').value);
      formData.append('insurance_id', document.getElementById('patient-insurance-id').value);
      formData.append('bio', document.getElementById('patient-bio').value);

      fetch('update_patient.php', {
          method: 'POST',
          body: formData
      }).then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Patient details updated successfully.');
                document.querySelectorAll('.patient-details input, .patient-details select, .patient-details textarea').forEach(field => {
                    field.disabled = true;
                });
                updatePatientBtn.disabled = true;
            } else {
                alert('Failed to update patient details.');
            }
        })
        .catch(error => {
            console.error('Error updating patient:', error);
        });
  });

  // Load all patients initially
  searchPatients();
});
