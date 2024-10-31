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

// Tentukan jumlah artikel per halaman
$articlesPerPage = 5;

// Ambil halaman saat ini dari URL (default ke halaman 1 jika tidak ada)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Hitung offset untuk query SQL
$offset = ($page - 1) * $articlesPerPage;

// Query untuk mendapatkan total artikel
$totalArticlesSql = "SELECT COUNT(*) as total FROM artikel";
$totalArticlesResult = $conn->query($totalArticlesSql);
$totalArticlesRow = $totalArticlesResult->fetch_assoc();
$totalArticles = $totalArticlesRow['total'];

// Hitung jumlah total halaman
$totalPages = ceil($totalArticles / $articlesPerPage);

// Query untuk mendapatkan artikel pada halaman saat ini
$sql = "SELECT * FROM artikel ORDER BY tanggal_publikasi DESC LIMIT $offset, $articlesPerPage";
$result = $conn->query($sql);
?>

<div class="list-view">
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="grids5-info img-block-mobile mt-5">
                <div class="blog-info align-self">
                    <span class="category"><?= htmlspecialchars($row['kategori']) ?></span>
                    <a href="#blog-single" class="blog-desc mt-0"><?= htmlspecialchars($row['judul']) ?></a>
                    <p><?= htmlspecialchars(substr($row['isi'], 0, 100)) ?>...</p>
                    <div class="author align-items-center mt-3 mb-1">
                        <a href="#author"><?= htmlspecialchars($row['author']) ?></a>
                    </div>
                    <ul class="blog-meta">
                        <li class="meta-item blog-lesson">
                            <span class="meta-value"><?= htmlspecialchars($row['tanggal_publikasi']) ?></span>
                        </li>
                        <li class="meta-item blog-students">
                            <span class="meta-value"><?= htmlspecialchars($row['views']) ?> views</span>
                        </li>
                    </ul>
                </div>
                <a href="#blog-single" class="d-block zoom mt-md-0 mt-3">
                    <img src="<?= htmlspecialchars($row['images']) ?>" alt="Gambar Artikel" class="img-fluid radius-image news-image">
                </a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Tidak ada artikel yang tersedia.</p>
    <?php endif; ?>
</div>

<!-- pagination -->
<div class="pagination-wrapper mt-5">
    <ul class="page-pagination">
        <?php if ($page > 1): ?>
            <li><a class="next" href="?page=<?= $page - 1 ?>"><span class="fa fa-angle-left"></span></a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li>
                <a class="page-numbers <?= ($i == $page) ? 'current' : '' ?>" href="?page=<?= $i ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <li><a class="next" href="?page=<?= $page + 1 ?>"><span class="fa fa-angle-right"></span></a></li>
        <?php endif; ?>
    </ul>
</div>

<?php $conn->close(); ?>
