<?php 

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$caCertPath = __DIR__ . '/ca.pem';


try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

    $options = [
        PDO::MYSQL_ATTR_SSL_CA => $caCertPath,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);

    return $pdo;

} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}
