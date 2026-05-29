<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>File Upload</title>
<style>
  body { font-family: Arial, sans-serif; padding: 20px; }
</style>
</head>
<body>

<h1>Upload a File (image, pdf, mp4, etc.)</h1>

<form action="upload.php" method="post" enctype="multipart/form-data">
  <label for="file">Choose file:</label><br>
  <input type="file" name="file" id="file" required>
  <p style="font-size:0.9rem; color:#555;">Max size: 50MB. Uploaded files go to /uploads</p>
  <button type="submit">Upload</button>
</form>

</body>
</html>
