<?php
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

// Xử lý chỉnh sửa thông tin nhân viên
if(isset($_POST['edit'])) {
    $id = $_POST['id'];
    $ten_nv = $_POST['ten_nv'];
    $noi_sinh = $_POST['noi_sinh'];
    $ma_phong = $_POST['ma_phong'];
    $luong = $_POST['luong'];

    // Query để cập nhật thông tin nhân viên
    $sql = "UPDATE NHANVIEN SET Ten_NV='$ten_nv', Noi_Sinh='$noi_sinh', Ma_Phong='$ma_phong', Luong=$luong WHERE Ma_NV='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Lấy thông tin nhân viên để hiển thị trong form
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM NHANVIEN WHERE Ma_NV='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin nhân viên</title>
</head>
<body>

<h2>Chỉnh sửa thông tin nhân viên</h2>
<form method="post">
    <input type="hidden" name="id" value="<?php echo $row['Ma_NV']; ?>">
    <label for="ten_nv">Tên nhân viên:</label><br>
    <input type="text" id="ten_nv" name="ten_nv" value="<?php echo $row['Ten_NV']; ?>"><br>
    <label for="noi_sinh">Nơi sinh:</label><br>
    <input type="text" id="noi_sinh" name="noi_sinh" value="<?php echo $row['Noi_Sinh']; ?>"><br>
    <label for="ma_phong">Mã phòng:</label><br>
    <input type="text" id="ma_phong" name="ma_phong" value="<?php echo $row['Ma_Phong']; ?>"><br>
    <label for="luong">Lương:</label><br>
    <input type="text" id="luong" name="luong" value="<?php echo $row['Luong']; ?>"><br><br>
    <input type="submit" name="edit" value="Lưu">
</form>

</body>
</html>
