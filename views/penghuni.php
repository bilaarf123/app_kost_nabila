<?php
require_once __DIR__ . '/../src/penghuni.php';

// Proses hapus data
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    deletePenghuni($id);
    header('Location: ?page=penghuni');
    exit;
}

// Proses edit data
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    foreach (getAllPenghuni() as $row) {
        if ($row['id'] == $id) {
            $editData = $row;
            break;
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $data = [
        'nama' => $_POST['nama'],
        'no_ktp' => $_POST['no_ktp'],
        'no_hp' => $_POST['no_hp'],
        'tgl_masuk' => $_POST['tgl_masuk'],
        'tgl_keluar' => $_POST['tgl_keluar'] ?? null
    ];
    updatePenghuni($id, $data);
    header('Location: ?page=penghuni');
    exit;
}

// Proses tambah data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $data = [
        'nama' => $_POST['nama'],
        'no_ktp' => $_POST['no_ktp'],
        'no_hp' => $_POST['no_hp'],
        'tgl_masuk' => $_POST['tgl_masuk']
    ];
    addPenghuni($data);
    header('Location: ?page=penghuni');
    exit;
}

$penghuni = getAllPenghuni();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penghuni</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
    <a href="?page=admin" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
    <h1>Data Penghuni</h1>
    <!-- Form tambah/edit penghuni -->
    <form method="post" class="mb-4">
        <?php if ($editData): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($editData['id']) ?>">
        <?php endif; ?>
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <input type="text" name="nama" class="form-control" placeholder="Nama" required value="<?= $editData ? htmlspecialchars($editData['nama']) : '' ?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="no_ktp" class="form-control" placeholder="No KTP" required value="<?= $editData ? htmlspecialchars($editData['no_ktp']) : '' ?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="no_hp" class="form-control" placeholder="No HP" required value="<?= $editData ? htmlspecialchars($editData['no_hp']) : '' ?>">
            </div>
            <div class="col-md-2">
                <input type="date" name="tgl_masuk" class="form-control" required value="<?= $editData ? htmlspecialchars($editData['tgl_masuk']) : '' ?>">
            </div>
            <div class="col-md-2">
                <input type="date" name="tgl_keluar" class="form-control" placeholder="Tgl Keluar" value="<?= $editData ? htmlspecialchars($editData['tgl_keluar']) : '' ?>">
            </div>
            <div class="col-md-1">
                <?php if ($editData): ?>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                    <a href="?page=penghuni" class="btn btn-secondary">Batal</a>
                <?php else: ?>
                    <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                <?php endif; ?>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>No KTP</th>
                <th>No HP</th>
                <th>Tgl Masuk</th>
                <th>Tgl Keluar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($penghuni as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['no_ktp']) ?></td>
                <td><?= htmlspecialchars($row['no_hp']) ?></td>
                <td><?= htmlspecialchars($row['tgl_masuk']) ?></td>
                <td><?= htmlspecialchars($row['tgl_keluar']) ?></td>
                <td>
                    <a href="?page=penghuni&edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="?page=penghuni&hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html> 