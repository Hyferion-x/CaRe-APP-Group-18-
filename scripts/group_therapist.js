
function toggleMenu() {
    var dropdownMenu = document.getElementById("dropdownMenu");
    dropdownMenu.classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('#menu_img')) {
        var dropdowns = document.getElementsByClassName("dropdown");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}


function openModal() {
    document.getElementById("editProfileModal").style.display = "block";
    toggleMenu(); // Optionally close the dropdown menu when opening the modal
}

function closeModal() {
    document.getElementById("editProfileModal").style.display = "none";
}


function closegeneral() {
    document.getElementById("generalInfoForm").style.display = "none";
}

// Close the modal if the user clicks outside of it
window.onclick = function(event) {
    var modal = document.getElementById("editProfileModal");
    if (event.target == modal) {
        closeModal();
    }
}

window.onclick = function(event) {
    var modal = document.getElementById("generalInfoForm");
    if (event.target == modal) {
        closegeneral();
    }
}


document.getElementById('profilePic').addEventListener('click', function() {
    document.getElementById('profilePicInput').click();
  });
  
  document.getElementById('profilePicInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('profilePic').src = e.target.result;
      }
      reader.readAsDataURL(file);
    }
  });

  function openForm(formId) {
    document.getElementById(formId).style.display = 'block';
}

function closeForm(formId) {
    document.getElementById(formId).style.display = 'none';
}

function updateGeneralInfo(event) {
    event.preventDefault(); // Prevent form from submitting

    // Get form values
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;

    // Update the display content
    document.getElementById('display-name').innerText = name;
    document.getElementById('display-email').innerText = email;
    document.getElementById('display-phone').innerText = phone;

    // Close the form
    closeForm('generalInfoForm');
}

document.getElementById('display-info').addEventListener('click', function() {
    // Get selected weight unit and input value
    const weightUnit = document.getElementById('weight-select').value;
    const weight = document.getElementById('weight-input').value;

    // Get selected height unit and input value
    const heightUnit = document.getElementById('height-select').value;
    const height = document.getElementById('height-input').value;

    // Get the name of the uploaded file
    const medicalReport = document.getElementById('medical-report').files[0] 
        ? document.getElementById('medical-report').files[0].name 
        : 'No file selected';

    // Display the weight and height with units
    document.getElementById('display-weight').textContent = weight ? `${weight} ${weightUnit}` : 'Not entered';
    document.getElementById('display-height').textContent = height ? `${height} ${heightUnit}` : 'Not entered';
    document.getElementById('display-report').textContent = medicalReport;
});