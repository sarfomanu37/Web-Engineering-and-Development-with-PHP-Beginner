<?php
require 'db.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM uploads WHERE id = ?");
$stmt->execute([$id]);
$fileData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$fileData) {
    die("File not found in database.");
}

$filePath = 'uploads/' . $fileData['filename'];
if (!file_exists($filePath)) {
    die("File not found on server.");
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>File Preview</title>
<style>
  body { font-family: Arial, sans-serif; padding: 20px; }
  img, video { max-width: 100%; height: auto; }
  iframe { border: none; }
</style>
</head>
<body>

<h1>File Uploaded Successfully</h1>
<p><strong>Original name:</strong> <?= htmlspecialchars($fileData['original_name']) ?></p>
<p><strong>MIME type:</strong> <?= htmlspecialchars($fileData['mime_type']) ?></p>
<p><strong>Size:</strong> <?= round($fileData['file_size'] / 1024, 2) ?> KB</p>
<p><strong>Uploaded on:</strong> <?= htmlspecialchars($fileData['upload_date']) ?></p>

<?php if (strpos($fileData['mime_type'], 'image/') === 0): ?>
  <h3>Image Preview</h3>
  <img src="<?= htmlspecialchars($filePath) ?>" alt="Uploaded image">
  <p><a href="<?= htmlspecialchars($filePath) ?>" download>Download Image</a></p>

<?php elseif ($fileData['mime_type'] === 'application/pdf'): ?>
  <h3>PDF Preview</h3>
  <iframe src="<?= htmlspecialchars($filePath) ?>" width="100%" height="600"></iframe>
  <p><a href="<?= htmlspecialchars($filePath) ?>" download>Download PDF</a></p>

<?php elseif (strpos($fileData['mime_type'], 'video/') === 0): ?>
  <h3>Video Preview</h3>
  <video controls>
    <source src="<?= htmlspecialchars($filePath) ?>" type="<?= htmlspecialchars($fileData['mime_type']) ?>">
    Your browser does not support the video tag.
  </video>
  <p><a href="<?= htmlspecialchars($filePath) ?>" download>Download Video</a></p>

<?php else: ?>
  <h3>File Uploaded</h3>
  <p>This file type cannot be previewed inline. <a href="<?= htmlspecialchars($filePath) ?>" download>Download file</a>.</p>
<?php endif; ?>

<p><a href="index.php">Upload another file</a></p>

</body>
</html>
