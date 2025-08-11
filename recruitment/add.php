<?php
include '../config/db.php';

ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $position = $_POST['position'] ?? '';
    $status = $_POST['status'] ?? 'Open';
    $date_posted = $_POST['date_posted'] ?? date('Y-m-d');

    if ($position) {
        $stmt = $conn->prepare("INSERT INTO recruitment (position, status, date_posted) VALUES (?, ?, ?)");
        $stmt->execute([$position, $status, $date_posted]);
        $_SESSION['flash']['success'] = 'Recruitment record added successfully.';
        header("Location: list.php");
        exit;
    } else {
        $_SESSION['flash']['error'] = 'Position is required.';
    }
}
?>

<h1 class="text-2xl font-bold mb-6">Add Recruitment Record</h1>

<a href="list.php" class="inline-block mb-4 text-sm text-blue-600 hover:underline">&larr; Back to List</a>

<?php include '../views/partials/flash.php'; ?>

<form method="POST" class="space-y-6 bg-white shadow p-6 rounded-lg">
  <div>
    <label class="block font-medium text-gray-700">Position</label>
    <input type="text" name="position" required
           class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-400">
  </div>

  <div>
    <label class="block font-medium text-gray-700">Status</label>
    <select name="status"
            class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-400">
      <option value="Open">Open</option>
      <option value="Closed">Closed</option>
    </select>
  </div>

  <div>
    <label class="block font-medium text-gray-700">Date Posted</label>
    <input type="date" name="date_posted" value="<?= date('Y-m-d') ?>"
           class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-400">
  </div>

  <div>
    <button type="submit"
            class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Submit</button>
  </div>
</form>

<?php
$content = ob_get_clean();
$title = "Add Recruitment";
include '../views/layout.php';
?>
