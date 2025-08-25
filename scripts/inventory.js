// Inventory-specific JavaScript functionality

document.addEventListener("DOMContentLoaded", function () {
  // Initialize inventory components
  initializeInventoryStats();
  initializeInventoryTable();
  initializeLoansTable();
  initializeSearchAndFilters();
  initializeInventoryActions();
  initializeInventoryAnimations();
});

// Inventory Statistics
function initializeInventoryStats() {
  // Update inventory statistics
  updateInventoryStats();

  // Refresh stats every 60 seconds
  setInterval(updateInventoryStats, 60000);
}

function updateInventoryStats() {
  // Simulate fetching inventory data
  const stats = {
    totalItems: getRandomNumber(180, 220),
    borrowedItems: getRandomNumber(15, 35),
    lowStockItems: getRandomNumber(5, 15),
    categories: getRandomNumber(8, 12),
  };

  // Update DOM elements
  updateStatElement("totalItems", stats.totalItems);
  updateStatElement("borrowedItems", stats.borrowedItems);
  updateStatElement("lowStockItems", stats.lowStockItems);
  updateStatElement("categories", stats.categories);
}

function updateStatElement(elementId, value) {
  const element = document.getElementById(elementId);
  if (element) {
    // Animate the number change
    animateNumber(element, parseInt(element.textContent) || 0, value);
  }
}

function animateNumber(element, start, end) {
  const duration = 1000;
  const startTime = performance.now();

  function update(currentTime) {
    const elapsed = currentTime - startTime;
    const progress = Math.min(elapsed / duration, 1);

    const current = Math.floor(start + (end - start) * progress);
    element.textContent = current;

    if (progress < 1) {
      requestAnimationFrame(update);
    }
  }

  requestAnimationFrame(update);
}

// Inventory Table Management
function initializeInventoryTable() {
  loadInventoryData();

  // Refresh inventory data every 5 minutes
  setInterval(loadInventoryData, 300000);
}

function loadInventoryData() {
  // Simulate loading inventory data
  const inventory = [
    {
      id: 1,
      name: "Wireless Microphones",
      category: "Audio",
      location: "AV Room",
      quantity: 8,
      borrowed: 2,
      status: "available",
    },
    {
      id: 2,
      name: "Plastic Chairs",
      category: "Furniture",
      location: "Storage A",
      quantity: 120,
      borrowed: 15,
      status: "available",
    },
    {
      id: 3,
      name: "Extension Cords",
      category: "Electrical",
      location: "Storage B",
      quantity: 15,
      borrowed: 8,
      status: "low-stock",
    },
    {
      id: 4,
      name: "Projectors",
      category: "IT",
      location: "Tech Room",
      quantity: 5,
      borrowed: 5,
      status: "out-of-stock",
    },
  ];

  displayInventoryTable(inventory);
}

function displayInventoryTable(inventory) {
  const tbody = document.querySelector("#inventoryTable tbody");
  if (!tbody) return;

  tbody.innerHTML = "";

  inventory.forEach((item) => {
    const row = createInventoryRow(item);
    tbody.appendChild(row);
  });
}

function createInventoryRow(item) {
  const row = document.createElement("tr");
  row.innerHTML = `
        <td>
            <div class="item-name">${item.name}</div>
            <div class="item-location">${item.location}</div>
        </td>
        <td><span class="item-category">${item.category}</span></td>
        <td class="item-quantity">${item.quantity}</td>
        <td class="item-quantity">${item.borrowed}</td>
        <td><span class="item-status ${item.status}">${getStatusText(
    item.status
  )}</span></td>
        <td>
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-primary" onclick="editItem(${
                  item.id
                })">
                    <i class="bi bi-pencil"></i>
                </button>
                <button type="button" class="btn btn-outline-success" onclick="borrowItem(${
                  item.id
                })">
                    <i class="bi bi-arrow-right"></i>
                </button>
                <button type="button" class="btn btn-outline-danger" onclick="deleteItem(${
                  item.id
                })">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </td>
    `;

  return row;
}

// Loans Table Management
function initializeLoansTable() {
  loadLoansData();

  // Refresh loans data every 3 minutes
  setInterval(loadLoansData, 180000);
}

function loadLoansData() {
  // Simulate loading loans data
  const loans = [
    {
      id: 1,
      borrower: "John Doe",
      item: "Wireless Microphones",
      quantity: 2,
      borrowedDate: "2025-01-10",
      dueDate: "2025-01-15",
      status: "active",
    },
    {
      id: 2,
      borrower: "Jane Smith",
      item: "Plastic Chairs",
      quantity: 10,
      borrowedDate: "2025-01-08",
      dueDate: "2025-01-12",
      status: "overdue",
    },
  ];

  displayLoansTable(loans);
}

function displayLoansTable(loans) {
  const tbody = document.querySelector("#loansTable tbody");
  if (!tbody) return;

  tbody.innerHTML = "";

  if (loans.length === 0) {
    tbody.innerHTML =
      '<tr><td colspan="6" class="text-center text-muted">No active loans</td></tr>';
    return;
  }

  loans.forEach((loan) => {
    const row = createLoanRow(loan);
    tbody.appendChild(row);
  });
}

function createLoanRow(loan) {
  const row = document.createElement("tr");
  row.innerHTML = `
        <td>${loan.borrower}</td>
        <td>${loan.item}</td>
        <td>${loan.quantity}</td>
        <td>${formatDate(loan.borrowedDate)}</td>
        <td>${formatDate(loan.dueDate)}</td>
        <td>
            <span class="loan-status ${loan.status}">${getLoanStatusText(
    loan.status
  )}</span>
        </td>
        <td>
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-success" onclick="returnItem(${
                  loan.id
                })">
                    <i class="bi bi-arrow-left"></i>
                </button>
                <button type="button" class="btn btn-outline-warning" onclick="extendLoan(${
                  loan.id
                })">
                    <i class="bi bi-clock"></i>
                </button>
            </div>
        </td>
    `;

  return row;
}

// Search and Filters
function initializeSearchAndFilters() {
  const searchInput = document.getElementById("inventorySearch");
  const categoryFilter = document.getElementById("categoryFilter");
  const statusFilter = document.getElementById("statusFilter");

  if (searchInput) {
    searchInput.addEventListener("input", debounce(handleSearch, 300));
  }

  if (categoryFilter) {
    categoryFilter.addEventListener("change", handleFilter);
  }

  if (statusFilter) {
    statusFilter.addEventListener("change", handleFilter);
  }
}

function handleSearch(e) {
  const searchTerm = e.target.value.toLowerCase();
  const rows = document.querySelectorAll("#inventoryTable tbody tr");

  rows.forEach((row) => {
    const itemName = row.querySelector(".item-name").textContent.toLowerCase();
    const itemLocation = row
      .querySelector(".item-location")
      .textContent.toLowerCase();

    if (itemName.includes(searchTerm) || itemLocation.includes(searchTerm)) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });
}

function handleFilter() {
  const categoryFilter = document.getElementById("categoryFilter");
  const statusFilter = document.getElementById("statusFilter");
  const rows = document.querySelectorAll("#inventoryTable tbody tr");

  const selectedCategory = categoryFilter ? categoryFilter.value : "";
  const selectedStatus = statusFilter ? statusFilter.value : "";

  rows.forEach((row) => {
    const category = row.querySelector(".item-category").textContent;
    const status = row.querySelector(".item-status").textContent;

    const categoryMatch = !selectedCategory || category === selectedCategory;
    const statusMatch = !selectedStatus || status === selectedStatus;

    if (categoryMatch && statusMatch) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });
}

// Inventory Actions
function initializeInventoryActions() {
  // Add event listeners for action buttons
  const addItemBtn = document.getElementById("addItemBtn");
  const borrowItemBtn = document.getElementById("borrowItemBtn");
  const exportBtn = document.getElementById("exportInventoryBtn");

  if (addItemBtn) {
    addItemBtn.addEventListener("click", () => {
      const modal = new bootstrap.Modal(
        document.getElementById("modalInventory")
      );
      modal.show();
    });
  }

  if (borrowItemBtn) {
    borrowItemBtn.addEventListener("click", () => {
      const modal = new bootstrap.Modal(document.getElementById("modalLoan"));
      modal.show();
    });
  }

  if (exportBtn) {
    exportBtn.addEventListener("click", exportInventoryData);
  }
}

// Item Management Functions
function editItem(itemId) {
  showToast(`Editing item ${itemId}...`, "info");
  // Here you would typically open an edit modal
}

function borrowItem(itemId) {
  showToast(`Borrowing item ${itemId}...`, "info");
  // Here you would typically open a borrow modal
}

function deleteItem(itemId) {
  if (confirm("Are you sure you want to delete this item?")) {
    showToast(`Deleting item ${itemId}...`, "warning");
    // Here you would typically make an API call to delete the item
  }
}

function returnItem(loanId) {
  showToast(`Returning item from loan ${loanId}...`, "success");
  // Here you would typically make an API call to return the item
}

function extendLoan(loanId) {
  showToast(`Extending loan ${loanId}...`, "info");
  // Here you would typically open an extend loan modal
}

// Inventory Animations
function initializeInventoryAnimations() {
  // Add scroll-triggered animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate-in");
      }
    });
  }, observerOptions);

  // Observe inventory sections
  const sections = document.querySelectorAll(".inventory-section");
  sections.forEach((section) => {
    observer.observe(section);
  });
}

// Export Functionality
function exportInventoryData() {
  showToast("Exporting inventory data...", "info");

  // Simulate export process
  setTimeout(() => {
    showToast("Inventory data exported successfully!", "success");
    // Here you would typically trigger a download
  }, 2000);
}

// Utility Functions
function getRandomNumber(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

function formatDate(dateString) {
  const date = new Date(dateString);
  return date.toLocaleDateString("en-US", {
    month: "short",
    day: "numeric",
    year: "numeric",
  });
}

function getStatusText(status) {
  const statusMap = {
    available: "Available",
    "low-stock": "Low Stock",
    "out-of-stock": "Out of Stock",
  };
  return statusMap[status] || status;
}

function getLoanStatusText(status) {
  const statusMap = {
    active: "Active",
    overdue: "Overdue",
    returned: "Returned",
  };
  return statusMap[status] || status;
}

function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

function showToast(message, type = "info") {
  // Create toast notification
  const toastContainer = document.getElementById("toastStack") || document.body;

  const toast = document.createElement("div");
  toast.className = `toast align-items-center text-white bg-${type} border-0`;
  toast.setAttribute("role", "alert");
  toast.setAttribute("aria-live", "assertive");
  toast.setAttribute("aria-atomic", "true");

  toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;

  toastContainer.appendChild(toast);

  const bsToast = new bootstrap.Toast(toast);
  bsToast.show();

  // Remove toast after it's hidden
  toast.addEventListener("hidden.bs.toast", () => {
    toast.remove();
  });
}

// Export functions for potential use in other scripts
window.Inventory = {
  updateInventoryStats,
  loadInventoryData,
  loadLoansData,
  exportInventoryData,
  showToast,
};
