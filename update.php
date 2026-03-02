<?php

// update.php

declare(strict_types=1);

require_once __DIR__ . "/config.php";

$id = (int)($_GET["id"] ?? 0);

if ($id <= 0) redirect("index.php?msg=" . urlencode("Neispravan ID."));

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");

$stmt->execute([":id" => $id]);

$user = $stmt->fetch();

if (!$user) redirect("index.php?msg=" . urlencode("Korisnik ne postoji."));

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $ime = trim((string)($_POST["ime"] ?? ""));

  $prezime = trim((string)($_POST["prezime"] ?? ""));

  $email = trim((string)($_POST["email"] ?? ""));

  if ($ime === "" || $prezime === "" || $email === "") {

    redirect("update.php?id=$id&msg=" . urlencode("Sva polja su obavezna."));

  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    redirect("update.php?id=$id&msg=" . urlencode("Email nije validan."));

  }

  try {

    $up = $pdo->prepare("UPDATE users SET ime=:ime, prezime=:prezime, email=:email WHERE id=:id");

    $up->execute([

      ":ime" => $ime,

      ":prezime" => $prezime,

      ":email" => $email,

      ":id" => $id

    ]);

    redirect("index.php?msg=" . urlencode("Korisnik je ažuriran."));

  } catch (PDOException $e) {

    redirect("update.php?id=$id&msg=" . urlencode("Greška: email već postoji ili problem sa bazom."));

  }

}

$msg = (string)($_GET["msg"] ?? "");

?>
<!doctype html>
<html lang="bs">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Edit korisnika</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
</head>
<body class="bg-light">
<div class="container py-4" style="max-width: 600px;">
<h3 class="mb-3">Edit korisnika #<?php echo (int)$user["id"]; ?></h3>
<?php if ($msg !== ""): ?>
<div class="alert alert-warning"><?php echo e($msg); ?></div>
<?php endif; ?>
<div class="card shadow-sm">
<div class="card-body">
<form method="post">
<div class="mb-2">
<label class="form-label">Ime</label>
<input name="ime" class="form-control" value="<?php echo e($user["ime"]); ?>" required>
</div>
<div class="mb-2">
<label class="form-label">Prezime</label>
<input name="prezime" class="form-control" value="<?php echo e($user["prezime"]); ?>" required>
</div>
<div class="mb-3">
<label class="form-label">Email</label>
<input name="email" type="email" class="form-control" value="<?php echo e($user["email"]); ?>" required>
</div>
<div class="d-flex gap-2">
<button class="btn btn-primary">Sačuvaj</button>
<a class="btn btn-secondary" href="index.php">Nazad</a>
</div>
</form>
</div>
</div>
</div>
</body>
</html>
 