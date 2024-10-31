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

// Query untuk mendapatkan artikel kategori "lifestyle" yang diurutkan berdasarkan "views" terbanyak
$sql = "SELECT * FROM artikel WHERE kategori = 'lifestyle' ORDER BY views DESC LIMIT 5";
$result = $conn->query($sql);
?>

<div class="trending-lifestyle">
    <?php if ($result->num_rows > 0): ?>
        <?php $counter = 1; ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="grids5-info">
                <h4><?= sprintf('%02d', $counter) ?>.</h4>
                <div class="blog-info">
                    <a href="#blog-single" class="blog-desc1"><?= htmlspecialchars($row['judul']) ?></a>
                    <div class="author align-items-center mt-2 mb-1">
                        <a href="#author"><?= htmlspecialchars($row['author']) ?></a> in <a href="#url">Lifestyle</a>
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
        <p>Tidak ada artikel trending di kategori lifestyle saat ini.</p>
    <?php endif; ?>
</div>

<?php $conn->close(); ?>
