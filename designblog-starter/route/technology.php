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

// Tentukan jumlah artikel per halaman untuk kategori technology
$articlesPerPage = 5;

// Ambil halaman saat ini dari URL (default ke halaman 1 jika tidak ada)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Hitung offset untuk query SQL
$offset = ($page - 1) * $articlesPerPage;

// Query untuk mendapatkan total artikel dengan kategori "technology"
$totalArticlesSql = "SELECT COUNT(*) as total FROM artikel WHERE kategori = 'technology'";
$totalArticlesResult = $conn->query($totalArticlesSql);
$totalArticlesRow = $totalArticlesResult->fetch_assoc();
$totalArticles = $totalArticlesRow['total'];

// Hitung jumlah total halaman
$totalPages = ceil($totalArticles / $articlesPerPage);

// Query untuk mendapatkan artikel kategori "technology" pada halaman saat ini
$sql = "SELECT * FROM artikel WHERE kategori = 'technology' ORDER BY tanggal_publikasi DESC LIMIT $offset, $articlesPerPage";
$result = $conn->query($sql);
?>

<div class="row">
    <?php if ($result->num_rows > 0): ?>
        <?php $isFirstArticle = true; ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <?php if ($isFirstArticle): ?>
                <div class="col-md-12 item">
                    <div class="card">
                        <div class="card-header p-0 position-relative">
                            <a href="#blog-single">
                                <img class="card-img-bottom d-block radius-image" src="<?= htmlspecialchars($row['images']) ?>" alt="Gambar Artikel">
                            </a>
                        </div>
                        <div class="card-body p-0 blog-details">
                            <a href="#blog-single" class="blog-desc"><?= htmlspecialchars($row['judul']) ?></a>
                            <p><?= htmlspecialchars(substr($row['isi'], 0, 100)) ?>...</p>
                            <div class="author align-items-center mt-3 mb-1">
                                <a href="#author"><?= htmlspecialchars($row['author']) ?></a> in <a href="#url">Technology</a>
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
                    </div>
                </div>
                <?php $isFirstArticle = false; ?>
            <?php else: ?>
                <div class="col-lg-6 col-md-6 item mt-5 pt-lg-3">
                    <div class="card">
                        <div class="card-header p-0 position-relative">
                            <a href="#blog-single">
                                <img class="card-img-bottom d-block radius-image" src="<?= htmlspecialchars($row['images']) ?>" alt="Gambar Artikel">
                            </a>
                        </div>
                        <div class="card-body p-0 blog-details">
                            <a href="#blog-single" class="blog-desc"><?= htmlspecialchars($row['judul']) ?></a>
                            <p><?= htmlspecialchars(substr($row['isi'], 0, 100)) ?>...</p>
                            <div class="author align-items-center mt-3 mb-1">
                                <a href="#author"><?= htmlspecialchars($row['author']) ?></a> in <a href="#url">Technology</a>
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
                    </div>
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Tidak ada artikel dengan kategori technology yang tersedia.</p>
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
