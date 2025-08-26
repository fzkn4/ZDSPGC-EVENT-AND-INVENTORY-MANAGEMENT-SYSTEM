<?php
require_once 'auth.php';

// Require authentication
requireAuth();

// Get current user data
$currentUser = getCurrentUser();
$sessionData = getSessionData();

// Handle logout
if (isset($_GET['logout'])) {
    $auth->logout();
}

// Handle access denied error
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Dashboard - ZDSPGC Event & Inventory Management System</title>

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
	<!-- Bootstrap Icons -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
	<!-- Flaticon Icons -->
	<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>
	<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
	<!-- Local styles -->
	<link href="styles/style.css" rel="stylesheet" />
	<link href="styles/dashboard.css" rel="stylesheet" />
</head>
<body class="user-<?php echo htmlspecialchars($sessionData['user_type']); ?>">
	<!-- Background Animation -->
	<div class="app-background">
		<div class="floating-shapes">
			<div class="shape shape-1"></div>
			<div class="shape shape-2"></div>
			<div class="shape shape-3"></div>
			<div class="shape shape-4"></div>
			<div class="shape shape-5"></div>
		</div>
	</div>
	
	<header class="navbar navbar-expand-lg">
		<div class="container-fluid">
			<a class="navbar-brand d-flex align-items-center gap-2" href="dashboard.php">
				<i class="bi bi-grid-1x2-fill"></i>
				<span class="fw-semibold">ZDSPGC EIMS</span>
			</a>
			
			<!-- Mobile Navigation Toggle -->
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<!-- Navigation Content -->
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
					<li class="nav-item dropdown">
						<button class="btn btn-outline-light d-flex align-items-center gap-2" id="btnUserDropdown" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="bi bi-person-circle"></i>
							<span id="userDisplayName"><?php echo htmlspecialchars($sessionData['user_name']); ?></span>
							<i class="bi bi-chevron-down"></i>
						</button>
						<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="btnUserDropdown">
							<li><span class="dropdown-item-text small text-muted" id="userEmail"><?php echo htmlspecialchars($sessionData['user_email']); ?></span></li>
							<?php if ($sessionData['student_id']): ?>
							<li><span class="dropdown-item-text small text-muted">Student ID: <?php echo htmlspecialchars($sessionData['student_id']); ?></span></li>
							<?php endif; ?>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
							<li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item text-danger" href="?logout=1"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</header>

	<div class="container-fluid">
		<div class="row">
			<!-- Sidebar -->
			<aside class="col-12 col-md-3 col-lg-3 py-3 sidebar" id="dashboardSidebar">
				<ul class="list-unstyled sidebar-menu px-2 mb-3">
					<li><a href="dashboard.php" class="menu-link active d-flex align-items-center gap-2"><i class="fi fi-br-dashboard-panel unfilled-icon"></i><i class="fi fi-sr-dashboard-panel filled-icon"></i><span>Dashboard</span></a></li>
					<li><a href="index.php" class="menu-link d-flex align-items-center gap-2"><i class="fi fi-br-calendar unfilled-icon"></i><i class="fi fi-sr-calendar filled-icon"></i><span>Events</span></a></li>
					<li><a href="inventory.php" class="menu-link d-flex align-items-center gap-2"><i class="fi fi-br-box unfilled-icon"></i><i class="fi fi-sr-box filled-icon"></i><span>Inventory</span></a></li>
				</ul>
			</aside>

			<main class="col-12 col-md-9 col-lg-9 py-3 py-md-4 page-content dashboard-main">
				<!-- Error Messages -->
				<?php if ($error === 'access_denied'): ?>
				<div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
					<i class="bi bi-exclamation-triangle me-2"></i>
					<strong>Access Denied!</strong> You don't have permission to access that page.
					<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				</div>
				<?php endif; ?>

				<!-- Welcome Section -->
				<div class="welcome-section mb-4">
					<div class="welcome-content">
						<h1 class="welcome-title">Welcome back, <?php echo htmlspecialchars($sessionData['user_name']); ?>!</h1>
						<p class="welcome-subtitle">Here's what's happening in your ZDSPGC Event & Inventory Management System</p>
					</div>
				</div>

				<!-- Statistics Cards and Quick Actions Row -->
				<div class="dashboard-row mb-4">
					<!-- Statistics Cards -->
					<div class="dashboard-stats">
						<div class="stats-grid">
							<div class="stat-card">
								<div class="stat-icon">
									<i class="bi bi-calendar-event"></i>
								</div>
								<div class="stat-number" id="statTotalEvents">12</div>
								<div class="stat-label">Total Events</div>
							</div>
							<div class="stat-card">
								<div class="stat-icon">
									<i class="bi bi-check2-square"></i>
								</div>
								<div class="stat-number" id="statCompletedCount">8</div>
								<div class="stat-label">Completed</div>
							</div>
							<div class="stat-card">
								<div class="stat-icon">
									<i class="bi bi-box-seam"></i>
								</div>
								<div class="stat-number" id="statInventoryItems">45</div>
								<div class="stat-label">Inventory Items</div>
							</div>
							<div class="stat-card">
								<div class="stat-icon">
									<i class="bi bi-arrow-left-right"></i>
								</div>
								<div class="stat-number" id="statActiveLoans">3</div>
								<div class="stat-label">Active Loans</div>
							</div>
						</div>
					</div>

					<!-- Quick Actions -->
					<div class="quick-actions">
						<div class="actions-grid">
							<a href="index.php" class="action-btn">
								<i class="bi bi-plus-circle action-icon"></i>
								<span class="action-text">Add Event</span>
							</a>
							<a href="inventory.php" class="action-btn">
								<i class="bi bi-box-seam action-icon"></i>
								<span class="action-text">Add Item</span>
							</a>
							<a href="inventory.php" class="action-btn">
								<i class="bi bi-arrow-left-right action-icon"></i>
								<span class="action-text">Borrow Item</span>
							</a>
							<a href="index.php" class="action-btn">
								<i class="bi bi-people-check action-icon"></i>
								<span class="action-text">Attendance</span>
							</a>
						</div>
					</div>
				</div>

				<!-- Recent Activity & Upcoming Events -->
				<div class="dashboard-grid">
					<!-- Upcoming Events -->
					<div class="upcoming-events">
						<h5 class="card-title mb-3"><i class="bi bi-calendar-event me-2"></i>Upcoming Events</h5>
						<div class="event-item">
							<div class="event-title">Orientation Day</div>
							<div class="event-date">Main Hall • 2025-09-01</div>
							<div class="event-location">Campus Event</div>
						</div>
						<div class="event-item">
							<div class="event-title">Tech Innovation Fair</div>
							<div class="event-date">Gymnasium • 2025-10-12</div>
							<div class="event-location">Public Event</div>
						</div>
						<div class="event-item">
							<div class="event-title">Faculty Workshop</div>
							<div class="event-date">Room B203 • 2025-08-25</div>
							<div class="event-location">Internal Event</div>
						</div>
					</div>

					<!-- Recent Activity -->
					<div class="recent-activity">
						<h5 class="card-title mb-3"><i class="bi bi-activity me-2"></i>Recent Activity</h5>
						<div class="activity-item">
							<div class="activity-icon">
								<i class="bi bi-calendar-plus"></i>
							</div>
							<div class="activity-content">
								<div class="activity-title">New event added</div>
								<div class="activity-time">Orientation Day scheduled for 2025-09-01 • 2 hours ago</div>
							</div>
						</div>
						<div class="activity-item">
							<div class="activity-icon">
								<i class="bi bi-box-seam"></i>
							</div>
							<div class="activity-content">
								<div class="activity-title">Item borrowed</div>
								<div class="activity-time">Wireless Microphones borrowed by John Doe • 4 hours ago</div>
							</div>
						</div>
						<div class="activity-item">
							<div class="activity-icon">
								<i class="bi bi-check-circle"></i>
							</div>
							<div class="activity-content">
								<div class="activity-title">Event completed</div>
								<div class="activity-time">Summer Workshop successfully completed • 1 day ago</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>
	</div>

	<!-- Scripts -->
	<script src="scripts/script.js"></script>
	<script src="scripts/dashboard.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
