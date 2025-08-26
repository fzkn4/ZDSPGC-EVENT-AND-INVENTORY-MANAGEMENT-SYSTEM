// Events Page JavaScript

document.addEventListener("DOMContentLoaded", function () {
  // Initialize events page functionality
  initializeEventsPage();
});

function initializeEventsPage() {
  // Search functionality
  const searchInput = document.getElementById("searchEvents");
  if (searchInput) {
    searchInput.addEventListener("input", function () {
      filterEvents();
    });
  }

  // Filter functionality
  const filterType = document.getElementById("filterType");
  const filterStatus = document.getElementById("filterStatus");

  if (filterType) {
    filterType.addEventListener("change", filterEvents);
  }

  if (filterStatus) {
    filterStatus.addEventListener("change", filterEvents);
  }

  // Form submissions
  const addEventForm = document.getElementById("formAddEvent");
  if (addEventForm) {
    addEventForm.addEventListener("submit", handleAddEvent);
  }

  // Initialize tooltips and popovers
  initializeBootstrapComponents();
}

function filterEvents() {
  const searchTerm =
    document.getElementById("searchEvents")?.value.toLowerCase() || "";
  const typeFilter = document.getElementById("filterType")?.value || "";
  const statusFilter = document.getElementById("filterStatus")?.value || "";

  const eventItems = document.querySelectorAll(".event-item");

  eventItems.forEach((item) => {
    const eventName =
      item.querySelector(".event-item-name")?.textContent.toLowerCase() || "";
    const eventType =
      item.querySelector(".event-item-type")?.textContent.toLowerCase() || "";

    let showItem = true;

    // Search filter
    if (searchTerm && !eventName.includes(searchTerm)) {
      showItem = false;
    }

    // Type filter
    if (typeFilter && eventType !== typeFilter.toLowerCase()) {
      showItem = false;
    }

    // Status filter (you can add more logic here based on your data)
    if (statusFilter) {
      // This is a placeholder - implement based on your event status logic
      // For now, we'll just show all items
    }

    item.style.display = showItem ? "block" : "none";
  });
}

function handleAddEvent(event) {
  event.preventDefault();

  const formData = new FormData(event.target);
  const eventData = Object.fromEntries(formData.entries());

  // Show loading state
  const submitBtn = event.target.querySelector('button[type="submit"]');
  const originalText = submitBtn.innerHTML;
  submitBtn.innerHTML =
    '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
  submitBtn.disabled = true;

  // Simulate API call
  setTimeout(() => {
    // Reset button
    submitBtn.innerHTML = originalText;
    submitBtn.disabled = false;

    // Close modal
    const modal = bootstrap.Modal.getInstance(
      document.getElementById("modalEvent")
    );
    if (modal) {
      modal.hide();
    }

    // Show success message
    showNotification("Event added successfully!", "success");

    // Reset form
    event.target.reset();

    // Refresh events list (in a real app, you'd fetch updated data)
    // refreshEventsList();
  }, 1500);
}

function showNotification(message, type = "info") {
  // Create notification element
  const notification = document.createElement("div");
  notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
  notification.style.cssText =
    "top: 20px; right: 20px; z-index: 9999; min-width: 300px;";
  notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

  // Add to page
  document.body.appendChild(notification);

  // Auto remove after 5 seconds
  setTimeout(() => {
    if (notification.parentNode) {
      notification.remove();
    }
  }, 5000);
}

function initializeBootstrapComponents() {
  // Initialize tooltips
  const tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Initialize popovers
  const popoverTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="popover"]')
  );
  popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
  });
}

// Utility functions
function formatDate(dateString) {
  const date = new Date(dateString);
  return date.toLocaleDateString("en-US", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });
}

function formatTime(timeString) {
  const time = new Date(`2000-01-01T${timeString}`);
  return time.toLocaleTimeString("en-US", {
    hour: "2-digit",
    minute: "2-digit",
  });
}

// Export functions for global access
window.EventsPage = {
  filterEvents,
  handleAddEvent,
  showNotification,
  formatDate,
  formatTime,
};
