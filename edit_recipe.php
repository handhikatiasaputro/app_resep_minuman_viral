<?php
// Ambil data berdasarkan ID dari database
require "db.php";

$id = $_GET['id'];
$query = "SELECT * FROM recipes WHERE id = $id";
$result = $db->querySingle($query, true);

// Update data ke database
if (isset($_POST['update'])) {
    $nama_minuman = $_POST['nama_minuman'];
    $bahan = $_POST['bahan'];
    $langkah = $_POST['langkah'];
    $file_name = $result['gambar']; // Menyimpan nama file gambar lama sebagai default

    // Cek apakah ada file gambar yang diunggah
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = __DIR__ . "/uploads/"; // Jalur absolut
        $file_name = basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file tersebut adalah gambar
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check !== false) {
            // Pindahkan file yang diunggah ke folder tujuan
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                // Jika berhasil, gunakan nama file baru
            } else {
                echo "Maaf, terjadi kesalahan saat mengunggah gambar.";
            }
        } else {
            echo "File yang diunggah bukan gambar.";
        }
    }

    // Update query untuk menyimpan data
    $query = "UPDATE recipes SET 
                nama_minuman = '$nama_minuman', 
                bahan = '$bahan', 
                langkah = '$langkah', 
                gambar = '$file_name' 
              WHERE id = $id";
    $db->query($query);

    // Redirect ke halaman utama
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resep Minuman</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Resep Minuman Viral</h1>

        <!-- Menampilkan gambar jika ada -->
        <?php if ($result['gambar']): ?>
            <div class="current-image">
                <h3>Gambar Saat Ini:</h3>
                <img src="uploads/<?php echo $result['gambar']; ?>" alt="<?php echo $result['nama_minuman']; ?>" style="max-width: 300px; max-height: 300px;">
            </div>
        <?php endif; ?>

        <form action="edit_recipe.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <label for="nama_minuman">Nama Minuman:</label>
            <input type="text" id="nama_minuman" name="nama_minuman" value="<?php echo $result['nama_minuman']; ?>" required>

            <label for="bahan">Bahan:</label>
            <textarea id="bahan" name="bahan" required><?php echo $result['bahan']; ?></textarea>

            <label for="langkah">Langkah:</label>
            <textarea id="langkah" name="langkah" required><?php echo $result['langkah']; ?></textarea>

            <label for="gambar">Gambar (opsional):</label>
            <input type="file" id="gambar" name="gambar">

            <button type="submit" name="update">Update Resep</button>
        </form>
        <a href="index.php" class="back">Kembali</a>
    </div>
</body>
</html>
