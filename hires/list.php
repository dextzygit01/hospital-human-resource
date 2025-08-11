<?php
include '../config/db.php';
ob_start();
session_start();

$stmt = $conn->prepare("
    SELECT hires.id, hires.start_date, applicants.name, applicants.position
    FROM hires
    JOIN applicants ON hires.applicant_id = applicants.id
    ORDER BY hires.start_date DESC
");
$stmt->execute();
$hires = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="text-2xl font-bold mb-6">Hires List</h1>

<a href="../applicants/list.php" class="text-sm text-blue-600 hover:underline">&larr; Back to Applicants</a>

<table class="w-full table-auto bg-white shadow mt-4">
    <thead class="bg-gray-200">
        <tr>
            <th class="px-4 py-2 text-left">Name</th>
            <th class="px-4 py-2 text-left">Position</th>
            <th class="px-4 py-2 text-left">Start Date</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($hires as $hire): ?>
            <tr class="border-t">
                <td class="px-4 py-2"><?= htmlspecialchars($hire['name']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($hire['position']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($hire['start_date']) ?></td>
                <td class="px-4 py-2 space-x-2">
                    <a href="edit.php?id=<?= $hire['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
                    <a href="delete.php?id=<?= $hire['id'] ?>" class="text-red-600 hover:underline">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
$title = "Hire List";
include '../views/layout.php';
?>
