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
						<p class="text-muted mb-0">Manage equipment, items, and track borrowing activities</p>
					</div>
					<div class="d-flex gap-2">
						<button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalLoan">
							<i class="bi bi-arrow-left-right me-1"></i>Borrow Item
						</button>
						<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalInventory">
							<i class="bi bi-plus-lg me-1"></i>Add Item
						</button>
					</div>
				</div>

				<!-- Inventory Statistics -->
				<div class="row g-3 mb-4">
					<div class="col-6 col-md-3">
						<div class="card shadow-sm h-100">
							<div class="card-body d-flex align-items-center gap-3">
								<i class="bi bi-box-seam fs-3 text-primary"></i>
								<div>
									<div class="small text-muted">Total Items</div>
									<div class="fs-5 fw-semibold" id="statTotalItems">45</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6 col-md-3">
						<div class="card shadow-sm h-100">
							<div class="card-body d-flex align-items-center gap-3">
								<i class="bi bi-arrow-left-right fs-3 text-warning"></i>
								<div>
									<div class="small text-muted">Borrowed</div>
									<div class="fs-5 fw-semibold" id="statBorrowedItems">12</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6 col-md-3">
						<div class="card shadow-sm h-100">
							<div class="card-body d-flex align-items-center gap-3">
								<i class="bi bi-check-circle fs-3 text-success"></i>
								<div>
									<div class="small text-muted">Available</div>
									<div class="fs-5 fw-semibold" id="statAvailableItems">33</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6 col-md-3">
						<div class="card shadow-sm h-100">
							<div class="card-body d-flex align-items-center gap-3">
								<i class="bi bi-exclamation-triangle fs-3 text-danger"></i>
								<div>
									<div class="small text-muted">Low Stock</div>
									<div class="fs-5 fw-semibold" id="statLowStockItems">3</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Filters and Search -->
				<div class="row g-3 mb-4">
					<div class="col-12">
						<div class="card shadow-sm">
							<div class="card-body">
								<div class="row g-3">
									<div class="col-12 col-md-4">
										<label for="searchItem" class="form-label">Search Items</label>
										<input type="text" class="form-control" id="searchItem" placeholder="Search by name, category, or location...">
									</div>
									<div class="col-12 col-md-3">
										<label for="filterCategory" class="form-label">Category</label>
										<select class="form-select" id="filterCategory">
											<option value="">All Categories</option>
											<option value="Audio">Audio</option>
											<option value="Electrical">Electrical</option>
											<option value="Furniture">Furniture</option>
											<option value="IT">IT</option>
										</select>
									</div>
									<div class="col-12 col-md-3">
										<label for="filterLocation" class="form-label">Location</label>
										<select class="form-select" id="filterLocation">
											<option value="">All Locations</option>
											<option value="AV Room">AV Room</option>
											<option value="Storage A">Storage A</option>
											<option value="Storage B">Storage B</option>
										</select>
									</div>
									<div class="col-12 col-md-2">
										<label for="filterStatus" class="form-label">Status</label>
										<select class="form-select" id="filterStatus">
											<option value="">All</option>
											<option value="available">Available</option>
											<option value="borrowed">Borrowed</option>
											<option value="low">Low Stock</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Inventory List -->
				<div class="row g-3 mb-4">
					<div class="col-12">
						<div class="card shadow-sm">
							<div class="card-header bg-light d-flex align-items-center justify-content-between">
								<h5 class="card-title mb-0"><i class="bi bi-box-seam me-2"></i>Inventory Items</h5>
								<div class="d-flex gap-2">
									<button class="btn btn-sm btn-outline-secondary" id="btnExportInventory">
										<i class="bi bi-download me-1"></i>Export
									</button>
									<button class="btn btn-sm btn-outline-primary" id="btnPrintInventory">
										<i class="bi bi-printer me-1"></i>Print
									</button>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>Item Name</th>
												<th>Category</th>
												<th>Location</th>
												<th>Quantity</th>
												<th>Borrowed</th>
												<th>Available</th>
												<th>Status</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody id="inventoryTableBody">
											<tr>
												<td>
													<div class="fw-semibold">Wireless Microphones</div>
													<div class="small text-muted">Professional audio equipment</div>
												</td>
												<td><span class="badge text-bg-primary">Audio</span></td>
												<td>AV Room</td>
												<td>8</td>
												<td>2</td>
												<td>6</td>
												<td><span class="badge text-bg-success">Available</span></td>
												<td>
													<div class="btn-group btn-group-sm">
														<button class="btn btn-outline-primary" title="Edit">
															<i class="bi bi-pencil"></i>
														</button>
														<button class="btn btn-outline-info" title="Borrow">
															<i class="bi bi-arrow-left-right"></i>
														</button>
														<button class="btn btn-outline-danger" title="Delete">
															<i class="bi bi-trash"></i>
														</button>
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="fw-semibold">Plastic Chairs</div>
													<div class="small text-muted">Stackable seating</div>
												</td>
												<td><span class="badge text-bg-secondary">Furniture</span></td>
												<td>Storage A</td>
												<td>120</td>
												<td>15</td>
												<td>105</td>
												<td><span class="badge text-bg-success">Available</span></td>
												<td>
													<div class="btn-group btn-group-sm">
														<button class="btn btn-outline-primary" title="Edit">
															<i class="bi bi-pencil"></i>
														</button>
														<button class="btn btn-outline-info" title="Borrow">
															<i class="bi bi-arrow-left-right"></i>
														</button>
														<button class="btn btn-outline-danger" title="Delete">
															<i class="bi bi-trash"></i>
														</button>
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="fw-semibold">Extension Cords</div>
													<div class="small text-muted">Power extension cables</div>
												</td>
												<td><span class="badge text-bg-warning">Electrical</span></td>
												<td>Storage B</td>
												<td>15</td>
												<td>12</td>
												<td>3</td>
												<td><span class="badge text-bg-danger">Low Stock</span></td>
												<td>
													<div class="btn-group btn-group-sm">
														<button class="btn btn-outline-primary" title="Edit">
															<i class="bi bi-pencil"></i>
														</button>
														<button class="btn btn-outline-info" title="Borrow">
															<i class="bi bi-arrow-left-right"></i>
														</button>
														<button class="btn btn-outline-danger" title="Delete">
															<i class="bi bi-trash"></i>
														</button>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Active Loans -->
				<div class="row g-3">
					<div class="col-12">
						<div class="card shadow-sm">
							<div class="card-header bg-light">
								<h5 class="card-title mb-0"><i class="bi bi-arrow-left-right me-2"></i>Active Loans</h5>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>Borrower</th>
												<th>Item</th>
												<th>Quantity</th>
												<th>Borrowed Date</th>
												<th>Due Date</th>
												<th>Status</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody id="loansTableBody">
											<tr>
												<td>
													<div class="fw-semibold">John Doe</div>
													<div class="small text-muted">john.doe@email.com</div>
												</td>
												<td>Wireless Microphones</td>
												<td>2</td>
												<td>2025-01-15</td>
												<td>2025-01-20</td>
												<td><span class="badge text-bg-warning">Active</span></td>
												<td>
													<div class="btn-group btn-group-sm">
														<button class="btn btn-outline-success" title="Return">
															<i class="bi bi-check-circle"></i>
														</button>
														<button class="btn btn-outline-info" title="Extend">
															<i class="bi bi-calendar-plus"></i>
														</button>
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="fw-semibold">Jane Smith</div>
													<div class="small text-muted">jane.smith@email.com</div>
												</td>
												<td>Plastic Chairs</td>
												<td>10</td>
												<td>2025-01-14</td>
												<td>2025-01-18</td>
												<td><span class="badge text-bg-warning">Active</span></td>
												<td>
													<div class="btn-group btn-group-sm">
														<button class="btn btn-outline-success" title="Return">
															<i class="bi bi-check-circle"></i>
														</button>
														<button class="btn btn-outline-info" title="Extend">
															<i class="bi bi-calendar-plus"></i>
														</button>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>
	</div>

	<!-- Add Inventory Modal -->
	<div class="modal fade" id="modalInventory" tabindex="-1" aria-hidden="true">
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
	<div class="modal fade" id="modalLoan" tabindex="-1" aria-hidden="true">
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
