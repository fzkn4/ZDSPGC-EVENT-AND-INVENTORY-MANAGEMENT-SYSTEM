<?php
require_once 'auth.php';

// Redirect if already logged in
if ($auth->isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'login') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $userType = $_POST['userType'] ?? 'student';
        
        $result = $auth->login($email, $password, $userType);
        
        if ($result['success']) {
            header('Location: dashboard.php');
            exit;
        } else {
            $error = $result['message'];
        }
    } elseif ($_POST['action'] === 'register') {
        $userData = [
            'firstName' => $_POST['firstName'] ?? '',
            'lastName' => $_POST['lastName'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'userType' => $_POST['userType'] ?? 'student',
            'studentId' => $_POST['studentId'] ?? null
        ];
        
        $result = $auth->register($userData);
        
        if ($result['success']) {
            $success = 'Account created successfully! Please sign in.';
        } else {
            $error = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Login - ZDSPGC EIMS</title>

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
	<!-- Bootstrap Icons -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<!-- Local styles -->
	<link href="styles/style.css" rel="stylesheet" />
	<link href="styles/login.css" rel="stylesheet" />
</head>
<body class="auth-body">
	<div class="auth-container">
		<!-- Background Animation -->
		<div class="auth-background">
			<div class="floating-shapes">
				<div class="shape shape-1"></div>
				<div class="shape shape-2"></div>
				<div class="shape shape-3"></div>
				<div class="shape shape-4"></div>
				<div class="shape shape-5"></div>
			</div>
		</div>

		<div class="container-fluid h-100">
			<div class="row h-100 align-items-center justify-content-center">
				<div class="col-12 col-lg-10 col-xl-8">
					<div class="auth-wrapper">
						<!-- Left Side - Branding -->
						<div class="auth-branding">
							<div class="branding-content">
								<div class="brand-logo">
									<i class="bi bi-grid-1x2-fill"></i>
								</div>
								<h1 class="brand-title">ZDSPGC EIMS</h1>
								<p class="brand-subtitle">Event & Inventory Management System</p>
								<div class="brand-features">
									<div class="feature-item">
										<i class="bi bi-calendar-check"></i>
										<span>Event Management</span>
									</div>
									<div class="feature-item">
										<i class="bi bi-box-seam"></i>
										<span>Inventory Control</span>
									</div>
									<div class="feature-item">
										<i class="bi bi-people"></i>
										<span>User Management</span>
									</div>
								</div>
							</div>
						</div>

						<!-- Right Side - Auth Forms -->
						<div class="auth-forms">
							<div class="forms-container">
								<!-- Error/Success Messages -->
								<?php if ($error): ?>
								<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
									<i class="bi bi-exclamation-triangle me-2"></i>
									<?php echo htmlspecialchars($error); ?>
									<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
								</div>
								<?php endif; ?>
								
								<?php if ($success): ?>
								<div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
									<i class="bi bi-check-circle me-2"></i>
									<?php echo htmlspecialchars($success); ?>
									<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
								</div>
								<?php endif; ?>

								<!-- Login Form -->
								<div class="auth-form active" id="loginForm">
									<div class="form-header">
										<h2>Welcome Back</h2>
										<p>Sign in to your account to continue</p>
									</div>

									<form method="post" class="auth-form-content">
										<input type="hidden" name="action" value="login">
										
										<!-- User Type Selection -->
										<div class="user-type-selector mb-4">
											<label class="form-label">I am a:</label>
											<div class="user-type-options">
												<input type="radio" name="userType" id="studentLogin" value="student" class="user-type-input" checked>
												<label for="studentLogin" class="user-type-label">
													<i class="bi bi-mortarboard"></i>
													<span>Student</span>
												</label>
												
												<input type="radio" name="userType" id="adminLogin" value="admin" class="user-type-input">
												<label for="adminLogin" class="user-type-label">
													<i class="bi bi-shield-check"></i>
													<span>Admin</span>
												</label>
											</div>
										</div>

										<!-- Email Field -->
										<div class="form-floating mb-3">
											<input type="email" class="form-control" id="loginEmail" name="email" placeholder="name@example.com" required>
											<label for="loginEmail">Email address</label>
										</div>

										<!-- Password Field -->
										<div class="form-floating mb-3">
											<input type="password" class="form-control" id="loginPassword" name="password" placeholder="Password" required>
											<label for="loginPassword">Password</label>
											<button type="button" class="password-toggle" id="loginPasswordToggle">
												<i class="bi bi-eye"></i>
											</button>
										</div>

										<!-- Remember Me & Forgot Password -->
										<div class="d-flex justify-content-between align-items-center mb-4">
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="rememberMe">
												<label class="form-check-label" for="rememberMe">
													Remember me
												</label>
											</div>
											<a href="#" class="forgot-password">Forgot password?</a>
										</div>

										<!-- Submit Button -->
										<button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
											<span class="btn-text">Sign In</span>
											<span class="btn-loading d-none">
												<span class="spinner-border spinner-border-sm me-2"></span>
												Signing in...
											</span>
										</button>

										<!-- Switch to Signup -->
										<div class="auth-switch text-center mt-4">
											<p class="mb-0">
												Don't have an account? 
												<a href="#" class="switch-link" data-target="signupForm">Sign up</a>
											</p>
										</div>
									</form>
								</div>

								<!-- Signup Form -->
								<div class="auth-form" id="signupForm">
									<div class="form-header">
										<h2>Create Account</h2>
										<p>Join us and start managing events & inventory</p>
									</div>

									<form method="post" class="auth-form-content" id="signupFormElement">
										<input type="hidden" name="action" value="register">
										
										<!-- User Type Selection -->
										<div class="user-type-selector mb-4">
											<label class="form-label">I am a:</label>
											<div class="user-type-options">
												<input type="radio" name="userType" id="studentSignup" value="student" class="user-type-input" checked>
												<label for="studentSignup" class="user-type-label">
													<i class="bi bi-mortarboard"></i>
													<span>Student</span>
												</label>
												
												<input type="radio" name="userType" id="adminSignup" value="admin" class="user-type-input">
												<label for="adminSignup" class="user-type-label">
													<i class="bi bi-shield-check"></i>
													<span>Admin</span>
												</label>
											</div>
										</div>

										<!-- Name Fields -->
										<div class="row">
											<div class="col-md-6">
												<div class="form-floating mb-3">
													<input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
													<label for="firstName">First Name</label>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-floating mb-3">
													<input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
													<label for="lastName">Last Name</label>
												</div>
											</div>
										</div>

										<!-- Student ID (for students) -->
										<div class="form-floating mb-3" id="studentIdField">
											<input type="text" class="form-control" id="studentId" name="studentId" placeholder="Student ID">
											<label for="studentId">Student ID</label>
										</div>

										<!-- Email Field -->
										<div class="form-floating mb-3">
											<input type="email" class="form-control" id="signupEmail" name="email" placeholder="name@example.com" required>
											<label for="signupEmail">Email address</label>
										</div>

										<!-- Password Field -->
										<div class="form-floating mb-3">
											<input type="password" class="form-control" id="signupPassword" name="password" placeholder="Password" required>
											<label for="signupPassword">Password</label>
											<button type="button" class="password-toggle" id="signupPasswordToggle">
												<i class="bi bi-eye"></i>
											</button>
										</div>

										<!-- Confirm Password Field -->
										<div class="form-floating mb-3">
											<input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" required>
											<label for="confirmPassword">Confirm Password</label>
											<button type="button" class="password-toggle" id="confirmPasswordToggle">
												<i class="bi bi-eye"></i>
											</button>
										</div>

										<!-- Terms and Conditions -->
										<div class="form-check mb-4">
											<input class="form-check-input" type="checkbox" id="agreeTerms" required>
											<label class="form-check-label" for="agreeTerms">
												I agree to the <a href="#" class="terms-link">Terms of Service</a> and <a href="#" class="terms-link">Privacy Policy</a>
											</label>
										</div>

										<!-- Submit Button -->
										<button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
											<span class="btn-text">Create Account</span>
											<span class="btn-loading d-none">
												<span class="spinner-border spinner-border-sm me-2"></span>
												Creating account...
											</span>
										</button>

										<!-- Switch to Login -->
										<div class="auth-switch text-center mt-4">
											<p class="mb-0">
												Already have an account? 
												<a href="#" class="switch-link" data-target="loginForm">Sign in</a>
											</p>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="scripts/login.js"></script>
</body>
</html>


