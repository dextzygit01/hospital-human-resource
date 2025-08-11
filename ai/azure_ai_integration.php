<?php
include '../config/db.php';

function getAzureAIPerformanceScore($hire_id) {
    global $conn;

    // Check if hire exists
    $check = $conn->prepare("SELECT id FROM hires WHERE id = ?");
    $check->execute([$hire_id]);

    if ($check->rowCount() === 0) {
        return ['error' => true, 'message' => 'Hire ID does not exist in the database.'];
    }

    // Simulate Azure AI Score
    sleep(1);
    $ai_score = rand(60, 100);
    $risk_level = $ai_score < 70 ? 'High' : ($ai_score < 85 ? 'Medium' : 'Low');
    $trend_note = $risk_level === 'High' ? 'Needs coaching' : 'On track';

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO ai_performance_scores (hire_id, ai_score, risk_level, trend_note) VALUES (?, ?, ?, ?)");
    $stmt->execute([$hire_id, $ai_score, $risk_level, $trend_note]);

    return [
        'ai_score' => $ai_score,
        'risk_level' => $risk_level,
        'trend_note' => $trend_note
    ];
}
