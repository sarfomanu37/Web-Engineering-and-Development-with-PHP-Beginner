<?php include 'form-handler.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
</head>
<body>
<h2>Student Registration Form</h2>

<?php if ($errors): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green;"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<form method="post" action="">
    <label>Index Number:</label><br>
    <input type="text" name="index_number" value="<?= htmlspecialchars($old['index_number'] ?? '') ?>"><br><br>

    <label>Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>"><br><br>

    <label>Level:</label><br>
    <select name="level">
        <option value="">--Select Level--</option>
        <option value="100" <?= (isset($old['level']) && $old['level'] == '100') ? 'selected' : '' ?>>100</option>
        <option value="200" <?= (isset($old['level']) && $old['level'] == '200') ? 'selected' : '' ?>>200</option>
        <option value="300" <?= (isset($old['level']) && $old['level'] == '300') ? 'selected' : '' ?>>300</option>
        <option value="400" <?= (isset($old['level']) && $old['level'] == '400') ? 'selected' : '' ?>>400</option>
    </select><br><br>

    <label>Gender:</label><br>
    <input type="radio" name="gender" value="Male" <?= (isset($old['gender']) && $old['gender'] === 'Male') ? 'checked' : '' ?>> Male
    <input type="radio" name="gender" value="Female" <?= (isset($old['gender']) && $old['gender'] === 'Female') ? 'checked' : '' ?>> Female<br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Submit</button>
</form>
</body>
</html>
