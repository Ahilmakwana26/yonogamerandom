<?php
$page_title = 'About Us | GameVault';
require_once 'includes/header.php';
?>
    <main class="container">
        <a href="<?php echo site_url('home'); ?>" class="back-button">← Back to all apps</a>

        <div class="detail-card">
            <div class="app-info" style="width: 100%;">
                <h1>About <?php echo SITE_NAME; ?></h1>
                <p style="color: #aaa; margin-bottom: 1.5rem; line-height: 1.8;">
                    Welcome to <?php echo SITE_NAME; ?>, your trusted destination for discovering the best real-money gaming apps of 2026.
                </p>
            </div>
        </div>

        <div class="description">
            <h2>Our Mission</h2>
            <p>
                At <?php echo SITE_NAME; ?>, we are dedicated to helping you find safe, reliable, and entertaining real-money gaming applications. Our team thoroughly researches and tests each app before featuring it on our platform.
            </p>

            <h2 style="margin-top: 2rem;">What We Offer</h2>
            <p>
                - Curated list of top-rated gaming apps<br>
                - Verified bonus offers and promotions<br>
                - Detailed app information and reviews<br>
                - Easy download links for quick access
            </p>

            <h2 style="margin-top: 2rem;">Our Commitment</h2>
            <p>
                We prioritize your safety and security. All apps listed on GameVault are vetted to ensure they meet our strict standards for fairness, security, and responsible gaming.
            </p>
        </div>
    </main>
<?php require_once 'includes/footer.php'; ?>
