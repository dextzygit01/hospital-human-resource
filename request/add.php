<?php
include '../config/db.php';
ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $department = $_POST['department'];
  $position = $_POST['position'];
  $num_applicants = $_POST['num_applicants'];
  $qualifications = $_POST['qualifications'];
  $deadline = $_POST['deadline'];

  $stmt = $conn->prepare("INSERT INTO recruitment_requests (department_name, position_needed, num_applicants, qualifications, deadline) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$department, $position, $num_applicants, $qualifications, $deadline]);

  header("Location: list.php");
  exit;
}
?>

<h1 class="text-2xl font-bold mb-6">New Recruitment Request</h1>

<form method="post" class="space-y-4 bg-white p-6 shadow rounded-lg max-w-xl">
  <div>
    <label class="block text-sm font-medium text-gray-700">Department Name</label>
    <input type="text" name="department" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700">Position Needed</label>
    <input type="text" name="position" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700">Number of Applicants</label>
    <input type="number" name="num_applicants" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700">Qualifications</label>
    <textarea name="qualifications" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700">Deadline</label>
    <input type="date" name="deadline" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
  </div>

  <div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit Request</button>
  </div>
</form>

<?php
$content = ob_get_clean();
$title = "Add Recruitment Request";
include '../views/layout.php';
?>
