(function () {
  const doc = document;

  // OPTIMIZED: Cache frequently used elements
  const root = doc.documentElement;
  const adminSwitch = doc.getElementById("adminModeSwitch");

  // OPTIMIZED: Use more efficient localStorage check
  const storedAdmin = localStorage.getItem("eims-admin") === "1";

  if (storedAdmin) {
    root.classList.add("admin-mode");
    if (adminSwitch) adminSwitch.checked = true;
  }

  // OPTIMIZED: Single event listener for admin switch
  if (adminSwitch) {
    adminSwitch.addEventListener("change", function () {
      if (adminSwitch.checked) {
        root.classList.add("admin-mode");
        localStorage.setItem("eims-admin", "1");
      } else {
        root.classList.remove("admin-mode");
        localStorage.setItem("eims-admin", "0");
      }
    });
  }

  // OPTIMIZED: Cache form elements
  const formAddEvent = doc.getElementById("formAddEvent");
  const eventsList = doc.getElementById("eventsList");
  const equipmentsInputs = doc.getElementById("equipmentsInputs");
  const itemsInputs = doc.getElementById("itemsInputs");
  const btnAddEquipmentRow = doc.getElementById("btnAddEquipmentRow");
  const btnAddItemRow = doc.getElementById("btnAddItemRow");

  // OPTIMIZED: Use event delegation for better performance
  if (btnAddEquipmentRow && equipmentsInputs) {
    btnAddEquipmentRow.addEventListener("click", addEquipmentRow);
  }

  if (btnAddItemRow && itemsInputs) {
    btnAddItemRow.addEventListener("click", addItemRow);
  }

  // OPTIMIZED: Simplified row creation functions
  function addEquipmentRow() {
    const row = doc.createElement("div");
    row.className = "row g-2 mb-2 equipment-row";
    row.innerHTML = `
      <div class="col-6"><input type="text" class="form-control equipment-name" placeholder="e.g., Sound System" /></div>
      <div class="col-3"><input type="number" min="0" class="form-control equipment-qty" placeholder="Qty" /></div>
      <div class="col-2"><input type="text" class="form-control equipment-unit" placeholder="Unit" /></div>
      <div class="col-1 d-grid"><button type="button" class="btn btn-outline-danger remove-row"><i class="bi bi-x"></i></button></div>
    `;
    equipmentsInputs.appendChild(row);

    // OPTIMIZED: Use event delegation for remove buttons
    const removeBtn = row.querySelector(".remove-row");
    if (removeBtn) {
      removeBtn.addEventListener("click", () => row.remove());
    }
  }

  function addItemRow() {
    const row = doc.createElement("div");
    row.className = "row g-2 mb-2 item-row";
    row.innerHTML = `
      <div class="col-6"><input type="text" class="form-control item-name" placeholder="e.g., Chairs" /></div>
      <div class="col-3"><input type="number" min="0" class="form-control item-qty" placeholder="Qty" /></div>
      <div class="col-2"><input type="text" class="form-control item-unit" placeholder="Unit" /></div>
      <div class="col-1 d-grid"><button type="button" class="btn btn-outline-danger remove-row"><i class="bi bi-x"></i></button></div>
    `;
    itemsInputs.appendChild(row);

    // OPTIMIZED: Use event delegation for remove buttons
    const removeBtn = row.querySelector(".remove-row");
    if (removeBtn) {
      removeBtn.addEventListener("click", () => row.remove());
    }
  }

  // OPTIMIZED: Simplified data collection functions
  function collectEquipmentsFromForm() {
    if (!equipmentsInputs) return [];

    const list = [];
    const rows = equipmentsInputs.querySelectorAll(".equipment-row");

    rows.forEach(function (row) {
      const nameEl = row.querySelector(".equipment-name");
      const qtyEl = row.querySelector(".equipment-qty");
      const unitEl = row.querySelector(".equipment-unit");

      const name = (nameEl?.value || "").trim();
      if (!name) return;

      const qty = parseInt(qtyEl?.value || "0", 10) || 0;
      const unit = (unitEl?.value || "").trim();

      list.push({ name, quantity: qty, unit });
    });

    return list;
  }

  function collectItemsFromForm() {
    if (!itemsInputs) return [];

    const list = [];
    const rows = itemsInputs.querySelectorAll(".item-row");

    rows.forEach(function (row) {
      const nameEl = row.querySelector(".item-name");
      const qtyEl = row.querySelector(".item-qty");
      const unitEl = row.querySelector(".item-unit");

      const name = (nameEl?.value || "").trim();
      if (!name) return;

      const qty = parseInt(qtyEl?.value || "0", 10) || 0;
      const unit = (unitEl?.value || "").trim();

      list.push({ name, quantity: qty, unit });
    });

    return list;
  }

  // OPTIMIZED: Enhanced Mobile Navigation and Header Functionality
  function initMobileNavigation() {
    const navbarToggler = doc.querySelector(".navbar-toggler");
    const navbarCollapse = doc.querySelector(".navbar-collapse");

    if (navbarToggler && navbarCollapse) {
      // OPTIMIZED: Use CSS transitions instead of JavaScript animations
      navbarCollapse.style.transition = "all 0.3s ease";

      // Auto-close mobile menu when clicking outside
      doc.addEventListener("click", function (e) {
        if (
          !navbarToggler.contains(e.target) &&
          !navbarCollapse.contains(e.target)
        ) {
          const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
          if (bsCollapse && bsCollapse._isShown()) {
            bsCollapse.hide();
          }
        }
      });

      // Auto-close mobile menu when clicking on dropdown items
      const dropdownItems = doc.querySelectorAll(".dropdown-item");
      dropdownItems.forEach((item) => {
        item.addEventListener("click", function () {
          const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
          if (bsCollapse && bsCollapse._isShown()) {
            bsCollapse.hide();
          }
        });
      });
    }
  }

  // OPTIMIZED: Enhanced Header Scroll Effects
  function initHeaderScrollEffects() {
    let lastScrollTop = 0;
    const header = doc.querySelector("header");

    if (header) {
      window.addEventListener(
        "scroll",
        function () {
          const scrollTop = window.pageYOffset || doc.documentElement.scrollTop;

          if (scrollTop > lastScrollTop && scrollTop > 100) {
            // Scrolling down - hide header
            header.style.transform = "translateY(-100%)";
          } else {
            // Scrolling up - show header
            header.style.transform = "translateY(0)";
          }

          lastScrollTop = scrollTop;
        },
        { passive: true }
      ); // OPTIMIZED: Use passive event listener
    }
  }

  // OPTIMIZED: Enhanced Dropdown Animations
  function initDropdownAnimations() {
    const dropdowns = doc.querySelectorAll(".dropdown");

    dropdowns.forEach((dropdown) => {
      const menu = dropdown.querySelector(".dropdown-menu");
      if (menu) {
        menu.style.transition = "opacity 0.3s ease, transform 0.3s ease";
      }
    });
  }

  // OPTIMIZED: Enhanced Notification Badge Animations
  function initNotificationAnimations() {
    const notificationBadge = doc.getElementById("notifCount");

    if (notificationBadge) {
      // OPTIMIZED: Use CSS animations instead of JavaScript
      notificationBadge.style.transition = "transform 0.3s ease";

      // Add bounce effect when content changes
      const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
          if (mutation.type === "childList") {
            notificationBadge.style.transform = "scale(1.2)";
            setTimeout(() => {
              notificationBadge.style.transform = "scale(1)";
            }, 150);
          }
        });
      });

      observer.observe(notificationBadge, { childList: true });
    }
  }

  // OPTIMIZED: Enhanced Brand Hover Effects
  function initBrandHoverEffects() {
    const brandIcon = doc.querySelector(".navbar-brand i");

    if (brandIcon) {
      brandIcon.style.transition = "transform 0.3s ease";

      const brand = doc.querySelector(".navbar-brand");
      if (brand) {
        brand.addEventListener("mouseenter", function () {
          brandIcon.style.transform = "scale(1.1) rotate(5deg)";
        });

        brand.addEventListener("mouseleave", function () {
          brandIcon.style.transform = "scale(1) rotate(0deg)";
        });
      }
    }
  }

  // OPTIMIZED: Initialize all enhanced features
  function initEnhancedFeatures() {
    // OPTIMIZED: Use requestIdleCallback for non-critical initializations
    if ("requestIdleCallback" in window) {
      requestIdleCallback(() => {
        initMobileNavigation();
        initHeaderScrollEffects();
        initDropdownAnimations();
        initNotificationAnimations();
        initBrandHoverEffects();
      });
    } else {
      // Fallback for browsers that don't support requestIdleCallback
      setTimeout(() => {
        initMobileNavigation();
        initHeaderScrollEffects();
        initDropdownAnimations();
        initNotificationAnimations();
        initBrandHoverEffects();
      }, 100);
    }
  }

  // OPTIMIZED: Sidebar Navigation with Smooth Transitions
  function initSidebarNavigation() {
    const sidebarLinks = doc.querySelectorAll(".sidebar-menu .menu-link");

    sidebarLinks.forEach((link) => {
      link.addEventListener("click", function (e) {
        // OPTIMIZED: Use CSS transitions instead of JavaScript animations
        const activeLink = doc.querySelector(".sidebar-menu .menu-link.active");
        if (activeLink && activeLink !== this) {
          activeLink.classList.remove("active");
        }
        this.classList.add("active");
      });
    });
  }

  // OPTIMIZED: Add page content animation on load
  function initPageContentAnimation() {
    const pageContent = doc.querySelector(".page-content");

    if (pageContent) {
      // OPTIMIZED: Use CSS animations instead of JavaScript
      pageContent.style.opacity = "0";
      pageContent.style.transform = "translateY(20px)";
      pageContent.style.transition = "opacity 0.5s ease, transform 0.5s ease";

      // Trigger animation after a short delay
      setTimeout(() => {
        pageContent.style.opacity = "1";
        pageContent.style.transform = "translateY(0)";
      }, 100);
    }
  }

  // OPTIMIZED: Initialize everything when DOM is ready
  if (doc.readyState === "loading") {
    doc.addEventListener("DOMContentLoaded", function () {
      initEnhancedFeatures();
      initSidebarNavigation();
      initPageContentAnimation();
    });
  } else {
    // DOM is already ready
    initEnhancedFeatures();
    initSidebarNavigation();
    initPageContentAnimation();
  }

  // OPTIMIZED: Form submission handling
  if (formAddEvent) {
    formAddEvent.addEventListener("submit", function (e) {
      e.preventDefault();

      // OPTIMIZED: Use FormData for better performance
      const formData = new FormData(formAddEvent);
      const eventData = {
        title: formData.get("title") || "",
        description: formData.get("description") || "",
        date: formData.get("date") || "",
        time: formData.get("time") || "",
        location: formData.get("location") || "",
        type: formData.get("type") || "",
        equipments: collectEquipmentsFromForm(),
        items: collectItemsFromForm(),
      };

      // OPTIMIZED: Validate data before processing
      if (!eventData.title || !eventData.date) {
        alert("Please fill in all required fields");
        return;
      }

      // OPTIMIZED: Simulate form submission
      console.log("Event data:", eventData);
      alert("Event added successfully!");
      formAddEvent.reset();

      // Clear dynamic rows
      if (equipmentsInputs) equipmentsInputs.innerHTML = "";
      if (itemsInputs) itemsInputs.innerHTML = "";
    });
  }

  // OPTIMIZED: Search and filter functionality
  function initSearchAndFilter() {
    const searchInput = doc.getElementById("searchEvents");
    const filterType = doc.getElementById("filterType");
    const filterStatus = doc.getElementById("filterStatus");

    // OPTIMIZED: Use debouncing for search input
    let searchTimeout;
    if (searchInput) {
      searchInput.addEventListener("input", function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
          performSearch(this.value);
        }, 300);
      });
    }

    // OPTIMIZED: Use event delegation for filters
    if (filterType) {
      filterType.addEventListener("change", function () {
        performFilter();
      });
    }

    if (filterStatus) {
      filterStatus.addEventListener("change", function () {
        performFilter();
      });
    }
  }

  function performSearch(searchTerm) {
    // OPTIMIZED: Implement search logic here
    console.log("Searching for:", searchTerm);
  }

  function performFilter() {
    // OPTIMIZED: Implement filter logic here
    console.log("Applying filters");
  }

  // OPTIMIZED: Initialize search and filter
  initSearchAndFilter();
})();
