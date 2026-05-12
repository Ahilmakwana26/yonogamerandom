<?php
$telegram_link = 'https://t.me/gamevault';
?>
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col footer-about">
                    <h4>About <?php echo SITE_NAME; ?></h4>
                    <p><?php echo SITE_NAME; ?> is a leading gaming app discovery portal in India. We curate the top games offering maximum bonuses and instant withdrawal facility.</p>
                    <div class="footer-social">
                        <a href="<?php echo $telegram_link; ?>" target="_blank" class="social-icon"><i class="fab fa-telegram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="<?php echo site_url('home'); ?>">Home</a></li>
                        <li><a href="<?php echo site_url('about'); ?>">About Us</a></li>
                        <li><a href="<?php echo site_url('contact'); ?>">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Policy</h4>
                    <ul class="footer-links">
                        <li><a href="<?php echo site_url('disclaimer'); ?>">Disclaimer</a></li>
                        <li><a href="<?php echo site_url('privacy'); ?>">Privacy Policy</a></li>
                        <li><a href="<?php echo site_url('terms'); ?>">Terms of Service</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Contact Us</h4>
                    <ul class="footer-links">
                        <li><i class="fas fa-envelope"></i> support@<?php echo strtolower(SITE_NAME); ?>.com</li>
                        <li><i class="fas fa-headset"></i> 24/7 Priority Support</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo strtoupper(SITE_NAME); ?> PREMIUM. Designed for Champions.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const mainNav = document.getElementById('mainNav');
            if (menuToggle && mainNav) {
                menuToggle.addEventListener('click', function() {
                    this.classList.toggle('active');
                    mainNav.classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html>
