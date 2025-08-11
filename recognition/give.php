<?php
include '../config/db.php';
ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'] ?? '';
    $recognition_text = $_POST['recognition_text'] ?? '';

    if ($employee_id && $recognition_text) {
        $stmt = $conn->prepare("INSERT INTO recognitions (employee_id, recognition_text, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$employee_id, $recognition_text]);

        $_SESSION['flash']['success'] = "Recognition given successfully.";
        header("Location: give.php");
        exit;
    } else {
        $_SESSION['flash']['error'] = "Please fill in all fields.";
    }
}

// Fetch employees for selection
$employees = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM hires ORDER BY first_name, last_name")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="text-2xl font-bold mb-6">Give Social Recognition</h1>

<?php if (!empty($_SESSION['flash']['success'])): ?>
  <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
    <?= $_SESSION['flash']['success'] ?>
  </div>
  <?php unset($_SESSION['flash']['success']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['flash']['error'])): ?>
  <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
    <?= $_SESSION['flash']['error'] ?>
  </div>
  <?php unset($_SESSION['flash']['error']); ?>
<?php endif; ?>

<form method="POST" class="bg-white shadow border border-gray-200 rounded-lg p-6 space-y-5 max-w-xl">
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
    <select name="employee_id" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
      <option value="">Select an employee</option>
      <?php foreach ($employees as $employee): ?>
        <option value="<?= htmlspecialchars($employee['id']) ?>"><?= htmlspecialchars($employee['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Recognition Text</label>
    <textarea name="recognition_text" required rows="4" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
  </div>

  <div class="flex items-center justify-between">
    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Give Recognition</button>
  </div>
</form>

<?php
$content = ob_get_clean();
$title = "Give Social Recognition";
include '../views/layout.php';
?>
