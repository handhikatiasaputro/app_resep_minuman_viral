<?php
require "db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Minuman Viral</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Resep Minuman Viral</h1>
        <a href="add_recipe.php" class="add-recipe-button">Tambah Resep</a>
        <div class="recipes-list">
            <?php
            // Ambil data dari database menggunakan query SQL
            $query = 'SELECT * FROM recipes';
            $results = $db->query($query);
            
            while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
                echo "<div class='recipe-card'>";
                echo "<h2>" . htmlspecialchars($row['nama_minuman']) . "</h2>";
                echo "<p><strong>Bahan:</strong> " . htmlspecialchars($row['bahan']) . "</p>";
                echo "<p><strong>Langkah:</strong> " . htmlspecialchars($row['langkah']) . "</p>";

                // Tampilkan gambar jika ada
                if (!empty($row['gambar'])) {
                    echo "<img src='./uploads/" . htmlspecialchars($row['gambar']) . "' alt='" . htmlspecialchars($row['nama_minuman']) . "' class='recipe-image'>";
                }

                // Tombol Edit dan Hapus
                echo "<a href='edit_recipe.php?id=" . $row['id'] . "' class='edit-button'>Edit</a>";
                echo "<a href='delete_recipe.php?id=" . $row['id'] . "' class='delete-button' onclick='return confirm(\"Apakah Anda yakin ingin menghapus resep ini?\");'>Hapus</a>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
