//weli0007
document.addEventListener('DOMContentLoaded', function() {
    fetchUserProfile();

    const editBtn = document.getElementById('edit-btn');
    const saveBtn = document.getElementById('save-btn');
    const formFields = document.querySelectorAll('#edit-profile-form input, #edit-profile-form select, #edit-contact-form input');

    
    toggleFormFields(formFields, true);

    
    editBtn.addEventListener('click', function() {
        toggleFormFields(formFields, false); 
        toggleButtons(editBtn, saveBtn, false); 
    });

    // Save the form data when clicking the Save button
    saveBtn.addEventListener('click', function(event) {
        event.preventDefault(); 
        if (validateEmail()) {
            saveProfile(); 
        } else {
            alert('Invalid email address. Please enter a valid email.');
        }
    });
});

// Function to validate email
function validateEmail() {
    const email = document.getElementById('edit-email').value;
    const emailPattern = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
    return emailPattern.test(email);
}

// Function to fetch user profile 
function fetchUserProfile() {
    fetch('fetch-user-profile.php') 
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error fetching profile data:', data.error);
                alert('Error fetching profile. Please try again.');
                return;
            }

            // Handle the profile photo
            const profilePhoto = document.getElementById('profile-photo');
            
            
            if (data.photo) {
                
                profilePhoto.src = `/CaRe/${data.photo}`;
            } else {
                profilePhoto.src = ''; 
            }

            profilePhoto.onerror = function() {
                
                console.error('Image failed to load:', profilePhoto.src);
            };

            
            document.getElementById('profile-name').textContent = data.name || 'Name not available';
            document.getElementById('profile-bio').textContent = data.bio || 'No bio available';

            
            document.getElementById('edit-username').value = data.username || '';
            document.getElementById('edit-gender').value = data.gender || '';
            document.getElementById('edit-birthday').value = data.birthday || '';
            document.getElementById('edit-blood-type').value = data.blood_type || '';
            document.getElementById('edit-allergies').value = data.allergies || '';
            document.getElementById('edit-insurance-id').value = data.insurance_id || '';

            
            document.getElementById('edit-email').value = data.email || '';
            document.getElementById('edit-phone').value = data.phone || '';
            document.getElementById('edit-mobile').value = data.mobile || '';
            document.getElementById('edit-address').value = data.address || '';
        })
        .catch(error => {
            console.error('Error fetching profile data:', error);
            alert('Error fetching profile data. Please try again later.');
            document.getElementById('profile-name').textContent = 'Error loading name';
            document.getElementById('profile-bio').textContent = 'Error loading bio';
            document.getElementById('profile-photo').src = '';
        });
}


// Function to save the profile data
function saveProfile() {
    const formData = new FormData(document.getElementById('edit-profile-form'));
    const contactData = new FormData(document.getElementById('edit-contact-form'));

    for (let pair of contactData.entries()) {
        formData.append(pair[0], pair[1]);
    }

    fetch('save-user-profile.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Profile updated successfully');
            fetchUserProfile(); 

            // Disable form fields again after saving
            toggleFormFields(document.querySelectorAll('#edit-profile-form input, #edit-profile-form select, #edit-contact-form input'), true);

            // Switch buttons back to initial state
            toggleButtons(document.getElementById('edit-btn'), document.getElementById('save-btn'), true);
        } else {
            console.error('Error updating profile:', data.error || 'Unknown error');
            alert('Error updating profile. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error saving profile data:', error);
        alert('Error saving profile data. Please try again later.');
    });
}

// function to enable or disable form fields
function toggleFormFields(fields, disable) {
    fields.forEach(field => {
        field.disabled = disable;
    });
}

// function to toggle between Edit and Save buttons
function toggleButtons(editBtn, saveBtn, isEditMode) {
    if (isEditMode) {
        editBtn.style.display = 'inline-block';
        saveBtn.style.display = 'none';
    } else {
        editBtn.style.display = 'none';
        saveBtn.style.display = 'inline-block';
    }
}
