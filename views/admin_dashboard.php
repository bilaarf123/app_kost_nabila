<?php
require_once __DIR__ . '/../src/dashboard_info.php';
$kamarKosong = getKamarKosong();
$kamarJatuhTempo = getKamarJatuhTempo();
$kamarTerlambat = getKamarTerlambatBayar();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard Kost Nabila</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(120deg, #fbeee6 0%, #fff7f0 100%);
        }
        .dashboard-title {
            font-size: 2rem;
            font-weight: bold;
            color: #a05a2c;
            text-align: center;
            margin-top: 1.5rem;
            margin-bottom: 0.2rem;
        }
        .dashboard-subtitle {
            text-align: center;
            color: #a05a2c;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }
        .card-dashboard {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 2px 12px 0 rgba(160,90,44,0.08);
        }
        .card-header {
            font-weight: bold;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
        }
        .card-header.bg-brown {
            background: #a05a2c;
            color: #fff;
        }
        .card-header.bg-orange {
            background: #ff8800;
            color: #fff;
        }
        .card-header.bg-lightbrown {
            background: #fbeee6;
            color: #a05a2c;
        }
        .card-header.bg-brown-strong {
            background: #a05a2c;
            color: #fff;
        }
        .icon-section {
            font-size: 1.5rem;
            margin-right: 0.5rem;
        }
        .btn-dashboard {
            background: #ff8800;
            color: #fff;
            border: none;
            margin-right: 0.5rem;
        }
        .btn-dashboard:hover {
            background: #a05a2c;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="dashboard-title"><i class="bi bi-person-badge-fill"></i> Admin Dashboard Nabila</div>
        <a href="?page=logout" class="btn btn-dashboard">Logout <i class="bi bi-box-arrow-right"></i></a>
    </div>
    <div class="dashboard-subtitle">Selamat datang di dashboard admin Kost Nabila. Kelola data dan monitoring dengan mudah!</div>
    <nav class="mb-3 d-flex flex-wrap gap-2 justify-content-center">
        <a href="?page=penghuni" class="btn btn-dashboard"><i class="bi bi-people-fill"></i> Penghuni</a>
        <a href="?page=kamar" class="btn btn-dashboard"><i class="bi bi-door-closed-fill"></i> Kamar</a>
        <a href="?page=barang" class="btn btn-dashboard"><i class="bi bi-box-seam"></i> Barang</a>
        <a href="?page=tagihan" class="btn btn-dashboard"><i class="bi bi-receipt"></i> Tagihan</a>
        <a href="?page=bayar" class="btn btn-dashboard"><i class="bi bi-cash-coin"></i> Pembayaran</a>
        <a href="?page=kmr_penghuni" class="btn btn-dashboard"><i class="bi bi-arrow-left-right"></i> Kamar-Penghuni</a>
        <a href="?page=brng_bawaan" class="btn btn-dashboard"><i class="bi bi-bag-check"></i> Barang Bawaan</a>
    </nav>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-dashboard">
                <div class="card-header bg-brown-strong">
                    <span class="icon-section"><i class="bi bi-house-heart-fill text-warning"></i></span> Kamar Kosong
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead><tr><th>Nomor</th><th>Harga</th></tr></thead>
                            <tbody>
                            <?php foreach($kamarKosong as $kamar): ?>
                                <tr>
                                    <td><?= htmlspecialchars($kamar['nomor']) ?></td>
                                    <td><?= htmlspecialchars($kamar['harga']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-dashboard">
                <div class="card-header bg-orange">
                    <span class="icon-section"><i class="bi bi-clock-history"></i></span> Kamar Jatuh Tempo Tagihan
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
                                    <td><span class="badge bg-warning text-dark">Rp<?= htmlspecialchars($row['jml_tagihan']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-dashboard">
                <div class="card-header bg-brown">
                    <span class="icon-section"><i class="bi bi-exclamation-triangle-fill"></i></span> Kamar Terlambat Bayar
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
                                    <td><span class="badge bg-brown text-white" style="background:#a05a2c;">Rp<?= htmlspecialchars($row['jml_tagihan']) ?></span></td>
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
</body>
</html> 