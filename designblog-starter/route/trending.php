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

// Query untuk mendapatkan artikel dari semua kategori, diurutkan berdasarkan "views" tertinggi
$sql = "SELECT * FROM artikel ORDER BY views DESC LIMIT 5";
$result = $conn->query($sql);
?>

<div class="trending-all-categories">
    <?php if ($result->num_rows > 0): ?>
        <?php $counter = 1; ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="grids5-info">
                <h4><?= sprintf('%02d', $counter) ?>.</h4>
                <div class="blog-info">
                <a href="detail.php?id=<?= $row['id'] ?>" class="blog-desc mt-0"><?= htmlspecialchars($row['judul']) ?></a>
                    <div class="author align-items-center mt-2 mb-1">
                        <a href="#author"><?= htmlspecialchars($row['author']) ?></a> in <a href="#url"><?= htmlspecialchars($row['kategori']) ?></a>
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
            <?php $counter++; ?>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Tidak ada artikel trending saat ini.</p>
    <?php endif; ?>
</div>

<?php $conn->close(); ?>
