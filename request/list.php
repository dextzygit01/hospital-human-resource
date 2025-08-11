<?php
include '../config/db.php';

$stmt = $conn->query("SELECT * FROM recruitment_requests ORDER BY created_at DESC");
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Applicant Requests</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4 text-blue-600">Department Applicant Requests</h2>

    <table class="min-w-full table-auto border border-gray-300">
      <thead class="bg-gray-100">
        <tr>
          <th class="border px-4 py-2 text-left">Department</th>
          <th class="border px-4 py-2 text-left">Position</th>
          <th class="border px-4 py-2">#</th>
          <th class="border px-4 py-2 text-left">Qualifications</th>
          <th class="border px-4 py-2">Deadline</th>
          <th class="border px-4 py-2">Status</th>
          <th class="border px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($requests as $req): ?>
          <tr class="hover:bg-gray-50">
            <td class="border px-4 py-2"><?= htmlspecialchars($req['department_name']) ?></td>
            <td class="border px-4 py-2"><?= htmlspecialchars($req['position_needed']) ?></td>
            <td class="border px-4 py-2 text-center"><?= $req['num_applicants'] ?></td>
            <td class="border px-4 py-2"><?= nl2br(htmlspecialchars($req['qualifications'])) ?></td>
            <td class="border px-4 py-2 text-center"><?= $req['deadline'] ?></td>
            <td class="border px-4 py-2 text-center">
              <span class="inline-block px-2 py-1 rounded text-white
                <?= $req['status'] === 'Pending' ? 'bg-yellow-500' : ($req['status'] === 'Fulfilled' ? 'bg-green-600' : 'bg-blue-500') ?>">
                <?= $req['status'] ?>
              </span>
            </td>
            <td class="border px-4 py-2 text-center">
              <a href="edit.php?id=<?= $req['id'] ?>" class="text-blue-600 hover:underline text-sm">Update</a>
              |
              <a href="delete.php?id=<?= $req['id'] ?>" class="text-red-500 hover:underline text-sm"
                 onclick="return confirm('Delete this request?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($requests)): ?>
          <tr>
            <td colspan="7" class="text-center py-4 text-gray-500">No requests submitted.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
