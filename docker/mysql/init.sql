-- Create users table and seed a default admin user
CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed admin user with password: admin123 (change in production)
INSERT INTO users (username, password_hash)
VALUES (
  'admin@example.com',
  -- php -r "echo password_hash('admin123', PASSWORD_DEFAULT);"
  '$2y$10$KmA1o6a9qkT3a5l9XrKpQOJkQ7tZ2XxQwqDk6S4wQKXy9l6oT0nH2'
)
ON DUPLICATE KEY UPDATE username = VALUES(username);


