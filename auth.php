<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Authentication class
class Auth {
    private $users = [];
    private $session_timeout = 3600; // 1 hour
    
    public function __construct() {
        // Load users from JSON file (in real app, this would be a database)
        $this->loadUsers();
        
        // Check session timeout
        $this->checkSessionTimeout();
    }
    
    private function loadUsers() {
        $usersFile = 'data/users.json';
        
        // Create data directory if it doesn't exist
        if (!is_dir('data')) {
            mkdir('data', 0755, true);
        }
        
        // Create default users if file doesn't exist
        if (!file_exists($usersFile)) {
            $this->createDefaultUsers($usersFile);
        }
        
        // Load users from file
        if (file_exists($usersFile)) {
            $this->users = json_decode(file_get_contents($usersFile), true) ?? [];
        }
    }
    
    private function createDefaultUsers($usersFile) {
        $defaultUsers = [
            [
                'id' => 1,
                'firstName' => 'Admin',
                'lastName' => 'User',
                'email' => 'admin@zdspgc.edu.ph',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'userType' => 'admin',
                'studentId' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'last_login' => null
            ],
            [
                'id' => 2,
                'firstName' => 'John',
                'lastName' => 'Doe',
                'email' => 'student@zdspgc.edu.ph',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'userType' => 'student',
                'studentId' => '2024-0001',
                'created_at' => date('Y-m-d H:i:s'),
                'last_login' => null
            ]
        ];
        
        file_put_contents($usersFile, json_encode($defaultUsers, JSON_PRETTY_PRINT));
        $this->users = $defaultUsers;
    }
    
    public function login($email, $password, $userType) {
        // Find user by email and user type
        $user = null;
        foreach ($this->users as $u) {
            if ($u['email'] === $email && $u['userType'] === $userType) {
                $user = $u;
                break;
            }
        }
        
        if (!$user) {
            return ['success' => false, 'message' => 'Invalid email or user type'];
        }
        
        // Verify password
        if (!password_verify($password, $user['password'])) {
            return ['success' => false, 'message' => 'Invalid password'];
        }
        
        // Update last login
        $this->updateLastLogin($user['id']);
        
        // Set session data
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_type'] = $user['userType'];
        $_SESSION['user_name'] = $user['firstName'] . ' ' . $user['lastName'];
        $_SESSION['student_id'] = $user['studentId'];
        $_SESSION['login_time'] = time();
        $_SESSION['is_logged_in'] = true;
        
        return ['success' => true, 'user' => $user];
    }
    
    public function register($userData) {
        // Check if email already exists
        foreach ($this->users as $user) {
            if ($user['email'] === $userData['email']) {
                return ['success' => false, 'message' => 'Email already exists'];
            }
        }
        
        // Create new user
        $newUser = [
            'id' => count($this->users) + 1,
            'firstName' => $userData['firstName'],
            'lastName' => $userData['lastName'],
            'email' => $userData['email'],
            'password' => password_hash($userData['password'], PASSWORD_DEFAULT),
            'userType' => $userData['userType'],
            'studentId' => $userData['studentId'] ?? null,
            'created_at' => date('Y-m-d H:i:s'),
            'last_login' => null
        ];
        
        // Add to users array
        $this->users[] = $newUser;
        
        // Save to file
        $this->saveUsers();
        
        return ['success' => true, 'user' => $newUser];
    }
    
    private function updateLastLogin($userId) {
        foreach ($this->users as &$user) {
            if ($user['id'] == $userId) {
                $user['last_login'] = date('Y-m-d H:i:s');
                break;
            }
        }
        $this->saveUsers();
    }
    
    private function saveUsers() {
        $usersFile = 'data/users.json';
        file_put_contents($usersFile, json_encode($this->users, JSON_PRETTY_PRINT));
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
    }
    
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            header('Location: login.php');
            exit;
        }
    }
    
    public function requireAdmin() {
        $this->requireLogin();
        if ($_SESSION['user_type'] !== 'admin') {
            header('Location: dashboard.php?error=access_denied');
            exit;
        }
    }
    
    public function requireStudent() {
        $this->requireLogin();
        if ($_SESSION['user_type'] !== 'student') {
            header('Location: dashboard.php?error=access_denied');
            exit;
        }
    }
    
    public function logout() {
        // Clear session
        session_unset();
        session_destroy();
        
        // Clear any session cookies
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        
        header('Location: login.php');
        exit;
    }
    
    public function getCurrentUser() {
        if (!$this->isLoggedIn()) {
            return null;
        }
        
        foreach ($this->users as $user) {
            if ($user['id'] == $_SESSION['user_id']) {
                return $user;
            }
        }
        
        return null;
    }
    
    public function getSessionData() {
        if (!$this->isLoggedIn()) {
            return null;
        }
        
        return [
            'user_id' => $_SESSION['user_id'] ?? null,
            'user_email' => $_SESSION['user_email'] ?? null,
            'user_type' => $_SESSION['user_type'] ?? null,
            'user_name' => $_SESSION['user_name'] ?? null,
            'student_id' => $_SESSION['student_id'] ?? null,
            'login_time' => $_SESSION['login_time'] ?? null
        ];
    }
    
    private function checkSessionTimeout() {
        if ($this->isLoggedIn()) {
            $loginTime = $_SESSION['login_time'] ?? 0;
            $currentTime = time();
            
            if (($currentTime - $loginTime) > $this->session_timeout) {
                $this->logout();
            }
        }
    }
    
    public function refreshSession() {
        if ($this->isLoggedIn()) {
            $_SESSION['login_time'] = time();
        }
    }
}

// Initialize authentication
$auth = new Auth();

// Function to require authentication on any page
function requireAuth() {
    global $auth;
    $auth->requireLogin();
}

// Function to require admin access
function requireAdmin() {
    global $auth;
    $auth->requireAdmin();
}

// Function to require student access
function requireStudent() {
    global $auth;
    $auth->requireStudent();
}

// Function to get current user data
function getCurrentUser() {
    global $auth;
    return $auth->getCurrentUser();
}

// Function to get session data
function getSessionData() {
    global $auth;
    return $auth->getSessionData();
}

// Function to check if user is admin
function isAdmin() {
    $sessionData = getSessionData();
    return $sessionData && $sessionData['user_type'] === 'admin';
}

// Function to check if user is student
function isStudent() {
    $sessionData = getSessionData();
    return $sessionData && $sessionData['user_type'] === 'student';
}
?>
