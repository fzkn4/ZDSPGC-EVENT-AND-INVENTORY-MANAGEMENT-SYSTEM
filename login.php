<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	header('Location: index.php');
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Login - ZDSPGC EIMS</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
	<link href="style.css" rel="stylesheet" />
</head>
<body class="bg-light">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-12 col-md-6 col-lg-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h1 class="h5 mb-3 text-center">Sign in</h1>
						<form method="post">
							<div class="mb-3">
								<label for="email" class="form-label">Email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required />
							</div>
						<div class="mb-3">
							<label for="password" class="form-label">Password</label>
							<div class="input-group">
								<input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required />
								<button class="input-group-text bg-transparent border-start-0 shadow-none" type="button" id="togglePassword" aria-label="Show password" style="cursor: pointer;">
									<i class="bi bi-eye"></i>
								</button>
							</div>
						</div>
							<button type="submit" class="btn btn-primary w-100">Login</button>
						</form>
						<div class="text-center mt-3">
							<a href="index.php" class="small">Skip and go to Dashboard</a>
						</div>
					</div>
				</div>
				<p class="text-center text-muted small mt-3">ZDSPGC Event & Inventory Management System</p>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<style>
		#togglePassword{
			outline: none !important;
			box-shadow: none !important;
		}
		#togglePassword:hover,
		#togglePassword:active,
		#togglePassword:focus{
			background-color: transparent !important;
		}
	</style>
    <script>
    (function() {
        var toggleBtn = document.getElementById('togglePassword');
        var passwordInput = document.getElementById('password');
        if (!toggleBtn || !passwordInput) return;
        toggleBtn.addEventListener('click', function () {
            var isHidden = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isHidden ? 'text' : 'password');
            var icon = this.querySelector('i');
            if (icon) {
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            }
            this.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
        });
    })();
    </script>
</body>
</html>


