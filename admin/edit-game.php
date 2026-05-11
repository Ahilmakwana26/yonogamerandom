<?php
require_once '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

// Fetch categories
$catStmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $catStmt->fetchAll();

// Fetch existing game
$stmt = $pdo->prepare("SELECT * FROM games WHERE id = ?");
$stmt->execute([$id]);
$game = $stmt->fetch();

if (!$game) {
    header('Location: index.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $slug = $_POST['slug'];
    $category_id = $_POST['category_id'];
    $bonus = $_POST['bonus'];
    $withdraw = $_POST['withdraw'];
    $rating = $_POST['rating'];
    $size = $_POST['size'];
    $version = $_POST['version'];
    $downloads = $_POST['downloads'];
    $download_link = $_POST['download_link'];
    $description = $_POST['description'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];

    // Handle Image Upload
    $image_path = $game['image']; // Keep old image by default
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../assets/images/games/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $new_filename = time() . '_' . bin2hex(random_bytes(8)) . '.' . $file_extension;
        $target_file = $upload_dir . $new_filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Delete old image file if it exists and is different
            if ($game['image'] && file_exists('../' . $game['image'])) {
                unlink('../' . $game['image']);
            }
            $image_path = 'assets/images/games/' . $new_filename;
        }
    }

    try {
        $updateStmt = $pdo->prepare("UPDATE games SET title=?, slug=?, category_id=?, image=?, bonus=?, withdraw=?, rating=?, size=?, version=?, downloads=?, download_link=?, description=?, meta_title=?, meta_description=? WHERE id=?");
        $updateStmt->execute([$title, $slug, $category_id, $image_path, $bonus, $withdraw, $rating, $size, $version, $downloads, $download_link, $description, $meta_title, $meta_description, $id]);
        $message = "Game updated successfully!";
        // Refresh game data
        $stmt->execute([$id]);
        $game = $stmt->fetch();
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Game | GameVault</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .form-container {
            background: #111;
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid #222;
            margin-top: 2rem;
        }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        .current-image {
            width: 80px; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid #333; margin-top: 10px;
        }
    </style>
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
                    <li><a href="index.php">Manage Games</a></li>
                    <li><a href="categories.php">Categories</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="admin-container" style="max-width: 900px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Edit Game: <?php echo htmlspecialchars($game['title']); ?></h1>
            <a href="index.php" class="back-button" style="margin:0;">← Back</a>
        </div>

        <?php if ($message): ?>
            <div style="background: <?php echo strpos($message, 'Error') !== false ? '#ff4444' : '#4ade80'; ?>; color: white; padding: 1rem; border-radius: 8px; margin: 1rem 0;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="form-container">
            <div class="grid-2">
                <div class="form-group">
                    <label>Game Title</label>
                    <input type="text" name="title" id="title" class="form-control" required value="<?php echo htmlspecialchars($game['title']); ?>">
                </div>
                <div class="form-group">
                    <label>Slug (SEO URL)</label>
                    <input type="text" name="slug" id="slug" class="form-control" required value="<?php echo htmlspecialchars($game['slug']); ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Game Logo (Leave empty to keep current)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <?php if ($game['image']): ?>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <img src="../<?php echo $game['image']; ?>" class="current-image">
                        <span style="color: #666; font-size: 0.8rem;">Current Logo</span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo $game['category_id'] == $cat['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Bonus Price</label>
                    <input type="text" name="bonus" class="form-control" value="<?php echo htmlspecialchars($game['bonus']); ?>">
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Min. Withdraw</label>
                    <input type="number" name="withdraw" class="form-control" value="<?php echo htmlspecialchars($game['withdraw']); ?>">
                </div>
                <div class="form-group">
                    <label>Rating (0.0 to 5.0)</label>
                    <input type="number" step="0.1" name="rating" class="form-control" value="<?php echo htmlspecialchars($game['rating']); ?>">
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>App Size</label>
                    <input type="text" name="size" class="form-control" value="<?php echo htmlspecialchars($game['size']); ?>">
                </div>
                <div class="form-group">
                    <label>Version</label>
                    <input type="text" name="version" class="form-control" value="<?php echo htmlspecialchars($game['version']); ?>">
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Downloads</label>
                    <input type="text" name="downloads" class="form-control" value="<?php echo htmlspecialchars($game['downloads']); ?>">
                </div>
                <div class="form-group">
                    <label>APK Download Link</label>
                    <input type="url" name="download_link" class="form-control" value="<?php echo htmlspecialchars($game['download_link']); ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5" class="form-control"><?php echo htmlspecialchars($game['description']); ?></textarea>
            </div>

            <hr style="border: 0; border-top: 1px solid #222; margin: 2rem 0;">
            <h3 style="margin-bottom: 1.5rem;">SEO Settings</h3>

            <div class="form-group">
                <label>Meta Title</label>
                <input type="text" name="meta_title" class="form-control" value="<?php echo htmlspecialchars($game['meta_title']); ?>">
            </div>

            <div class="form-group">
                <label>Meta Description</label>
                <textarea name="meta_description" rows="2" class="form-control"><?php echo htmlspecialchars($game['meta_description']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; margin-top: 1rem;">Update Game</button>
        </form>
    </main>

    <script>
        document.getElementById('title').addEventListener('input', function() {
            if (confirm('Regenerate slug based on new title?')) {
                const slug = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^\w ]+/g, '')
                    .replace(/ +/g, '-');
                document.getElementById('slug').value = slug;
            }
        });
    </script>
</body>
</html>
