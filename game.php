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

$page_title = htmlspecialchars($game['meta_title'] ?: $game['title'] . ' | GameVault');
require_once 'includes/header.php';

// Fetch related games by category, exclude current game
$relatedGames = [];
if (!empty($game['category_id'])) {
    $stmt = $pdo->prepare("SELECT g.*, c.name as category_name 
                        FROM games g 
                        LEFT JOIN categories c ON g.category_id = c.id 
                        WHERE g.category_id = ? AND g.id != ? 
                        ORDER BY g.created_at DESC 
                        LIMIT 8");
    $stmt->execute([$game['category_id'], $game['id']]);
    $relatedGames = $stmt->fetchAll();
}

// Extract icon text
$words = explode(' ', $game['title']);
$iconText = '';
foreach ($words as $w) {
    if(!empty($w)) $iconText .= strtoupper($w[0]);
}
$iconText = substr($iconText, 0, 3);
?>
    <main class="container">
        <a href="<?php echo site_url('home'); ?>" class="back-button">← Back to all apps</a>
        
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

        <?php if (count($relatedGames) > 0): ?>
        <div class="related-games">
            <h2>Related Games</h2>
            <div class="apps-grid">
                <?php foreach ($relatedGames as $index => $app): ?>
                    <?php
                    $catClass = strtolower(str_replace(' ', '-', ($app['category_name'] ?? '')));
                    $iconWords = explode(' ', $app['title']);
                    $iconText = '';
                    foreach ($iconWords as $w) {
                        if (!empty($w)) {
                            $iconText .= strtoupper($w[0]);
                        }
                    }
                    $iconText = substr($iconText, 0, 3);
                    ?>
                    <div class="app-card-new">
                        <div class="rank-badge"><?php echo $index + 1; ?></div>
                        <div class="app-card-left <?php echo $catClass; ?>" onclick="location.href='<?php echo site_url('game/'); ?><?php echo $app['slug']; ?>'">
                            <?php if ($app['image']): ?>
                                <img src="<?php echo htmlspecialchars($app['image']); ?>" alt="<?php echo htmlspecialchars($app['title']); ?>">
                            <?php else: ?>
                                <div class="app-icon-text"><?php echo $iconText; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="app-card-info" onclick="location.href='<?php echo site_url('game/'); ?><?php echo $app['slug']; ?>'">
                            <div class="app-name-text"><?php echo htmlspecialchars($app['title']); ?></div>
                            <div class="app-info-row">
                                <div class="info-item">
                                    <span class="info-icon">🎁</span>
                                    <span class="bonus-text">Sign Up Bonus <?php echo $app['bonus'] ?? '₹0'; ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-icon">💳</span>
                                    <span class="withdraw-text">Min. Withdraw ₹<?php echo $app['withdraw'] ?? '100'; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="app-card-right">
                            <a href="<?php echo site_url('game/'); ?><?php echo $app['slug']; ?>" class="download-button">Download</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </main>
<?php require_once 'includes/footer.php'; ?>
