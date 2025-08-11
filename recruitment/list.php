<?php
include '../config/db.php';
include '../partials/flash.php'; // ✅ Include the flash message system
ob_start();

// Fetch requests
$stmt = $conn->query("SELECT * FROM department_requests ORDER BY id DESC");
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="text-2xl font-bold mb-6">Department Applicant Requests</h1>

<a href="add.php" class="mb-4 inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
  + New Department Request
</a>

<div class="overflow-x-auto bg-white shadow rounded-lg">
  <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-100 text-gray-600 text-sm font-medium">
      <tr>
        <th class="px-4 py-2 text-left">#</th>
        <th class="px-4 py-2 text-left">Department</th>
        <th class="px-4 py-2 text-left">Position Needed</th>
        <th class="px-4 py-2 text-left">Qualifications</th>
        <th class="px-4 py-2 text-left">Date Requested</th>
        <th class="px-4 py-2 text-left">Action</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 text-sm">
      <?php if (count($requests) === 0): ?>
        <tr>
          <td colspan="6" class="text-center py-4 text-gray-500">No requests found.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($requests as $i => $req): ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2"><?= $i + 1 ?></td>
            <td class="px-4 py-2 font-medium"><?= htmlspecialchars($req['department']) ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($req['position']) ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($req['qualifications']) ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars(date("M d, Y", strtotime($req['created_at']))) ?></td>
            <td class="px-4 py-2 space-x-2">
              <a href="edit.php?id=<?= $req['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
              <a href="delete.php?id=<?= $req['id'] ?>" onclick="return confirm('Are you sure?')" class="text-red-600 hover:underline">Delete</a>
            </td>
          </tr>
        <?php endforeach ?>
      <?php endif ?>
    </tbody>
  </table>
</div>

<?php
$content = ob_get_clean();
$title = "Inter-Department Requests";
include '../views/layout.php';
?>
