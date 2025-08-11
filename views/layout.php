<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'HR System' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <!-- Alpine.js -->
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 text-gray-800">
  <div class="flex min-h-screen">
    
    <!-- Sidebar -->
    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <?php include __DIR__ . '/partials/flash.php'; ?>
      <?= $content ?? '' ?>
    </main>

  </div>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
