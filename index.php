<?php
include 'koneksi.php';
// Query untuk mengambil data barang dan kategori yang terkait
$sql = "SELECT b.id_barang, b.nama_barang, b.harga_barang, b.stok_barang, k.nama_kategori 
        FROM barang b 
        JOIN kategori k ON b.id_kategori = k.id_kategori";
$result = $conn->query($sql); // Menjalankan query

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-2">
        <h2 class="text-center">Daftar Data Barang</h2>
    <a href="tambah_data.php" class="btn btn-primary">Tambah Data</a> <hr>
    <table class="table table-striped">
        <tr>
            <th>ID Barang</th>
            <th>Nama Barang</th>
            <th>Harga Barang</th>
            <th>Stok Barang</th>
            <th>Kategori</th>
            <th>Aksi</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id_barang']; ?></td>
                    <td><?php echo $row['nama_barang']; ?></td>
                    <td><?php echo number_format($row['harga_barang']); ?></td>
                    <td><?php echo $row['stok_barang']; ?></td>
                    <td><?php echo $row['nama_kategori']; ?></td>
                    <td>
                        <!-- Tautan untuk mengedit dan menghapus data -->
                        <a href="crud.php?action=edit&id=<?php echo $row['id_barang']; ?>" class="btn btn-primary">Edit</a> |
                        <a href="crud.php?action=delete&id=<?php echo $row['id_barang']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus?')" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">Tidak ada data.</td></tr> <!-- Pesan jika tidak ada data -->
        <?php endif; ?>

    </table>

    <?php $conn->close(); ?> <!-- Menutup koneksi database -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
