<?php
require_once __DIR__ . '/../src/dashboard_info.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Proses login admin dari modal
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_admin'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: ?page=admin');
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
$kamarKosong = getKamarKosong();
$kamarJatuhTempo = getKamarJatuhTempo();
$kamarTerlambat = getKamarTerlambatBayar();
function format_rupiah($angka) {
    return number_format($angka, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Depan Kost eklusive Nabila</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(rgba(255,255,255,0.85), rgba(255,255,255,0.92)), url('/app_kost_nabila/assets/depan.jpeg') center 80px no-repeat;
            background-size: contain;
            background-attachment: fixed;
        }
        td, th { white-space: nowrap; }
        .card-body { padding: 1rem 0.5rem 1rem 0.5rem; }
        .navbar-gradient {
            background: linear-gradient(90deg, #fff 0%, #f3f3f3 100%);
            border-bottom: 1px solid #e0e0e0;
        }
        .main-title {
            font-size: 2.2rem;
            font-weight: bold;
            text-align: center;
            margin-top: 1.5rem;
            margin-bottom: 0.2rem;
            color: #222;
        }
        .main-address {
            text-align: center;
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }
        @media (max-width: 768px) {
            body {
                background-size: cover;
                background-position: center 100px;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-gradient mb-4">
  <div class="container-fluid">
    <a class="navbar-brand text-dark fw-bold" href="?page=home">Welcome</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <button class="btn btn-outline-primary px-3" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="bi bi-person-lock"></i> Login Admin</button>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
    <div class="main-title">Kost eklusive Nabila</div>
    <div class="main-address">Jln. Majalaya-Cikawo No.12.</div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-house-door-fill me-2"></i>Kamar Kosong
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead><tr><th>Nomor</th><th>Harga</th></tr></thead>
                            <tbody>
                            <?php foreach($kamarKosong as $kamar): ?>
                                <tr>
                                    <td><?= htmlspecialchars($kamar['nomor']) ?></td>
                                    <td>Rp<?= format_rupiah($kamar['harga']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-clock-history me-2"></i>Kamar Jatuh Tempo Tagihan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead><tr><th>Nomor</th><th>Nama Penghuni</th><th>Bulan</th><th>Jumlah Tagihan</th></tr></thead>
                            <tbody>
                            <?php foreach($kamarJatuhTempo as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nomor']) ?></td>
                                    <td><?= htmlspecialchars($row['nama']) ?></td>
                                    <td><?= htmlspecialchars($row['bulan']) ?></td>
                                    <td><span class="badge bg-info text-dark">Rp<?= format_rupiah($row['jml_tagihan']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Kamar Terlambat Bayar
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead><tr><th>Nomor</th><th>Nama Penghuni</th><th>Bulan</th><th>Jumlah Tagihan</th></tr></thead>
                            <tbody>
                            <?php foreach($kamarTerlambat as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nomor']) ?></td>
                                    <td><?= htmlspecialchars($row['nama']) ?></td>
                                    <td><?= htmlspecialchars($row['bulan']) ?></td>
                                    <td><span class="badge bg-danger">Rp<?= format_rupiah($row['jml_tagihan']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Login Admin -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel"><i class="bi bi-person-lock"></i> Login Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post">
        <div class="modal-body">
          <?php if ($error): ?>
            <div class="alert alert-danger py-2"><?= $error ?></div>
          <?php endif; ?>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required autofocus>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" name="login_admin" class="btn btn-primary">Login</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 