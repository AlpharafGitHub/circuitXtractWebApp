<?php
// signup.php
require __DIR__ . '/../config/config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($password) >= 6) {
        // Check for existing user
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Email is already registered.';
        } else {
            // Hash & insert
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
            $stmt->execute([$email, $hash]);
            header('Location: login.php?registered=1');
            exit;
        }
    } else {
        $error = 'Enter a valid email and a password of at least 6 characters.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Sign Up | CircuitXtract</title>
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
    .login-link { margin-top: 15px; display: block; text-align: center; color: #4EC5F1; text-decoration: none; }
    .login-link:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <div class="box">
    <h2>Create Account</h2>
    <form method="POST" action="signup.php">
      <label>Email
        <input type="email" name="email" required />
      </label>
      <label>Password
        <input type="password" name="password" minlength="6" required />
      </label>
      <button type="submit">Sign Up</button>
      <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
    </form>
    <a href="login.php" class="login-link">Already have an account? Login</a>
  </div>
</body>
</html>