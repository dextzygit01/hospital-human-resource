<?php
include '../config/db.php';
include '../partials/flash.php'; // ✅ Include the flash message system
ob_start();

$errors = [];
$success = false;

// Fetch applicants
$applicants = $conn->query("SELECT id, name FROM applicants ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $applicant_id = $_POST['applicant_id'] ?? null;
    $department = $_POST['department'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $status = $_POST['onboarding_status'] ?? 'Pending';

    if (!$applicant_id || !$department || !$start_date) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO hires (applicant_id, department, start_date, onboarding_status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$applicant_id, $department, $start_date, $status]);
        $success = true;
    }
}
?>

<h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Hire for Onboarding</h1>

<?php if ($success): ?>
  <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">Hire added successfully.</div>
<?php elseif (!empty($errors)): ?>
  <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
    <?= implode('<br>', $errors) ?>
  </div>
<?php endif; ?>

<form method="POST" class="bg-white shadow rounded-lg p-6 space-y-4 max-w-xl">
  <div>
    <label class="block mb-1 font-medium text-gray-700">Select Applicant</label>
    <select name="applicant_id" required class="w-full border rounded px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
      <option value="">-- Choose Applicant --</option>
      <?php foreach ($applicants as $applicant): ?>
        <option value="<?= $applicant['id'] ?>"><?= htmlspecialchars($applicant['name']) ?></option>
      <?php endforeach ?>
    </select>
  </div>

  <div>
    <label class="block mb-1 font-medium text-gray-700">Department</label>
    <input type="text" name="department" required class="w-full border rounded px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. Human Resources">
  </div>

  <div>
    <label class="block mb-1 font-medium text-gray-700">Start Date</label>
    <input type="date" name="start_date" required class="w-full border rounded px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
  </div>

  <div>
    <label class="block mb-1 font-medium text-gray-700">Onboarding Status</label>
    <select name="onboarding_status" class="w-full border rounded px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
      <option value="Pending">Pending</option>
      <option value="In Progress">In Progress</option>
      <option value="Completed">Completed</option>
    </select>
  </div>

  <div class="text-right">
    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition text-sm font-medium">
      Save
    </button>
  </div>
</form>

<?php
$content = ob_get_clean();
$title = "Add New Hire";
include '../views/layout.php';
?>
