<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = "root"; // Ganti dengan password database Anda
$dbname = "dashboard_db"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data gaji
$sql = "SELECT staff.name AS staff_name, staff.id AS staff_id, salary.amount FROM staff LEFT JOIN salary ON staff.id = salary.staff_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Gaji</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard Menu</h2>
        <ul>
            <li>
                <a href="#">Department</a>
                <div class="dropdown">
                    <a href="add_department.php">Add Department</a>
                    <a href="manage_department.php">Manage Department</a>
                </div>
            </li>
            <li>
                <a href="#">Staff</a>
                <div class="dropdown">
                    <a href="add_staff.php">Add Staff</a>
                    <a href="manage_staff.php">Manage Staff</a>
                </div>
            </li>
            <li>
                <a href="#">Salary</a>
                <div class="dropdown">
                    <a href="manage_salary.php">Manage Salary</a>
                </div>
            </li>
            <li>
                <a href="logout.php">Logout</a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Kelola Gaji</h1>
        <table>
            <thead>
                <tr>
                    <th>Nama Staf</th>
                    <th>Jumlah Gaji</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['staff_name']; ?></td>
                            <td><?php echo $row['amount'] ? 'Rp ' . number_format($row['amount'], 0, ',', '.') : 'Belum Ditentukan'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="2">Tidak ada gaji yang tersedia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
