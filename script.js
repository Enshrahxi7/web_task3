document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
    
    document.getElementById('userForm').addEventListener('submit', function(e) {
        e.preventDefault();
        addUser();
    });
});

function addUser() {
    const name = document.getElementById('name').value;
    const age = document.getElementById('age').value;
    
    if (!name || !age) {
        alert('Please fill in all fields');
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'add');
    formData.append('name', name);
    formData.append('age', age);
    
    fetch('process.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('userForm').reset();
            loadUsers();
        } else {
            alert('Error adding user: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding user');
    });
}

function loadUsers() {
    fetch('process.php?action=get')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayUsers(data.users);
        } else {
            console.error('Error loading users:', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function displayUsers(users) {
    const tbody = document.getElementById('userTableBody');
    tbody.innerHTML = '';
    
    users.forEach(user => {
        const row = document.createElement('tr');
        
        const statusText = user.status; // Show 0 or 1 instead of Active/Inactive
        const statusClass = user.status == 1 ? 'status-active' : 'status-inactive';
        const buttonClass = user.status == 1 ? 'active' : 'inactive';
        const buttonText = 'Toggle';
        
        row.innerHTML = `
            <td>${user.id}</td>
            <td>${user.name}</td>
            <td>${user.age}</td>
            <td class="${statusClass}">${statusText}</td>
            <td>
                <button class="toggle-btn ${buttonClass}" onclick="toggleStatus(${user.id})">
                    ${buttonText}
                </button>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

function toggleStatus(userId) {
    const formData = new FormData();
    formData.append('action', 'toggle');
    formData.append('id', userId);
    
    fetch('process.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadUsers();
        } else {
            alert('Error toggling status: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error toggling status');
    });
}