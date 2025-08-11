<?php
include './config/db.php';
ob_start();

// quick stats
$applicants = $conn->query("SELECT COUNT(*) FROM applicants")->fetchColumn();
$jobs       = $conn->query("SELECT COUNT(*) FROM job_posts")->fetchColumn();
$hires      = $conn->query("SELECT COUNT(*) FROM hires")->fetchColumn();
$reviews    = $conn->query("SELECT COUNT(*) FROM performance_reviews")->fetchColumn();
?>

<h1 class="text-2xl font-bold mb-6">HR Dashboard</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
  <a href="applicants.php" class="block p-4 bg-white rounded-lg shadow hover:bg-gray-100 transition">
    <p class="text-sm text-slate-500">Applicants</p>
    <p class="text-2xl font-semibold"><?= $applicants ?></p>
  </a>

  <a href="job_posts.php" class="block p-4 bg-white rounded-lg shadow hover:bg-gray-100 transition">
    <p class="text-sm text-slate-500">Job Posts</p>
    <p class="text-2xl font-semibold"><?= $jobs ?></p>
  </a>

  <a href="hires.php" class="block p-4 bg-white rounded-lg shadow hover:bg-gray-100 transition">
    <p class="text-sm text-slate-500">Hires</p>
    <p class="text-2xl font-semibold"><?= $hires ?></p>
  </a>

  <a href="performance_reviews.php" class="block p-4 bg-white rounded-lg shadow hover:bg-gray-100 transition">
    <p class="text-sm text-slate-500">Performance Reviews</p>
    <p class="text-2xl font-semibold"><?= $reviews ?></p>
  </a>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-8">
  <h2 class="text-lg font-semibold mb-2">Performance Trend (placeholder)</h2>
  <div class="h-64 flex items-center justify-center text-slate-400">
    Your chart goes here (Power BI iframe / Chart.js)
  </div>
</div>

<!-- Inter-Department Request Module -->
<a href="inter_department_requests.php" class="block bg-blue-100 hover:bg-blue-200 transition p-4 rounded-lg text-center font-semibold text-blue-700">
  ➕ View Inter-Department Applicant Requests
</a>

<?php
$content = ob_get_clean();
$title = "Dashboard";
include './views/layout.php';
?>
