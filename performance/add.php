<?php
include '../config/db.php';
include '../partials/flash.php';
ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_name = $_POST['employee_name'];
    $reviewer = $_POST['reviewer'];
    $score = $_POST['score'];
    $review_date = $_POST['review_date'];

    $stmt = $conn->prepare("INSERT INTO performance_reviews (employee_name, reviewer, score, review_date) VALUES (?, ?, ?, ?)");
    $stmt->execute([$employee_name, $reviewer, $score, $review_date]);

    $_SESSION['flash']['success'] = "Performance review added.";
    header("Location: list.php");
    exit;
}
?>

<h1 class="text-2xl font-bold mb-6">Add Performance Review</h1>

<a href="list.php" class="mb-4 inline-block text-blue-600 hover:underline text-sm">&larr; Back to List</a>

<form method="POST" class="bg-white p-6 rounded shadow-md max-w-md">
  <div class="mb-4">
    <label class="block font-semibold text-gray-700 mb-1">Employee Name</label>
    <input type="text" name="employee_name" required class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-200">
  </div>

  <div class="mb-4">
    <label class="block font-semibold text-gray-700 mb-1">Reviewer</label>
    <input type="text" name="reviewer" required class="w-full border border-gray-300 p-2 rounded">
  </div>

  <div class="mb-4">
    <label class="block font-semibold text-gray-700 mb-1">Score</label>
    <input type="number" name="score" min="1" max="10" required class="w-full border border-gray-300 p-2 rounded">
  </div>

  <div class="mb-6">
    <label class="block font-semibold text-gray-700 mb-1">Review Date</label>
    <input type="date" name="review_date" required class="w-full border border-gray-300 p-2 rounded">
  </div>

  <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Add Review</button>
</form>

<?php
$content = ob_get_clean();
$title = "Add Performance Review";
include '../views/layout.php';
?>
