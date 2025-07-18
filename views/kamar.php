<?php
require_once __DIR__ . '/../src/kamar.php';

// Proses hapus data
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    deleteKamar($id);
    header('Location: ?page=kamar');
    exit;
}

// Proses edit data
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    foreach (getAllKamar() as $row) {
        if ($row['id'] == $id) {
            $editData = $row;
            break;
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $data = [
        'nomor' => $_POST['nomor'],
        'harga' => $_POST['harga']
    ];
    updateKamar($id, $data);
    header('Location: ?page=kamar');
    exit;
}

// Proses tambah data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $data = [
        'nomor' => $_POST['nomor'],
        'harga' => $_POST['harga']
    ];
    addKamar($data);
    header('Location: ?page=kamar');
    exit;
}

$kamar = getAllKamar();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kamar</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
    <a href="?page=admin" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
    <h1>Data Kamar</h1>
    <!-- Form tambah/edit kamar -->
    <form method="post" class="mb-4">
        <?php if ($editData): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($editData['id']) ?>">
        <?php endif; ?>
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <input type="text" name="nomor" class="form-control" placeholder="Nomor Kamar" required value="<?= $editData ? htmlspecialchars($editData['nomor']) : '' ?>">
            </div>
            <div class="col-md-3">
                <input type="number" name="harga" class="form-control" placeholder="Harga" required value="<?= $editData ? htmlspecialchars($editData['harga']) : '' ?>">
            </div>
            <div class="col-md-2">
                <?php if ($editData): ?>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                    <a href="?page=kamar" class="btn btn-secondary">Batal</a>
                <?php else: ?>
                    <button type="submit" name="tambah" class="btn btn-success">Tambah Kamar</button>
                <?php endif; ?>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nomor</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($kamar as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['nomor']) ?></td>
                <td><?= htmlspecialchars($row['harga']) ?></td>
                <td>
                    <a href="?page=kamar&edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="?page=kamar&hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html> 