<?php
require 'db.php'; // include database connection

$uploadDir = __DIR__ . '/uploads';
$maxFileSize = 50 * 1024 * 1024; // 50MB

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Error uploading file. Code: " . $file['error']);
    }
    if ($file['size'] > $maxFileSize) {
        die("File exceeds maximum size of 50MB.");
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']) ?: 'application/octet-stream';

    $origName = pathinfo($file['name'], PATHINFO_FILENAME);
    $origExt = pathinfo($file['name'], PATHINFO_EXTENSION);
    $safeBase = preg_replace('/[^A-Za-z0-9_\-]/', '_', $origName);
    $unique = $safeBase . '_' . time();
    $finalName = $unique . ($origExt ? '.' . $origExt : '');
    $destination = $uploadDir . '/' . $finalName;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        die("Failed to move uploaded file.");
    }

    chmod($destination, 0644);

    // Store file info in database
    $stmt = $pdo->prepare("INSERT INTO uploads (filename, original_name, mime_type, file_size) VALUES (:filename, :original_name, :mime_type, :file_size)");
    $stmt->execute([
        ':filename'      => $finalName,
        ':original_name' => $file['name'],
        ':mime_type'     => $mime,
        ':file_size'     => $file['size']
    ]);

    $fileId = $pdo->lastInsertId();

    // Redirect to preview
    header("Location: preview.php?id=" . $fileId);
    exit;
}
