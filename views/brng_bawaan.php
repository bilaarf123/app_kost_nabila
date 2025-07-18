<?php
require_once __DIR__ . '/../src/brng_bawaan.php';

// Proses hapus data
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    deleteBrngBawaan($id);
    header('Location: ?page=brng_bawaan');
    exit;
}

// Proses tambah data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $data = [
        'id_penghuni' => $_POST['id_penghuni'],
        'id_barang' => $_POST['id_barang']
    ];
    addBrngBawaan($data);
    header('Location: ?page=brng_bawaan');
    exit;
}

// Proses edit data
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    foreach (getAllBrngBawaan() as $row) {
        if ($row['id'] == $id) {
            $editData = $row;
            break;
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $data = [
        'id_penghuni' => $_POST['id_penghuni'],
        'id_barang' => $_POST['id_barang']
    ];
    updateBrngBawaan($id, $data);
    header('Location: ?page=brng_bawaan');
    exit;
}

$brng_bawaan = getAllBrngBawaan();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang Bawaan</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
    <a href="?page=admin" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
    <h1>Data Barang Bawaan</h1>
    <!-- Form tambah barang bawaan -->
    <form method="post" class="mb-4">
        <?php if ($editData): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($editData['id']) ?>">
        <?php endif; ?>
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <input type="number" name="id_penghuni" class="form-control" placeholder="ID Penghuni" required value="<?= $editData ? htmlspecialchars($editData['id_penghuni']) : '' ?>">
            </div>
            <div class="col-md-3">
                <input type="number" name="id_barang" class="form-control" placeholder="ID Barang" required value="<?= $editData ? htmlspecialchars($editData['id_barang']) : '' ?>">
            </div>
            <div class="col-md-2">
                <?php if ($editData): ?>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                    <a href="?page=brng_bawaan" class="btn btn-secondary">Batal</a>
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
                <th>ID Penghuni</th>
                <th>ID Barang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($brng_bawaan as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['id_penghuni']) ?></td>
                <td><?= htmlspecialchars($row['id_barang']) ?></td>
                <td>
                    <a href="?page=brng_bawaan&edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="?page=brng_bawaan&hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html> 