<?php
require_once '../includes/db.php';

// Fetch games with category names
try {
    $stmt = $pdo->query("SELECT g.*, c.name as category_name 
                        FROM games g 
                        LEFT JOIN categories c ON g.category_id = c.id 
                        ORDER BY g.created_at DESC");
    $games = $stmt->fetchAll();
} catch (PDOException $e) {
    $games = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | GameVault</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <header>
        <div class="header-content">
            <a href="../index.php" class="logo">
                <div class="logo-icon">G</div>
                <span>GameVault ADMIN</span>
            </a>
            <nav>
                <ul>
                    <li><a href="../index.php">View Site</a></li>
                    <li><a href="index.php">Manage Games</a></li>
                    <li><a href="categories.php">Categories</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="admin-container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Manage Games</h1>
            <a href="add-game.php" class="btn btn-primary" style="padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 8px; font-weight: 700;">+ Add Game</a>
        </div>

        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Bonus</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($games) > 0): ?>
                        <?php foreach ($games as $game): ?>
                            <?php 
                                $words = explode(' ', $game['title']);
                                $iconText = '';
                                foreach ($words as $w) if(!empty($w)) $iconText .= strtoupper($w[0]);
                                $iconText = substr($iconText, 0, 3);
                            ?>
                            <tr>
                                <td>
                                    <div style="width: 50px; height: 50px; background: #222; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-weight: 800; font-size: 0.8rem;">
                                        <?php echo $iconText; ?>
                                    </div>
                                </td>
                                <td style="font-weight: 600;"><?php echo htmlspecialchars($game['title']); ?></td>
                                <td style="color: #aaa;"><?php echo htmlspecialchars($game['category_name'] ?: 'Uncategorized'); ?></td>
                                <td style="color: #4ade80; font-weight: 700;"><?php echo htmlspecialchars($game['bonus']); ?></td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="edit-game.php?id=<?php echo $game['id']; ?>" class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem; text-decoration: none; border-radius: 4px;">Edit</a>
                                        <a href="delete-game.php?id=<?php echo $game['id']; ?>" class="btn btn-danger" style="padding: 0.4rem 0.8rem; font-size: 0.8rem; text-decoration: none; border-radius: 4px;" onclick="return confirm('Delete this game?')">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 3rem; color: #666;">No games found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 GameVault Admin Panel.</p>
    </footer>

</body>
</html>
