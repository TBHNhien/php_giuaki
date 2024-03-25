<?php
// Kiểm tra nếu người dùng đã đăng nhập và có quyền admin.
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 1) {
    header("Location: login.php"); // Nếu không phải admin, chuyển hướng về trang đăng nhập.
    exit;
}

// Database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ql_nhansu";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT ma_phong, ten_phong FROM PHONGBAN";
$result = $conn->query($sql);



// Xử lý khi người dùng gửi form thêm nhân viên
if (isset($_POST['submit'])) {
    // Xử lý dữ liệu được gửi từ form
    $ma_nv = $_POST['ma_nv'];
    $ten_nv = $_POST['ten_nv'];
    $phai = $_POST['phai'];
    $noi_sinh = $_POST['noi_sinh'];
    $ma_phong = $_POST['ma_phong'];
    $luong = $_POST['luong'];

    // Thực hiện thêm nhân viên vào cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ql_nhansu";

    // Tạo kết nối đến cơ sở dữ liệu
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Chuẩn bị câu lệnh SQL để thêm nhân viên mới
    $sql = "INSERT INTO NHANVIEN (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong)
            VALUES ('$ma_nv', '$ten_nv', '$phai', '$noi_sinh', '$ma_phong', '$luong')";

    // Thực thi câu lệnh SQL
    if ($conn->query($sql) === TRUE) {
        echo "Thêm nhân viên thành công!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close(); // Đóng kết nối
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thêm Nhân Viên</title>
    <style>
        /* Add your CSS styling here */
        /* ... */
    </style>
</head>
<body>

<h2>Thêm Nhân Viên</h2>
<form method="post">
    <label for="ma_nv">Mã Nhân Viên:</label><br>
    <input type="text" id="ma_nv" name="ma_nv" required><br>
    <label for="ten_nv">Tên Nhân Viên:</label><br>
    <input type="text" id="ten_nv" name="ten_nv" required><br>
    <label for="phai">Giới Tính:</label><br>
    <select id="phai" name="phai">
        <option value="NAM">Nam</option>
        <option value="NU">Nữ</option>
    </select><br>
    <label for="noi_sinh">Nơi Sinh:</label><br>
    <input type="text" id="noi_sinh" name="noi_sinh" required><br>
    <label for="ma_phong">Mã Phòng:</label><br>
    <select id="ma_phong" name="ma_phong" required>
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <option value="<?php echo $row['ma_phong']; ?>"><?php echo $row['ten_phong']; ?></option>
        <?php endwhile; ?>
    <?php endif; ?>
    </select><br>

    <label for="luong">Lương:</label><br>
    <input type="text" id="luong" name="luong" required><br><br>
    <input type="submit" name="submit" value="Thêm Nhân Viên">
</form>

</body>
</html>
