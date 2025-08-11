<?php
// Flash message setter function
if (!function_exists('flash')) {
    function flash($type, $message) {
        if (!session_id()) session_start();
        $_SESSION['flash'][$type] = $message;
    }
}
?>

<?php if (!empty($_SESSION['flash'])): ?>
  <?php foreach ($_SESSION['flash'] as $type => $msg): ?>
    <div class="mb-4 rounded border px-4 py-3 
      <?= $type === 'success' ? 'bg-green-50 border-green-300 text-green-800' : 'bg-red-50 border-red-300 text-red-800' ?>">
      <?= htmlspecialchars($msg) ?>
    </div>
  <?php endforeach; unset($_SESSION['flash']); ?>
<?php endif; ?>
