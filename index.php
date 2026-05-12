<?php
$GLOBALS['page_title'] = 'GameVault - Best Rummy & Slots Apps of 2026';
$GLOBALS['meta_description'] = 'Discover the best real-money gaming apps like Rummy, Slots, Teen Patti, and Ludo with verified bonuses and instant withdrawals at GameVault. Curated, ranked, and updated regularly.';
require_once 'includes/header.php';

// Fetch all games with category names
$stmt = $pdo->query("SELECT g.*, c.name as category_name 
                    FROM games g 
                    LEFT JOIN categories c ON g.category_id = c.id 
                    ORDER BY g.created_at DESC");
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);

// If no games found, insert some sample data to match the new schema
if (count($games) == 0) {
    // Ensure categories exist
    $pdo->exec("INSERT IGNORE INTO categories (id, name) VALUES (1, 'Rummy'), (2, 'Slots'), (3, 'Teen Patti'), (4, 'Ludo')");
    
    $samples = [
        ['title' => 'Rummy Gold', 'slug' => 'rummy-gold', 'cat_id' => 1, 'bonus' => '₹51', 'rating' => 4.7],
        ['title' => 'Slots 777', 'slug' => 'slots-777', 'cat_id' => 2, 'bonus' => '₹70', 'rating' => 4.8],
        ['title' => 'Teen Patti Master', 'slug' => 'teen-patti-master', 'cat_id' => 3, 'bonus' => '₹60', 'rating' => 4.5],
        ['title' => 'Ludo Supreme', 'slug' => 'ludo-supreme', 'cat_id' => 4, 'bonus' => '₹35', 'rating' => 4.6]
    ];

    $insert = $pdo->prepare("INSERT INTO games (title, slug, category_id, bonus, rating) VALUES (?, ?, ?, ?, ?)");
    foreach ($samples as $s) {
        $insert->execute([$s['title'], $s['slug'], $s['cat_id'], $s['bonus'], $s['rating']]);
    }
    
    // Re-fetch
    $stmt = $pdo->query("SELECT g.*, c.name as category_name FROM games g LEFT JOIN categories c ON g.category_id = c.id ORDER BY g.created_at DESC");
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$gamesJson = json_encode($games);
?>
    <main id="homePage">
        <section class="hero">
            <h1>Best rummy & slots<br>apps of 2026.</h1>
            <p>Curated, ranked and updated. Download trusted real-money game APKs with verified bonus offers.</p>
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search games..." id="searchInput">
                <button class="search-button" onclick="searchGames()">Search</button>
            </div>
        </section>

        <section class="apps-section">
            <div class="apps-header">
                <div class="apps-title">
                    <h2>Latest apps</h2>
                    <div class="apps-count" id="appsCount"><?php echo count($games); ?> apps available</div>
                </div>
                <div class="filter-tabs">
                    <button class="filter-tab active" onclick="filterApps('all', this)">All</button>
                    <button class="filter-tab" onclick="filterApps('Rummy', this)">Rummy</button>
                    <button class="filter-tab" onclick="filterApps('Slots', this)">Slots</button>
                    <button class="filter-tab" onclick="filterApps('Teen Patti', this)">Teen Patti</button>
                    <button class="filter-tab" onclick="filterApps('Ludo', this)">Ludo</button>
                </div>
            </div>

            <div class="apps-grid" id="appsGrid">
                <!-- Apps will be dynamically inserted here -->
            </div>
        </section>
    </main>

    <script>
        const appsData = <?php echo $gamesJson; ?>;

        function initializeApps(data = appsData) {
            const grid = document.getElementById('appsGrid');
            grid.innerHTML = '';
            
            data.forEach((app, index) => {
                const card = document.createElement('div');
                card.className = 'app-card-new';
                
                const catClass = (app.category_name || '').toLowerCase().replace(' ', '-');
                const iconText = app.title.split(' ').map(w => w[0]).join('').substring(0, 3).toUpperCase();
                
                const iconHtml = app.image 
                    ? `<img src="${app.image}" alt="${app.title}">`
                    : `<div class="app-icon-text">${iconText}</div>`;
                
                card.innerHTML = `
                    <div class="rank-badge">${index + 1}</div>
                    <div class="app-card-left ${catClass}" onclick="location.href='<?php echo site_url('game/'); ?>${app.slug}'">
                        ${iconHtml}
                    </div>
                    <div class="app-card-info" onclick="location.href='<?php echo site_url('game/'); ?>${app.slug}'">
                        <div class="app-name-text">${app.title}</div>
                        <div class="app-info-row">
                            <div class="info-item">
                                <span class="info-icon">🎁</span>
                                <span class="bonus-text">Sign Up Bonus ${app.bonus || '₹0'}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-icon">💳</span>
                                <span class="withdraw-text">Min. Withdraw ₹${app.withdraw || '100'}</span>
                            </div>
                        </div>
                    </div>
                    <div class="app-card-right">
                        <a href="<?php echo site_url('game/'); ?>${app.slug}" class="download-button">Download</a>
                    </div>
                `;
                
                grid.appendChild(card);
            });

            document.getElementById('appsCount').textContent = `${data.length} apps available`;
        }

        function filterApps(category, el) {
            const tabs = document.querySelectorAll('.filter-tab');
            tabs.forEach(tab => tab.classList.remove('active'));
            el.classList.add('active');

            const filtered = category === 'all' ? appsData : appsData.filter(app => app.category_name === category);
            initializeApps(filtered);
        }

        function searchGames() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const filtered = appsData.filter(app => 
                app.title.toLowerCase().includes(searchTerm) || 
                (app.category_name && app.category_name.toLowerCase().includes(searchTerm))
            );
            initializeApps(filtered);
        }

        document.addEventListener('DOMContentLoaded', function() {
            initializeApps();
            document.getElementById('searchInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') searchGames();
            });
        });
    </script>
<?php require_once 'includes/footer.php'; ?>
