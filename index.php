<?php
require 'config.php';

$authorize_url = "https://discord.com/api/oauth2/authorize?client_id=$client_id&redirect_uri=" . urlencode($redirect_uri) . "&response_type=code&scope=" . urlencode($scopes);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login dengan Discord</title>
  <style>
    body {
      background: #0e0e0e;
      color: white;
      text-align: center;
      font-family: sans-serif;
      margin-top: 120px;
    }
    a {
      background-color: #5865F2;
      padding: 12px 24px;
      border-radius: 6px;
      color: white;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }
    a:hover {
      background-color: #4752C4;
    }
  </style>
</head>
<body>
  <h1>Login menggunakan Discord</h1>
  <a href="<?php echo $authorize_url; ?>">Login with Discord</a>
</body>
</html>
