<?php
// view-someones-blog.php - CORREGIDO - Mostrar blogs con sanitización
require_once 'includes/database.php';
session_start();

$database = new Database();
$db = $database->getConnection();

// Sanitizar el parámetro user_id
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 1;

// Obtener blogs con Prepared Statement
$query = "SELECT id, user_id, entry, created_at FROM blogs WHERE user_id = :user_id ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute([':user_id' => $user_id]);
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Blog - Mutillidae Security Fix</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .container { max-width: 800px; margin: auto; }
        .blog-entry { 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            padding: 15px; 
            margin: 15px 0;
            background-color: #f9f9f9;
        }
        .blog-meta { 
            font-size: 12px; 
            color: #666; 
            margin-top: 10px;
            border-top: 1px solid #eee;
            padding-top: 8px;
        }
        .no-blogs { text-align: center; color: #666; padding: 40px; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📖 Blog Entries</h1>
        
        <?php if (empty($blogs)): ?>
            <div class="no-blogs">
                <p>No blog entries found for this user.</p>
            </div>
        <?php else: ?>
            <?php foreach ($blogs as $blog): ?>
                <div class="blog-entry">
                    <?php 
                    // DOBLE SANITIZACIÓN: al mostrar también escapamos
                    $safe_entry = htmlspecialchars($blog['entry'], ENT_QUOTES, 'UTF-8');
                    // Convertir saltos de línea a <br> (seguro)
                    $safe_entry = nl2br($safe_entry);
                    ?>
                    <div class="blog-content"><?php echo $safe_entry; ?></div>
                    <div class="blog-meta">
                        Posted on: <?php echo htmlspecialchars($blog['created_at']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <hr>
        <p><a href="add-to-your-blog.php">✍️ Add New Blog Entry</a></p>
        <p><a href="index.php">← Back to Home</a></p>
        
        <p style="font-size: 12px; color: #666; margin-top: 20px;">
            <strong>Security Note:</strong> All blog entries are displayed with proper output encoding.
            Any stored XSS attempts are neutralized.
        </p>
    </div>
</body>
</html>
