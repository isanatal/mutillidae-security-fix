<?php
// add-to-your-blog.php - CORREGIDO contra Stored XSS
require_once 'includes/database.php';
session_start();

$success = null;
$error = null;

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    // Redirigir a login si no está autenticado
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blog_entry = $_POST['blog_entry'] ?? '';
    
    if (empty($blog_entry)) {
        $error = "Blog entry cannot be empty";
    } else {
        // SANITIZAR antes de guardar (doble capa de seguridad)
        $blog_entry = htmlspecialchars($blog_entry, ENT_QUOTES, 'UTF-8');
        // Permitir solo etiquetas HTML seguras
        $blog_entry = strip_tags($blog_entry, '<p><br><b><i><strong><em>');
        
        // Guardar en base de datos con Prepared Statement
        $database = new Database();
        $db = $database->getConnection();
        
        $query = "INSERT INTO blogs (user_id, entry, created_at) VALUES (:user_id, :entry, NOW())";
        $stmt = $db->prepare($query);
        
        if ($stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':entry' => $blog_entry
        ])) {
            $success = "Blog entry saved securely!";
        } else {
            $error = "Error saving blog entry";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add to Blog - Mutillidae Security Fix</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .container { max-width: 600px; margin: auto; }
        textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; }
        input[type="submit"] { background-color: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .success { color: green; background-color: #d4edda; padding: 10px; border-radius: 5px; }
        .error { color: red; background-color: #f8d7da; padding: 10px; border-radius: 5px; }
        .warning { background-color: #fff3cd; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Blog Entry</h1>
        <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</p>
        
        <?php if ($success): ?>
            <div class="success">✅ <?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="error">❌ <?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="warning">
            <strong>ℹ️ Security Note:</strong> Scripts and malicious code are automatically sanitized.
            Only safe HTML tags (&lt;p&gt;, &lt;b&gt;, &lt;i&gt;) are allowed.
        </div>
        
        <form method="POST">
            <textarea name="blog_entry" rows="6" placeholder="Write your blog entry here..."></textarea>
            <br>
            <input type="submit" value="Save Blog Entry">
        </form>
        
        <hr>
        <p><a href="view-someones-blog.php">📖 View All Blog Entries</a></p>
        <p><a href="index.php">← Back to Home</a></p>
        
        <p style="font-size: 12px; color: #666; margin-top: 20px;">
            <strong>Test Stored XSS:</strong> Intentar &lt;script&gt;alert("Hacked")&lt;/script&gt; - NO se ejecutará al guardar ni al mostrar
        </p>
    </div>
</body>
</html>
