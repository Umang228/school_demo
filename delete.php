<?php
include('config.php');

$id = $_GET['id'];

// Fetch student details
$stmt = $pdo->prepare("SELECT * FROM student WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete the student's image file from the server
    $imagePath = 'uploads/' . $student['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete student record
    $stmt = $pdo->prepare("DELETE FROM student WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Are you sure you want to delete this student?</h1>
        <p><strong>Name:</strong> <?= htmlspecialchars($student['name']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($student['email']); ?></p>
        <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($student['address'])); ?></p>
        <p><img src="uploads/<?= htmlspecialchars($student['image']); ?>" width="100" /></p>

        <form action="delete.php?id=<?= $student['id']; ?>" method="POST">
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
