<?php
include '../config/db.php';
include '../partials/flash.php'; // ✅ Include the flash message system

$hire_id = $_GET['id'] ?? null;

if (!$hire_id) {
    header("Location: onboard.php?status=invalid");
    exit;
}

// Check if the hire exists
$stmt = $conn->prepare("SELECT id FROM hires WHERE id = ?");
$stmt->execute([$hire_id]);

if ($stmt->rowCount() === 0) {
    header("Location: onboard.php?status=notfound");
    exit;
}

// Perform the delete
$stmt = $conn->prepare("DELETE FROM hires WHERE id = ?");
$stmt->execute([$hire_id]);

header("Location: onboard.php?status=deleted");
exit;
?>
