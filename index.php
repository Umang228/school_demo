<?php
include('config.php');

// Fetch all students along with their class names
$stmt = $pdo->query("SELECT student.*, classes.name AS class_name FROM student
                     JOIN classes ON student.class_id = classes.class_id");
$students = $stmt->fetchAll();

// Fetch all classes to check if any exist
$classesStmt = $pdo->query("SELECT * FROM classes");
$classes = $classesStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Student Management</h1>

        <?php if (empty($classes)): ?>
            <div class="alert alert-warning" role="alert">
                There are no classes available. Please <a href="classes.php" class="alert-link">add a class</a> first.
            </div>
        <?php else: ?>
            <a href="create.php" class="btn btn-primary mb-3">Add Student</a>
        <?php endif; ?>

        <a href="classes.php" class="btn btn-info mb-3">Add Class</a>

        <h3>Students List</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Class</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student['name']); ?></td>
                    <td><?= htmlspecialchars($student['email']); ?></td>
                    <td><?= htmlspecialchars($student['created_at']); ?></td>
                    <td><?= htmlspecialchars($student['class_name']); ?></td>
                    <td><img src="uploads/<?= htmlspecialchars($student['image']); ?>" width="50"></td>
                    <td>
                        <a href="view.php?id=<?= $student['id']; ?>" class="btn btn-info btn-sm">View</a>
                        <a href="edit.php?id=<?= $student['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?= $student['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
