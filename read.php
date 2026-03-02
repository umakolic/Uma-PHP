<?php

// read.php

declare(strict_types=1);

require_once __DIR__ . "/config.php";

$search = trim((string)($_GET["search"] ?? ""));

$page = max(1, (int)($_GET["page"] ?? 1));

$perPage = 5;

$offset = ($page - 1) * $perPage;

$where = "";

$params = [];

if ($search !== "") {

  $where = "WHERE ime LIKE :q OR prezime LIKE :q OR email LIKE :q";

  $params[":q"] = "%$search%";

}

// count

$stmtCount = $pdo->prepare("SELECT COUNT(*) AS cnt FROM users $where");

$stmtCount->execute($params);

$total = (int)$stmtCount->fetch()["cnt"];

$totalPages = max(1, (int)ceil($total / $perPage));

// list

$sql = "SELECT * FROM users $where ORDER BY id DESC LIMIT :lim OFFSET :off";

$stmt = $pdo->prepare($sql);

foreach ($params as $k => $v) $stmt->bindValue($k, $v, PDO::PARAM_STR);

$stmt->bindValue(":lim", $perPage, PDO::PARAM_INT);

$stmt->bindValue(":off", $offset, PDO::PARAM_INT);

$stmt->execute();

$users = $stmt->fetchAll();
 