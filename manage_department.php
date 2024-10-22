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

// Proses penambahan departemen
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['department_name'])) {
    $department_name = $conn->real_escape_string($_POST['department_name']);
    $sql = "INSERT INTO departments (name) VALUES ('$department_name')";
    $conn->query($sql);
}

// Proses penghapusan departemen
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM departments WHERE id = $id";
    $conn->query($sql);
}

// Query untuk mengambil data departemen
$sql = "SELECT * FROM departments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Kelola Departemen</title>
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
    <h1>Kelola Departemen</h1>
    
    <!-- Tombol untuk menampilkan form tambah departemen -->
    <button onclick="toggleAddDepartment()">Tambah Departemen</button>

    <!-- Form untuk tambah departemen -->
    <div id="addDepartmentForm" style="display:none;">
        <h3>Tambah Departemen</h3>
        <form method="POST" action="">
            <label for="department_name">Nama Departemen:</label>
            <input type="text" name="department_name" required>
            <button type="submit">Simpan</button>
            <button type="button" onclick="toggleAddDepartment()">Batal</button>
        </form>
    </div>

    <!-- Tabel untuk menampilkan daftar departemen -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Departemen</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>
                        <a href="?delete=<?php echo $row['id']; ?>" class="delete-button" onclick="return confirm('Apakah Anda yakin ingin menghapus departemen ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    function toggleAddDepartment() {
        var form = document.getElementById("addDepartmentForm");
        if (form.style.display === "none") {
            form.style.display = "block";
        } else {
            form.style.display = "none";
        }
    }
</script>

</body>
</html>

<?php
$conn->close();
?>
