<?php
include '../config/db.php';
ob_start();
session_start();

$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['flash']['error'] = "No hire ID provided.";
    header("Location: list.php");
    exit;
}

// Fetch hire + applicant data
$stmt = $conn->prepare("
    SELECT hires.*, applicants.name, applicants.position
    FROM hires
    JOIN applicants ON hires.applicant_id = applicants.id
    WHERE hires.id = ?
");
$stmt->execute([$id]);
$hire = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$hire) {
    $_SESSION['flash']['error'] = "Hire record not found.";
    header("Location: list.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'] ?? null;

    $stmt = $conn->prepare("UPDATE hires SET start_date = ? WHERE id = ?");
    $stmt->execute([$start_date, $id]);

    $_SESSION['flash']['success'] = "Hire updated successfully.";
    header("Location: list.php");
    exit;
}
?>

<h1 class="text-2xl font-bold mb-6">Edit Hire</h1>

<a href="list.php" class="text-blue-600 text-sm hover:underline">&larr; Back to List</a>

<form method="POST" class="bg-white p-6 rounded shadow max-w-md mt-4 space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Applicant</label>
        <input type="text" class="w-full mt-1 border border-gray-300 p-2 rounded bg-gray-100" value="<?= htmlspecialchars($hire['name']) ?> (<?= htmlspecialchars($hire['position']) ?>)" readonly>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Start Date</label>
        <input type="date" name="start_date" class="w-full mt-1 border border-gray-300 p-2 rounded" value="<?= htmlspecialchars($hire['start_date']) ?>" required>
    </div>

    <div class="flex space-x-4">
        <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
        <a href="list.php" class="px-5 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</a>
    </div>
</form>

<?php
$content = ob_get_clean();
$title = "Edit Hire";
include '../views/layout.php';
?>
