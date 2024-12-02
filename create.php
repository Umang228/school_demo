<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];

    // Image upload handling
    $image = $_FILES['image']['name'];
    $target = 'uploads/' . basename($image);

    // Validate inputs
    if (empty($name)) {
        echo "Name is required.";
    } elseif ($_FILES['image']['type'] != 'image/jpeg' && $_FILES['image']['type'] != 'image/png') {
        echo "Invalid image format.";
    } else {
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $stmt = $pdo->prepare("INSERT INTO student (name, email, address, class_id, image) 
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $address, $class_id, $image]);

        header('Location: index.php');
        exit;
    }
}

// Fetch classes for dropdown
$stmt = $pdo->query("SELECT * FROM classes");
$classes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Add New Student</h1>
        <form action="create.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address"></textarea>
            </div>
            <div class="form-group">
                <label for="class_id">Class</label>
                <select class="form-control" id="class_id" name="class_id" required>
                    <?php foreach ($classes as $class): ?>
                    <option value="<?= $class['class_id']; ?>"><?= htmlspecialchars($class['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
