<?php

require "db.php";

// Ambil ID resep dan hapus dari database
$id = $_GET['id'];
$query = "DELETE FROM recipes WHERE id = $id";
$db->query($query);

// Redirect ke halaman utama setelah menghapus
header("Location: index.php");
?>
