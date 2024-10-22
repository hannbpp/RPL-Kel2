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

// Fungsi untuk menghapus staf
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM staff WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Query untuk mengambil data staff dan departemen
$sql = "SELECT s.*, d.name AS department_name FROM staff s 
        JOIN departments d ON s.department_id = d.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Kelola Staf</title>
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
    <h1>Kelola Staf</h1>
    <table>
        <tr>
            <th>Nama Lengkap</th>
            <th>Jenis Kelamin</th>
            <th>Agama</th>
            <th>No Telepon</th>
            <th>TTL</th>
            <th>Alamat</th>
            <th>Departemen</th>
            <th>Email</th>
            <th>Tanggal Bergabung</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['nama_lengkap']; ?></td>
            <td><?php echo $row['jenis_kelamin']; ?></td>
            <td><?php echo $row['agama']; ?></td>
            <td><?php echo $row['no_telepon']; ?></td>
            <td><?php echo $row['ttl']; ?></td>
            <td><?php echo $row['alamat']; ?></td>
            <td><?php echo $row['department_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['tanggal_bergabung']; ?></td>
            <td>
                <a href="?delete=<?php echo $row['id']; ?>" class="delete-button" onclick="return confirm('Apakah Anda yakin ingin menghapus staff ini?');">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
