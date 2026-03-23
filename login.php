 <?php
// login.php - CORREGIDO contra SQL Injection
require_once 'includes/database.php';
session_start();

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Conexión a base de datos
    $database = new Database();
    $db = $database->getConnection();
    
    // Prepared Statement para evitar SQL Injection
    $query = "SELECT * FROM users WHERE username = :username AND password = :password";
    $stmt = $db->prepare($query);
    
    // Hash de la contraseña (simulado - en producción usar password_hash)
    $hashed_password = hash('sha256', $password);
    
    $stmt->execute([
        ':username' => $username,
        ':password' => $hashed_password
    ]);
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Mutillidae Security Fix</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .container { max-width: 400px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; margin: 5px 0 15px 0; }
        input[type="submit"] { background-color: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        
        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>
            
            <label>Password:</label>
            <input type="password" name="password" required>
            
            <input type="submit" value="Login">
        </form>
        
        <p style="margin-top: 20px; font-size: 12px; color: #666;">
            <strong>Test SQL Injection:</strong> Intentar ' OR 1=1-- - NO funcionará
        </p>
    </div>
</body>
</html>