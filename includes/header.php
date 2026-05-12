<?php
require_once 'db.php';

// Website Settings - Change these values to update your site
define('SITE_NAME', 'GameVault'); // Change this to your desired logo name
define('SITE_TAGLINE', 'Best Rummy & Slots Apps of 2026');

function site_url($path = '') {
    $base = '/yonogamerandom/';
    return $base . ltrim($path, '/');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $GLOBALS['meta_description'] ?? 'Discover the best real-money gaming apps with verified bonuses and instant withdrawals at ' . SITE_NAME . '. Curated, ranked, and updated regularly.'; ?>">
    <meta name="keywords" content="rummy, slots, teen patti, ludo, real money games, gaming apps, bonus offers">
    <meta name="author" content="<?php echo SITE_NAME; ?>">
    <meta name="robots" content="index, follow">
    <title><?php echo $GLOBALS['page_title'] ?? SITE_NAME . ' - ' . SITE_TAGLINE; ?></title>
    <link rel="stylesheet" href="<?php echo site_url('assets/css/style.css?v=' . time()); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-content">
            <a href="<?php echo site_url('home'); ?>" class="logo">
                <div class="logo-icon"><?php echo strtoupper(substr(SITE_NAME, 0, 1)); ?></div>
                <span><?php echo SITE_NAME; ?></span>
            </a>
            <button class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav id="mainNav">
                <ul>
                    <li><a href="<?php echo site_url('home'); ?>">Home</a></li>
                    <li><a href="<?php echo site_url('about'); ?>">About Us</a></li>
                    <li><a href="<?php echo site_url('disclaimer'); ?>">Disclaimer</a></li>
                    <li><a href="<?php echo site_url('privacy'); ?>">Privacy Policy</a></li>
                    <li><a href="<?php echo site_url('terms'); ?>">Terms of Service</a></li>
                    <li><a href="<?php echo site_url('contact'); ?>">Contact</a></li>
                    <li><a href="<?php echo site_url('admin/index.php'); ?>">Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>
