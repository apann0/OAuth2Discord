<?php
require 'config.php';
require 'db.php';

if (!isset($_GET['code'])) {
    die('Error: tidak ada kode OAuth');
}

$code = $_GET['code'];

// Tukar code dengan access token
$data = [
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'grant_type' => 'authorization_code',
    'code' => $code,
    'redirect_uri' => $redirect_uri,
    'scope' => 'identify email'
];

$opts = [
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/x-www-form-urlencoded",
        'content' => http_build_query($data)
    ]
];

$context  = stream_context_create($opts);
$response = file_get_contents('https://discord.com/api/oauth2/token', false, $context);
$token = json_decode($response, true);

if (!isset($token['access_token'])) {
    die("Gagal mendapatkan access token");
}

// Ambil data user dari Discord API
$opts = [
    'http' => [
        'method' => 'GET',
        'header' => "Authorization: Bearer " . $token['access_token']
    ]
];

$context  = stream_context_create($opts);
$user = file_get_contents('https://discord.com/api/users/@me', false, $context);
$user = json_decode($user, true);

// Simpan ke database
$stmt = $pdo->prepare("INSERT INTO users (discord_id, username, discriminator, email, avatar)
    VALUES (?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
    username = VALUES(username),
    discriminator = VALUES(discriminator),
    email = VALUES(email),
    avatar = VALUES(avatar)");

$stmt->execute([
    $user['id'],
    $user['username'],
    $user['discriminator'],
    $user['email'] ?? '',
    $user['avatar']
]);

// Tampilkan profil user
echo "<h2>Halo, {$user['username']}#{$user['discriminator']}!</h2>";
echo "<img src='https://cdn.discordapp.com/avatars/{$user['id']}/{$user['avatar']}.png' width='120' style='border-radius:50%;'><br>";
echo "<p>Email: {$user['email']}</p>";
echo "<p>ID Discord: {$user['id']}</p>";
echo "<hr><a href='index.php'>Kembali</a>";
