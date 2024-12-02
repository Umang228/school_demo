<?php
include('config.php');

// Fetch all classes
$stmt = $pdo->query("SELECT * FROM classes");
$classes = $stmt->fetchAll();

// Handle adding new class
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_name = $_POST['class_name'];
    $stmt = $pdo->prepare("INSERT INTO classes (name) VALUES (?)");
    $stmt->execute([$class_name]);
    header('Location: classes.php');
    exit;
}

// Handle deleting class
if (isset($_GET['delete'])) {
    $class_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM classes WHERE class_id = ?");
    $stmt->execute([$class_id]);
    header('Location: classes.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Manage Classes</h1>

        <form action="classes.php" method="POST">
            <div class="form-group">
                <label for="class_name">Class Name</label>
                <input type="text" class="form-control" id="class_name" name="class_name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Class</button>
        </form>

        <h3 class="mt-4">Classes</h3>
        <ul class="list-group">
            <?php foreach ($classes as $class): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= htmlspecialchars($class['name']); ?>
                <a href="classes.php?delete=<?= $class['class_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
            </li>
            <?php endforeach; ?>
        </ul>

        <a href="index.php" class="btn btn-secondary mt-3">Back to Students</a>
    </div>
</body>
</html>
