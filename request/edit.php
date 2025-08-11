<?php
include '../config/db.php';
  
ob_start();

$id = $_GET['id'] ?? null;
if (!$id) {
  header("Location: list.php");
  exit;
}

$stmt = $conn->prepare("SELECT * FROM department_requests WHERE id = ?");
$stmt->execute([$id]);
$request = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$request) {
  echo "<p class='text-red-600'>Request not found.</p>";
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $department = $_POST['department'];
  $position = $_POST['position'];
  $qualifications = $_POST['qualifications'];

  $stmt = $conn->prepare("UPDATE department_requests SET department=?, position=?, qualifications=? WHERE id=?");
  $stmt->execute([$department, $position, $qualifications, $id]);

  header("Location: list.php");
  exit;
}
?>

<h1 class="text-2xl font-bold mb-6">Edit Applicant Request</h1>

<form method="post" class="space-y-4 bg-white p-6 shadow rounded-lg max-w-xl">
  <div>
    <label class="block text-sm font-medium text-gray-700">Department</label>
    <input type="text" name="department" value="<?= htmlspecialchars($request['department']) ?>" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
  </div>
  <div>
    <label class="block text-sm font-medium text-gray-700">Position</label>
    <input type="text" name="position" value="<?= htmlspecialchars($request['position']) ?>" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
  </div>
  <div>
    <label class="block text-sm font-medium text-gray-700">Qualifications</label>
    <textarea name="qualifications" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><?= htmlspecialchars($request['qualifications']) ?></textarea>
  </div>
  <div>
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update</button>
  </div>
</form>

<?php
$content = ob_get_clean();
$title = "Edit Applicant Request";
include '../views/layout.php';
?>
