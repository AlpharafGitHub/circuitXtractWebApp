<?php
// login.php
require __DIR__ . '/../config/config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
        // Check user credentials
        $stmt = $pdo->prepare('SELECT id, password FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Set a secure cookie
            setcookie('user', $user['id'], [
                'expires' => time() + 3600, // 1 hour
                'path' => '/',
                'secure' => true, // Ensure the cookie is only sent over HTTPS
                'httponly' => true, // Prevent JavaScript access to the cookie
                'samesite' => 'Strict' // Prevent cross-site request forgery
            ]);
            // Redirect to the dashboard
            header('Location: /CircuitXtract/public/dashboard/admin_dashboard.php');
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    } else {
        $error = 'Enter a valid email and password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Login | CircuitXtract</title>
  <style>
    body {
      display: flex; justify-content: center; align-items: center;
      height: 100vh; background: #2E2E30; color: #EEE; font-family: Arial, sans-serif;
    }
    .box {
      background: rgba(255, 255, 255, 0.1); padding: 30px; border-radius: 10px; width: 300px;
    }
    h2 { margin-bottom: 20px; }
    label { display: block; margin-bottom: 10px; }
    input {
      width: 100%; padding: 8px; margin-top: 5px; border: none; border-radius: 5px;
    }
    button {
      width: 100%; padding: 10px; margin-top: 20px;
      background: #4EC5F1; border: none; border-radius: 5px; color: #1C1C1E; cursor: pointer;
    }
    .error { color: #E63946; margin-top: 10px; }
    .signup-link { margin-top: 15px; display: block; text-align: center; color: #4EC5F1; text-decoration: none; }
    .signup-link:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <div class="box">
    <h2>Login</h2>
    <form method="POST" action="login.php">
      <label>Email
        <input type="email" name="email" required />
      </label>
      <label>Password
        <input type="password" name="password" required />
      </label>
      <button type="submit">Login</button>
      <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
    </form>
    <a href="signup.php" class="signup-link">Don't have an account? Sign Up</a>
  </div>
</body>
</html>