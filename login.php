<?php
session_start();

// Kiểm tra nếu người dùng đã đăng nhập, chuyển hướng đến trang phù hợp
if(isset($_SESSION['username'])) {
    if($_SESSION['role'] == 1) {
        header("Location: admin.php");
        exit;
    } else {
        header("Location: index.php");
        exit;
    }
}

// Database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ql_nhansu";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xử lý đăng nhập
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role']; 
        if($row['role'] == 1) {
            header("Location: admin.php");
            exit;
        } else {
            header("Location: index.php");
            exit;
        }
    } else {
        $error = "Tên đăng nhập hoặc mật khẩu không chính xác.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
</head>
<body>

<h2>Đăng nhập</h2>
<?php if(isset($error)): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>
<form method="post">
    <label for="username">Tên đăng nhập:</label><br>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Mật khẩu:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" name="login" value="Đăng nhập">
</form>

</body>
</html>
