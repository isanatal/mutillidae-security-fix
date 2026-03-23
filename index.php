<?php
// index.php - Página principal con vulnerabilidades corregidas
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mutillidae Security Fix - Vulnerabilities Corrected</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px;
        }
        .container { 
            max-width: 1000px; 
            margin: auto; 
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .header {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 { margin-bottom: 10px; }
        .header p { opacity: 0.9; }
        .content { padding: 30px; }
        .welcome {
            background: #e8f4fd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logout-btn {
            background: #e74c3c;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-btn:hover { background: #c0392b; }
        h2 { color: #2c3e50; margin-bottom: 20px; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        .vuln-list {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .vuln-list ul { list-style: none; }
        .vuln-list li {
            padding: 10px;
            margin: 5px 0;
            background: white;
            border-left: 4px solid #27ae60;
            border-radius: 5px;
        }
        .test-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .test-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
            transition: transform 0.2s, box-shadow 0.2s;
            display: block;
        }
        .test-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .test-card h3 { color: #3498db; margin-bottom: 10px; }
        .test-card p { font-size: 14px; color: #666; }
        .badge {
            display: inline-block;
            background: #27ae60;
            color: white;
            font-size: 12px;
            padding: 3px 8px;
            border-radius: 10px;
            margin-top: 10px;
        }
        .footer {
            background: #ecf0f1;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛡️ Mutillidae - Security Fixed Version</h1>
            <p>Demostración de vulnerabilidades corregidas según OWASP Top 10</p>
        </div>
        
        <div class="content">
            <?php if (isset($_SESSION['username'])): ?>
                <div class="welcome">
                    <div>
                        👋 Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!
                    </div>
                    <a href="logout.php" class="logout-btn">🚪 Logout</a>
                </div>
            <?php else: ?>
                <div class="welcome">
                    <div>👋 You are not logged in</div>
                    <a href="login.php" style="background: #3498db; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px;">🔑 Login</a>
                </div>
            <?php endif; ?>
            
            <h2>✅ Vulnerabilidades Corregidas</h2>
            <div class="vuln-list">
                <ul>
                    <li>🔒 <strong>SQL Injection (A1:2021)</strong> - Bypass Authentication y Union-Based</li>
                    <li>🛡️ <strong>Cross-Site Scripting (A3:2021)</strong> - Reflected XSS en DNS Lookup</li>
                    <li>📝 <strong>Stored XSS (A3:2021)</strong> - Persistent XSS en Blog Comments</li>
                    <li>🎯 <strong>HTML/JavaScript Injection</strong> - Password Generator Parameter</li>
                    <li>🔐 <strong>Missing Function Level Access Control</strong> - Protección de rutas</li>
                </ul>
            </div>
            
            <h2>🧪 Páginas de Prueba</h2>
            <div class="test-links">
                <a href="login.php" class="test-card">
                    <h3>🔑 Login Page</h3>
                    <p>Prueba SQL Injection: <code>' OR 1=1-- -</code> - YA NO funciona</p>
                    <span class="badge">SQLi Fixed</span>
                </a>
                
                <a href="dns-lookup.php" class="test-card">
                    <h3>🌐 DNS Lookup</h3>
                    <p>Prueba XSS: <code>&lt;script&gt;alert(1)&lt;/script&gt;</code> - YA NO ejecuta</p>
                    <span class="badge">XSS Fixed</span>
                </a>
                
                <a href="add-to-your-blog.php" class="test-card">
                    <h3>📝 Add to Blog</h3>
                    <p>Prueba Stored XSS: El script se guarda como texto plano</p>
                    <span class="badge">Stored XSS Fixed</span>
                </a>
                
                <a href="view-someones-blog.php" class="test-card">
                    <h3>📖 View Blog</h3>
                    <p>Visualización segura con output encoding</p>
                    <span class="badge">Output Encoding</span>
                </a>
                
                <a href="password-generator.php" class="test-card">
                    <h3>🔐 Password Generator</h3>
                    <p>Prueba HTML Injection: <code>&lt;img onerror=alert(1)&gt;</code> - Bloqueado</p>
                    <span class="badge">Input Validation</span>
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p>🔒 Security Fix Demo | OWASP Top 10 Compliance | Prepared Statements | Output Encoding | Input Validation</p>
            <p>© 2026 - Proyecto de Refaccionaria SA - Auditoría y Remediación de Seguridad</p>
        </div>
    </div>
</body>
</html>

