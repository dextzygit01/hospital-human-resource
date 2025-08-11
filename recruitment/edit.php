<?php
include '../config/db.php';
include '../partials/flash.php';
ob_start();

$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['flash']['error'] = 'No recruitment ID provided.';
    header("Location: list.php");
    exit;
}

// Fetch existing record
$stmt = $conn->prepare("SELECT * FROM recruitment WHERE id = ?");
$stmt->execute([$id]);
$recruitment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recruitment) {
    $_SESSION['flash']['error'] = 'Recruitment record not found.';
    header("Location: list.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $position = $_POST['position'] ?? '';
    $status = $_POST['status'] ?? 'Open';
    $date_posted = $_POST['date_posted'] ?? date('Y-m-d');

    if ($position) {
        $stmt = $conn->prepare("UPDATE recruitment SET position = ?, status = ?, date_posted = ? WHERE id = ?");
        $stmt->execute([$position, $status, $date_posted, $id]);
        $_SESSION['flash']['success'] = 'Recruitment record updated successfully.';
        header("Location: list.php");
        exit;
    } else {
        $_SESSION['flash']['error'] = 'Position is required.';
    }
}
?>

<h1 class="text-2xl font-bold mb-6">Edit Recruitment Record</h1>

<a href="list.php" class="inline-block mb-4 text-sm text-blue-600 hover:underline">&larr; Back to List</a>

<?php include '../partials/flash.php'; ?>

<form method="POST" class="space-y-6 bg-white shadow p-6 rounded-lg">
  <div>
    <label class="block font-medium text-gray-700">Position</label>
    <input type="text" name="position" value="<?= htmlspecialchars($recruitment['position']) ?>" required
           class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-400">
  </div>

  <div>
    <label class="block font-medium text-gray-700">Status</label>
    <select name="status"
            class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-400">
      <option value="Open" <?= $recruitment['status'] === 'Open' ? 'selected' : '' ?>>Open</option>
      <option value="Closed" <?= $recruitment['status'] === 'Closed' ? 'selected' : '' ?>>Closed</option>
    </select>
  </div>

  <div>
    <label class="block font-medium text-gray-700">Date Posted</label>
    <input type="date" name="date_posted" value="<?= htmlspecialchars($recruitment['date_posted']) ?>"
           class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-400">
  </div>

  <div>
    <button type="submit"
            class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Update</button>
  </div>
</form>

<?php
$content = ob_get_clean();
$title = "Edit Recruitment";
include '../views/layout.php';
?>
