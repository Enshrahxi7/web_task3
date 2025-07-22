<?php
// This file redirects to index.html or serves as the main entry point
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>User Management System</h1>
        
        <form id="userForm" class="form-container">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required>
            </div>
            
            <button type="submit">Submit</button>
        </form>
        
        <div class="table-container">
            <h2>User Records</h2>
            <table id="userTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    <!-- Data will be loaded here -->
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>