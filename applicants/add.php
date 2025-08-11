<?php
include '../config/db.php';
ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $role_applied = $_POST['role_applied'] ?? '';
    $resume_link = $_POST['resume_link'] ?? '';

    $stmt = $conn->prepare("INSERT INTO applicants (name, email, role_applied, resume_link) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $role_applied, $resume_link]);

    $_SESSION['flash']['success'] = "Applicant added successfully.";
    header("Location: list.php");
    exit;
}
?>

<h1 class="text-2xl font-bold mb-6">Add New Applicant</h1>

<form method="POST" class="bg-white shadow border border-gray-200 rounded-lg p-6 space-y-5 max-w-xl">
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
    <input type="text" name="name" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
    <input type="email" name="email" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Role Applied</label>
    <input type="text" name="role_applied" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Resume Link (URL)</label>
    <input type="url" name="resume_link" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
  </div>

  <div class="flex items-center justify-between">
    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Save</button>
    <a href="list.php" class="text-sm text-gray-600 hover:underline">← Back to list</a>
  </div>
</form>

<?php
$content = ob_get_clean();
$title = "Add Applicant";
include '../views/layout.php';
?>
