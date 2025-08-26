// Modern Login Page JavaScript

document.addEventListener("DOMContentLoaded", function () {
  initializeAuthPage();
});

function initializeAuthPage() {
  // Initialize all components
  initializeFormSwitching();
  initializePasswordToggles();
  initializeUserTypeSelectors();
  initializeFormValidation();
  initializeFormSubmissions();
  initializeAnimations();

  console.log("Auth page initialized successfully");
}

// Form Switching between Login and Signup
function initializeFormSwitching() {
  const switchLinks = document.querySelectorAll(".switch-link");

  switchLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();

      const targetForm = this.getAttribute("data-target");
      switchForm(targetForm);
    });
  });
}

function switchForm(targetFormId) {
  const currentForm = document.querySelector(".auth-form.active");
  const targetForm = document.getElementById(targetFormId);

  if (currentForm && targetForm) {
    // Fade out current form
    currentForm.style.opacity = "0";
    currentForm.style.transform = "translateY(-20px)";

    setTimeout(() => {
      // Hide current form and show target form
      currentForm.classList.remove("active");
      targetForm.classList.add("active");

      // Reset form styles
      currentForm.style.opacity = "";
      currentForm.style.transform = "";

      // Fade in target form
      targetForm.style.opacity = "0";
      targetForm.style.transform = "translateY(20px)";

      setTimeout(() => {
        targetForm.style.opacity = "1";
        targetForm.style.transform = "translateY(0)";
      }, 50);
    }, 300);
  }
}

// Password Toggle Functionality
function initializePasswordToggles() {
  const passwordToggles = document.querySelectorAll(".password-toggle");

  passwordToggles.forEach((toggle) => {
    toggle.addEventListener("click", function () {
      const input = this.previousElementSibling;
      const icon = this.querySelector("i");

      if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
        this.setAttribute("aria-label", "Hide password");
      } else {
        input.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
        this.setAttribute("aria-label", "Show password");
      }
    });
  });
}

// User Type Selector Functionality
function initializeUserTypeSelectors() {
  // Login form user type selectors
  const loginUserTypes = document.querySelectorAll('input[name="userType"]');
  loginUserTypes.forEach((input) => {
    input.addEventListener("change", function () {
      updateUserTypeUI(this.value, "login");
    });
  });

  // Signup form user type selectors
  const signupUserTypes = document.querySelectorAll(
    'input[name="signupUserType"]'
  );
  signupUserTypes.forEach((input) => {
    input.addEventListener("change", function () {
      updateUserTypeUI(this.value, "signup");
    });
  });
}

function updateUserTypeUI(userType, formType) {
  const studentIdField = document.getElementById("studentIdField");

  if (userType === "student") {
    if (studentIdField) {
      studentIdField.classList.remove("hidden");
      studentIdField.querySelector("input").required = true;
    }
  } else {
    if (studentIdField) {
      studentIdField.classList.add("hidden");
      studentIdField.querySelector("input").required = false;
    }
  }

  // Add visual feedback
  const labels = document.querySelectorAll(
    `input[name="${
      formType === "login" ? "userType" : "signupUserType"
    }"][value="${userType}"] + .user-type-label`
  );
  labels.forEach((label) => {
    label.classList.add("success-animation");
    setTimeout(() => {
      label.classList.remove("success-animation");
    }, 500);
  });
}

// Form Validation
function initializeFormValidation() {
  // Real-time validation for signup form
  const signupForm = document.getElementById("signupFormElement");
  if (signupForm) {
    const inputs = signupForm.querySelectorAll("input[required]");

    inputs.forEach((input) => {
      input.addEventListener("blur", function () {
        validateField(this);
      });

      input.addEventListener("input", function () {
        if (this.classList.contains("is-invalid")) {
          validateField(this);
        }
      });
    });

    // Password confirmation validation
    const passwordInput = document.getElementById("signupPassword");
    const confirmPasswordInput = document.getElementById("confirmPassword");

    if (passwordInput && confirmPasswordInput) {
      confirmPasswordInput.addEventListener("input", function () {
        validatePasswordMatch(passwordInput, this);
      });
    }
  }
}

function validateField(field) {
  const value = field.value.trim();
  let isValid = true;
  let errorMessage = "";

  // Remove existing validation classes
  field.classList.remove("is-valid", "is-invalid");

  // Remove existing error message
  const existingError = field.parentNode.querySelector(".invalid-feedback");
  if (existingError) {
    existingError.remove();
  }

  // Validation rules
  switch (field.type) {
    case "email":
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(value)) {
        isValid = false;
        errorMessage = "Please enter a valid email address";
      }
      break;

    case "password":
      if (value.length < 8) {
        isValid = false;
        errorMessage = "Password must be at least 8 characters long";
      } else if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(value)) {
        isValid = false;
        errorMessage = "Password must contain uppercase, lowercase, and number";
      }
      break;

    default:
      if (field.required && !value) {
        isValid = false;
        errorMessage = "This field is required";
      }
  }

  // Apply validation result
  if (isValid) {
    field.classList.add("is-valid");
  } else {
    field.classList.add("is-invalid");
    showFieldError(field, errorMessage);
  }

  return isValid;
}

function validatePasswordMatch(passwordField, confirmField) {
  const password = passwordField.value;
  const confirmPassword = confirmField.value;

  confirmField.classList.remove("is-valid", "is-invalid");

  const existingError =
    confirmField.parentNode.querySelector(".invalid-feedback");
  if (existingError) {
    existingError.remove();
  }

  if (confirmPassword && password !== confirmPassword) {
    confirmField.classList.add("is-invalid");
    showFieldError(confirmField, "Passwords do not match");
    return false;
  } else if (confirmPassword) {
    confirmField.classList.add("is-valid");
    return true;
  }

  return true;
}

function showFieldError(field, message) {
  const errorDiv = document.createElement("div");
  errorDiv.className = "invalid-feedback";
  errorDiv.textContent = message;
  field.parentNode.appendChild(errorDiv);
}

// Form Submissions
function initializeFormSubmissions() {
  // Login form submission
  const loginForm = document.querySelector("#loginForm form");
  if (loginForm) {
    loginForm.addEventListener("submit", handleLoginSubmit);
  }

  // Signup form submission
  const signupForm = document.getElementById("signupFormElement");
  if (signupForm) {
    signupForm.addEventListener("submit", handleSignupSubmit);
  }
}

function handleLoginSubmit(e) {
  // Let the form submit normally to PHP
  const form = e.target;
  const submitBtn = form.querySelector('button[type="submit"]');

  // Show loading state
  setButtonLoading(submitBtn, true);

  // Form will submit to PHP for authentication
  // PHP will handle the redirect on success or show error message
}

function handleSignupSubmit(e) {
  // Let the form submit normally to PHP
  const form = e.target;
  const submitBtn = form.querySelector('button[type="submit"]');

  // Validate all fields
  const inputs = form.querySelectorAll("input[required]");
  let isValid = true;

  inputs.forEach((input) => {
    if (!validateField(input)) {
      isValid = false;
    }
  });

  // Validate password match
  const passwordInput = form.querySelector("#signupPassword");
  const confirmPasswordInput = form.querySelector("#confirmPassword");
  if (passwordInput && confirmPasswordInput) {
    if (!validatePasswordMatch(passwordInput, confirmPasswordInput)) {
      isValid = false;
    }
  }

  if (!isValid) {
    e.preventDefault();
    showNotification("Please fix the errors in the form", "error");
    return;
  }

  // Show loading state
  setButtonLoading(submitBtn, true);

  // Form will submit to PHP for registration
  // PHP will handle the success/error messages
}

// Utility Functions
function setButtonLoading(button, loading) {
  const btnText = button.querySelector(".btn-text");
  const btnLoading = button.querySelector(".btn-loading");

  if (loading) {
    button.classList.add("loading");
    button.disabled = true;
  } else {
    button.classList.remove("loading");
    button.disabled = false;
  }
}

function showNotification(message, type = "info") {
  // Create notification element
  const notification = document.createElement("div");
  notification.className = `auth-notification auth-notification-${type}`;
  notification.innerHTML = `
        <div class="notification-content">
            <i class="bi bi-${
              type === "success"
                ? "check-circle"
                : type === "error"
                ? "exclamation-circle"
                : "info-circle"
            }"></i>
            <span>${message}</span>
        </div>
        <button class="notification-close">
            <i class="bi bi-x"></i>
        </button>
    `;

  // Add to page
  document.body.appendChild(notification);

  // Show notification
  setTimeout(() => {
    notification.classList.add("show");
  }, 100);

  // Auto hide after 5 seconds
  setTimeout(() => {
    hideNotification(notification);
  }, 5000);

  // Close button functionality
  const closeBtn = notification.querySelector(".notification-close");
  closeBtn.addEventListener("click", () => {
    hideNotification(notification);
  });
}

function hideNotification(notification) {
  notification.classList.remove("show");
  setTimeout(() => {
    if (notification.parentNode) {
      notification.parentNode.removeChild(notification);
    }
  }, 300);
}

// Animations
function initializeAnimations() {
  // Add entrance animation to form elements
  const formElements = document.querySelectorAll(
    ".auth-form.active .form-floating, .auth-form.active .user-type-selector, .auth-form.active .btn"
  );

  formElements.forEach((element, index) => {
    element.style.opacity = "0";
    element.style.transform = "translateY(20px)";

    setTimeout(() => {
      element.style.transition = "all 0.5s ease";
      element.style.opacity = "1";
      element.style.transform = "translateY(0)";
    }, 100 + index * 100);
  });
}

// Social Login Handlers
document.addEventListener("DOMContentLoaded", function () {
  const googleBtn = document.querySelector(".btn-outline-secondary");
  if (googleBtn) {
    googleBtn.addEventListener("click", function () {
      showNotification(
        "Google login integration would be implemented here",
        "info"
      );
    });
  }

  // Forgot password handler
  const forgotPasswordLink = document.querySelector(".forgot-password");
  if (forgotPasswordLink) {
    forgotPasswordLink.addEventListener("click", function (e) {
      e.preventDefault();
      showNotification(
        "Password reset functionality would be implemented here",
        "info"
      );
    });
  }
});

// Add notification styles dynamically
const notificationStyles = `
.auth-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    z-index: 1000;
    transform: translateX(400px);
    transition: transform 0.3s ease;
    max-width: 350px;
}

.auth-notification.show {
    transform: translateX(0);
}

.auth-notification-success {
    border-left: 4px solid #198754;
}

.auth-notification-error {
    border-left: 4px solid #dc3545;
}

.auth-notification-info {
    border-left: 4px solid #0dcaf0;
}

.notification-content {
    display: flex;
    align-items: center;
    gap: 8px;
    flex: 1;
}

.notification-content i {
    font-size: 1.2rem;
}

.auth-notification-success .notification-content i {
    color: #198754;
}

.auth-notification-error .notification-content i {
    color: #dc3545;
}

.auth-notification-info .notification-content i {
    color: #0dcaf0;
}

.notification-close {
    background: none;
    border: none;
    color: #666;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: background-color 0.2s ease;
}

.notification-close:hover {
    background-color: #f8f9fa;
}
`;

// Inject notification styles
const styleSheet = document.createElement("style");
styleSheet.textContent = notificationStyles;
document.head.appendChild(styleSheet);
