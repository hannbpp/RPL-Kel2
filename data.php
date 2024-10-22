<?php
// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = "root"; // Ganti dengan password database Anda
$dbname = "dashboard_db"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengambil data dari formulir
$nama_lengkap = $_POST['nama_lengkap'];
$email = $_POST['email'];
$no_telepon = $_POST['no_telepon'];
$posisi_dilamar = $_POST['posisi_dilamar'];

// Query untuk memasukkan data
$sql = "INSERT INTO calon_pelamar (nama_lengkap, email, no_telepon, posisi_dilamar, tanggal_lamaran)
VALUES ('$nama_lengkap', '$email', '$no_telepon', '$posisi_dilamar', CURRENT_DATE())";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php"); // Redirect ke dashboard setelah sukses
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
