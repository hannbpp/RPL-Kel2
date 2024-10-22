<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = "root"; // Ganti dengan password database Anda
$dbname = "dashboard_db"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form dan simpan ke database
    $nama_lengkap = $_POST['nama_lengkap'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $no_telepon = $_POST['no_telepon'];
    $ttl = $_POST['ttl'];
    $alamat = $_POST['alamat'];
    $department_id = $_POST['department_id'];
    $email = $_POST['email'];
    $tanggal_bergabung = $_POST['tanggal_bergabung'];

    $sql = "INSERT INTO staff (nama_lengkap, jenis_kelamin, agama, no_telepon, ttl, alamat, department_id, email, tanggal_bergabung) VALUES ('$nama_lengkap', '$jenis_kelamin', '$agama', '$no_telepon', '$ttl', '$alamat', '$department_id', '$email', '$tanggal_bergabung')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Tambah Staf</title>
</head>
<body>

<div class="sidebar">
    <h2>Dashboard</h2>
    <ul>
        <li><a href="index.php">Data Karyawan</a></li>
        <li>
            <a href="#">Manajemen Departemen</a>
            <div class="dropdown">
                <a href="add_department.php">Tambah Departemen</a>
                <a href="manage_department.php">Kelola Departemen</a>
            </div>
        </li>
        <li>
            <a href="#">Staf</a>
            <div class="dropdown">
                <a href="add_staff.php">Tambah Staf</a>
                <a href="manage_staff.php">Kelola Staf</a>
            </div>
        </li>
        <li>
            <a href="#">Gaji</a>
            <div class="dropdown">
                <a href="add_salary.php">Tambah Gaji</a>
                <a href="manage_salary.php">Kelola Gaji</a>
            </div>
        </li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <h1>Tambah Staf</h1>
    <form action="add_staff.php" method="POST">
        <label for="nama_lengkap">Nama Lengkap:</label>
        <input type="text" id="nama_lengkap" name="nama_lengkap" required>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" name="jenis_kelamin" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>

        <label for="agama">Agama:</label>
        <input type="text" id="agama" name="agama" required>

        <label for="no_telepon">No Telepon:</label>
        <input type="text" id="no_telepon" name="no_telepon" required>

        <label for="ttl">Tempat Tanggal Lahir:</label>
        <input type="text" id="ttl" name="ttl" required>

        <label for="alamat">Alamat:</label>
        <textarea id="alamat" name="alamat" required></textarea>

        <label for="department_id">Departemen:</label>
        <input type="number" id="department_id" name="department_id" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="tanggal_bergabung">Tanggal Bergabung:</label>
        <input type="date" id="tanggal_bergabung" name="tanggal_bergabung" required>

        <input type="submit" value="Simpan">
    </form>
</div>

</body>
</html>
