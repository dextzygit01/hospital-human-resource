<?php
include '../config/db.php';
include '../partials/flash.php';
ob_start();

$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['flash']['error'] = "No recruitment ID provided.";
    header("Location: list.php");
    exit;
}

// Fetch the record
$stmt = $conn->prepare("SELECT * FROM recruitment WHERE id = ?");
$stmt->execute([$id]);
$recruitment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recruitment) {
    $_SESSION['flash']['error'] = "Recruitment record not found.";
    header("Location: list.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("DELETE FROM recruitment WHERE id = ?");
    $stmt->execute([$id]);

    $_SESSION['flash']['success'] = "Recruitment record deleted.";
    header("Location: list.php");
    exit;
}
?>

<h1 class="text-2xl font-bold text-red-600 mb-6">Delete Recruitment</h1>

<a href="list.php" class="inline-block mb-4 text-sm text-blue-600 hover:underline">&larr; Cancel and go back</a>

<div class="bg-white p-6 rounded shadow-md max-w-md">
  <p class="mb-4 text-gray-700">Are you sure you want to delete the recruitment for:</p>

  <div class="mb-6 px-4 py-3 bg-gray-100 rounded border-l-4 border-red-400">
    <strong class="block text-lg text-red-700"><?= htmlspecialchars($recruitment['position']) ?></strong>
    <span class="text-sm text-gray-600">Posted on: <?= htmlspecialchars($recruitment['date_posted']) ?></span><br>
    <span class="text-sm text-gray-600">Status: <?= htmlspecialchars($recruitment['status']) ?></span>
  </div>

  <form method="POST">
    <div class="flex space-x-4">
      <button type="submit" class="px-5 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Yes, Delete</button>
      <a href="list.php" class="px-5 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Cancel</a>
    </div>
  </form>
</div>

<?php
$content = ob_get_clean();
$title = "Delete Recruitment";
include '../views/layout.php';
?>
