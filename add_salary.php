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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['staff_id'];
    $gaji = $_POST['gaji'];
    $sql = "INSERT INTO salary (staff_id, gaji) VALUES ('$staff_id', '$gaji')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Gaji berhasil ditambahkan!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql_staff = "SELECT * FROM staff";
$result_staff = $conn->query($sql_staff);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Salary</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-content">
        <h2>Tambah Gaji</h2>
        <form method="POST" action="">
            <label for="staff_id">Staff:</label>
            <select id="staff_id" name="staff_id" required>
                <?php while ($row = $result_staff->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_lengkap']; ?></option>
                <?php endwhile; ?>
            </select>
            <label for="gaji">Gaji:</label>
            <input type="number" id="gaji" name="gaji" required>
            <button type="submit">Tambah</button>
        </form>
    </div>
</body>
</html>
