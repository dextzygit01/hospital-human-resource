<?php
include '../config/db.php';
include 'azure_ai_integration.php';

// Get hires
$stmt = $conn->query("SELECT * FROM hires ORDER BY id DESC");
$hires = $stmt->fetchAll(PDO::FETCH_ASSOC);

$score_result = null;
if (isset($_GET['hire_id'])) {
    $hire_id = $_GET['hire_id'];
    $score_result = getAzureAIPerformanceScore($hire_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AI Performance Tracking</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-100 min-h-screen py-10 px-4 sm:px-8">

  <div class="max-w-6xl mx-auto bg-white shadow-md rounded-xl p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">🎯 Azure AI Performance Tracker</h1>

    <?php if ($score_result && isset($score_result['error'])): ?>
      <div class="bg-red-100 text-red-700 border border-red-300 px-4 py-3 rounded mb-6">
        ⚠️ <?= htmlspecialchars($score_result['message']) ?>
      </div>
    <?php elseif ($score_result): ?>
      <div class="bg-green-100 text-green-800 border border-green-300 px-4 py-3 rounded mb-6">
        ✅ <strong>AI Score:</strong> <?= $score_result['ai_score'] ?> |
        <span class="inline-block px-2 py-1 rounded 
          <?= $score_result['risk_level'] == 'High' ? 'bg-red-500' : ($score_result['risk_level'] == 'Medium' ? 'bg-yellow-400' : 'bg-green-500') ?> 
          text-white text-xs font-semibold">
          <?= $score_result['risk_level'] ?>
        </span>
        <span class="ml-4"><strong>Note:</strong> <?= $score_result['trend_note'] ?></span>
      </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
      <table class="min-w-full bg-white border rounded-lg overflow-hidden">
        <thead class="bg-gray-100 text-gray-600 uppercase text-sm font-semibold">
          <tr>
            <th class="px-6 py-3 text-left">#</th>
            <th class="px-6 py-3 text-left">Name</th>
            <th class="px-6 py-3 text-left">Email</th>
            <th class="px-6 py-3 text-left">Position</th>
            <th class="px-6 py-3 text-left">Action</th>
          </tr>
        </thead>
        <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
          <?php if (empty($hires)): ?>
            <tr><td colspan="5" class="text-center py-6 text-gray-400">No hires found.</td></tr>
          <?php else: ?>
            <?php foreach ($hires as $i => $hire): ?>
              <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-3"><?= $i + 1 ?></td>
                <td class="px-6 py-3 font-medium"><?= htmlspecialchars($hire['name']) ?></td>
                <td class="px-6 py-3"><?= htmlspecialchars($hire['email']) ?></td>
                <td class="px-6 py-3"><?= htmlspecialchars($hire['position']) ?></td>
                <td class="px-6 py-3">
                  <a href="?hire_id=<?= $hire['id'] ?>"
                     class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 text-sm font-medium rounded shadow">
                    Run AI Score
                  </a>
                </td>
              </tr>
            <?php endforeach ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
