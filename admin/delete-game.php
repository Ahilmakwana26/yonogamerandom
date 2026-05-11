<?php
require_once '../includes/db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM games WHERE id = ?");
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        // Error handling
    }
}

header('Location: index.php');
exit;
