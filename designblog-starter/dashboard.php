<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';  // Ganti jika username database Anda berbeda
$password = '';  // Ganti jika ada password
$dbname = 'uas5a'; // Pastikan ini sesuai dengan nama database Anda

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
    $id = $_POST['id']; // Mendapatkan ID untuk update

    // Proses upload gambar
    $target_dir = "uploads/"; // Folder untuk menyimpan gambar
    $target_file = $target_dir . time() . '_' . basename($_FILES["images"]["name"]); // Tambahkan timestamp
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar adalah gambar
    $check = getimagesize($_FILES["images"]["tmp_name"]);
    if($check === false) {
        echo "File yang diunggah bukan gambar.";
        $uploadOk = 0;
    }

    // Cek ukuran file
    if ($_FILES["images"]["size"] > 500000) { // Cek jika ukuran file lebih dari 500KB
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
            // Jika ID ada, maka lakukan update
            if (!empty($id)) {
                $sql = "UPDATE artikel SET judul='$judul', isi='$isi', kategori='$kategori', author='$author', tanggal_publikasi='$tanggal_publikasi', images='$target_file', views='$views' WHERE id=$id";
            } else {
                // Jika tidak ada ID, berarti kita menambah artikel baru
                $sql = "INSERT INTO artikel (judul, isi, kategori, author, tanggal_publikasi, images, views) 
                        VALUES ('$judul', '$isi', '$kategori', '$author', '$tanggal_publikasi', '$target_file', '$views')";
            }
            
            if ($conn->query($sql) === TRUE) {
                echo "Artikel berhasil disimpan.";
                header("Location: dashboard.php"); // Redirect ke dashboard setelah submit
                exit();
            } else {
                echo "Gagal menyimpan artikel: " . $conn->error; // Menampilkan kesalahan
            }            
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    }
}

// Hapus artikel
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM artikel WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Artikel berhasil dihapus.";
    } else {
        echo "Gagal menghapus artikel: " . $conn->error;
    }
}

// Mengambil data artikel dari database
$sql = "SELECT * FROM artikel"; // Pastikan nama tabel sesuai dengan yang ada di database
$result = $conn->query($sql);
$action = isset($_GET['action']) ? $_GET['action'] : 'view';

// Ambil data untuk edit jika action adalah edit
if ($action === 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $edit_sql = "SELECT * FROM artikel WHERE id=$id";
    $edit_result = $conn->query($edit_sql);
    $edit_row = $edit_result->fetch_assoc(); // Ambil data artikel yang ingin diedit
}
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

    <?php if ($action === 'add' || $action === 'edit'): ?>
        <!-- Halaman Tambah atau Edit Artikel -->
        <h2><?= $action === 'edit' ? 'Edit Artikel' : 'Tambah Artikel Baru' ?></h2>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-bottom: 20px;">
            <form action="dashboard.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $action === 'edit' ? $edit_row['id'] : '' ?>"> <!-- Menyimpan ID untuk edit -->
                <tr>
                    <td><label>Judul:</label></td>
                    <td><input type="text" name="judul" required style="width: 100%;" value="<?= $action === 'edit' ? htmlspecialchars($edit_row['judul']) : '' ?>"></td>
                </tr>
                <tr>
                    <td><label>Isi:</label></td>
                    <td><textarea name="isi" required style="width: 100%; height: 100px;"><?= $action === 'edit' ? htmlspecialchars($edit_row['isi']) : '' ?></textarea></td>
                </tr>
                <tr>
                    <td><label>Kategori:</label></td>
                    <td>
                        <select name="kategori" style="width: 100%;">
                            <option value="Technology" <?= ($action === 'edit' && $edit_row['kategori'] === 'Technology') ? 'selected' : '' ?>>Technology</option>
                            <option value="LifeStyle" <?= ($action === 'edit' && $edit_row['kategori'] === 'LifeStyle') ? 'selected' : '' ?>>LifeStyle</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Author:</label></td>
                    <td><input type="text" name="author" required style="width: 100%;" value="<?= $action === 'edit' ? htmlspecialchars($edit_row['author']) : '' ?>"></td>
                </tr>
                <tr>
                    <td><label>Tanggal Publikasi:</label></td>
                    <td><input type="date" name="tanggal_publikasi" required style="width: 100%;" value="<?= $action === 'edit' ? $edit_row['tanggal_publikasi'] : '' ?>"></td>
                </tr>
                <tr>
                    <td><label>Images:</label></td>
                    <td>
                        <input type="file" name="images" style="width: 100%;">
                        <?php if ($action === 'edit'): ?>
                            <br>
                            <img src="<?= htmlspecialchars($edit_row['images']) ?>" alt="Gambar" style="width: 100px; height: auto;"/>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td><label>Views:</label></td>
                    <td><input type="number" name="views" required style="width: 100%;" value="<?= $action === 'edit' ? $edit_row['views'] : '' ?>"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <input type="submit" value="<?= $action === 'edit' ? 'Update Artikel' : 'Tambah Artikel' ?>" class="btn btn-add">
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
                                <a href="dashboard.php?action=edit&id=<?= $row['id'] ?>">Edit</a> |
                                <a href="dashboard.php?action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">Hapus</a>
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
