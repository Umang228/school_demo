<?php
include('config.php');

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT student.*, classes.name AS class_name FROM student 
                       JOIN classes ON student.class_id = classes.class_id 
                       WHERE student.id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4"><?= htmlspecialchars($student['name']); ?></h1>
        <p><strong>Email:</strong> <?= htmlspecialchars($student['email']); ?></p>
        <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($student['address'])); ?></p>
        <p><strong>Class:</strong> <?= htmlspecialchars($student['class_name']); ?></p>
        <p><strong>Created At:</strong> <?= $student['created_at']; ?></p>
        <img src="uploads/<?= htmlspecialchars($student['image']); ?>" width="150" />
        <a href="index.php" class="btn btn-secondary mt-3">Back to List</a>
    </div>
</body>
</html>
