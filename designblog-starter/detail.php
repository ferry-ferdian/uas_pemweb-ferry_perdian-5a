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

// Mendapatkan ID artikel dari URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitasi input

    // Update jumlah tampilan
    $updateViewsSql = "UPDATE artikel SET views = views + 1 WHERE id = $id";
    if ($conn->query($updateViewsSql) === FALSE) {
        echo "Error updating views: " . $conn->error;
    }

    // Mengambil detail artikel
    $sql = "SELECT judul, isi, images, tanggal_publikasi, views FROM artikel WHERE id = $id"; // Ambil views juga
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mengeluarkan data artikel yang dipilih
        $row = $result->fetch_assoc();
        $judul = htmlspecialchars($row['judul']);
        $isi = htmlspecialchars($row['isi']);
        $image = htmlspecialchars($row['images']);
        $tanggal = htmlspecialchars($row['tanggal_publikasi']);
        $views = htmlspecialchars($row['views']); // Ambil jumlah views
    } else {
        echo "Artikel tidak ditemukan.";
        exit;
    }
} else {
    echo "ID artikel tidak valid.";
    exit;
}

$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $judul; ?> - Web Programming Blog</title>

    <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-starter.css">
</head>

<body>
    <!-- header -->
    <header class="w3l-header">
        <!--/nav-->
        <nav class="navbar navbar-expand-lg navbar-light fill px-lg-0 py-0 px-3">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <span class="fa fa-pencil-square-o"></span> Web Programming Blog</a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="fa icon-expand fa-bars"></span>
                    <span class="fa icon-close fa-times"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!--//nav-->
    </header>
    <!-- //header -->

    <div class="container mt-5">
        <h1><?php echo $judul; ?></h1>
        <p><small>Dipublikasikan pada: <?php echo $tanggal; ?></small></p>
        <p><small>Views: <?php echo $views; ?></small></p> <!-- Tampilkan views -->
        <?php if ($image): ?>
            <img src="<?php echo $image; ?>" alt="<?php echo $judul; ?>" class="img-fluid">
        <?php endif; ?>
        <div class="article-content">
            <p><?php echo nl2br($isi); ?></p>
        </div>
       <!-- Form untuk kembali ke halaman sebelumnya -->
    <form action="<?php echo htmlspecialchars($_SERVER['HTTP_REFERER']); ?>" method="post">
        <button type="submit" class="btn btn-primary">Kembali</button>
    </form>
    </div>

    <!-- footer -->
    <footer class="w3l-footer-16">
        <div class="footer-content py-lg-5 py-4 text-center">
            <div class="container">
                <div class="copy-right">
                    <h6>© 2024 Web Programming Blog. Made by <i></i> with <span class="fa fa-heart" aria-hidden="true"></span><br>Designed by
                        <a href="https://w3layouts.com">W3layouts</a> </h6>
                </div>
            </div>
        </div>
    </footer>
    <!-- //footer -->

    <!-- Template JavaScript -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>