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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Inventory - ZDSPGC Event & Inventory Management System</title>

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
	<!-- Bootstrap Icons -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
	<!-- Flaticon Icons -->
	<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>
	<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
	<!-- Local styles -->
	<link href="styles/style.css" rel="stylesheet" />
	<link href="styles/inventory.css" rel="stylesheet" />
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
					<li><a href="dashboard.php" class="menu-link d-flex align-items-center gap-2"><i class="fi fi-br-dashboard-panel unfilled-icon"></i><i class="fi fi-sr-dashboard-panel filled-icon"></i><span>Dashboard</span></a></li>
					<li><a href="index.php" class="menu-link d-flex align-items-center gap-2"><i class="fi fi-br-calendar unfilled-icon"></i><i class="fi fi-sr-calendar filled-icon"></i><span>Events</span></a></li>
					<li><a href="inventory.php" class="menu-link active d-flex align-items-center gap-2"><i class="fi fi-br-box unfilled-icon"></i><i class="fi fi-sr-box filled-icon"></i><span>Inventory</span></a></li>
				</ul>
			</aside>

			<main class="col-12 col-md-9 col-lg-9 py-3 py-md-4 page-content">
				<!-- Page Header -->
				<div class="d-flex align-items-center justify-content-between mb-4">
					<div>
						<h1 class="h3 mb-1">Inventory Management</h1>
						<p class="text-muted mb-0">Manage equipment and items</p>
					</div>
					<div class="d-flex gap-2">
						<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalInventory">
							<i class="bi bi-plus-lg me-1"></i>Add Item
						</button>
						<button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalLoan">
							<i class="bi bi-arrow-left-right me-1"></i>Borrow Item
						</button>
					</div>
				</div>

				<!-- Inventory Statistics -->
				<div class="inventory-overview">
					<div class="inventory-stats">
						<div class="inventory-stat-card">
							<div class="inventory-stat-icon">
								<i class="bi bi-box-seam"></i>
							</div>
							<div class="inventory-stat-number">45</div>
							<div class="inventory-stat-label">Total Items</div>
						</div>
						<div class="inventory-stat-card">
							<div class="inventory-stat-icon">
								<i class="bi bi-arrow-left-right"></i>
							</div>
							<div class="inventory-stat-number">12</div>
							<div class="inventory-stat-label">Borrowed</div>
						</div>
						<div class="inventory-stat-card">
							<div class="inventory-stat-icon">
								<i class="bi bi-check-circle"></i>
							</div>
							<div class="inventory-stat-number">33</div>
							<div class="inventory-stat-label">Available</div>
						</div>
						<div class="inventory-stat-card">
							<div class="inventory-stat-icon">
								<i class="bi bi-exclamation-triangle"></i>
							</div>
							<div class="inventory-stat-number">3</div>
							<div class="inventory-stat-label">Low Stock</div>
						</div>
					</div>
				</div>

				<!-- Search and Filter -->
				<div class="inventory-filters">
					<div class="filter-group">
						<div class="filter-input">
							<input type="text" class="form-control" placeholder="Search items..." id="searchInventory">
						</div>
						<select class="form-select" id="filterCategory" style="max-width: 200px;">
							<option value="">All Categories</option>
							<option value="Audio">Audio</option>
							<option value="Electrical">Electrical</option>
							<option value="Furniture">Furniture</option>
							<option value="IT">IT</option>
						</select>
						<select class="form-select" id="filterStatus" style="max-width: 200px;">
							<option value="">All Status</option>
							<option value="available">Available</option>
							<option value="borrowed">Borrowed</option>
							<option value="low-stock">Low Stock</option>
						</select>
					</div>
				</div>

				<!-- Inventory Items -->
				<div class="inventory-items">
					<div class="inventory-item">
						<div class="inventory-item-header">
							<h5 class="inventory-item-name">Projector</h5>
							<span class="inventory-item-category">Electronics</span>
						</div>
						<div class="inventory-item-details">
							<div class="inventory-item-location">
								<i class="bi bi-geo-alt"></i>
								Storage Room A
							</div>
							<div class="inventory-item-quantity">
								<span class="quantity-badge">Qty: 5</span>
								<span class="borrowed-badge">0 borrowed</span>
							</div>
						</div>
						<div class="inventory-actions">
							<a href="#" class="inventory-action-btn primary">Edit</a>
							<a href="#" class="inventory-action-btn secondary">Borrow</a>
						</div>
					</div>

					<div class="inventory-item">
						<div class="inventory-item-header">
							<h5 class="inventory-item-name">Chairs</h5>
							<span class="inventory-item-category">Furniture</span>
						</div>
						<div class="inventory-item-details">
							<div class="inventory-item-location">
								<i class="bi bi-geo-alt"></i>
								Storage Room B
							</div>
							<div class="inventory-item-quantity">
								<span class="quantity-badge">Qty: 50</span>
								<span class="borrowed-badge">12 borrowed</span>
							</div>
						</div>
						<div class="inventory-actions">
							<a href="#" class="inventory-action-btn primary">Edit</a>
							<a href="#" class="inventory-action-btn secondary">Borrow</a>
						</div>
					</div>

					<div class="inventory-item">
						<div class="inventory-item-header">
							<h5 class="inventory-item-name">Wireless Microphones</h5>
							<span class="inventory-item-category">Audio</span>
						</div>
						<div class="inventory-item-details">
							<div class="inventory-item-location">
								<i class="bi bi-geo-alt"></i>
								Audio Equipment Room
							</div>
							<div class="inventory-item-quantity">
								<span class="quantity-badge">Qty: 8</span>
								<span class="borrowed-badge">3 borrowed</span>
							</div>
						</div>
						<div class="inventory-actions">
							<a href="#" class="inventory-action-btn primary">Edit</a>
							<a href="#" class="inventory-action-btn secondary">Borrow</a>
						</div>
					</div>
				</div>
			</main>
		</div>
	</div>

	<!-- Add Inventory Modal -->
	<div class="modal fade inventory-modal" id="modalInventory" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="bi bi-plus-lg me-2"></i>Add Inventory Item</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="formAddItem">
					<div class="modal-body">
						<div class="mb-3">
							<label for="itemName" class="form-label">Item Name</label>
							<input type="text" class="form-control" id="itemName" name="name" placeholder="e.g., Projector" required />
						</div>
						<div class="mb-3">
							<label for="itemDescription" class="form-label">Description</label>
							<textarea class="form-control" id="itemDescription" name="description" rows="2" placeholder="Brief description of the item"></textarea>
						</div>
						<div class="row g-2">
							<div class="col-12 col-md-6 mb-3">
								<label for="itemQty" class="form-label">Quantity</label>
								<input type="number" min="0" class="form-control" id="itemQty" name="quantity" value="1" required />
							</div>
							<div class="col-12 col-md-6 mb-3">
								<label for="itemCategory" class="form-label">Category</label>
								<select class="form-select" id="itemCategory" name="category">
									<option value="Audio">Audio</option>
									<option value="Electrical">Electrical</option>
									<option value="Furniture">Furniture</option>
									<option value="IT">IT</option>
								</select>
							</div>
						</div>
						<div class="mb-3">
							<label for="itemLocation" class="form-label">Location</label>
							<input type="text" class="form-control" id="itemLocation" name="location" placeholder="e.g., Storage A" />
						</div>
						<div class="mb-3">
							<label for="itemUnit" class="form-label">Unit</label>
							<input type="text" class="form-control" id="itemUnit" name="unit" placeholder="e.g., PCS, UNITS, SETS" />
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Borrow/Loan Modal -->
	<div class="modal fade inventory-modal" id="modalLoan" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="bi bi-arrow-left-right me-2"></i>Borrow Item</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="formAddLoan">
					<div class="modal-body">
						<div class="row g-2">
							<div class="col-12 col-md-6 mb-3">
								<label class="form-label" for="loanBorrower">Borrower</label>
								<input type="text" class="form-control" id="loanBorrower" name="borrower" placeholder="Full name" required />
							</div>
							<div class="col-12 col-md-6 mb-3">
								<label class="form-label" for="loanContact">Contact</label>
								<input type="text" class="form-control" id="loanContact" name="contact" placeholder="Phone or Email" />
							</div>
						</div>
						<div class="row g-2">
							<div class="col-12 col-md-6 mb-3">
								<label class="form-label" for="loanItem">Item</label>
								<select class="form-select" id="loanItem" name="item" required>
									<option value="">Select an item</option>
									<option value="Wireless Microphones">Wireless Microphones</option>
									<option value="Plastic Chairs">Plastic Chairs</option>
									<option value="Extension Cords">Extension Cords</option>
								</select>
							</div>
							<div class="col-12 col-md-3 mb-3">
								<label class="form-label" for="loanQty">Qty</label>
								<input type="number" min="1" class="form-control" id="loanQty" name="quantity" value="1" required />
							</div>
							<div class="col-12 col-md-3 mb-3">
								<label class="form-label" for="loanDue">Due</label>
								<input type="date" class="form-control" id="loanDue" name="due" />
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label" for="loanNotes">Notes</label>
							<textarea class="form-control" id="loanNotes" name="notes" rows="2" placeholder="Optional"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Save & Create Invoice</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<script src="scripts/script.js"></script>
	<script src="scripts/inventory.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
