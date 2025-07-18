<?php
require_once __DIR__ . '/../src/tagihan.php';

// Generate tagihan jika tombol ditekan
if (isset($_GET['generate'])) {
    require_once __DIR__ . '/../src/tagihan_generator.php';
    generateTagihanBulanan();
    header('Location: ?page=tagihan');
    exit;
}

// Proses hapus data
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    deleteTagihan($id);
    header('Location: ?page=tagihan');
    exit;
}

// Proses edit data
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    foreach (getAllTagihan() as $row) {
        if ($row['id'] == $id) {
            $editData = $row;
            break;
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $data = [
        'bulan' => $_POST['bulan'],
        'id_kmr_penghuni' => $_POST['id_kmr_penghuni'],
        'jml_tagihan' => $_POST['jml_tagihan']
    ];
    updateTagihan($id, $data);
    header('Location: ?page=tagihan');
    exit;
}

// Proses tambah data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $data = [
        'bulan' => $_POST['bulan'],
        'id_kmr_penghuni' => $_POST['id_kmr_penghuni'],
        'jml_tagihan' => $_POST['jml_tagihan']
    ];
    addTagihan($data);
    header('Location: ?page=tagihan');
    exit;
}

$tagihan = getAllTagihan();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tagihan</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
<div class="container mt-4">
    <a href="?page=admin" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Kembali ke Dashboard</a>
    <a href="?page=tagihan&generate=1" class="btn btn-success mb-2" onclick="return confirm('Generate tagihan bulan ini?')">Generate Tagihan Bulanan</a>
    <!-- Form tambah/edit tagihan -->
    <form method="post" class="mb-4">
        <?php if ($editData): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($editData['id']) ?>">
        <?php endif; ?>
        <div class="row g-2 align-items-end">
            <div class="col-md-2">
                <input type="month" name="bulan" class="form-control" required value="<?= $editData ? htmlspecialchars($editData['bulan']) : '' ?>">
            </div>
            <div class="col-md-3">
                <input type="number" name="id_kmr_penghuni" class="form-control" placeholder="ID Kamar Penghuni" required value="<?= $editData ? htmlspecialchars($editData['id_kmr_penghuni']) : '' ?>">
            </div>
            <div class="col-md-3">
                <input type="number" name="jml_tagihan" class="form-control" placeholder="Jumlah Tagihan" required value="<?= $editData ? htmlspecialchars($editData['jml_tagihan']) : '' ?>">
            </div>
            <div class="col-md-2">
                <?php if ($editData): ?>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                    <a href="?page=tagihan" class="btn btn-secondary">Batal</a>
                <?php else: ?>
                    <button type="submit" name="tambah" class="btn btn-success">Tambah Tagihan</button>
                <?php endif; ?>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Bulan</th>
                <th>Kamar Penghuni</th>
                <th>Jumlah Tagihan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tagihan as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['bulan']) ?></td>
                <td><?= htmlspecialchars($row['id_kmr_penghuni']) ?></td>
                <td><?= htmlspecialchars($row['jml_tagihan']) ?></td>
                <td>
                    <a href="?page=tagihan&edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="?page=tagihan&hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html> 