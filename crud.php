<?php
// crud.php
$host = "localhost"; // Host database
$user = "root"; // Username database
$password = ""; // Password database
$dbname = "otomotif"; // Nama database

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error); // Menampilkan pesan error jika koneksi gagal
}

// Hapus data jika action adalah 'delete'
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id']; // Mengambil ID barang yang akan dihapus
    $sql_delete = "DELETE FROM barang WHERE id_barang='$id'"; // Query untuk menghapus data

    if ($conn->query($sql_delete) === TRUE) {
        header("Location: tampil_data.php"); // Redirect setelah berhasil menghapus data
        exit();
    } else {
        echo "Error deleting record: " . $conn->error; // Menampilkan pesan error jika gagal menghapus data
    }
}

// Edit data jika action adalah 'edit'
if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") { // Memeriksa apakah form disubmit dengan metode POST
        // Mengambil data dari form edit
        $id = $_POST['id'];
        $nama_barang = $_POST['nama_barang'];
        $harga_barang = $_POST['harga_barang'];
        $stok_barang = $_POST['stok_barang'];
        $id_kategori = $_POST['id_kategori'];

        // Query untuk memperbarui data barang di tabel barang
        $sql_update = "UPDATE barang SET nama_barang='$nama_barang', harga_barang='$harga_barang', stok_barang='$stok_barang', id_kategori='$id_kategori' WHERE id_barang='$id'";

        if ($conn->query($sql_update) === TRUE) {
            header("Location: tampil_data.php"); // Redirect setelah berhasil memperbarui data
            exit();
        } else {
            echo "Error updating record: " . $conn->error; // Menampilkan pesan error jika gagal memperbarui data
        }
    }

    // Ambil data untuk diedit berdasarkan ID yang diberikan
    $id_edit = $_GET['id'];
    $sql_edit = "SELECT * FROM barang WHERE id_barang='$id_edit'";
    $result_edit = $conn->query($sql_edit);
    
    if ($result_edit->num_rows > 0) { // Jika ada hasil yang ditemukan
        $data_edit = $result_edit->fetch_assoc(); // Mengambil data yang akan diedit
        
        // Ambil kategori untuk dropdown pada form edit
        $sql_kategori = "SELECT * FROM kategori";
        $result_kategori = $conn->query($sql_kategori);
        
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<h1>Edit Data Barang</h1>

    <!-- Form untuk mengedit data barang -->
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($data_edit['id_barang']); ?>"> <!-- Hidden input untuk ID barang -->
        
        Nama Barang: <input type="text" name="nama_barang" value="<?php echo htmlspecialchars($data_edit['nama_barang']); ?>" required><br><br> <!-- Input nama barang -->
            
        Harga Barang: <input type="number" step="0.01" name="harga_barang" value="<?php echo htmlspecialchars($data_edit['harga_barang']); ?>" required><br><br> <!-- Input harga barang -->
        
        Stok Barang: <input type="number" name="stok_barang" value="<?php echo htmlspecialchars($data_edit['stok_barang']); ?>" required><br><br> <!-- Input stok barang -->

        Kategori:
        <select name="id_kategori" required> <!-- Dropdown untuk memilih kategori -->
            <?php while($row_kategori = $result_kategori->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row_kategori['id_kategori']); ?>" <?php if ($row_kategori['id_kategori'] == $data_edit['id_kategori']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($row_kategori['nama_kategori']); ?>
                </option> <!-- Menampilkan kategori dan menandai yang dipilih -->
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" value="Update"> <!-- Tombol untuk memperbarui data -->
    </form>

<?php 
    } else {
        echo "Data tidak ditemukan."; // Pesan jika ID tidak ditemukan di database.
    }
}

$conn->close(); // Menutup koneksi database.
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>