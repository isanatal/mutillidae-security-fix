<?php
// password-generator.php - CORREGIDO contra HTML/JavaScript Injection

$username = $_GET['username'] ?? 'anonymous';
$error = null;
$safe_username = '';
$password = '';

// Validar que solo contenga caracteres seguros
if (!preg_match('/^[a-zA-Z0-9_\-]+$/', $username)) {
    $error = "Invalid username format. Only letters, numbers, underscores and hyphens allowed.";
    $username = 'anonymous';
}

// Escapar para HTML
$safe_username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');

// Generar contraseña segura si se solicita
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['generate'])) {
    // Usar random_bytes para generar contraseña criptográficamente segura
    $password = bin2hex(random_bytes(8)); // 16 caracteres hexadecimales
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Generator - Mutillidae Security Fix</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .container { max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        input[type="text"] { width: 100%; padding: 8px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; }
        input[type="submit"] { background-color: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 4px; }
        .password-result { 
            background-color: #f0f0f0; 
            padding: 15px; 
            margin: 15px 0;
            border-radius: 5px;
            font-family: monospace;
            font-size: 18px;
            text-align: center;
        }
        .error { color: red; background-color: #f8d7da; padding: 10px; border-radius: 5px; }
        .warning { background-color: #fff3cd; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Secure Password Generator</h1>
        
        <div class="warning">
            <strong>⚠️ Security Note:</strong> HTML/JavaScript injection attempts are blocked.
            Special characters are sanitized automatically.
        </div>
        
        <?php if ($error): ?>
            <div class="error">❌ <?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="GET">
            <label><strong>Username:</strong></label>
            <input type="text" name="username" value="<?php echo $safe_username; ?>" placeholder="Enter username">
            
            <input type="submit" name="generate" value="Generate Secure Password">
        </form>
        
        <?php if ($password): ?>
            <div class="password-result">
                <strong>Generated Password for <?php echo $safe_username; ?>:</strong><br>
                <span style="font-size: 20px; letter-spacing: 1px;"><?php echo htmlspecialchars($password); ?></span>
                <br>
                <button onclick="navigator.clipboard.writeText('<?php echo $password; ?>')" style="margin-top: 10px;">
                    📋 Copy to Clipboard
                </button>
            </div>
        <?php endif; ?>
        
        <hr>
        <p><a href="index.php">← Back to Home</a></p>
        
        <p style="font-size: 12px; color: #666; margin-top: 20px;">
            <strong>Test HTML Injection:</strong> Intentar &lt;img src=x onerror=alert(1)&gt; - NO se ejecutará
        </p>
    </div>
</body>
</html>