<?php

// delete.php

declare(strict_types=1);

require_once __DIR__ . "/config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") redirect("index.php");

$id = (int)($_POST["id"] ?? 0);

if ($id <= 0) redirect("index.php?msg=" . urlencode("Neispravan ID."));

$stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");

$stmt->execute([":id" => $id]);

redirect("index.php?msg=" . urlencode("Korisnik je obrisan."));
 