<?php
include '../config/db.php';
include '../partials/flash.php'; // ✅ Include the flash message system
ob_start();

$hire_id = $_GET['id'] ?? null;

if (!$hire_id) {
    echo "<div class='text-red-600'>No hire ID provided.</div>";
    exit;
}

// Fetch hire record
$stmt = $conn->prepare("SELECT hires.*, applicants.name FROM hires JOIN applicants ON hires.applicant_id = applicants.id WHERE hires.id = ?");
$stmt->execute([$hire_id]);
$hire = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$hire) {
    echo "<div class='text-red-600'>Hire not found.</div>";
    exit;
}

$errors = [];
$success = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $department = $_POST['department'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $status = $_POST['onboarding_status'] ?? '';

    if (!$department || !$start_date || !$status) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE hires SET department = ?, start_date = ?, onboarding_status = ? WHERE id = ?");
        $stmt->execute([$department, $start_date, $status, $hire_id]);
        $success = true;

        // Refresh data
        $stmt = $conn->prepare("SELECT hires.*, applicants.name FROM hires JOIN applicants ON hires.applicant_id = applicants.id WHERE hires.id = ?");
        $stmt->execute([$hire_id]);
        $hire = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Onboarding Details</h1>

<?php if ($success): ?>
  <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">Changes saved successfully.</div>
<?php elseif (!empty($errors)): ?>
  <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
    <?= implode('<br>', $errors) ?>
  </div>
<?php endif; ?>

<form method="POST" class="bg-white shadow rounded-lg p-6 space-y-4 max-w-xl">
  <div>
    <label class="block mb-1 font-medium text-gray-700">Applicant</label>
    <input type="text" readonly class="w-full bg-gray-100 border rounded px-3 py-2 text-sm" value="<?= htmlspecialchars($hire['name']) ?>">
  </div>

  <div>
    <label class="block mb-1 font-medium text-gray-700">Department</label>
    <input type="text" name="department" value="<?= htmlspecialchars($hire['department']) ?>" required class="w-full border rounded px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
  </div>

  <div>
    <label class="block mb-1 font-medium text-gray-700">Start Date</label>
    <input type="date" name="start_date" value="<?= htmlspecialchars($hire['start_date']) ?>" required class="w-full border rounded px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
  </div>

  <div>
    <label class="block mb-1 font-medium text-gray-700">Onboarding Status</label>
    <select name="onboarding_status" class="w-full border rounded px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
      <option value="Pending" <?= $hire['onboarding_status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
      <option value="In Progress" <?= $hire['onboarding_status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
      <option value="Completed" <?= $hire['onboarding_status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
    </select>
  </div>

  <div class="text-right">
    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition text-sm font-medium">
      Save Changes
    </button>
  </div>
</form>

<?php
$content = ob_get_clean();
$title = "Edit Onboarding";
include '../views/layout.php';
?>
