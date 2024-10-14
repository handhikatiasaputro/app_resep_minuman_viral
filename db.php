<?php
// Buat database dan tabel SQLite3 (index.php)
$db = new SQLite3('minuman.db');

if(!$db) {
    echo $db->lastErrorMsg();
  } else {
    // echo "Open database success...\n";
  } 

$db->exec("CREATE TABLE IF NOT EXISTS recipes (
    id INTEGER PRIMARY KEY,
    nama_minuman TEXT NOT NULL,
    bahan TEXT NOT NULL,
    langkah TEXT NOT NULL,
    gambar TEXT
)");
?>