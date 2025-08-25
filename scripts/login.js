(function () {
  var toggleBtn = document.getElementById("togglePassword");
  var passwordInput = document.getElementById("password");
  if (!toggleBtn || !passwordInput) return;
  toggleBtn.addEventListener("click", function () {
    var isHidden = passwordInput.getAttribute("type") === "password";
    passwordInput.setAttribute("type", isHidden ? "text" : "password");
    var icon = this.querySelector("i");
    if (icon) {
      icon.classList.toggle("bi-eye");
      icon.classList.toggle("bi-eye-slash");
    }
    this.setAttribute(
      "aria-label",
      isHidden ? "Hide password" : "Show password"
    );
  });
})();
