<?php
// dns-lookup.php - CORREGIDO contra Reflected XSS

$domain = $_GET['dns'] ?? '';
$safe_domain = htmlspecialchars($domain, ENT_QUOTES, 'UTF-8');
$error = null;
$result = null;

if (isset($_GET['dns']) && $_GET['dns'] !== '') {
    // Validar formato de dominio
    if (!preg_match('/^[a-zA-Z0-9.-]+$/', $domain)) {
        $error = "Invalid domain format. Only letters, numbers, dots and hyphens allowed.";
    } else {
        $result = gethostbyname($domain);
        if ($result === $domain) {
            $error = "Could not resolve domain: " . $safe_domain;
            $result = null;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>DNS Lookup - Mutillidae Security Fix</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .container { max-width: 600px; margin: auto; }
        input[type="text"] { width: 70%; padding: 8px; margin: 10px 0; }
        input[type="submit"] { padding: 8px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .result { margin-top: 20px; padding: 10px; background-color: #f0f0f0; border-radius: 5px; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="container">
        <h1>DNS Lookup Tool</h1>
        <p>Enter a domain name to get its IP address</p>
        
        <form method="GET">
            <input type="text" name="dns" value="<?php echo $safe_domain; ?>" placeholder="ejemplo: google.com">
            <input type="submit" value="Lookup DNS">
        </form>
        
        <?php if ($error): ?>
            <div class="result error">
                <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php elseif ($result): ?>
            <div class="result success">
                <strong>DNS Lookup Results for: <?php echo $safe_domain; ?></strong><br>
                IP Address: <?php echo htmlspecialchars($result); ?>
            </div>
        <?php endif; ?>
        
        <hr>
        <p style="font-size: 12px; color: #666;">
            <strong>Test XSS:</strong> Intentar &lt;script&gt;alert("XSS")&lt;/script&gt; - NO se ejecutará
        </p>
        <a href="index.php">← Back to Home</a>
    </div>
</body>
</html>