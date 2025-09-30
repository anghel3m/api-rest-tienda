<?php 

$env = parse_ini_file(__DIR__ . '/../.env');

$host = $env['DB_HOST'];
$port = $env['DB_PORT'];
$dbname = $env['DB_NAME'];
$user = $env['DB_USER'];
$pass = $env['DB_PASS'];
$caCertPath = __DIR__ . '/../' . $env['DB_SSL_CA'];

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

    $options = [
        PDO::MYSQL_ATTR_SSL_CA => $caCertPath,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);

} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}
