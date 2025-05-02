<?php
// logout.php

// 1) Expire the cookie by setting its timestamp in the past
setcookie('user', '', time() - 3600, '/');

// 2) (Optional) Make sure PHP’s superglobal is empty
unset($_COOKIE['user']);

// 3) Redirect back to your landing page (or login page)
header('Location: ../landing_page.html');
exit;
