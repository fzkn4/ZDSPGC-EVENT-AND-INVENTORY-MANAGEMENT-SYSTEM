// Dashboard-specific JavaScript functionality

document.addEventListener("DOMContentLoaded", function () {
  // Ensure dashboard is the main focus
  console.log("Dashboard loading...");

  // Initialize dashboard components
  initializeDashboardStats();
  initializeQuickActions();
  initializeUpcomingEvents();
  initializeRecentActivity();
  initializeDashboardAnimations();

  // Ensure dashboard content is visible
  showDashboardContent();
});

// Show dashboard content as primary focus
function showDashboardContent() {
  // Hide any event-related content that might be showing
  const eventSections = document.querySelectorAll(".tab-pane, #tab-events");
  eventSections.forEach((section) => {
    if (section) {
      section.style.display = "none";
    }
  });

  // Ensure dashboard sections are visible
  const dashboardSections = document.querySelectorAll(
    ".dashboard-section, .card, .row"
  );
  dashboardSections.forEach((section) => {
    if (section) {
      section.style.display = "";
    }
  });

  // Ensure main dashboard content is visible
  const mainContent = document.querySelector(".dashboard-main");
  if (mainContent) {
    mainContent.style.display = "block";
    mainContent.style.opacity = "1";
    mainContent.style.transform = "none";
  }

  // Update page title to reflect dashboard
  document.title = "Dashboard - ZDSPGC Event & Inventory Management System";

  // Add dashboard-specific class to body
  document.body.classList.add("dashboard-page");

  console.log("Dashboard content displayed successfully");
}

// Dashboard Statistics
function initializeDashboardStats() {
  // Update statistics with real-time data
  updateStatistics();

  // Refresh stats every 30 seconds
  setInterval(updateStatistics, 30000);
}

function updateStatistics() {
  // Simulate fetching real-time data
  const stats = {
    totalEvents: getRandomNumber(15, 25),
    upcomingEvents: getRandomNumber(3, 8),
    totalItems: getRandomNumber(150, 200),
    borrowedItems: getRandomNumber(10, 25),
  };

  // Update DOM elements
  updateStatElement("totalEvents", stats.totalEvents);
  updateStatElement("upcomingEvents", stats.upcomingEvents);
  updateStatElement("totalItems", stats.totalItems);
  updateStatElement("borrowedItems", stats.borrowedItems);
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

// Quick Actions
function initializeQuickActions() {
  const actionButtons = document.querySelectorAll(".action-btn");

  actionButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();

      const action = this.getAttribute("data-action");
      handleQuickAction(action);
    });
  });
}

function handleQuickAction(action) {
  switch (action) {
    case "add-event":
      // Trigger add event modal
      const eventModal = new bootstrap.Modal(
        document.getElementById("modalEvent")
      );
      eventModal.show();
      break;
    case "add-item":
      // Trigger add inventory modal
      const inventoryModal = new bootstrap.Modal(
        document.getElementById("modalInventory")
      );
      inventoryModal.show();
      break;
    case "view-calendar":
      // Navigate to calendar view
      window.location.href = "index.php";
      break;
    case "generate-report":
      // Generate dashboard report
      generateDashboardReport();
      break;
  }
}

// Upcoming Events
function initializeUpcomingEvents() {
  loadUpcomingEvents();

  // Refresh events every 5 minutes
  setInterval(loadUpcomingEvents, 300000);
}

function loadUpcomingEvents() {
  // Simulate loading upcoming events
  const events = [
    {
      title: "Faculty Meeting",
      date: "2025-01-15",
      location: "Conference Room A",
      time: "10:00 AM",
    },
    {
      title: "Student Orientation",
      date: "2025-01-17",
      location: "Main Hall",
      time: "2:00 PM",
    },
    {
      title: "Equipment Maintenance",
      date: "2025-01-20",
      location: "Storage Room",
      time: "9:00 AM",
    },
  ];

  displayUpcomingEvents(events);
}

function displayUpcomingEvents(events) {
  const container = document.getElementById("upcomingEventsList");
  if (!container) return;

  container.innerHTML = "";

  events.forEach((event) => {
    const eventElement = createEventElement(event);
    container.appendChild(eventElement);
  });
}

function createEventElement(event) {
  const div = document.createElement("div");
  div.className = "event-item";
  div.innerHTML = `
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <div class="event-title">${event.title}</div>
                <div class="event-location">${event.location}</div>
            </div>
            <div class="text-end">
                <div class="event-date">${formatDate(event.date)}</div>
                <div class="event-time">${event.time}</div>
            </div>
        </div>
    `;

  return div;
}

// Recent Activity
function initializeRecentActivity() {
  loadRecentActivity();

  // Refresh activity every 2 minutes
  setInterval(loadRecentActivity, 120000);
}

function loadRecentActivity() {
  // Simulate loading recent activity
  const activities = [
    {
      type: "event",
      text: 'New event "Tech Workshop" added',
      time: "2 minutes ago",
      icon: "bi-calendar-plus",
      color: "bg-primary",
    },
    {
      type: "inventory",
      text: 'Item "Projector" borrowed by John Doe',
      time: "15 minutes ago",
      icon: "bi-box-arrow-right",
      color: "bg-warning",
    },
    {
      type: "system",
      text: "System backup completed",
      time: "1 hour ago",
      icon: "bi-check-circle",
      color: "bg-success",
    },
  ];

  displayRecentActivity(activities);
}

function displayRecentActivity(activities) {
  const container = document.getElementById("recentActivityList");
  if (!container) return;

  container.innerHTML = "";

  activities.forEach((activity) => {
    const activityElement = createActivityElement(activity);
    container.appendChild(activityElement);
  });
}

function createActivityElement(activity) {
  const div = document.createElement("div");
  div.className = "activity-item";
  div.innerHTML = `
        <div class="activity-icon ${activity.color} text-white">
            <i class="${activity.icon}"></i>
        </div>
        <div class="activity-content">
            <div class="activity-text">${activity.text}</div>
            <div class="activity-time">${activity.time}</div>
        </div>
    `;

  return div;
}

// Dashboard Animations
function initializeDashboardAnimations() {
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

  // Observe dashboard sections
  const sections = document.querySelectorAll(".dashboard-section");
  sections.forEach((section) => {
    observer.observe(section);
  });
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
  });
}

function generateDashboardReport() {
  // Simulate report generation
  showToast("Generating dashboard report...", "info");

  setTimeout(() => {
    showToast("Dashboard report generated successfully!", "success");
    // Here you would typically trigger a download or open a new window
  }, 2000);
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

// Logout function (redirects to PHP logout)
function logout() {
  window.location.href = "?logout=1";
}

// Export functions for potential use in other scripts
window.Dashboard = {
  updateStatistics,
  loadUpcomingEvents,
  loadRecentActivity,
  generateDashboardReport,
  showToast,
  logout,
};
