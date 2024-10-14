<?php
require "db.php";

// Logika untuk menambahkan resep ke database
if (isset($_POST['submit'])) {
    $nama_minuman = $_POST['nama_minuman'];
    $bahan = $_POST['bahan'];
    $langkah = $_POST['langkah'];

    // Cek apakah ada file gambar yang diunggah
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = __DIR__ . "/uploads/";
        $file_name = basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file tersebut adalah gambar
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check !== false) {
            // Pindahkan file yang diunggah ke folder tujuan
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                // Simpan data resep bersama dengan nama file gambar ke database
                $query = "INSERT INTO recipes (nama_minuman, bahan, langkah, gambar) 
                          VALUES ('$nama_minuman', '$bahan', '$langkah', '$file_name')";
                $db->query($query);

                // Redirect kembali ke halaman utama
                header("Location: index.php");
                exit();
            } else {
                echo "Maaf, terjadi kesalahan saat mengunggah gambar.";
            }
        } else {
            echo "File yang diunggah bukan gambar.";
        }
    } else {
        echo "Tidak ada gambar yang diunggah atau terjadi kesalahan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Resep Minuman</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Tambah Resep Minuman Viral</h1>
        <form action="add_recipe.php" method="post" enctype="multipart/form-data">
            <label for="nama_minuman">Nama Minuman:</label>
            <input type="text" id="nama_minuman" name="nama_minuman" required>

            <label for="bahan">Bahan:</label>
            <textarea id="bahan" name="bahan" required></textarea>

            <label for="langkah">Langkah:</label>
            <textarea id="langkah" name="langkah" required></textarea>

            <label for="gambar">Gambar Minuman:</label>
            <input type="file" id="gambar" name="gambar" accept="image/*" required>

            <button type="submit" name="submit">Tambah Resep</button>
        </form>
        <a href="index.php" class="back">Kembali</a>
    </div>
</body>
</html>
