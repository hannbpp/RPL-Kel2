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
    <title>Dashboard</title>
</head>
<body>

<div class="sidebar">
    <h2>Dashboard</h2>
    <ul>
        <li><a href="#">Data Karyawan</a></li>
        <li>
            <a href="#">Manajemen Departemen</a>
            <div class="dropdown">
                <a href="#" onclick="toggleAddDepartment()">Tambah Departemen</a>
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
        <li><a href="#" onclick="logout()">Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <h1>HR System Kelompok 2</h1>
    <h2>Data Karyawan</h2>
    <table>
        <tr>
            <th>Nama Lengkap</th>
            <th>Jenis Kelamin</th>
            <th>Agama</th>
            <th>No Telepon</th>
            <th>Tempat, Tanggal Lahir</th>
            <th>Alamat</th>
            <th>Departemen</th>
            <th>Email</th>
            <th>Tanggal Bergabung</th>
            <th>Aksi</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
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
                        <a href="edit_staff.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="delete_staff.php?id=<?php echo $row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="10">Tidak ada data karyawan</td></tr>
        <?php endif; ?>
    </table>
    <button class="logout" onclick="logout()">Logout</button>
</div>

<!-- Form untuk tambah departemen -->
<div id="addDepartmentForm" style="display:none;">
    <h3>Tambah Departemen</h3>
    <form method="POST" action="add_department.php">
        <label for="department_name">Nama Departemen:</label>
        <input type="text" name="department_name" required>
        <button type="submit">Simpan</button>
        <button type="button" onclick="toggleAddDepartment()">Batal</button>
    </form>
</div>

<script>
    function toggleAddDepartment() {
        const form = document.getElementById('addDepartmentForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function logout() {
        // Logic untuk logout
        window.location.href = 'logout.php'; // Ganti dengan URL logout Anda
    }
</script>

</body>
</html>
