-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS school;

-- Select the database
USE school;

-- Create the students table
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    index_number VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    level VARCHAR(10) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
