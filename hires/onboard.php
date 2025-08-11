<?php
include '../config/db.php';
include '../partials/flash.php'; // ✅ Include the flash message system
ob_start();

// Handle onboarding status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hire_id = $_POST['hire_id'] ?? null;
    $status = $_POST['onboarding_status'] ?? null;
    if ($hire_id && $status) {
        $stmt = $conn->prepare("UPDATE hires SET onboarding_status = ? WHERE id = ?");
        $stmt->execute([$status, $hire_id]);
        header("Location: onboard.php");
        exit;
    }
}

// Fetch hires with applicant info
$stmt = $conn->query("SELECT hires.id, applicants.name, hires.department, hires.start_date, hires.onboarding_status 
                      FROM hires 
                      JOIN applicants ON hires.applicant_id = applicants.id 
                      ORDER BY hires.id DESC");
$hires = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="text-3xl font-bold text-gray-800 mb-6">New Hire Onboarding</h1>

<div class="overflow-x-auto bg-white shadow-md rounded-lg">
  <table class="min-w-full divide-y divide-gray-200 text-sm">
    <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
      <tr>
        <th class="px-4 py-3 text-left">#</th>
        <th class="px-4 py-3 text-left">Name</th>
        <th class="px-4 py-3 text-left">Department</th>
        <th class="px-4 py-3 text-left">Start Date</th>
        <th class="px-4 py-3 text-left">Status</th>
        <th class="px-4 py-3 text-left">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      <?php if (count($hires) === 0): ?>
        <tr>
          <td colspan="6" class="text-center text-gray-500 py-4">No hires found.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($hires as $i => $hire): ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2"><?= $i + 1 ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($hire['name']) ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($hire['department']) ?></td>
            <td class="px-4 py-2"><?= htmlspecialchars($hire['start_date']) ?></td>
            <td class="px-4 py-2">
              <span class="inline-block px-2 py-1 rounded text-xs font-medium
                <?= match($hire['onboarding_status']) {
                    'Pending' => 'bg-yellow-100 text-yellow-800',
                    'In Progress' => 'bg-blue-100 text-blue-800',
                    'Completed' => 'bg-green-100 text-green-800',
                    default => 'bg-gray-100 text-gray-800'
                } ?>">
                <?= htmlspecialchars($hire['onboarding_status']) ?>
              </span>
            </td>
            <td class="px-4 py-2">
              <form method="POST" class="flex items-center space-x-2">
                <input type="hidden" name="hire_id" value="<?= $hire['id'] ?>">
                <select name="onboarding_status" class="rounded border-gray-300 focus:ring-blue-500 focus:border-blue-500 px-2 py-1 text-sm">
                  <option value="Pending" <?= $hire['onboarding_status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                  <option value="In Progress" <?= $hire['onboarding_status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                  <option value="Completed" <?= $hire['onboarding_status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                </select>
                <button type="submit" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">Update</button>
              </form>
            </td>
          </tr>
        <?php endforeach ?>
      <?php endif ?>
    </tbody>
  </table>
</div>

<?php
$content = ob_get_clean();
$title = "New Hire Onboarding";
include '../views/layout.php';
?>
