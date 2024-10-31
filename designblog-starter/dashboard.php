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
    $views = $_POST['views'];

    // Proses upload gambar
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["images"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar adalah gambar
    $check = getimagesize($_FILES["images"]["tmp_name"]);
    if($check === false) {
        echo "File yang diunggah bukan gambar.";
        $uploadOk = 0;
    }

    // Cek ukuran file
    if ($_FILES["images"]["size"] > 500000) {
        echo "Maaf, ukuran file terlalu besar.";
        $uploadOk = 0;
    }

    // Cek format file
    if(!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
        $uploadOk = 0;
    }

    // Jika tidak ada kesalahan, coba unggah file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["images"]["tmp_name"], $target_file)) {
            // Query untuk menambahkan artikel baru dengan nama file gambar
            $sql = "INSERT INTO artikel (judul, isi, kategori, author, tanggal_publikasi, images, views) 
                    VALUES ('$judul', '$isi', '$kategori', '$author', '$tanggal_publikasi', '$target_file', '$views')";
            
            if ($conn->query($sql) === TRUE) {
                // Sukses
            } else {
                echo "Gagal menambahkan artikel: " . $conn->error;
            }            
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    }
}

// Mengambil data artikel dari database
$action = isset($_GET['action']) ? $_GET['action'] : 'view';
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Query untuk pencarian (hanya digunakan pada halaman view)
if ($action === 'view') {
    $sql = "SELECT * FROM artikel WHERE judul LIKE '%$search%' OR isi LIKE '%$search%' OR kategori LIKE '%$search%' OR author LIKE '%$search%' ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM artikel ORDER BY id DESC";
}
$result = $conn->query($sql);
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
    <button class="toggle-btn" onclick="toggleSidebar()"> &gt; </button>

    <div class="sidebar" id="sidebar">
        <h2>Menu</h2>
        <ul>
            <li><a href="dashboard.php?action=view">Dashboard</a></li>
            <li><a href="dashboard.php?action=add">Tambah Artikel</a></li>
        </ul>
        <button class="toggle-btn" onclick="toggleSidebar()"> &gt; </button>
    </div>

    <div class="main-content" id="main-content">
        <div class="content-wrapper">
            <h1 style="text-align: center;">Dashboard Artikel</h1>

            <?php if ($action === 'view'): ?>
                <!-- Form pencarian hanya ditampilkan di halaman view -->
                <form method="POST" style="margin-bottom: 20px;">
                    <input type="text" name="search" placeholder="Cari artikel..." required style="width: 300px;">
                    <input type="submit" value="Cari" class="btn btn-search">
                </form>
            <?php endif; ?>

            <?php if ($action === 'add'): ?>
                <!-- Halaman Tambah Artikel -->
                <h2>Tambah Artikel Baru</h2>
                <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-bottom: 20px;">
                    <form action="dashboard.php" method="post" enctype="multipart/form-data">
                        <tr>
                            <td><label>Judul:</label></td>
                            <td><input type="text" name="judul" required style="width: 100%;"></td>
                        </tr>
                        <tr>
                            <td><label>Isi:</label></td>
                            <td><textarea name="isi" required style="width: 100%;"></textarea></td>
                        </tr>
                        <tr>
                            <td><label>Kategori:</label></td>
                            <td>
                                <select name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Technology">Technology</option>
                                    <option value="Life">Life</option>
                                    <option value="Health">Health</option>
                                    <option value="Travel">Travel</option>
                                    <option value="Education">Education</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Author:</label></td>
                            <td><input type="text" name="author" required style="width: 100%;"></td>
                        </tr>
                        <tr>
                            <td><label>Tanggal Publikasi:</label></td>
                            <td><input type="date" name="tanggal_publikasi" required></td>
                        </tr>
                        <tr>
                            <td><label>Gambar:</label></td>
                            <td><input type="file" name="images" accept="image/*" required></td>
                        </tr>
                        <tr>
                            <td><label>Views:</label></td>
                            <td><input type="number" name="views" required style="width: 100%;"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <input type="submit" value="Tambah Artikel" class="btn">
                            </td>
                        </tr>
                    </form>
                </table>
            <?php else: ?>
                <h2>Daftar Artikel</h2>
                <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Isi</th>
                            <th>Kategori</th>
                            <th>Author</th>
                            <th>Tanggal Publikasi</th>
                            <th>Gambar</th>
                            <th>Views</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['judul']) ?></td>
                                    <td><?= htmlspecialchars(substr($row['isi'], 0, 50)) . '...' ?></td>
                                    <td><?= htmlspecialchars($row['kategori']) ?></td>
                                    <td><?= htmlspecialchars($row['author']) ?></td>
                                    <td><?= $row['tanggal_publikasi'] ?></td>
                                    <td>
                                        <?php if (isset($row['images']) && !empty($row['images'])): ?>
                                            <img src="<?= htmlspecialchars($row['images']) ?>" alt="Gambar" style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php else: ?>
                                            Tidak ada gambar
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $row['views'] ?></td>
                                    <td>
                                        <a href="dashboard.php?action=edit&id=<?= $row['id'] ?>">Edit</a> |
                                        <a href="dashboard.php?action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center;">Tidak ada artikel yang ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            sidebar.classList.toggle('open');
            mainContent.classList.toggle('shift');
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
