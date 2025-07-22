-- Create database
CREATE DATABASE IF NOT EXISTS user_management CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Use the database
USE user_management;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    age INT NOT NULL,
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO users (name, age, status) VALUES 
('John', 25, 0),
('Sarah', 30, 1),
('Michael', 22, 0);

-- Show all users
SELECT * FROM users;