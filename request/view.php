<?php
include '../config/db.php';
session_start();
ob_start();

$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['flash']['error'] = "Missing request ID.";
    header("Location: list.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM department_requests WHERE id = ?");
$stmt->execute([$id]);
$request = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$request) {
    $_SESSION['flash']['error'] = "Request not found.";
    header("Location: list.php");
    exit;
}
?>

<h1 class="text-2xl font-bold mb-4">Request Details</h1>

<div class="bg-white p-6 rounded shadow max-w-md space-y-3">
  <p><strong>Department:</strong> <?= htmlspecialchars($request['department_name']) ?></p>
  <p><strong>Position:</strong> <?= htmlspecialchars($request['requested_position']) ?></p>
  <p><strong>Details:</strong><br><?= nl2br(htmlspecialchars($request['request_details'])) ?></p>
  <p><strong>Status:</strong> <?= ucfirst($request['status']) ?></p>
  <p><strong>Date:</strong> <?= date('Y-m-d', strtotime($request['created_at'])) ?></p>

  <a href="list.php" class="inline-block mt-4 text-blue-600 hover:underline">&larr; Back to list</a>
</div>

<?php
$content = ob_get_clean();
$title = "View Department Request";
include '../views/layout.php';
?>
