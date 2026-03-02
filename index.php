<?php

// index.php

require_once __DIR__ . "/read.php"; // dobije: $users, $search, $page, $totalPages, $total

?>
<!doctype html>
<html lang="bs">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>php-mysql-backend | CRUD</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
</head>
<body class="bg-light">
<div class="container py-4">
<div class="d-flex justify-content-between align-items-center mb-3">
<h2 class="mb-0">User Management (CRUD)</h2>
<span class="badge bg-secondary">Ukupno: <?php echo (int)$total; ?></span>
</div>
<?php if (!empty($_GET["msg"])): ?>
<div class="alert alert-info"><?php echo e((string)$_GET["msg"]); ?></div>
<?php endif; ?>
<div class="row g-3">
<div class="col-md-4">
<div class="card shadow-sm">
<div class="card-body">
<h5 class="card-title">Dodaj korisnika</h5>
<form method="post" action="create.php" novalidate>
<div class="mb-2">
<label class="form-label">Ime</label>
<input name="ime" class="form-control" required>
</div>
<div class="mb-2">
<label class="form-label">Prezime</label>
<input name="prezime" class="form-control" required>
</div>
<div class="mb-3">
<label class="form-label">Email</label>
<input name="email" type="email" class="form-control" required>
</div>
<button class="btn btn-primary w-100">Sačuvaj</button>
</form>
</div>
</div>
</div>
<div class="col-md-8">
<div class="card shadow-sm">
<div class="card-body">
<div class="d-flex gap-2 justify-content-between align-items-center mb-3">
<form class="d-flex gap-2" method="get" action="index.php">
<input class="form-control" name="search" placeholder="Pretraga..." value="<?php echo e($search); ?>">
<button class="btn btn-outline-primary">Traži</button>
<a class="btn btn-outline-secondary" href="index.php">Reset</a>
</form>
</div>
<div class="table-responsive">
<table class="table table-striped align-middle">
<thead>
<tr>
<th>ID</th>
<th>Ime</th>
<th>Prezime</th>
<th>Email</th>
<th>Kreiran</th>
<th>Akcija</th>
</tr>
</thead>
<tbody>
<?php if (!$users): ?>
<tr><td colspan="6" class="text-center text-muted">Nema korisnika.</td></tr>
<?php else: ?>
<?php foreach ($users as $u): ?>
<tr>
<td><?php echo (int)$u["id"]; ?></td>
<td><?php echo e($u["ime"]); ?></td>
<td><?php echo e($u["prezime"]); ?></td>
<td><?php echo e($u["email"]); ?></td>
<td><?php echo e($u["created_at"]); ?></td>
<td class="text-nowrap">
<a class="btn btn-sm btn-warning" href="update.php?id=<?php echo (int)$u["id"]; ?>">Edit</a>
<form class="d-inline" method="post" action="delete.php" onsubmit="return confirmDelete();">
<input type="hidden" name="id" value="<?php echo (int)$u["id"]; ?>">
<button class="btn btn-sm btn-danger">Delete</button>
</form>
</td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
</div>
<nav>
<ul class="pagination mb-0">
<?php

                $q = ($search !== "") ? "&search=" . urlencode($search) : "";

              ?>
<li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
<a class="page-link" href="index.php?page=<?php echo max(1, $page-1).$q; ?>">Prethodna</a>
</li>
<?php for ($p=1; $p <= $totalPages; $p++): ?>
<li class="page-item <?php echo $p === $page ? 'active' : ''; ?>">
<a class="page-link" href="index.php?page=<?php echo $p.$q; ?>"><?php echo $p; ?></a>
</li>
<?php endfor; ?>
<li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
<a class="page-link" href="index.php?page=<?php echo min($totalPages, $page+1).$q; ?>">Sljedeća</a>
</li>
</ul>
</nav>
</div>
</div>
</div>
</div>
</div>
<script src="assets/script.js"></script>
</body>
</html>
 