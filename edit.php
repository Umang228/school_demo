<?php
include('config.php');

$id = $_GET['id'];

// Fetch current student details
$stmt = $pdo->prepare("SELECT student.*, classes.name AS class_name FROM student 
                       JOIN classes ON student.class_id = classes.class_id 
                       WHERE student.id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

// Fetch classes for dropdown
$classesStmt = $pdo->query("SELECT * FROM classes");
$classes = $classesStmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];

    // Handle image upload if a new one is provided
    $image = $student['image']; // keep existing image by default
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = 'uploads/' . basename($image);
        if ($_FILES['image']['type'] == 'image/jpeg' || $_FILES['image']['type'] == 'image/png') {
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
        }
    }

    // Update student information
    $stmt = $pdo->prepare("UPDATE student SET name = ?, email = ?, address = ?, class_id = ?, image = ? WHERE id = ?");
    $stmt->execute([$name, $email, $address, $class_id, $image, $id]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Edit Student</h1>
        <form action="edit.php?id=<?= $student['id']; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($student['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($student['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address"><?= htmlspecialchars($student['address']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="class_id">Class</label>
                <select class="form-control" id="class_id" name="class_id" required>
                    <?php foreach ($classes as $class): ?>
                    <option value="<?= $class['class_id']; ?>" <?= $class['class_id'] == $student['class_id'] ? 'selected' : ''; ?>><?= htmlspecialchars($class['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <img src="uploads/<?= htmlspecialchars($student['image']); ?>" width="100" class="mt-2" />
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</body>
</html>
