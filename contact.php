<?php
$page_title = 'Contact Us | GameVault';
require_once 'includes/header.php';
?>
    <main class="container">
        <a href="<?php echo site_url('home'); ?>" class="back-button">← Back to all apps</a>

        <div class="detail-card">
            <div class="app-info" style="width: 100%;">
                <h1>Contact Us</h1>
                <p style="color: #aaa; margin-bottom: 1.5rem; line-height: 1.8;">
                    Have questions or feedback? We'd love to hear from you!
                </p>
            </div>
        </div>

        <div class="description">
            <h2>Get in Touch</h2>
            <p>
                You can reach us through the following channels:
            </p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
                <div style="background: #0a0a0a; padding: 1.5rem; border-radius: 12px; border: 1px solid #111;">
                    <div style="color: #666; font-size: 0.8rem; text-transform: uppercase; margin-bottom: 0.5rem;">Email</div>
                    <div style="font-weight: 700;">contact@gamevault.com</div>
                </div>
                <div style="background: #0a0a0a; padding: 1.5rem; border-radius: 12px; border: 1px solid #111;">
                    <div style="color: #666; font-size: 0.8rem; text-transform: uppercase; margin-bottom: 0.5rem;">Support</div>
                    <div style="font-weight: 700;">support@gamevault.com</div>
                </div>
                <div style="background: #0a0a0a; padding: 1.5rem; border-radius: 12px; border: 1px solid #111;">
                    <div style="color: #666; font-size: 0.8rem; text-transform: uppercase; margin-bottom: 0.5rem;">Response Time</div>
                    <div style="font-weight: 700;">Within 24 hours</div>
                </div>
            </div>
        </div>
    </main>
<?php require_once 'includes/footer.php'; ?>
