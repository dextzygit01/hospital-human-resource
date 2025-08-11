<?php
include '../config/db.php';
ob_start();
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $applicant_id = $_POST['applicant_id'] ?? null;
    $start_date = $_POST['start_date'] ?? null;

    if ($applicant_id && $start_date) {
        $stmt = $conn->prepare("INSERT INTO hires (applicant_id, start_date) VALUES (?, ?)");
        $stmt->execute([$applicant_id, $start_date]);

        $_SESSION['flash']['success'] = "Hire added successfully.";
        header("Location: list.php");
        exit;
    } else {
        $_SESSION['flash']['error'] = "Please complete all fields.";
    }
}

// Fetch applicants to populate dropdown
$stmt = $conn->query("SELECT id, name, position FROM applicants ORDER BY name ASC");
$applicants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="text-2xl font-bold mb-6">Add Hire</h1>

<a href="list.php" class="text-blue-600 text-sm hover:underline">&larr; Back to List</a>

<form method="POST" class="bg-white p-6 rounded shadow max-w-md mt-4 space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Applicant</label>
        <select name="applicant_id" class="w-full mt-1 border border-gray-300 p-2 rounded" required>
            <option value="">Select applicant</option>
            <?php foreach ($applicants as $applicant): ?>
                <option value="<?= $applicant['id'] ?>">
                    <?= htmlspecialchars($applicant['name']) ?> (<?= htmlspecialchars($applicant['position']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Start Date</label>
        <input type="date" name="start_date" class="w-full mt-1 border border-gray-300 p-2 rounded" required>
    </div>

    <div class="flex space-x-4">
        <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
        <a href="list.php" class="px-5 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</a>
    </div>
</form>

<?php
$content = ob_get_clean();
$title = "Add Hire";
include '../views/layout.php';
?>
