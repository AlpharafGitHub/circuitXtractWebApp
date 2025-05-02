<?php
// login.php
require __DIR__ . '/config.php';

$error   = '';
$success = '';
if (isset($_GET['registered'])) {
    $success = 'Account created. Please log in.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Fetch user by email
    $stmt = $pdo->prepare('SELECT id,password FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Successful login
        setcookie('user', $user['id'], time() + 3600, '/');
        header('Location: Dashboard/admin_dashboard.php');
        exit;
    } else {
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Login | Analytics Pro</title>
  <style>
    body{display:flex;justify-content:center;align-items:center;
      height:100vh;background:#2E2E30;color:#EEE;font-family:Arial,sans-serif;}
    .box{background:rgba(255,255,255,0.1);padding:30px;border-radius:10px;width:300px;}
    h2{margin-bottom:20px;}
    label{display:block;margin-bottom:10px;}
    input{width:100%;padding:8px;margin-top:5px;border:none;border-radius:5px;}
    button{width:100%;padding:10px;margin-top:20px;
      background:#4EC5F1;border:none;border-radius:5px;color:#1C1C1E;cursor:pointer;}
    .error{color:#E63946;margin-top:10px;}
    .success{color:#A8DADC;margin-bottom:10px;}
    p{margin-top:15px;text-align:center;}
    p a{color:#4EC5F1;text-decoration:none;}
  </style>
</head>
<body>
  <div class="box">
    <h2>Login</h2>
    <?php if($success): ?>
      <div class="success"><?=htmlspecialchars($success)?></div>
    <?php endif; ?>
    <form method="POST" action="login.php">
      <label>Email
        <input type="email" name="email" required />
      </label>
      <label>Password
        <input type="password" name="password" required />
      </label>
      <button type="submit">Sign In</button>
      <?php if($error): ?>
        <div class="error"><?=htmlspecialchars($error)?></div>
      <?php endif; ?>
    </form>
    <p>No account? <a href="signup.php">Sign Up</a></p>
  </div>
</body>
</html>
