<?php
require_once 'includes/db.php';

$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    header('Location: index.php');
    exit;
}

// Fetch game with category name
$stmt = $pdo->prepare("SELECT g.*, c.name as category_name 
                    FROM games g 
                    LEFT JOIN categories c ON g.category_id = c.id 
                    WHERE g.slug = ?");
$stmt->execute([$slug]);
$game = $stmt->fetch();

if (!$game) {
    header('Location: index.php');
    exit;
}

// Extract icon text
$words = explode(' ', $game['title']);
$iconText = '';
foreach ($words as $w) {
    if(!empty($w)) $iconText .= strtoupper($w[0]);
}
$iconText = substr($iconText, 0, 3);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($game['meta_title'] ?: $game['title'] . ' | GameVault'); ?></title>
    <base href="/yonogamerandom/">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="header-content">
            <a href="index.php" class="logo">
                <div class="logo-icon">G</div>
                <span>GameVault</span>
            </a>
        </div>
    </header>

    <main class="container">
        <a href="index.php" class="back-button">← Back to all apps</a>
        
        <div class="detail-card">
            <div class="app-icon-large <?php echo strtolower(str_replace(' ', '-', $game['category_name'] ?? '')); ?>">
                <?php if ($game['image']): ?>
                    <img src="<?php echo htmlspecialchars($game['image']); ?>" alt="<?php echo htmlspecialchars($game['title']); ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 24px;">
                <?php else: ?>
                    <?php echo $iconText; ?>
                <?php endif; ?>
            </div>
            <div class="app-info">
                <div class="category"><?php echo htmlspecialchars($game['category_name'] ?? 'Uncategorized'); ?></div>
                <h1><?php echo htmlspecialchars($game['title']); ?></h1>
                
                <div style="display: flex; gap: 2rem; margin-bottom: 2rem; color: #aaa;">
                    <div>Rating: <span class="star">★</span> <?php echo $game['rating']; ?></div>
                    <div>Bonus: <span style="color: #4ade80; font-weight: 700;"><?php echo $game['bonus']; ?></span></div>
                </div>

                <a href="<?php echo htmlspecialchars($game['download_link'] ?: '#'); ?>" class="btn">Download APK</a>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 2rem;">
            <div style="background: #111; padding: 1.5rem; border-radius: 12px; border: 1px solid #222;">
                <div style="color: #666; font-size: 0.8rem; text-transform: uppercase;">Version</div>
                <div style="font-weight: 700;"><?php echo $game['version'] ?: 'Latest'; ?></div>
            </div>
            <div style="background: #111; padding: 1.5rem; border-radius: 12px; border: 1px solid #222;">
                <div style="color: #666; font-size: 0.8rem; text-transform: uppercase;">Size</div>
                <div style="font-weight: 700;"><?php echo $game['size'] ?: 'N/A'; ?></div>
            </div>
            <div style="background: #111; padding: 1.5rem; border-radius: 12px; border: 1px solid #222;">
                <div style="color: #666; font-size: 0.8rem; text-transform: uppercase;">Downloads</div>
                <div style="font-weight: 700;"><?php echo $game['downloads'] ?: '0'; ?></div>
            </div>
        </div>

        <div class="description">
            <h2>About this game</h2>
            <p><?php echo nl2br(htmlspecialchars($game['description'])); ?></p>
        </div>
    </main>
</body>
</html>
