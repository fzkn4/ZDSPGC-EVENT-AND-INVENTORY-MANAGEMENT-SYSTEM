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
<body>
	<header class="navbar navbar-expand-lg navbar-dark bg-primary">
		<div class="container-fluid">
			<a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
				<i class="bi bi-grid-1x2-fill"></i>
				<span class="fw-semibold">ZDSPGC EIMS</span>
			</a>
			<ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
				<li class="nav-item dropdown me-2">
					<button class="btn btn-outline-light position-relative" id="btnNotifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="bi bi-bell"></i>
						<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notifCount">0</span>
					</button>
					<ul class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="btnNotifDropdown" id="notifMenu" style="min-width: 320px;">
						<li class="px-3 py-2 small text-muted" id="notifEmpty">No notifications</li>
					</ul>
				</li>
			</ul>
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

			<main class="col-12 col-md-9 col-lg-9 py-3 py-md-4 page-content">
				<!-- Page Header -->
				<div class="d-flex align-items-center justify-content-between mb-4">
					<div>
						<h1 class="h3 mb-1">Dashboard</h1>
						<p class="text-muted mb-0">Welcome to ZDSPGC Event & Inventory Management System</p>
					</div>
					<div class="d-flex gap-2">
						<button class="btn btn-outline-primary" onclick="window.location.href='index.php'">
							<i class="bi bi-calendar-event me-1"></i>View Events
						</button>
						<button class="btn btn-outline-primary" onclick="window.location.href='inventory.php'">
							<i class="bi bi-box-seam me-1"></i>View Inventory
						</button>
					</div>
				</div>

				<!-- Statistics Cards -->
				<div class="row g-3 mb-4">
					<div class="col-6 col-md-3">
						<div class="card shadow-sm h-100">
							<div class="card-body d-flex align-items-center gap-3">
								<i class="bi bi-calendar-event fs-3 text-primary"></i>
								<div>
									<div class="small text-muted">Total Events</div>
									<div class="fs-5 fw-semibold" id="statTotalEvents">12</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6 col-md-3">
						<div class="card shadow-sm h-100">
							<div class="card-body d-flex align-items-center gap-3">
								<i class="bi bi-check2-square fs-3 text-success"></i>
								<div>
									<div class="small text-muted">Completed</div>
									<div class="fs-5 fw-semibold" id="statCompletedCount">8</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6 col-md-3">
						<div class="card shadow-sm h-100">
							<div class="card-body d-flex align-items-center gap-3">
								<i class="bi bi-box-seam fs-3 text-warning"></i>
								<div>
									<div class="small text-muted">Inventory Items</div>
									<div class="fs-5 fw-semibold" id="statInventoryItems">45</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6 col-md-3">
						<div class="card shadow-sm h-100">
							<div class="card-body d-flex align-items-center gap-3">
								<i class="bi bi-arrow-left-right fs-3 text-info"></i>
								<div>
									<div class="small text-muted">Active Loans</div>
									<div class="fs-5 fw-semibold" id="statActiveLoans">3</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Quick Actions -->
				<div class="row g-3 mb-4">
					<div class="col-12">
						<div class="card shadow-sm">
							<div class="card-header bg-light">
								<h5 class="card-title mb-0"><i class="bi bi-lightning me-2"></i>Quick Actions</h5>
							</div>
							<div class="card-body">
								<div class="row g-3">
									<div class="col-6 col-md-3">
										<button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3" onclick="window.location.href='index.php'">
											<i class="bi bi-plus-circle fs-2 mb-2"></i>
											<span>Add Event</span>
										</button>
									</div>
									<div class="col-6 col-md-3">
										<button class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3" onclick="window.location.href='inventory.php'">
											<i class="bi bi-box-seam fs-2 mb-2"></i>
											<span>Add Item</span>
										</button>
									</div>
									<div class="col-6 col-md-3">
										<button class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3" onclick="window.location.href='inventory.php'">
											<i class="bi bi-arrow-left-right fs-2 mb-2"></i>
											<span>Borrow Item</span>
										</button>
									</div>
									<div class="col-6 col-md-3">
										<button class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3" onclick="window.location.href='index.php'">
											<i class="bi bi-people-check fs-2 mb-2"></i>
											<span>Attendance</span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Recent Activity & Upcoming Events -->
				<div class="row g-3">
					<!-- Upcoming Events -->
					<div class="col-12 col-lg-6">
						<div class="card shadow-sm h-100">
							<div class="card-header bg-light d-flex align-items-center justify-content-between">
								<h5 class="card-title mb-0"><i class="bi bi-calendar-event me-2"></i>Upcoming Events</h5>
								<a href="index.php" class="btn btn-sm btn-outline-primary">View All</a>
							</div>
							<div class="card-body">
								<div class="list-group list-group-flush">
									<div class="list-group-item d-flex align-items-start justify-content-between border-0 px-0">
										<div>
											<div class="fw-semibold">Orientation Day</div>
											<div class="small text-muted">Main Hall • 2025-09-01</div>
										</div>
										<span class="badge text-bg-info">Campus</span>
									</div>
									<div class="list-group-item d-flex align-items-start justify-content-between border-0 px-0">
										<div>
											<div class="fw-semibold">Tech Innovation Fair</div>
											<div class="small text-muted">Gymnasium • 2025-10-12</div>
										</div>
										<span class="badge text-bg-warning">Public</span>
									</div>
									<div class="list-group-item d-flex align-items-start justify-content-between border-0 px-0">
										<div>
											<div class="fw-semibold">Faculty Workshop</div>
											<div class="small text-muted">Room B203 • 2025-08-25</div>
										</div>
										<span class="badge text-bg-success">Internal</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Recent Activity -->
					<div class="col-12 col-lg-6">
						<div class="card shadow-sm h-100">
							<div class="card-header bg-light">
								<h5 class="card-title mb-0"><i class="bi bi-activity me-2"></i>Recent Activity</h5>
							</div>
							<div class="card-body">
								<div class="list-group list-group-flush">
									<div class="list-group-item d-flex align-items-start border-0 px-0">
										<div class="flex-shrink-0 me-3">
											<i class="bi bi-calendar-plus text-success"></i>
										</div>
										<div class="flex-grow-1">
											<div class="fw-semibold">New event added</div>
											<div class="small text-muted">Orientation Day scheduled for 2025-09-01</div>
											<div class="small text-muted">2 hours ago</div>
										</div>
									</div>
									<div class="list-group-item d-flex align-items-start border-0 px-0">
										<div class="flex-shrink-0 me-3">
											<i class="bi bi-box-seam text-primary"></i>
										</div>
										<div class="flex-grow-1">
											<div class="fw-semibold">Item borrowed</div>
											<div class="small text-muted">Wireless Microphones borrowed by John Doe</div>
											<div class="small text-muted">4 hours ago</div>
										</div>
									</div>
									<div class="list-group-item d-flex align-items-start border-0 px-0">
										<div class="flex-shrink-0 me-3">
											<i class="bi bi-check-circle text-success"></i>
										</div>
										<div class="flex-grow-1">
											<div class="fw-semibold">Event completed</div>
											<div class="small text-muted">Summer Workshop successfully completed</div>
											<div class="small text-muted">1 day ago</div>
										</div>
									</div>
								</div>
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
