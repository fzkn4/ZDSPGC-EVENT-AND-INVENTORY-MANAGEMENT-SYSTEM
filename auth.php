<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Auth
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function login(string $email, string $password, string $userType = 'student'): array
    {
        $email = trim(strtolower($email));
        if ($email === '' || $password === '') {
            return ['success' => false, 'message' => 'Email and password are required.'];
        }

        // Using email as username for simplicity; adjust schema if you store email separately
        $stmt = $this->pdo->prepare('SELECT id, username AS email, password_hash FROM users WHERE username = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return ['success' => false, 'message' => 'Invalid credentials.'];
        }

        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['user_email'] = $email;
        $_SESSION['email'] = $email;
        $_SESSION['user_type'] = $userType;
        $_SESSION['user_name'] = $email; // Default to email if no name available
        $_SESSION['login_time'] = time();
        $_SESSION['is_logged_in'] = true;
        session_regenerate_id(true);

        return ['success' => true];
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        header('Location: login.php');
        exit;
    }

    public function requireLogin(): void
    {
        if (!$this->isLoggedIn()) {
            header('Location: login.php');
            exit;
        }
    }

    public function requireAdmin(): void
    {
        $this->requireLogin();
        if (($_SESSION['user_type'] ?? '') !== 'admin') {
            header('Location: dashboard.php?error=access_denied');
            exit;
        }
    }

    public function requireStudent(): void
    {
        $this->requireLogin();
        if (($_SESSION['user_type'] ?? '') !== 'student') {
            header('Location: dashboard.php?error=access_denied');
            exit;
        }
    }

    public function getCurrentUser(): ?array
    {
        if (!$this->isLoggedIn()) {
            return null;
        }
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            return null;
        }
        $stmt = $this->pdo->prepare('SELECT id, username FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $userId]);
        return $stmt->fetch() ?: null;
    }

    public function getSessionData(): ?array
    {
        if (!$this->isLoggedIn()) {
            return null;
        }
        return [
            'user_id' => $_SESSION['user_id'] ?? null,
            'user_email' => $_SESSION['user_email'] ?? $_SESSION['email'] ?? null,
            'user_type' => $_SESSION['user_type'] ?? null,
            'user_name' => $_SESSION['user_name'] ?? $_SESSION['user_email'] ?? $_SESSION['email'] ?? 'User',
            'student_id' => $_SESSION['student_id'] ?? null,
            'login_time' => $_SESSION['login_time'] ?? null,
        ];
    }

    public function register(array $userData): array
    {
        $firstName = trim($userData['firstName'] ?? '');
        $lastName = trim($userData['lastName'] ?? '');
        $email = trim(strtolower($userData['email'] ?? ''));
        $password = $userData['password'] ?? '';

        if ($email === '' || $password === '') {
            return ['success' => false, 'message' => 'Email and password are required.'];
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // For demo, store email in username column. Extend schema for names as needed.
        try {
            $stmt = $this->pdo->prepare('INSERT INTO users (username, password_hash) VALUES (:email, :password_hash)');
            $stmt->execute([
                'email' => $email,
                'password_hash' => $passwordHash,
            ]);
        } catch (PDOException $e) {
            if ((int)$e->getCode() === 23000) {
                return ['success' => false, 'message' => 'Account already exists.'];
            }
            return ['success' => false, 'message' => 'Registration failed.'];
        }

        return ['success' => true];
    }
}

// Expose $auth as in existing pages
/** @var PDO $pdo */
$auth = new Auth($pdo);

// Global helper functions for backward compatibility
function requireAuth(): void
{
    global $auth;
    $auth->requireLogin();
}

function requireAdmin(): void
{
    global $auth;
    $auth->requireAdmin();
}

function requireStudent(): void
{
    global $auth;
    $auth->requireStudent();
}

function getCurrentUser(): ?array
{
    global $auth;
    return $auth->getCurrentUser();
}

function getSessionData(): ?array
{
    global $auth;
    return $auth->getSessionData();
}

function isAdmin(): bool
{
    $sessionData = getSessionData();
    return $sessionData && ($sessionData['user_type'] ?? '') === 'admin';
}

function isStudent(): bool
{
    $sessionData = getSessionData();
    return $sessionData && ($sessionData['user_type'] ?? '') === 'student';
}
