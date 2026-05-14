<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

// Include config and database
require_once __DIR__ . '/../db/app.php';
require_once __DIR__ . '/../db/database.php';

$error = '';
$full_name = '';
$email = '';

// CSRF token generate
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF validation
    $csrf = $_POST['csrf_token'] ?? '';
    if (!$csrf || $csrf !== $_SESSION['csrf_token']) {
        $error = "Invalid request. Please refresh and try again.";
    } else {

        $full_name = trim($_POST['full_name'] ?? '');
        $email     = strtolower(trim($_POST['email'] ?? ''));
        $password  = trim($_POST['password'] ?? '');
        $confirm   = trim($_POST['confirm_password'] ?? '');

        // Basic validation
        if ($full_name === '' || $email === '' || $password === '' || $confirm === '') {
            $error = "All fields are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email address.";
        } elseif ($password !== $confirm) {
            $error = "Passwords do not match.";
        } else {

            // Check if email already exists
            $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            if ($stmt->fetch()) {
                $error = "Email already registered.";
            } else {

                // Hash password
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                // Insert user
                $stmt = $pdo->prepare("
                    INSERT INTO users (full_name, email, password_hash, role)
                    VALUES (:full_name, :email, :hash, :role)
                ");
                $stmt->execute([
                    'full_name' => $full_name,
                    'email'     => $email,
                    'hash'      => $password_hash,
                    'role'      => 'customer' // default role
                ]);

                // Redirect to login
                header("Location: " . BASE_URL . "/auth/login.php?registered=1");
                exit;
            }
        }
    }
}

// Include header
include __DIR__ . '/../views/header.php';
?>

<!-- ================= SIGNUP SECTION ================= -->
<section class="signup-section d-flex align-items-center justify-content-center py-5" style="min-height:80vh; background:#f8f9fa;">
  <div class="card shadow-lg rounded-4 p-4" style="max-width:450px; width:100%; background:#111;">
    
    <h2 class="text-center fw-bold mb-3" style="font-family:'Playfair Display', serif; color:gold;">Sign Up</h2>
    <p class="text-center text-light mb-4">
      Create your <span class="fw-bold text-gold">Shahizewer</span> account
    </p>

    <?php if ($error): ?>
      <div class="alert alert-danger rounded-3">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="post" autocomplete="off">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

      <div class="mb-3">
        <label class="form-label fw-semibold text-light">Full Name</label>
        <input type="text" name="full_name" class="form-control form-control-lg rounded-pill" value="<?= htmlspecialchars($full_name) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold text-light">Email</label>
        <input type="email" name="email" class="form-control form-control-lg rounded-pill" value="<?= htmlspecialchars($email) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold text-light">Password</label>
        <input type="password" name="password" class="form-control form-control-lg rounded-pill" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold text-light">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control form-control-lg rounded-pill" required>
      </div>

      <button type="submit" class="btn btn-gold w-100 fw-bold py-2 rounded-pill">Sign Up</button>
    </form>

    <p class="mt-4 text-center text-light opacity-75">
      Already have an account? 
      <a href="<?= BASE_URL ?>/auth/login.php" class="text-gold fw-semibold text-decoration-none">Login</a>
    </p>

  </div>
</section>

<?php
include __DIR__ . '/../views/footer.php';
?>
