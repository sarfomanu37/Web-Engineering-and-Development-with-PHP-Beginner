<?php
// ==== Database Connection ====
// Database connection + form processing
$host = 'localhost';
$dbname = 'school';
$username = 'root'; // Change if needed
$password = '';     // Change if needed

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

// ==== Form Processing ====
$errors = [];
$success = '';
$old = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = trim($_POST['index_number'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $level = $_POST['level'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $password = $_POST['password'] ?? '';

    $old = $_POST;

    if (empty($index)) $errors[] = "Index number is required.";
    if (empty($name)) $errors[] = "Name is required.";
    if (empty($level)) $errors[] = "Level is required.";
    if (empty($gender)) $errors[] = "Gender is required.";
    if (empty($password)) $errors[] = "Password is required.";

    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO students (index_number, name, level, gender, password_hash) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$index, $name, $level, $gender, $password_hash]);
            $success = "Student registered successfully!";
            $old = []; // Clear form values on success
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>
