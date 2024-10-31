<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'uas5a';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $kategori = $_POST['kategori'];
    $author = $_POST['author'];
    $tanggal_publikasi = $_POST['tanggal_publikasi'];
    $images = $_POST['images'];
    $views = $_POST['views'];

    // Query untuk menambahkan artikel baru
    $sql = "INSERT INTO articles (judul, isi, kategori, author, tanggal_publikasi, images, views) 
            VALUES ('$judul', '$isi', '$kategori', '$author', '$tanggal_publikasi', '$images', '$views')";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php"); // Redirect ke dashboard setelah submit
        exit();
    } else {
        echo "Gagal menambahkan artikel: " . $conn->error;
    }
}

// Mengambil data artikel dari database
$sql = "SELECT * FROM artikel";
$result = $conn->query($sql);
$action = isset($_GET['action']) ? $_GET['action'] : 'view';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Artikel</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <h1 style="text-align: center;">Dashboard Artikel</h1>

    <?php if ($action === 'add'): ?>
        <!-- Halaman Tambah Artikel -->
        <h2>Tambah Artikel Baru</h2>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-bottom: 20px;">
            <form action="dashboard.php" method="post">
                <tr>
                    <td><label>Judul:</label></td>
                    <td><input type="text" name="judul" required style="width: 100%;"></td>
                </tr>
                <tr>
                    <td><label>Isi:</label></td>
                    <td><textarea name="isi" required style="width: 100%; height: 100px;"></textarea></td>
                </tr>
                <tr>
                    <td><label>Kategori:</label></td>
                    <td>
                        <select name="kategori" style="width: 100%;">
                            <option value="Technology">Technology</option>
                            <option value="LifeStyle">LifeStyle</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Author:</label></td>
                    <td><input type="text" name="author" required style="width: 100%;"></td>
                </tr>
                <tr>
                    <td><label>Tanggal Publikasi:</label></td>
                    <td><input type="date" name="tanggal_publikasi" required style="width: 100%;"></td>
                </tr>
                <tr>
                    <td><label>Images (URL):</label></td>
                    <td><input type="text" name="images" style="width: 100%;"></td>
                </tr>
                <tr>
                    <td><label>Views:</label></td>
                    <td><input type="number" name="views" required style="width: 100%;"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <input type="submit" value="Tambah Artikel" class="btn btn-add">
                        <a href="dashboard.php" class="btn btn-back">Kembali ke Dashboard</a>
                    </td>
                </tr>
            </form>
        </table>
    <?php else: ?>
        <!-- Tabel Artikel -->
        <div style="margin-bottom: 20px;">
            <a href="dashboard.php?action=add" class="btn btn-add">+ Tambah Artikel</a>
        </div>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Kategori</th>
                    <th>Author</th>
                    <th>Tanggal Publikasi</th>
                    <th>Images</th>
                    <th>Views</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['judul']) ?></td>
                            <td><?= substr(htmlspecialchars($row['isi']), 0, 50) . '...' ?></td>
                            <td><?= $row['kategori'] ?></td>
                            <td><?= htmlspecialchars($row['author']) ?></td>
                            <td><?= $row['tanggal_publikasi'] ?></td>
                            <td><img src="<?= htmlspecialchars($row['images']) ?>" alt="Gambar" style="width: 50px; height: 50px; object-fit: cover;"></td>
                            <td><?= $row['views'] ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" style="text-align: center;">Tidak ada artikel yang ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>

<?php $conn->close(); ?>
