<?php
include '../config/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
  echo "Invalid request ID.";
  exit;
}

// Delete the request
$stmt = $conn->prepare("DELETE FROM recruitment_requests WHERE id = ?");
$stmt->execute([$id]);

header("Location: list.php");
exit;
?>
