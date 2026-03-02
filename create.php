<?php

// create.php

declare(strict_types=1);

require_once __DIR__ . "/config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") redirect("index.php");

$ime = trim((string)($_POST["ime"] ?? ""));

$prezime = trim((string)($_POST["prezime"] ?? ""));

$email = trim((string)($_POST["email"] ?? ""));

if ($ime === "" || $prezime === "" || $email === "") {

  redirect("index.php?msg=" . urlencode("Sva polja su obavezna."));

}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

  redirect("index.php?msg=" . urlencode("Email nije validan."));

}

try {

  $stmt = $pdo->prepare("INSERT INTO users (ime, prezime, email) VALUES (:ime, :prezime, :email)");

  $stmt->execute([

    ":ime" => $ime,

    ":prezime" => $prezime,

    ":email" => $email

  ]);

  redirect("index.php?msg=" . urlencode("Korisnik je dodat."));

} catch (PDOException $e) {

  // najčešće: dupli email

  redirect("index.php?msg=" . urlencode("Greška: email već postoji ili problem sa bazom."));

}
 