<?php
// includes/database.php
// Clase para conexión segura a base de datos usando PDO

class Database {
    private $host = 'localhost';
    private $db_name = 'mutillidae';
    private $username = 'root';
    private $password = '';
    private $conn;
    private $error = null;

    public function getConnection() {
        $this->conn = null;
        
        try {
            // Usar PDO con prepared statements
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            
            // Configurar PDO para que lance excepciones
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Desactivar emulación de prepared statements (más seguro)
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
            // Usar fetch asociativo por defecto
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            // Guardar error para depuración
            $this->error = $e->getMessage();
            
            // Mostrar error amigable (puedes comentar en producción)
            echo "<div style='background:#f8d7da; color:#721c24; padding:10px; margin:10px; border-radius:5px;'>";
            echo "<strong>❌ Error de conexión a base de datos:</strong><br>";
            echo "No se pudo conectar a MySQL. Verifica que:<br>";
            echo "1. MySQL esté corriendo en XAMPP<br>";
            echo "2. La base de datos 'mutillidae' exista<br>";
            echo "3. Usuario/contraseña sean correctos<br>";
            echo "<hr><small>Detalle técnico: " . htmlspecialchars($e->getMessage()) . "</small>";
            echo "</div>";
        }
        
        return $this->conn;
    }
    
    // Método para obtener el error (útil para debugging)
    public function getError() {
        return $this->error;
    }
    
    // Método para probar la conexión
    public function testConnection() {
        $conn = $this->getConnection();
        if ($conn) {
            echo "✅ Conexión exitosa a base de datos '{$this->db_name}'";
            return true;
        }
        return false;
    }
}
?>