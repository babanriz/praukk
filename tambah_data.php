<?php
include 'koneksi.php';
// Memeriksa apakah form disubmit dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    // Mengambil data dari form
    $nama_barang = $_POST['nama_barang'];
    $harga_barang = $_POST['harga_barang'];
    $stok_barang = $_POST['stok_barang'];
    $id_kategori = $_POST['id_kategori'];

    // Query untuk menambahkan data barang ke tabel barang
    $sql = "INSERT INTO barang VALUES ('$nama_barang', '$harga_barang', '$stok_barang', '$id_kategori')";

    if ($conn->query($sql) === TRUE) {
        header("Location: tampil_data.php"); // Redirect ke halaman tampil_data setelah berhasil menambah data
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // Menampilkan pesan error jika gagal menambah data
    }
}

// Query untuk mengambil kategori dari tabel kategori untuk dropdown
$sql_kategori = "SELECT * FROM kategori";
$result_kategori = $conn->query($sql_kategori);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Tambah Data Barang</h2>
        <!-- Form untuk menambah data barang -->
    <form method="POST" action="">
        <label class="form-label">Nama Barang:</label> 
        <input type="text" name="nama_barang" class="form-control" required><br><br> <!-- Input nama barang -->
        <label class="form-label">Harga Barang:</label>  
        <input type="number" step="0.01" name="harga_barang" class="form-control" required><br><br> <!-- Input harga barang -->
        <label class="form-label">Stok Barang:</label> 
        <input type="number" name="stok_barang" class="form-control" required><br><br> <!-- Input stok barang -->
        <label class="form-label">Kategori:</label> 
        <select name="id_kategori" required> <!-- Dropdown untuk memilih kategori -->
            <?php while($row_kategori = $result_kategori->fetch_assoc()): ?>
                <option value="<?php echo $row_kategori['id_kategori']; ?>"><?php echo $row_kategori['nama_kategori']; ?></option> <!-- Menampilkan kategori -->
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" class="btn btn-primary" value="Simpan"> <!-- Tombol untuk menyimpan data -->
    </form>
    </div>

    <?php $conn->close(); ?> <!-- Menutup koneksi database -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
