<?php
require_once __DIR__ . '/../src/kmr_penghuni.php';

// Proses hapus data
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    deleteKmrPenghuni($id);
    header('Location: ?page=kmr_penghuni');
    exit;
}

// Proses tambah data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $data = [
        'id_kamar' => $_POST['id_kamar'],
        'id_penghuni' => $_POST['id_penghuni'],
        'tgl_masuk' => $_POST['tgl_masuk'],
        'tgl_keluar' => $_POST['tgl_keluar'] ?? null
    ];
    addKmrPenghuni($data);
    header('Location: ?page=kmr_penghuni');
    exit;
}

// Proses edit data
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    foreach (getAllKmrPenghuni() as $row) {
        if ($row['id'] == $id) {
            $editData = $row;
            break;
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $data = [
        'id_kamar' => $_POST['id_kamar'],
        'id_penghuni' => $_POST['id_penghuni'],
        'tgl_masuk' => $_POST['tgl_masuk'],
        'tgl_keluar' => $_POST['tgl_keluar'] ?? null
    ];
    updateKmrPenghuni($id, $data);
    header('Location: ?page=kmr_penghuni');
    exit;
}

$kmr_penghuni = getAllKmrPenghuni();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kamar Penghuni</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
    <a href="?page=admin" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
    <h1>Data Kamar Penghuni</h1>
    <!-- Form tambah kamar-penghuni -->
    <form method="post" class="mb-4">
        <?php if ($editData): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($editData['id']) ?>">
        <?php endif; ?>
        <div class="row g-2 align-items-end">
            <div class="col-md-2">
                <input type="number" name="id_kamar" class="form-control" placeholder="ID Kamar" required value="<?= $editData ? htmlspecialchars($editData['id_kamar']) : '' ?>">
            </div>
            <div class="col-md-2">
                <input type="number" name="id_penghuni" class="form-control" placeholder="ID Penghuni" required value="<?= $editData ? htmlspecialchars($editData['id_penghuni']) : '' ?>">
            </div>
            <div class="col-md-3">
                <input type="date" name="tgl_masuk" class="form-control" required value="<?= $editData ? htmlspecialchars($editData['tgl_masuk']) : '' ?>">
            </div>
            <div class="col-md-3">
                <input type="date" name="tgl_keluar" class="form-control" placeholder="Tgl Keluar" value="<?= $editData ? htmlspecialchars($editData['tgl_keluar']) : '' ?>">
            </div>
            <div class="col-md-2">
                <?php if ($editData): ?>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                    <a href="?page=kmr_penghuni" class="btn btn-secondary">Batal</a>
                <?php else: ?>
                    <button type="submit" name="tambah" class="btn btn-success">Tambah Data</button>
                <?php endif; ?>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Kamar</th>
                <th>ID Penghuni</th>
                <th>Tgl Masuk</th>
                <th>Tgl Keluar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($kmr_penghuni as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['id_kamar']) ?></td>
                <td><?= htmlspecialchars($row['id_penghuni']) ?></td>
                <td><?= htmlspecialchars($row['tgl_masuk']) ?></td>
                <td><?= htmlspecialchars($row['tgl_keluar']) ?></td>
                <td>
                    <a href="?page=kmr_penghuni&edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="?page=kmr_penghuni&hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html> 