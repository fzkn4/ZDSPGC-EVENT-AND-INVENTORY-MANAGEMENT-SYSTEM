<?php
/**
 * ZDSPGC EIMS - Database Setup Script
 * 
 * This script will:
 * 1. Connect to MySQL using your credentials
 * 2. Create the database if it doesn't exist
 * 3. Create all required tables
 * 4. Seed initial data
 * 
 * Usage: Open this file in your browser
 */

declare(strict_types=1);

session_start();

// Configuration
$setupConfig = [
    'db_host' => '127.0.0.1',
    'db_port' => '3306',
    'db_name' => 'zdspgc_db',
    'charset' => 'utf8mb4'
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rootUser = $_POST['root_user'] ?? 'root';
    $rootPass = $_POST['root_pass'] ?? '';
    
    try {
        // Step 1: Connect to MySQL server (without database)
        $dsn = sprintf('mysql:host=%s;port=%s;charset=%s', 
            $setupConfig['db_host'], 
            $setupConfig['db_port'], 
            $setupConfig['charset']
        );
        
        $pdo = new PDO($dsn, $rootUser, $rootPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        
        // Step 2: Create database if it doesn't exist
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$setupConfig['db_name']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE `{$setupConfig['db_name']}`");
        
        // Step 3: Create users table
        $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        
        $pdo->exec($sql);
        
        // Step 4: Create app user and grant privileges
        $appUser = 'zdspgc_user';
        $appPass = 'zdspgc_pass';
        
        // Drop user if exists (to reset)
        $pdo->exec("DROP USER IF EXISTS '$appUser'@'localhost'");
        $pdo->exec("DROP USER IF EXISTS '$appUser'@'%'");
        
        // Create user
        $pdo->exec("CREATE USER '$appUser'@'localhost' IDENTIFIED BY '$appPass'");
        $pdo->exec("CREATE USER '$appUser'@'%' IDENTIFIED BY '$appPass'");
        
        // Grant privileges
        $pdo->exec("GRANT ALL PRIVILEGES ON `{$setupConfig['db_name']}`.* TO '$appUser'@'localhost'");
        $pdo->exec("GRANT ALL PRIVILEGES ON `{$setupConfig['db_name']}`.* TO '$appUser'@'%'");
        $pdo->exec("FLUSH PRIVILEGES");
        
        // Step 5: Seed default admin user if table is empty
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $count = $stmt->fetch()['count'];
        
        if ($count == 0) {
            $hashedPass = '$2y$10$KmA1o6a9qkT3a5l9XrKpQOJkQ7tZ2XxQwqDk6S4wQKXy9l6oT0nH2'; // admin123
            $stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
            $stmt->execute(['admin@example.com', $hashedPass]);
        }
        
        // Success!
        $setupSuccess = true;
        
    } catch (PDOException $e) {
        $setupError = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - ZDSPGC EIMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px;
        }
        .setup-card {
            max-width: 600px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            border-radius: 15px;
        }
        .success-icon {
            font-size: 4rem;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card setup-card">
                    <div class="card-body p-5">
                        <?php if (isset($setupSuccess)): ?>
                            <!-- Success Message -->
                            <div class="text-center">
                                <div class="success-icon mb-3">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <h2 class="card-title mb-3">Setup Complete!</h2>
                                <p class="text-muted mb-4">Your database has been configured successfully.</p>
                                
                                <div class="alert alert-info text-start mb-4">
                                    <strong>Database Configuration:</strong><br>
                                    <small>
                                        <code>Host:</code> <?php echo htmlspecialchars($setupConfig['db_host']); ?><br>
                                        <code>Port:</code> <?php echo htmlspecialchars($setupConfig['db_port']); ?><br>
                                        <code>Database:</code> <?php echo htmlspecialchars($setupConfig['db_name']); ?><br>
                                        <code>Username:</code> zdspgc_user<br>
                                        <code>Password:</code> zdspgc_pass
                                    </small>
                                </div>
                                
                                <div class="alert alert-warning text-start mb-4">
                                    <strong>Default Admin Credentials:</strong><br>
                                    <code>Username:</code> admin@example.com<br>
                                    <code>Password:</code> admin123<br>
                                    <small class="text-danger">⚠️ Please change this password after first login!</small>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <a href="login.php" class="btn btn-primary btn-lg">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Go to Login
                                    </a>
                                    <button onclick="window.location.reload()" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-clockwise me-2"></i>Run Setup Again
                                    </button>
                                </div>
                            </div>
                        <?php elseif (isset($setupError)): ?>
                            <!-- Error Message -->
                            <div class="text-center">
                                <div class="text-danger mb-3" style="font-size: 4rem;">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                </div>
                                <h2 class="card-title mb-3">Setup Failed</h2>
                                <div class="alert alert-danger text-start">
                                    <strong>Error:</strong><br>
                                    <?php echo htmlspecialchars($setupError); ?>
                                </div>
                                <button onclick="window.location.reload()" class="btn btn-primary">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Try Again
                                </button>
                            </div>
                        <?php else: ?>
                            <!-- Setup Form -->
                            <div class="text-center mb-4">
                                <i class="bi bi-database" style="font-size: 3rem; color: #667eea;"></i>
                                <h2 class="card-title mt-3">Database Setup</h2>
                                <p class="text-muted">Enter your MySQL root credentials to set up the database</p>
                            </div>
                            
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="root_user" class="form-label">
                                        <i class="bi bi-person-circle me-1"></i>MySQL Root Username
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control form-control-lg" 
                                        id="root_user" 
                                        name="root_user" 
                                        value="root" 
                                        required
                                        placeholder="root"
                                    >
                                </div>
                                
                                <div class="mb-4">
                                    <label for="root_pass" class="form-label">
                                        <i class="bi bi-lock-fill me-1"></i>MySQL Root Password
                                    </label>
                                    <input 
                                        type="password" 
                                        class="form-control form-control-lg" 
                                        id="root_pass" 
                                        name="root_pass" 
                                        placeholder="Enter root password"
                                    >
                                    <small class="form-text text-muted">
                                        For XAMPP, this is usually empty. For WAMP/MAMP, enter your root password.
                                    </small>
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>What this will do:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li>Create database: <code>zdspgc_db</code></li>
                                        <li>Create app user: <code>zdspgc_user</code></li>
                                        <li>Set up all required tables</li>
                                        <li>Seed default admin account</li>
                                    </ul>
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-play-circle me-2"></i>Run Setup
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                        
                        <hr class="my-4">
                        
                        <div class="text-center">
                            <small class="text-muted">
                                <i class="bi bi-shield-check me-1"></i>
                                Secure • This page can be deleted after setup
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

