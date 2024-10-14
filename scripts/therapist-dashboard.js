//weli0007
document.addEventListener('DOMContentLoaded', function () {
    let draggedPatient = null;

    
    function loadPatients() {
        fetch('fetch_therapist_patients.php')
            .then(response => response.json())
            .then(data => {
                const patientListContainer = document.getElementById('patient-list-container');
                patientListContainer.innerHTML = '';

                data.forEach(patient => {
                    const block = document.createElement('div');
                    block.classList.add('patient-block');
                    block.setAttribute('draggable', true);
                    block.setAttribute('data-patient-id', patient.id);
                    block.textContent = patient.name;

                    block.addEventListener('dragstart', (event) => {
                        draggedPatient = block;
                        setTimeout(() => block.classList.add('invisible'), 0);
                    });

                    block.addEventListener('dragend', () => {
                        draggedPatient = null;
                        block.classList.remove('invisible');
                    });

                    patientListContainer.appendChild(block);
                });
            })
            .catch(error => console.error('Error fetching patients:', error));
    }

    // Function to load existing groups
    function loadGroups() {
        fetch('fetch_groups.php')
            .then(response => response.json())
            .then(data => {
                const groupListContainer = document.getElementById('group-list-container');
                const noGroupsMessage = document.querySelector('.no-groups-message');

                groupListContainer.innerHTML = ''; 

                if (data.status === 'success' && data.groups.length > 0) {
                    noGroupsMessage.classList.add('hidden'); 

                    data.groups.forEach(group => {
                        const newDropzone = document.createElement('div');
                        newDropzone.classList.add('group-dropzone');
                        newDropzone.setAttribute('data-group-id', group.id);
                        newDropzone.textContent = group.name;

                        newDropzone.addEventListener('dragover', (event) => {
                            event.preventDefault();
                        });

                        newDropzone.addEventListener('drop', () => {
                            if (draggedPatient) {
                                newDropzone.appendChild(draggedPatient);
                                const patientId = draggedPatient.getAttribute('data-patient-id');
                                fetch('assign_patient_to_group.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: `patient_id=${patientId}&group_id=${group.id}`
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        console.log(`Patient ${patientId} assigned to group ${group.name}`);
                                    } else {
                                        console.error('Error assigning patient:', data.message);
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                            }
                        });

                        groupListContainer.appendChild(newDropzone);
                    });
                } else {
                    noGroupsMessage.classList.remove('hidden'); 
                }
            })
            .catch(error => console.error('Error fetching groups:', error));
    }

    // adding new groups
    document.getElementById('add-group').addEventListener('click', () => {
        const groupName = prompt("Enter the name for the new group:");
        if (groupName) {
            fetch('create_group.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `group_name=${encodeURIComponent(groupName)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const groupListContainer = document.getElementById('group-list-container');
                    const noGroupsMessage = document.querySelector('.no-groups-message');
                    noGroupsMessage.classList.add('hidden'); 

                    const newDropzone = document.createElement('div');
                    newDropzone.classList.add('group-dropzone');
                    newDropzone.setAttribute('data-group-id', data.group_id);
                    newDropzone.textContent = data.group_name; 

                    newDropzone.addEventListener('dragover', (event) => {
                        event.preventDefault();
                    });

                    newDropzone.addEventListener('drop', () => {
                        if (draggedPatient) {
                            newDropzone.appendChild(draggedPatient);
                            const patientId = draggedPatient.getAttribute('data-patient-id');
                            fetch('assign_patient_to_group.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: `patient_id=${patientId}&group_id=${data.group_id}`
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    console.log(`Patient ${patientId} assigned to new group ${groupName}`);
                                } else {
                                    console.error('Error assigning patient to new group:', data.message);
                                }
                            })
                            .catch(error => console.error('Error:', error));
                        }
                    });

                    groupListContainer.appendChild(newDropzone);
                } else {
                    console.error('Error creating group:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });

    
    loadPatients();
    loadGroups();
});
