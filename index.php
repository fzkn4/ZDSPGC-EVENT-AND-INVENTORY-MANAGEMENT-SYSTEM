<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>ZDSPGC Event & Inventory Management System</title>

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
	<!-- Bootstrap Icons -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
	<!-- Local styles -->
	<link href="style.css" rel="stylesheet" />
</head>
<body>
	<header class="navbar navbar-expand-lg navbar-dark bg-primary">
		<div class="container-fluid">
			<a class="navbar-brand d-flex align-items-center gap-2" href="#">
				<i class="bi bi-grid-1x2-fill"></i>
				<span class="fw-semibold">ZDSPGC EIMS</span>
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="mainNavbar">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
					<li class="nav-item me-lg-3">
						<form class="d-flex" role="search">
							<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
							<button class="btn btn-light" type="submit"><i class="bi bi-search icon-fixed-black"></i></button>
						</form>
					</li>
					<li class="nav-item dropdown me-2">
						<button class="btn btn-outline-light position-relative" id="btnNotifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="bi bi-bell"></i>
							<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notifCount">0</span>
						</button>
						<ul class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="btnNotifDropdown" id="notifMenu" style="min-width: 320px;">
							<li class="px-3 py-2 small text-muted" id="notifEmpty">No notifications</li>
						</ul>
					</li>
					<li class="nav-item me-2 d-flex align-items-center">
						<div class="form-check form-switch text-light">
							<input class="form-check-input" type="checkbox" role="switch" id="adminModeSwitch" />
							<label class="form-check-label small" for="adminModeSwitch">Admin</label>
						</div>
					</li>
					<li class="nav-item">
						<button class="btn btn-outline-light" id="btnThemeToggle" type="button"><i class="bi bi-moon-stars"></i></button>
					</li>
				</ul>
			</div>
		</div>
	</header>

	<main class="container py-3 py-md-4">
		<!-- Dashboard Summary -->
		<section class="row g-3 mb-2" id="dashboardSummary">
			<div class="col-6 col-md-3">
				<div class="card shadow-sm h-100">
					<div class="card-body d-flex align-items-center gap-3">
						<i class="bi bi-check2-square fs-3 text-success"></i>
						<div>
							<div class="small text-muted">Completed</div>
							<div class="fs-5 fw-semibold" id="statCompletedCount">1</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Tabs Content -->
		<div class="tab-content" id="mainTabsContent">
			<!-- Events Tab -->
			<section class="tab-pane fade show active" id="tab-events" role="tabpanel" aria-labelledby="tab-events-btn">
				<div class="d-flex align-items-center justify-content-between mb-2">
					<h2 class="h5 mb-0"><i class="bi bi-calendar-event me-2"></i>Events</h2>
					<div class="d-flex gap-2">
						<select class="form-select form-select-sm" id="eventsFilter" style="max-width: 140px;">
							<option value="upcoming" selected>Upcoming</option>
							<option value="all">All</option>
							<option value="past">Past</option>
						</select>
						<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEvent"><i class="bi bi-plus-lg me-1"></i>Add</button>
					</div>
				</div>
				<ul class="list-group" id="eventsList">
					<li class="list-group-item d-flex align-items-start justify-content-between">
						<div>
							<div class="fw-semibold">Orientation Day</div>
							<div class="small text-muted">Main Hall • 2025-09-01</div>
						</div>
						<div class="d-flex align-items-center gap-2">
							<span class="badge text-bg-info">Campus</span>
							<button class="btn btn-sm btn-outline-secondary" data-event-title="Orientation Day" data-event-date="2025-09-01" data-event-location="Main Hall" data-event-tag="Campus" data-bs-toggle="modal" data-bs-target="#modalEventDetails"><i class="bi bi-card-text"></i> Details</button>
						</div>
					</li>
					<li class="list-group-item d-flex align-items-start justify-content-between">
						<div>
							<div class="fw-semibold">Tech Innovation Fair</div>
							<div class="small text-muted">Gymnasium • 2025-10-12</div>
						</div>
						<div class="d-flex align-items-center gap-2">
							<span class="badge text-bg-warning">Public</span>
							<button class="btn btn-sm btn-outline-secondary" data-event-title="Tech Innovation Fair" data-event-date="2025-10-12" data-event-location="Gymnasium" data-event-tag="Public" data-bs-toggle="modal" data-bs-target="#modalEventDetails"><i class="bi bi-card-text"></i> Details</button>
						</div>
					</li>
					<li class="list-group-item d-flex align-items-start justify-content-between">
						<div>
							<div class="fw-semibold">Faculty Workshop</div>
							<div class="small text-muted">Room B203 • 2025-08-25</div>
						</div>
						<div class="d-flex align-items-center gap-2">
							<span class="badge text-bg-success">Internal</span>
							<button class="btn btn-sm btn-outline-secondary" data-event-title="Faculty Workshop" data-event-date="2025-08-25" data-event-location="Room B203" data-event-tag="Internal" data-bs-toggle="modal" data-bs-target="#modalEventDetails"><i class="bi bi-card-text"></i> Details</button>
						</div>
					</li>
				</ul>
			</section>

			<!-- Inventory Tab -->
			<section class="tab-pane fade" id="tab-inventory" role="tabpanel" aria-labelledby="tab-inventory-btn">
				<div class="d-flex align-items-center justify-content-between mb-2">
					<h2 class="h5 mb-0"><i class="bi bi-box-seam me-2"></i>Inventory</h2>
					<div class="d-flex gap-2">
						<button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalLoan"><i class="bi bi-arrow-left-right me-1"></i>Borrow</button>
						<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalInventory"><i class="bi bi-plus-lg me-1"></i>Add</button>
					</div>
				</div>
				<ul class="list-group" id="inventoryList">
					<li class="list-group-item d-flex align-items-start justify-content-between">
						<div>
							<div class="fw-semibold">Wireless Microphones <span class="text-muted small">(<span class="inv-borrowed" data-item="Wireless Microphones">0</span> borrowed)</span></div>
							<div class="small text-muted">Category: Audio • Location: AV Room</div>
						</div>
						<span class="badge text-bg-primary align-self-center">Qty: <span class="inv-qty" data-item="Wireless Microphones">8</span></span>
					</li>
					<li class="list-group-item d-flex align-items-start justify-content-between">
						<div>
							<div class="fw-semibold">Plastic Chairs <span class="text-muted small">(<span class="inv-borrowed" data-item="Plastic Chairs">0</span> borrowed)</span></div>
							<div class="small text-muted">Category: Furniture • Location: Storage A</div>
						</div>
						<span class="badge text-bg-primary align-self-center">Qty: <span class="inv-qty" data-item="Plastic Chairs">120</span></span>
					</li>
					<li class="list-group-item d-flex align-items-start justify-content-between">
						<div>
							<div class="fw-semibold">Extension Cords <span class="text-muted small">(<span class="inv-borrowed" data-item="Extension Cords">0</span> borrowed)</span></div>
							<div class="small text-muted">Category: Electrical • Location: Storage B</div>
						</div>
						<span class="badge text-bg-primary align-self-center">Qty: <span class="inv-qty" data-item="Extension Cords">15</span></span>
					</li>
				</ul>
				<div class="mt-3">
					<h3 class="h6 d-flex align-items-center gap-2 mb-2"><i class="bi bi-arrow-left-right"></i> Active Loans</h3>
					<ul class="list-group" id="loansList">
						<li class="list-group-item small text-muted" id="loansEmpty">No active loans yet.</li>
					</ul>
				</div>
			</section>

			<!-- Calendar Tab -->
			<section class="tab-pane fade" id="tab-calendar" role="tabpanel" aria-labelledby="tab-calendar-btn">
				<div class="d-flex align-items-center justify-content-between mb-2">
					<h2 class="h5 mb-0"><i class="bi bi-calendar-week me-2"></i>Calendar</h2>
				</div>
				<div class="card shadow-sm">
					<div class="card-body">
						<div class="row row-cols-7 g-2 text-center small" id="miniCalendar">
							<!-- Mini calendar will be rendered by JS -->
						</div>
					</div>
				</div>
				<div class="mt-3">
					<h3 class="h6">This Week</h3>
					<ul class="list-group" id="weekEvents">
						<li class="list-group-item d-flex align-items-start justify-content-between">
							<div>
								<div class="fw-semibold">Logistics Check</div>
								<div class="small text-muted">Tue • 10:00 - 11:00 • Storage A</div>
							</div>
							<span class="badge text-bg-secondary align-self-center"><i class="bi bi-clock me-1"></i>1h</span>
						</li>
						<li class="list-group-item d-flex align-items-start justify-content-between">
							<div>
								<div class="fw-semibold">Venue Walkthrough</div>
								<div class="small text-muted">Thu • 14:00 - 15:30 • Main Hall</div>
							</div>
							<span class="badge text-bg-secondary align-self-center"><i class="bi bi-clock me-1"></i>1.5h</span>
						</li>
					</ul>
				</div>
			</section>
		</div>
	</main>

	<!-- Bottom Mobile Tabs -->
	<nav class="navbar fixed-bottom navbar-light bg-white border-top shadow-sm" id="bottomTabs">
		<div class="container-fluid">
			<ul class="nav nav-pills nav-justified w-100" id="mainTabs" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active d-flex flex-column align-items-center" id="tab-events-btn" data-bs-toggle="tab" data-bs-target="#tab-events" type="button" role="tab" aria-controls="tab-events" aria-selected="true">
						<i class="bi bi-calendar-event fs-5"></i>
						<span class="small">Events</span>
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link d-flex flex-column align-items-center" id="tab-inventory-btn" data-bs-toggle="tab" data-bs-target="#tab-inventory" type="button" role="tab" aria-controls="tab-inventory" aria-selected="false">
						<i class="bi bi-box-seam fs-5"></i>
						<span class="small">Inventory</span>
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link d-flex flex-column align-items-center" id="tab-invoices-btn" data-bs-toggle="tab" data-bs-target="#tab-invoices" type="button" role="tab" aria-controls="tab-invoices" aria-selected="false">
						<i class="bi bi-receipt fs-5"></i>
						<span class="small">Invoices</span>
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link d-flex flex-column align-items-center" id="tab-attendance-btn" data-bs-toggle="tab" data-bs-target="#tab-attendance" type="button" role="tab" aria-controls="tab-attendance" aria-selected="false">
						<i class="bi bi-people-check fs-5"></i>
						<span class="small">Attendance</span>
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link d-flex flex-column align-items-center" id="tab-calendar-btn" data-bs-toggle="tab" data-bs-target="#tab-calendar" type="button" role="tab" aria-controls="tab-calendar" aria-selected="false">
						<i class="bi bi-calendar-week fs-5"></i>
						<span class="small">Calendar</span>
					</button>
				</li>
			</ul>
		</div>
	</nav>

	<!-- Invoices Tab -->
	<div class="tab-content">
		<section class="tab-pane fade" id="tab-invoices" role="tabpanel" aria-labelledby="tab-invoices-btn">
			<div class="d-flex align-items-center justify-content-between mb-2">
				<h2 class="h5 mb-0"><i class="bi bi-receipt me-2"></i>Invoices</h2>
			</div>
			<ul class="list-group" id="invoicesList">
				<li class="list-group-item small text-muted" id="invoicesEmpty">No invoices yet.</li>
			</ul>
		</section>

		<!-- Attendance Tab -->
		<section class="tab-pane fade" id="tab-attendance" role="tabpanel" aria-labelledby="tab-attendance-btn">
			<div class="d-flex align-items-center justify-content-between mb-2">
				<h2 class="h5 mb-0"><i class="bi bi-people-check me-2"></i>Attendance Tracker</h2>
				<div class="d-flex gap-2">
					<button class="btn btn-outline-secondary" id="btnExportAttendance"><i class="bi bi-download me-1"></i>Export</button>
					<button class="btn btn-outline-danger" id="btnClearAttendance"><i class="bi bi-trash me-1"></i>Clear</button>
				</div>
			</div>
			<div class="row g-2 align-items-end">
				<div class="col-12 col-md-4">
					<label class="form-label" for="attNameAll">Name</label>
					<input type="text" class="form-control" id="attNameAll" placeholder="Full name" />
				</div>
				<div class="col-12 col-md-4">
					<label class="form-label" for="attIdAll">ID</label>
					<input type="text" class="form-control" id="attIdAll" placeholder="Student/Employee ID" />
				</div>
				<div class="col-12 col-md-4">
					<button class="btn btn-primary w-100" id="btnCheckInAll"><i class="bi bi-person-check me-1"></i>Check-in</button>
				</div>
			</div>
			<div class="mt-3">
				<h6 class="mb-2">Records</h6>
				<ul class="list-group" id="attendanceAllList">
					<li class="list-group-item small text-muted" id="attendanceAllEmpty">No attendees yet.</li>
				</ul>
			</div>
		</section>
	</div>

	<!-- Add Event Modal -->
	<div class="modal fade" id="modalEvent" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="bi bi-plus-lg me-2"></i>Add Event</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form id="formAddEvent">
					<div class="modal-body">
						<div class="mb-3">
							<label for="eventTitle" class="form-label">Title</label>
							<input type="text" class="form-control" id="eventTitle" name="title" placeholder="Event title" required />
						</div>
						<div class="row g-2">
							<div class="col-12 col-md-6 mb-3">
								<label for="eventDate" class="form-label">Date</label>
								<input type="date" class="form-control" id="eventDate" name="date" required />
							</div>
							<div class="col-12 col-md-6 mb-3">
								<label for="eventLocation" class="form-label">Location</label>
								<input type="text" class="form-control" id="eventLocation" name="location" placeholder="Where" />
							</div>
						</div>
						<div class="mb-3">
							<label for="eventTag" class="form-label">Tag</label>
							<select class="form-select" id="eventTag" name="tag">
								<option value="Campus">Campus</option>
								<option value="Public">Public</option>
								<option value="Internal">Internal</option>
							</select>
						</div>
						<div class="mb-3">
							<label for="eventDesc" class="form-label">Description</label>
							<textarea class="form-control" id="eventDesc" name="description" rows="3" placeholder="Optional"></textarea>
						</div>
						<hr />
						<div class="mb-3">
							<label class="form-label">Equipments</label>
							<div id="equipmentsInputs">
								<div class="row g-2 mb-2 equipment-row">
									<div class="col-6"><input type="text" class="form-control equipment-name" placeholder="e.g., Sound System" /></div>
									<div class="col-3"><input type="number" min="0" class="form-control equipment-qty" placeholder="Qty" /></div>
									<div class="col-3"><input type="text" class="form-control equipment-unit" placeholder="Unit (e.g., UNITS)" /></div>
								</div>
							</div>
							<button class="btn btn-sm btn-outline-primary" type="button" id="btnAddEquipmentRow"><i class="bi bi-plus-lg"></i> Add Equipment</button>
						</div>
						<div class="mb-3">
							<label class="form-label">Items</label>
							<div id="itemsInputs">
								<div class="row g-2 mb-2 item-row">
									<div class="col-6"><input type="text" class="form-control item-name" placeholder="e.g., Chairs" /></div>
									<div class="col-3"><input type="number" min="0" class="form-control item-qty" placeholder="Qty" /></div>
									<div class="col-3"><input type="text" class="form-control item-unit" placeholder="Unit (e.g., PCS)" /></div>
								</div>
							</div>
							<button class="btn btn-sm btn-outline-primary" type="button" id="btnAddItemRow"><i class="bi bi-plus-lg"></i> Add Item</button>
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

	<!-- Invoice View/Print Modal -->
	<div class="modal fade" id="modalInvoice" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="bi bi-receipt me-2"></i>Invoice</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div id="invoiceContainer">
						<!-- Filled by JS -->
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-success" id="btnPrintInvoice"><i class="bi bi-printer me-1"></i>Print</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Event Details Modal (Attendance & Coverage) -->
	<div class="modal fade" id="modalEventDetails" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="eventDetailsTitle"><i class="bi bi-card-text me-2"></i>Event Details</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" data-bs-toggle="tab" data-bs-target="#eventDetailsTab" type="button" role="tab">Details</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" data-bs-toggle="tab" data-bs-target="#eventAttendanceTab" type="button" role="tab">Attendance</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" data-bs-toggle="tab" data-bs-target="#eventCoverageTab" type="button" role="tab">Coverage</button>
						</li>
					</ul>
					<div class="tab-content pt-3">
						<div class="tab-pane fade show active" id="eventDetailsTab" role="tabpanel">
							<div id="eventDetailsInfo" class="small text-muted"></div>
						</div>
						<div class="tab-pane fade" id="eventAttendanceTab" role="tabpanel">
							<div class="row g-2 align-items-end">
								<div class="col-12 col-md-4">
									<label class="form-label" for="attendeeName">Name</label>
									<input type="text" class="form-control" id="attendeeName" placeholder="Full name" />
								</div>
								<div class="col-12 col-md-4">
									<label class="form-label" for="attendeeId">ID</label>
									<input type="text" class="form-control" id="attendeeId" placeholder="Student/Employee ID" />
								</div>
								<div class="col-12 col-md-4">
									<button class="btn btn-primary w-100" id="btnCheckIn"><i class="bi bi-person-check me-1"></i>Check-in</button>
								</div>
							</div>
							<div class="mt-3">
								<h6 class="mb-2">Checked-in</h6>
								<ul class="list-group" id="attendanceList">
									<li class="list-group-item small text-muted" id="attendanceEmpty">No attendees yet.</li>
								</ul>
							</div>
						</div>
						<div class="tab-pane fade" id="eventCoverageTab" role="tabpanel">
							<div class="mb-2">
								<label class="form-label" for="coverageNotes">Add note or link</label>
								<div class="input-group">
									<input type="text" class="form-control" id="coverageNotes" placeholder="e.g., https://link-to-photos.com or short note" />
									<button class="btn btn-outline-primary" id="btnAddCoverage"><i class="bi bi-plus-lg"></i></button>
								</div>
							</div>
							<ul class="list-group" id="coverageList">
								<li class="list-group-item small text-muted" id="coverageEmpty">No coverage yet.</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Toasts Container -->
	<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
		<div id="toastStack" class="toast-container"></div>
	</div>

	<!-- Scripts -->
	<script src="script.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 	<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
</body>
</html>

