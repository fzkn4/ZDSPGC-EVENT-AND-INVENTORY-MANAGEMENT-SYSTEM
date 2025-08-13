(function () {
	const doc = document;

	// Theme toggle
	const themeToggleBtn = doc.getElementById('btnThemeToggle');
	const root = doc.documentElement;
	const storedTheme = localStorage.getItem('eims-theme');
	if (storedTheme === 'dark') {
		root.classList.add('theme-dark');
	}
	if (themeToggleBtn) {
		themeToggleBtn.addEventListener('click', function () {
			root.classList.toggle('theme-dark');
			localStorage.setItem('eims-theme', root.classList.contains('theme-dark') ? 'dark' : 'light');
		});
	}

	// Admin mode toggle
	const adminSwitch = doc.getElementById('adminModeSwitch');
	const storedAdmin = localStorage.getItem('eims-admin') === '1';
	if (storedAdmin) {
		root.classList.add('admin-mode');
		if (adminSwitch) adminSwitch.checked = true;
	}
	if (adminSwitch) {
		adminSwitch.addEventListener('change', function () {
			if (adminSwitch.checked) {
				root.classList.add('admin-mode');
				localStorage.setItem('eims-admin', '1');
			} else {
				root.classList.remove('admin-mode');
				localStorage.setItem('eims-admin', '0');
			}
		});
	}

	// Forms: Add Event
	const formAddEvent = doc.getElementById('formAddEvent');
	const eventsList = doc.getElementById('eventsList');
	const equipmentsInputs = doc.getElementById('equipmentsInputs');
	const itemsInputs = doc.getElementById('itemsInputs');
	const btnAddEquipmentRow = doc.getElementById('btnAddEquipmentRow');
	const btnAddItemRow = doc.getElementById('btnAddItemRow');

	if (btnAddEquipmentRow && equipmentsInputs) {
		btnAddEquipmentRow.addEventListener('click', function () {
			addEquipmentRow();
		});
	}
	if (btnAddItemRow && itemsInputs) {
		btnAddItemRow.addEventListener('click', function () {
			addItemRow();
		});
	}

	function addEquipmentRow() {
		const row = doc.createElement('div');
		row.className = 'row g-2 mb-2 equipment-row';
		row.innerHTML = '' +
			'<div class="col-6"><input type="text" class="form-control equipment-name" placeholder="e.g., Sound System" /></div>' +
			'<div class="col-3"><input type="number" min="0" class="form-control equipment-qty" placeholder="Qty" /></div>' +
			'<div class="col-2"><input type="text" class="form-control equipment-unit" placeholder="Unit" /></div>' +
			'<div class="col-1 d-grid"><button type="button" class="btn btn-outline-danger remove-row"><i class="bi bi-x"></i></button></div>';
		equipmentsInputs.appendChild(row);
		const removeBtn = row.querySelector('.remove-row');
		if (removeBtn) removeBtn.addEventListener('click', function () { row.remove(); });
	}

	function addItemRow() {
		const row = doc.createElement('div');
		row.className = 'row g-2 mb-2 item-row';
		row.innerHTML = '' +
			'<div class="col-6"><input type="text" class="form-control item-name" placeholder="e.g., Chairs" /></div>' +
			'<div class="col-3"><input type="number" min="0" class="form-control item-qty" placeholder="Qty" /></div>' +
			'<div class="col-2"><input type="text" class="form-control item-unit" placeholder="Unit" /></div>' +
			'<div class="col-1 d-grid"><button type="button" class="btn btn-outline-danger remove-row"><i class="bi bi-x"></i></button></div>';
		itemsInputs.appendChild(row);
		const removeBtn = row.querySelector('.remove-row');
		if (removeBtn) removeBtn.addEventListener('click', function () { row.remove(); });
	}

	function collectEquipmentsFromForm() {
		var list = [];
		if (!equipmentsInputs) return list;
		equipmentsInputs.querySelectorAll('.equipment-row').forEach(function (row) {
			var name = String((row.querySelector('.equipment-name') || {}).value || '').trim();
			var qtyStr = String((row.querySelector('.equipment-qty') || {}).value || '').trim();
			var unit = String((row.querySelector('.equipment-unit') || {}).value || '').trim();
			if (!name) return;
			var qty = parseInt(qtyStr || '0', 10) || 0;
			list.push({ name: name, quantity: qty, unit: unit });
		});
		return list;
	}

	function collectItemsFromForm() {
		var list = [];
		if (!itemsInputs) return list;
		itemsInputs.querySelectorAll('.item-row').forEach(function (row) {
			var name = String((row.querySelector('.item-name') || {}).value || '').trim();
			var qtyStr = String((row.querySelector('.item-qty') || {}).value || '').trim();
			var unit = String((row.querySelector('.item-unit') || {}).value || '').trim();
			if (!name) return;
			var qty = parseInt(qtyStr || '0', 10) || 0;
			list.push({ name: name, quantity: qty, unit: unit });
		});
		return list;
	}
	if (formAddEvent && eventsList) {
		formAddEvent.addEventListener('submit', function (e) {
			e.preventDefault();
			const data = new FormData(formAddEvent);
			const title = data.get('title');
			const date = data.get('date');
			const location = data.get('location');
			const tag = data.get('tag') || 'Info';
			const equipments = collectEquipmentsFromForm();
			const items = collectItemsFromForm();
			const eqAttr = encodeURIComponent(JSON.stringify(equipments));
			const itAttr = encodeURIComponent(JSON.stringify(items));

			const li = doc.createElement('li');
			li.className = 'list-group-item d-flex align-items-start justify-content-between';
			li.innerHTML = '<div>' +
				'<div class="fw-semibold">' + escapeHtml(String(title)) + '</div>' +
				'<div class="small text-muted">' + escapeHtml(String(location || 'TBA')) + ' • ' + escapeHtml(String(date || '')) + '</div>' +
			'</div>' +
			'<div class="d-flex align-items-center gap-2">' +
				'<span class="badge text-bg-info">' + escapeHtml(String(tag)) + '</span>' +
				'<button class="btn btn-sm btn-outline-secondary" data-event-title="' + escapeHtml(String(title)) + '" data-event-date="' + escapeHtml(String(date || '')) + '" data-event-location="' + escapeHtml(String(location || 'TBA')) + '" data-event-tag="' + escapeHtml(String(tag)) + '" data-event-eq="' + escapeHtml(eqAttr) + '" data-event-it="' + escapeHtml(itAttr) + '" data-bs-toggle="modal" data-bs-target="#modalEventDetails"><i class="bi bi-card-text"></i> Details</button>' +
			'</div>';
			eventsList.prepend(li);

			// close modal
			const modalEl = doc.getElementById('modalEvent');
			if (modalEl && window.bootstrap) {
				const m = window.bootstrap.Modal.getOrCreateInstance(modalEl);
				m.hide();
			}
			formAddEvent.reset();

			// update counters
			incrementCounter('statUpcomingCount');
		});
	}

	// Forms: Add Inventory Item
	const formAddItem = doc.getElementById('formAddItem');
	const inventoryList = doc.getElementById('inventoryList');
	if (formAddItem && inventoryList) {
		formAddItem.addEventListener('submit', function (e) {
			e.preventDefault();
			const data = new FormData(formAddItem);
			const name = data.get('name');
			const quantity = data.get('quantity');
			const category = data.get('category');
			const location = data.get('location');

			const li = doc.createElement('li');
			li.className = 'list-group-item d-flex align-items-start justify-content-between';
			li.innerHTML = '<div>' +
				'<div class="fw-semibold">' + escapeHtml(String(name)) + ' <span class="text-muted small">(<span class="inv-borrowed" data-item="' + escapeHtml(String(name)) + '">0</span> borrowed)</span></div>' +
				'<div class="small text-muted">Category: ' + escapeHtml(String(category || 'General')) + ' • Location: ' + escapeHtml(String(location || 'Unassigned')) + '</div>' +
			'</div>' +
			'<span class="badge text-bg-primary align-self-center">Qty: <span class="inv-qty" data-item="' + escapeHtml(String(name)) + '">' + escapeHtml(String(quantity || '0')) + '</span></span>';
			inventoryList.prepend(li);

			// close modal
			const modalEl = doc.getElementById('modalInventory');
			if (modalEl && window.bootstrap) {
				const m = window.bootstrap.Modal.getOrCreateInstance(modalEl);
				m.hide();
			}
			formAddItem.reset();

			// update counters
			incrementCounter('statItemsCount');
			updateLowStockBadge();
		});
	}

	// Loans & Invoices
	const formAddLoan = doc.getElementById('formAddLoan');
	const loansList = doc.getElementById('loansList');
	const loansEmpty = doc.getElementById('loansEmpty');
	const invoicesList = doc.getElementById('invoicesList');
	const invoicesEmpty = doc.getElementById('invoicesEmpty');
	const invoiceContainer = doc.getElementById('invoiceContainer');
	const btnPrintInvoice = doc.getElementById('btnPrintInvoice');

	if (btnPrintInvoice) {
		btnPrintInvoice.addEventListener('click', function () {
			window.print();
		});
	}

	if (formAddLoan && loansList && invoicesList) {
		formAddLoan.addEventListener('submit', function (e) {
			e.preventDefault();
			const data = new FormData(formAddLoan);
			const borrower = data.get('borrower');
			const contact = data.get('contact');
			const item = data.get('item');
			const qty = parseInt(String(data.get('quantity') || '1'), 10) || 1;
			const due = data.get('due');
			const notes = data.get('notes');

			// Update inventory counters
			adjustInventory(String(item), -qty);
			adjustBorrowed(String(item), +qty);
			updateLowStockBadge();

			// Create loan entry
			const loanId = 'LN-' + Date.now();
			const li = doc.createElement('li');
			li.className = 'list-group-item d-flex align-items-start justify-content-between';
			li.innerHTML = '<div>' +
				'<div class="fw-semibold">' + escapeHtml(String(item)) + ' × ' + qty + '</div>' +
				'<div class="small text-muted">Borrower: ' + escapeHtml(String(borrower)) + (contact ? ' • ' + escapeHtml(String(contact)) : '') + (due ? ' • Due: ' + escapeHtml(String(due)) : '') + '</div>' +
				(notes ? '<div class="small">' + escapeHtml(String(notes)) + '</div>' : '') +
			'</div>' +
			'<div class="d-flex align-items-center gap-2">' +
				'<button class="btn btn-sm btn-outline-success" data-loan-id="' + loanId + '" data-item="' + escapeHtml(String(item)) + '" data-qty="' + qty + '" id="btnReturn_' + loanId + '"><i class="bi bi-box-arrow-in-left"></i> Return</button>' +
			'</div>';
			loansList.prepend(li);
			if (loansEmpty) loansEmpty.remove();

			// Create invoice entry + view
			const invId = 'INV-' + Date.now();
			const invLi = doc.createElement('li');
			invLi.className = 'list-group-item d-flex align-items-center justify-content-between';
			invLi.innerHTML = '<div>' +
				'<div class="fw-semibold">' + invId + '</div>' +
				'<div class="small text-muted">' + escapeHtml(String(borrower)) + ' • ' + escapeHtml(String(item)) + ' × ' + qty + (due ? ' • Due: ' + escapeHtml(String(due)) : '') + '</div>' +
			'</div>' +
			'<button class="btn btn-sm btn-outline-secondary" data-invoice-id="' + invId + '" id="btnOpenInv_' + invId + '"><i class="bi bi-eye"></i> View</button>';
			invoicesList.prepend(invLi);
			if (invoicesEmpty) invoicesEmpty.remove();

			// Hook return button
			const returnBtn = doc.getElementById('btnReturn_' + loanId);
			if (returnBtn) {
				returnBtn.addEventListener('click', function () {
					adjustInventory(String(item), +qty);
					adjustBorrowed(String(item), -qty);
					li.remove();
					if (!loansList.children.length) {
						const empty = doc.createElement('li');
						empty.id = 'loansEmpty';
						empty.className = 'list-group-item small text-muted';
						empty.textContent = 'No active loans yet.';
						loansList.appendChild(empty);
					}
					notify('Item returned: ' + escapeHtml(String(item)) + ' × ' + qty, 'success');
					updateLowStockBadge();
				});
			}

			// Hook invoice view
			const openBtn = doc.getElementById('btnOpenInv_' + invId);
			if (openBtn) {
				openBtn.addEventListener('click', function () {
					renderInvoice({ invId: invId, borrower: String(borrower), contact: String(contact || ''), item: String(item), qty: qty, due: String(due || ''), notes: String(notes || '') });
					openModal('modalInvoice');
				});
			}

			formAddLoan.reset();
			renderInvoice({ invId: invId, borrower: String(borrower), contact: String(contact || ''), item: String(item), qty: qty, due: String(due || ''), notes: String(notes || '') });
			openModal('modalInvoice');
			notify('Loan saved and invoice created', 'primary');
		});
	}

	function renderInvoice(data) {
		if (!invoiceContainer) return;
		invoiceContainer.innerHTML = '' +
			'<div class="d-flex justify-content-between align-items-start mb-3">' +
				'<div>' +
					'<div class="fw-semibold">ZDSPGC Event & Inventory</div>' +
					'<div class="small text-muted">Invoice ID: ' + escapeHtml(data.invId) + '</div>' +
				'</div>' +
				'<div class="text-end small">' + new Date().toLocaleString() + '</div>' +
			'</div>' +
			'<div class="row g-2 mb-3 small">' +
				'<div class="col-12 col-md-6"><span class="text-muted">Borrower:</span> ' + escapeHtml(data.borrower) + '</div>' +
				(data.contact ? '<div class="col-12 col-md-6"><span class="text-muted">Contact:</span> ' + escapeHtml(data.contact) + '</div>' : '') +
				(data.due ? '<div class="col-12 col-md-6"><span class="text-muted">Due:</span> ' + escapeHtml(data.due) + '</div>' : '') +
			'</div>' +
			'<table class="table table-sm">' +
				'<thead><tr><th>Item</th><th class="text-end">Qty</th></tr></thead>' +
				'<tbody><tr><td>' + escapeHtml(data.item) + '</td><td class="text-end">' + data.qty + '</td></tr></tbody>' +
			'</table>' +
			(data.notes ? '<div class="small"><span class="text-muted">Notes:</span> ' + escapeHtml(data.notes) + '</div>' : '') +
			'<div class="small text-muted mt-3">Signature: _________________________</div>';
	}

	function adjustInventory(itemName, delta) {
		const selector = '.inv-qty[data-item="' + cssEscape(itemName) + '"]';
		const qtyEl = doc.querySelector(selector);
		if (!qtyEl) return;
		var current = parseInt(qtyEl.textContent || '0', 10) || 0;
		qtyEl.textContent = String(Math.max(0, current + delta));
	}

	function adjustBorrowed(itemName, delta) {
		const selector = '.inv-borrowed[data-item="' + cssEscape(itemName) + '"]';
		const el = doc.querySelector(selector);
		if (!el) return;
		var current = parseInt(el.textContent || '0', 10) || 0;
		el.textContent = String(Math.max(0, current + delta));
	}

	function updateLowStockBadge() {
		var low = 0;
		doc.querySelectorAll('.inv-qty').forEach(function (el) {
			var q = parseInt(el.textContent || '0', 10) || 0;
			if (q <= 5) low++;
		});
		const badge = doc.getElementById('statLowStockCount');
		if (badge) badge.textContent = String(low);
	}

	function openModal(id) {
		const m = doc.getElementById(id);
		if (m && window.bootstrap) {
			window.bootstrap.Modal.getOrCreateInstance(m).show();
		}
	}

	// Notifications using Bootstrap Toasts
	function notify(message, color) {
		var bg = 'text-bg-' + (color || 'primary');
		const container = doc.getElementById('toastStack');
		if (!container) return;
		const toast = doc.createElement('div');
		toast.className = 'toast align-items-center ' + bg;
		toast.setAttribute('role', 'alert');
		toast.setAttribute('aria-live', 'assertive');
		toast.setAttribute('aria-atomic', 'true');
		toast.innerHTML = '<div class="d-flex">' +
			'<div class="toast-body">' + escapeHtml(String(message)) + '</div>' +
			'<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
		'</div>';
		container.appendChild(toast);
		if (window.bootstrap) {
			const t = new window.bootstrap.Toast(toast, { delay: 3000 });
			t.show();
		}
	}

	// Event details (attendance & coverage)
	const eventDetailsModal = doc.getElementById('modalEventDetails');
	if (eventDetailsModal) {
		eventDetailsModal.addEventListener('show.bs.modal', function (ev) {
			var trigger = ev.relatedTarget;
			if (!trigger) return;
			var title = trigger.getAttribute('data-event-title') || 'Event';
			var date = trigger.getAttribute('data-event-date') || '';
			var location = trigger.getAttribute('data-event-location') || '';
			var tag = trigger.getAttribute('data-event-tag') || '';
			var eqRaw = trigger.getAttribute('data-event-eq') || '';
			var itRaw = trigger.getAttribute('data-event-it') || '';
			var equipments = [];
			var items = [];
			try { if (eqRaw) equipments = JSON.parse(decodeURIComponent(eqRaw)); } catch (e) { equipments = []; }
			try { if (itRaw) items = JSON.parse(decodeURIComponent(itRaw)); } catch (e) { items = []; }
			doc.getElementById('eventDetailsTitle').innerHTML = '<i class="bi bi-card-text me-2"></i>' + escapeHtml(title);
			doc.getElementById('eventDetailsInfo').innerHTML = '' +
				'<div class="details-inventory">' +
					'<div class="mb-2"><span class="text-fixed-red fw-semibold">DATE</span><div class="ms-3 d-inline-block text-fixed-white">&nbsp; ' + escapeHtml(date || '') + '</div></div>' +
					(location ? '<div class="mb-2"><span class="text-fixed-red fw-semibold">LOCATION</span><div class="ms-3 d-inline-block text-fixed-white">&nbsp; ' + escapeHtml(location) + '</div></div>' : '') +
					(tag ? '<div class="mb-2"><span class="text-fixed-red fw-semibold">TAG</span><div class="ms-3 d-inline-block text-fixed-white">&nbsp; ' + escapeHtml(tag) + '</div></div>' : '') +
					'<div class="row g-4 mt-3">' +
						'<div class="col-12 col-md-6">' +
							'<div class="text-fixed-red fw-semibold section-title">EQUIPMENTS</div>' +
							(equipments.length ? '<ul>' + equipments.map(function (e) {
								return '<li><span class="text-fixed-white">' + escapeHtml(e.name) + '</span>' + (e.quantity ? '<span class="ms-3 text-fixed-white fw-semibold">' + e.quantity + '</span> <span class="text-fixed-white">' + escapeHtml(e.unit || '') + '</span>' : '') + '</li>';
							}).join('') + '</ul>' : '<div class="text-fixed-white small">None</div>') +
						'</div>' +
						'<div class="col-12 col-md-6">' +
							'<div class="text-fixed-red fw-semibold section-title">ITEMS</div>' +
							(items.length ? '<ul>' + items.map(function (e) {
								return '<li><span class="text-fixed-white">' + escapeHtml(e.name) + '</span>' + (e.quantity ? '<span class="ms-3 text-fixed-white fw-semibold">' + e.quantity + '</span> <span class="text-fixed-white">' + escapeHtml(e.unit || '') + '</span>' : '') + '</li>';
							}).join('') + '</ul>' : '<div class="text-fixed-white small">None</div>') +
						'</div>' +
					'</div>' +
				'</div>';
			resetAttendanceUI();
			resetCoverageUI();
		});
	}

	const btnCheckIn = doc.getElementById('btnCheckIn');
	const attendanceList = doc.getElementById('attendanceList');
	const attendanceEmpty = doc.getElementById('attendanceEmpty');
	if (btnCheckIn && attendanceList) {
		btnCheckIn.addEventListener('click', function () {
			const name = String(doc.getElementById('attendeeName').value || '').trim();
			const id = String(doc.getElementById('attendeeId').value || '').trim();
			if (!name) return notify('Enter attendee name', 'danger');
			const li = doc.createElement('li');
			li.className = 'list-group-item d-flex align-items-center justify-content-between';
			li.innerHTML = '<div>' + escapeHtml(name) + (id ? ' <span class="text-muted small">(' + escapeHtml(id) + ')</span>' : '') + '</div>' +
				'<span class="badge text-bg-success">Present</span>';
			attendanceList.prepend(li);
			if (attendanceEmpty) attendanceEmpty.remove();
			doc.getElementById('attendeeName').value = '';
			doc.getElementById('attendeeId').value = '';
			notify('Checked in: ' + name, 'success');
		});
	}

	const btnAddCoverage = doc.getElementById('btnAddCoverage');
	const coverageList = doc.getElementById('coverageList');
	const coverageEmpty = doc.getElementById('coverageEmpty');
	if (btnAddCoverage && coverageList) {
		btnAddCoverage.addEventListener('click', function () {
			const input = doc.getElementById('coverageNotes');
			const value = String(input.value || '').trim();
			if (!value) return notify('Enter a link or note', 'danger');
			const li = doc.createElement('li');
			li.className = 'list-group-item d-flex align-items-center justify-content-between';
			var content = escapeHtml(value);
			if (/^https?:\/\//i.test(value)) {
				content = '<a href="' + escapeHtml(value) + '" target="_blank" rel="noopener">' + escapeHtml(value) + '</a>';
			}
			li.innerHTML = '<div>' + content + '</div>' +
				'<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>';
			const delBtn = li.querySelector('button');
			delBtn.addEventListener('click', function () { li.remove(); });
			coverageList.prepend(li);
			if (coverageEmpty) coverageEmpty.remove();
			input.value = '';
			notify('Coverage added', 'primary');
		});
	}

	function resetAttendanceUI() {
		if (attendanceList) attendanceList.innerHTML = '<li class="list-group-item small text-muted" id="attendanceEmpty">No attendees yet.</li>';
	}
	function resetCoverageUI() {
		if (coverageList) coverageList.innerHTML = '<li class="list-group-item small text-muted" id="coverageEmpty">No coverage yet.</li>';
	}

	// Mini Calendar Renderer (current month)
	const miniCalendar = doc.getElementById('miniCalendar');
	if (miniCalendar) {
		renderMiniCalendar(miniCalendar, new Date());
	}

	function renderMiniCalendar(container, date) {
		container.innerHTML = '';
		const year = date.getFullYear();
		const month = date.getMonth();
		const firstDay = new Date(year, month, 1);
		const startDow = firstDay.getDay();
		const daysInMonth = new Date(year, month + 1, 0).getDate();
		const weekdays = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
		weekdays.forEach(function (w) {
			const div = doc.createElement('div');
			div.className = 'col fw-semibold text-muted';
			div.textContent = w;
			container.appendChild(div);
		});
		for (var i = 0; i < startDow; i++) {
			const div = doc.createElement('div');
			div.className = 'col';
			div.innerHTML = '&nbsp;';
			container.appendChild(div);
		}
		for (var day = 1; day <= daysInMonth; day++) {
			const div = doc.createElement('div');
			div.className = 'col day-cell';
			div.textContent = String(day);
			if (isToday(year, month, day)) {
				div.classList.add('border', 'border-primary', 'fw-semibold');
			}
			container.appendChild(div);
		}
	}

	function isToday(y, m, d) {
		const now = new Date();
		return now.getFullYear() === y && now.getMonth() === m && now.getDate() === d;
	}

	function incrementCounter(id) {
		const el = doc.getElementById(id);
		if (!el) return;
		var current = parseInt(el.textContent || '0', 10);
		if (isNaN(current)) current = 0;
		el.textContent = String(current + 1);
	}

	function escapeHtml(raw) {
		return String(raw)
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#039;');
	}

	// CSS escape helper for attribute selector
	function cssEscape(value) {
		return String(value).replace(/"/g, '\\"');
	}

	// Events filter (Upcoming/All/Past)
	const eventsFilter = doc.getElementById('eventsFilter');
	if (eventsFilter && eventsList) {
		eventsFilter.addEventListener('change', function () {
			filterEvents(eventsFilter.value);
		});
		filterEvents(eventsFilter.value);
	}

	function filterEvents(mode) {
		const now = new Date();
		Array.prototype.forEach.call(eventsList.children, function (li) {
			if (!li.matches('li.list-group-item')) return;
			var text = li.querySelector('.small.text-muted');
			if (!text) return;
			var content = text.textContent || '';
			var match = content.match(/\b(\d{4}-\d{2}-\d{2})\b/);
			if (!match) { li.style.display = ''; return; }
			var dateStr = match[1];
			var d = new Date(dateStr + 'T00:00:00');
			var isPast = d < new Date(now.getFullYear(), now.getMonth(), now.getDate());
			if (mode === 'all') li.style.display = '';
			else if (mode === 'upcoming') li.style.display = isPast ? 'none' : '';
			else if (mode === 'past') li.style.display = isPast ? '' : 'none';
		});
	}

	// Initial low stock compute
	updateLowStockBadge();
})();

