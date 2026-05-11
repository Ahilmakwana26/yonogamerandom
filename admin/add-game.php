<?php
require_once '../includes/db.php';

// Fetch categories for the dropdown
$catStmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $catStmt->fetchAll();

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
    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../assets/images/games/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $new_filename = time() . '_' . bin2hex(random_bytes(8)) . '.' . $file_extension;
        $target_file = $upload_dir . $new_filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = 'assets/images/games/' . $new_filename;
        } else {
            $message = "Error: Failed to move uploaded file.";
       }
    }

    if (empty($message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO games (title, slug, category_id, image, bonus, withdraw, rating, size, version, downloads, download_link, description, meta_title, meta_description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $category_id, $image_path, $bonus, $withdraw, $rating, $size, $version, $downloads, $download_link, $description, $meta_title, $meta_description]);
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            $message = "Database Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Game | GameVault</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .form-container { background: #111; padding: 2rem; border-radius: 16px; border: 1px solid #222; margin-top: 2rem; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
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
                </ul>
            </nav>
        </div>
    </header>

    <main class="admin-container" style="max-width: 900px;">
        <h1>Add New Game</h1>

        <?php if ($message): ?>
            <div style="background: #ff4444; color: white; padding: 1rem; border-radius: 8px; margin: 1rem 0;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="form-container">
            <div class="grid-2">
                <div class="form-group">
                    <label>Game Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Slug (SEO URL)</label>
                    <input type="text" name="slug" id="slug" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label>Game Logo (Upload Image)</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Bonus Price</label>
                    <input type="text" name="bonus" class="form-control" placeholder="e.g. ₹51">
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Min. Withdraw</label>
                    <input type="number" name="withdraw" class="form-control">
                </div>
                <div class="form-group">
                    <label>Rating</label>
                    <input type="number" step="0.1" name="rating" class="form-control">
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Size</label>
                    <input type="text" name="size" class="form-control">
                </div>
                <div class="form-group">
                    <label>Version</label>
                    <input type="text" name="version" class="form-control">
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Downloads</label>
                    <input type="text" name="downloads" class="form-control">
                </div>
                <div class="form-group">
                    <label>Download Link</label>
                    <input type="url" name="download_link" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label>Meta Title</label>
                <input type="text" name="meta_title" class="form-control">
            </div>

            <div class="form-group">
                <label>Meta Description</label>
                <textarea name="meta_description" rows="2" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; cursor: pointer; border: none; border-radius: 8px; font-weight: 700;">Save Game</button>
        </form>
    </main>

    <script>
        document.getElementById('title').addEventListener('input', function() {
            const slug = this.value.toLowerCase().trim().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
            document.getElementById('slug').value = slug;
        });
    </script>
</body>
</html>
