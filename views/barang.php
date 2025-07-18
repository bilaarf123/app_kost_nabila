<?php
require_once __DIR__ . '/../src/barang.php';

// Proses hapus data
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    deleteBarang($id);
    header('Location: ?page=barang');
    exit;
}

// Proses edit data
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    foreach (getAllBarang() as $row) {
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
        'harga' => $_POST['harga']
    ];
    updateBarang($id, $data);
    header('Location: ?page=barang');
    exit;
}

// Proses tambah data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $data = [
        'nama' => $_POST['nama'],
        'harga' => $_POST['harga']
    ];
    addBarang($data);
    header('Location: ?page=barang');
    exit;
}

$barang = getAllBarang();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
    <a href="?page=admin" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
    <h1>Data Barang</h1>
    <!-- Form tambah/edit barang -->
    <form method="post" class="mb-4">
        <?php if ($editData): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($editData['id']) ?>">
        <?php endif; ?>
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="nama" class="form-control" placeholder="Nama Barang" required value="<?= $editData ? htmlspecialchars($editData['nama']) : '' ?>">
            </div>
            <div class="col-md-3">
                <input type="number" name="harga" class="form-control" placeholder="Harga" required value="<?= $editData ? htmlspecialchars($editData['harga']) : '' ?>">
            </div>
            <div class="col-md-2">
                <?php if ($editData): ?>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                    <a href="?page=barang" class="btn btn-secondary">Batal</a>
                <?php else: ?>
                    <button type="submit" name="tambah" class="btn btn-success">Tambah Barang</button>
                <?php endif; ?>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($barang as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['harga']) ?></td>
                <td>
                    <a href="?page=barang&edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="?page=barang&hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html> 