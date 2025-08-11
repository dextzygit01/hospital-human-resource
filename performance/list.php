<?php
include '../config/db.php';
include '../partials/flash.php';
ob_start();

$stmt = $conn->query("SELECT * FROM performance_reviews ORDER BY review_date DESC");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="text-2xl font-bold mb-6">Initial Performance Reviews</h1>

<a href="add.php" class="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">+ Add Review</a>

<table class="min-w-full bg-white border rounded shadow-sm mt-4">
  <thead class="bg-gray-100">
    <tr>
      <th class="text-left py-3 px-4 border-b">Employee Name</th>
      <th class="text-left py-3 px-4 border-b">Reviewer</th>
      <th class="text-left py-3 px-4 border-b">Score</th>
      <th class="text-left py-3 px-4 border-b">Date</th>
      <th class="text-left py-3 px-4 border-b">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($reviews as $review): ?>
      <tr class="hover:bg-gray-50">
        <td class="py-2 px-4 border-b"><?= htmlspecialchars($review['employee_name']) ?></td>
        <td class="py-2 px-4 border-b"><?= htmlspecialchars($review['reviewer']) ?></td>
        <td class="py-2 px-4 border-b"><?= htmlspecialchars($review['score']) ?></td>
        <td class="py-2 px-4 border-b"><?= htmlspecialchars($review['review_date']) ?></td>
        <td class="py-2 px-4 border-b space-x-2">
          <a href="edit.php?id=<?= $review['id'] ?>" class="text-blue-600 hover:underline text-sm">Edit</a>
          <a href="delete.php?id=<?= $review['id'] ?>" class="text-red-600 hover:underline text-sm">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php
$content = ob_get_clean();
$title = "Performance Reviews";
include '../views/layout.php';
?>
