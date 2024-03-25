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

// Xử lý xoá nhân viên
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    // Query để xoá nhân viên
    $sql = "DELETE FROM NHANVIEN WHERE Ma_NV='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Xoá nhân viên thành công!";
        // header("Location: index.php");       
        //exit;
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
