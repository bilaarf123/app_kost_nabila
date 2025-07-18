<?php
require_once __DIR__ . '/../src/bayar.php';

// Proses hapus data
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    deleteBayar($id);
    header('Location: ?page=bayar');
    exit;
}

// Proses edit data
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    foreach (getAllBayar() as $row) {
        if ($row['id'] == $id) {
            $editData = $row;
            break;
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $data = [
        'id_tagihan' => $_POST['id_tagihan'],
        'jml_bayar' => $_POST['jml_bayar'],
        'status' => $_POST['status']
    ];
    updateBayar($id, $data);
    header('Location: ?page=bayar');
    exit;
}

// Proses tambah data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $data = [
        'id_tagihan' => $_POST['id_tagihan'],
        'jml_bayar' => $_POST['jml_bayar'],
        'status' => $_POST['status']
    ];
    addBayar($data);
    header('Location: ?page=bayar');
    exit;
}

$bayar = getAllBayar();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembayaran</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
    <a href="?page=admin" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
    <h1>Data Pembayaran</h1>
    <!-- Form tambah/edit pembayaran -->
    <form method="post" class="mb-4">
        <?php if ($editData): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($editData['id']) ?>">
        <?php endif; ?>
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <input type="number" name="id_tagihan" class="form-control" placeholder="ID Tagihan" required value="<?= $editData ? htmlspecialchars($editData['id_tagihan']) : '' ?>">
            </div>
            <div class="col-md-3">
                <input type="number" name="jml_bayar" class="form-control" placeholder="Jumlah Bayar" required value="<?= $editData ? htmlspecialchars($editData['jml_bayar']) : '' ?>">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control" required>
                    <option value="">Status</option>
                    <option value="cicil" <?= $editData && $editData['status'] == 'cicil' ? 'selected' : '' ?>>Cicil</option>
                    <option value="lunas" <?= $editData && $editData['status'] == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                </select>
            </div>
            <div class="col-md-2">
                <?php if ($editData): ?>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                    <a href="?page=bayar" class="btn btn-secondary">Batal</a>
                <?php else: ?>
                    <button type="submit" name="tambah" class="btn btn-success">Tambah Pembayaran</button>
                <?php endif; ?>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Tagihan</th>
                <th>Jumlah Bayar</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($bayar as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['id_tagihan']) ?></td>
                <td><?= htmlspecialchars($row['jml_bayar']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td>
                    <a href="?page=bayar&edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="?page=bayar&hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html> 