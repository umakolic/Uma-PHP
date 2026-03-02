<?php

// config.php

declare(strict_types=1);

$host = "localhost";

$db   = "php_mysql_backend";

$user = "root";

$pass = ""; // npr. "root" na MAMP/XAMPP zavisi

$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {

  $pdo = new PDO($dsn, $user, $pass, [

    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

  ]);

} catch (PDOException $e) {

  die("Greška konekcije: " . $e->getMessage());

}

function e(string $s): string {

  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");

}

function redirect(string $to): void {

  header("Location: $to");

  exit;

}
 