<?php
include '../config/db.php';
  
ob_start();

// Fetch applicants
$stmt = $conn->prepare("
    SELECT hires.*, applicants.name, applicants.position
    FROM hires
    JOIN applicants ON hires.applicant_id = applicants.id
    WHERE hires.id = ?
");
$stmt->execute([$id]);
$hire = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<div class="flex justify-between items-center mb-6">
  <h1 class="text-2xl font-bold">Applicant List</h1>
  <a href="add.php" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
    <i data-lucide="plus"></i> Add Applicant
  </a>
</div>

<div class="overflow-x-auto bg-white shadow border border-gray-200 rounded-lg">
  <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50 text-gray-600 text-sm font-semibold">
      <tr>
        <th class="px-4 py-3 text-left">#</th>
        <th class="px-4 py-3 text-left">Name</th>
        <th class="px-4 py-3 text-left">Email</th>
        <th class="px-4 py-3 text-left">Role Applied</th>
        <th class="px-4 py-3 text-left">Resume</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
      <?php if (count($applicants) === 0): ?>
        <tr>
          <td colspan="5" class="text-center py-6 text-gray-500">No applicants found.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($applicants as $i => $app): ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-3"><?= $i + 1 ?></td>
            <td class="px-4 py-3"><?= htmlspecialchars($app['name']) ?></td>
            <td class="px-4 py-3"><?= htmlspecialchars($app['email']) ?></td>
            <td class="px-4 py-3"><?= htmlspecialchars($app['role_applied']) ?></td>
            <td class="px-4 py-3">
              <a href="<?= htmlspecialchars($app['resume_link']) ?>" target="_blank" class="text-blue-600 underline">View</a>
            </td>
          </tr>
        <?php endforeach ?>
      <?php endif ?>
    </tbody>
  </table>
</div>

<?php
$content = ob_get_clean();
$title = "Applicant List";
include '../views/layout.php';
?>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
  lucide.createIcons();
</script>
