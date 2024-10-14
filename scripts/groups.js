document.addEventListener('DOMContentLoaded', function () {
    const groupListEl = document.querySelector('.group-list ul');
    const selectedGroupNameEl = document.querySelector('.right-section h2');
    const groupMembersEl = document.querySelector('#group-members');
    const addMemberBtn = document.querySelector('.add-member-btn');
    const addMemberModal = document.getElementById('add-member-modal');
    const closeModalBtn = addMemberModal.querySelector('.close');
    const addMemberForm = document.getElementById('add-member-form');
    const patientsDropdown = document.getElementById('patients');

    
    const createGroupBtn = document.querySelector('.create-group-btn');
    const groupNameInput = document.getElementById('new-group-name'); 

    let currentGroupId = null; 

    // Load groups 
    function loadGroups() {
        fetch('fetch_groups_overview.php')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success' && Array.isArray(data.groups)) {
                    groupListEl.innerHTML = ''; 
                    data.groups.forEach(group => {
                        const li = document.createElement('li');
                        li.textContent = group.group_name;
                        li.dataset.groupId = group.id;

                        
                        const removeGroupBtn = document.createElement('button');
                        removeGroupBtn.textContent = 'Remove Group';
                        removeGroupBtn.className = 'remove-group-btn';
                        removeGroupBtn.style.marginLeft = '10px';
                        removeGroupBtn.addEventListener('click', (e) => {
                            e.stopPropagation(); 
                            removeGroup(group.id);
                        });

                        li.appendChild(removeGroupBtn);
                        li.addEventListener('click', () => loadGroupDetails(group.id, group.group_name));
                        groupListEl.appendChild(li);
                    });
                } else {
                    console.error('No groups found or an error occurred.');
                    alert('No groups available.');
                }
            })
            .catch(error => console.error('Error fetching groups:', error));
    }

    
    function loadGroupDetails(groupId, groupName) {
        selectedGroupNameEl.textContent = groupName;
        currentGroupId = groupId; 

        
        groupMembersEl.innerHTML = '';

        
        fetch(`fetch_group_overview_details.php?group_id=${groupId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                
                if (data.members && data.members.length > 0) {
                    data.members.forEach(member => {
                        const li = document.createElement('li');
                        li.textContent = member.name;

                        
                        const removeBtn = document.createElement('button');
                        removeBtn.textContent = 'Remove';
                        removeBtn.className = 'remove-btn'; 
                        removeBtn.style.marginLeft = '10px';
                        removeBtn.addEventListener('click', () => removeMemberFromGroup(member.group_patient_id));

                        li.appendChild(removeBtn);
                        groupMembersEl.appendChild(li);
                    });
                } else {
                    const noMembers = document.createElement('li');
                    noMembers.textContent = 'No members in this group.';
                    groupMembersEl.appendChild(noMembers);
                }

                
                drawGroupOverview(data);
            })
            .catch(error => console.error('Error fetching group details:', error));
    }

    // Function to remove a group
    function removeGroup(groupId) {
        if (confirm('Are you sure you want to remove this group?')) {
            fetch('remove_group.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `group_id=${groupId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Group removed successfully.');
                    loadGroups(); 
                } else {
                    alert(data.message); 
                }
            })
            .catch(error => console.error('Error removing group:', error));
        }
    }

    
    addMemberBtn.addEventListener('click', () => {
        addMemberModal.style.display = 'block'; 
        loadPatients(); 
    });

    
    closeModalBtn.addEventListener('click', () => {
        addMemberModal.style.display = 'none'; 
    });

    
    function loadPatients() {
        fetch('fetch_available_patients.php')
            .then(response => response.json())
            .then(data => {
                patientsDropdown.innerHTML = ''; 
                if (data.status === 'success' && Array.isArray(data.patients)) {
                    data.patients.forEach(patient => {
                        const option = document.createElement('option');
                        option.value = patient.id;
                        option.textContent = patient.name;
                        patientsDropdown.appendChild(option);
                    });
                } else {
                    const noPatientsOption = document.createElement('option');
                    noPatientsOption.textContent = 'No patients available';
                    patientsDropdown.appendChild(noPatientsOption);
                }
            })
            .catch(error => console.error('Error fetching patients:', error));
    }

    // Add Member form submission
    addMemberForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const selectedPatientId = patientsDropdown.value;

        if (!selectedPatientId || !currentGroupId) {
            alert('Please select a patient and a valid group.');
            return;
        }

        // Assign patient to group 
        fetch('edit_assigned_patient.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `patient_id=${selectedPatientId}&group_id=${currentGroupId}&action=add`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Member added successfully.');
                addMemberModal.style.display = 'none'; 
                loadGroupDetails(currentGroupId, selectedGroupNameEl.textContent); 
            } else {
                alert('Error adding member.');
            }
        })
        .catch(error => console.error('Error assigning patient to group:', error));
    });

    // remove a member from the group
    function removeMemberFromGroup(groupPatientId) {
        if (confirm('Are you sure you want to remove this member from the group?')) {
            fetch('remove_group_member.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `group_patient_id=${groupPatientId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Member removed successfully.');
                    loadGroupDetails(currentGroupId, selectedGroupNameEl.textContent); 
                } else {
                    alert(data.message); 
                }
            })
            .catch(error => console.error('Error removing member:', error));
        }
    }

    // Create Group 
    createGroupBtn.addEventListener('click', () => {
        const groupName = groupNameInput.value.trim();
        if (!groupName) {
            alert('Please enter a group name.');
            return;
        }

        // Create a new group
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
                alert('Group created successfully.');
                groupNameInput.value = ''; 
                loadGroups(); 
            } else {
                alert('Error creating group.');
            }
        })
        .catch(error => console.error('Error creating group:', error));
    });

    
    function drawGroupOverview(groupData) {
        const canvas = document.getElementById('group-details-canvas');
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height); 

        
        ctx.fillStyle = '#0074D9';
        ctx.font = '20px Arial';
        ctx.fillText(`Group: ${groupData.group_name}`, 10, 30);
        ctx.fillText(`Members: ${groupData.members.length}`, 10, 60);
    }

    
    loadGroups();
});
