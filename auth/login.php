<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

// Include config and database
require_once __DIR__ . '/../db/app.php';      // defines BASE_URL
require_once __DIR__ . '/../db/database.php'; // PDO $pdo

$error = '';
$email = '';

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = trim($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            $error = "Email and password are required.";
        } else {

            // Fetch user based on your table structure
            $stmt = $pdo->prepare("
                SELECT user_id, full_name, email, password_hash, role 
                FROM users 
                WHERE email = :email
                LIMIT 1
            ");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            // Verify user exists and password matches
            if (!$user || !password_verify($password, $user['password_hash'])) {
                $error = "Invalid email or password.";
            } else {

                // Login success
                session_regenerate_id(true);

                // Store user info
                $_SESSION['user'] = [
                    'user_id' => (int)$user['user_id'],
                    'email'   => $user['email'],
                    'role'    => $user['role'],
                    'name'    => $user['full_name'],
                ];

                // Make user ID compatible with older cart code
                $_SESSION['customerID'] = (int)$user['user_id'];

                // ---------------- Merge guest session cart into DB ----------------
                if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                    $user_id = $_SESSION['user']['user_id'];
                    foreach ($_SESSION['cart'] as $item) {
                        $stmt = $pdo->prepare("
                            INSERT INTO carts (user_id, product_id, quantity) 
                            VALUES (?, ?, ?)
                            ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity), updated_at = NOW()
                        ");
                        $stmt->execute([
                            $user_id,
                            $item['product_id'],
                            $item['quantity']
                        ]);
                    }
                    unset($_SESSION['cart']); // clear guest cart after merging
                }

                
                // ------------------------------------------------------------

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header("Location: " . BASE_URL . "/views/admin/dashboard.php");
                } else {
                    header("Location: " . BASE_URL . "/account/index.php");
                }
                exit;
            }
        }
    }
}

// ================= INCLUDE HEADER =================
include __DIR__ . '/../views/header.php';
?>

<!-- ================= LOGIN SECTION ================= -->
<section class="login-section d-flex align-items-center justify-content-center py-5" style="min-height:80vh; background:#f8f9fa;">
  <div class="card shadow-lg rounded-4 p-4" style="max-width:450px; width:100%; background:#111;">
    
    <h2 class="text-center fw-bold mb-3" style="font-family:'Playfair Display', serif; color:gold;">Login</h2>
    <p class="text-center text-light mb-4">
      Welcome back to <span class="fw-bold text-gold">Shahizewer</span>
    </p>

    <?php if ($error): ?>
      <div class="alert alert-danger rounded-3">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="post" autocomplete="off">

      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

      <div class="mb-3">
        <label class="form-label fw-semibold text-light">Email</label>
        <input type="email" name="email" class="form-control form-control-lg rounded-pill" value="<?= htmlspecialchars($email) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold text-light">Password</label>
        <input type="password" name="password" class="form-control form-control-lg rounded-pill" required>
      </div>

      <button type="submit" class="btn-gold w-100 fw-bold py-2">

        Login
      </button>
    </form>

    <p class="mt-4 text-center text-light opacity-75">
      No account? 
      <a href="<?= BASE_URL ?>/auth/signup.php" class="text-gold fw-semibold text-decoration-none">Sign up</a>
    </p>

  </div>
</section>

<style>
.login-section::before {
    content: "";
    position: absolute;
    inset: 0;
    background: url('<?= BASE_URL ?>/assets/images/sparkles.png') repeat;
    opacity: 0.05;
    z-index: 0;
}
.login-card {
    position: relative;
    z-index: 1;
}
</style>

<?php
// ================= INCLUDE FOOTER =================
include __DIR__ . '/../views/footer.php';
?>
