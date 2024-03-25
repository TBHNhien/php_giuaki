<?php
session_start(); // Bắt đầu session.

// Kiểm tra nếu người dùng đã đăng nhập và có quyền admin.
if(!isset($_SESSION['username']) || $_SESSION['role'] != 1) {
    header("Location: login.php"); // Nếu không phải admin, chuyển hướng về trang đăng nhập.
    exit;
}

// Kiểm tra nếu người dùng muốn đăng xuất.
if(isset($_GET['logout'])) {
    // Xoá tất cả session variables.
    $_SESSION = array();

    // Hủy bỏ session.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy(); // Hủy bỏ session.
    header("Location: login.php"); // Chuyển hướng về trang đăng nhập.
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

// Tính toán trang hiện tại và offset
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 5;
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

// Lấy tổng số dòng trong NHANVIEN
$totalResult = $conn->query("SELECT COUNT(*) as total FROM NHANVIEN");
$totalRow = $totalResult->fetch_assoc();
$total = $totalRow['total'];
$pages = ceil($total / $perPage);

// Query để lấy dữ liệu nhân viên với LIMIT và OFFSET
$sql = "SELECT * FROM NHANVIEN LIMIT {$perPage} OFFSET {$start}";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thông Tin Nhân Viên</title>
    <style>
        /* Add your CSS styling here */
        /* ... */
    </style>
</head>
<a href="admin.php?logout=true">Đăng xuất</a>
<body>

<div class="table-container">
    <h1>Thông Tin Nhân Viên</h1>
    <a href="add.php">Thêm Nhân Viên</a> <!-- Thêm nút Thêm Nhân Viên -->
    <table>
        <!-- Table headers -->
        <tr>
            <th>Mã Nhân Viên</th>
            <th>Tên Nhân Viên</th>
            <th>Giới Tính</th>
            <th>Nơi Sinh</th>
            <th>Tên Phòng</th>
            <th>Lương</th>
            <th>Hành Động</th> 
        </tr>

        <!-- PHP to fetch and display rows -->
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['Ma_NV']; ?></td>
                    <td><?php echo $row['Ten_NV']; ?></td>
                    <td>                  
                    <img src="<?php echo $row['Phai'] == 'NAM' ? './man.jpg ' : './woman.jpg'; ?>" alt="Gender" class="gender-icon" width="20" height="20">
                    </td>
                    <td><?php echo $row['Noi_Sinh']; ?></td>
                    <td><?php echo $row['Ma_Phong']; ?></td>
                    <td><?php echo $row['Luong']; ?></td>
                    <td>
                        <!-- Thêm nút sửa -->
                        <a href="edit.php?id=<?php echo $row['Ma_NV']; ?>">Sửa</a>
                        <!-- Thêm nút xoá -->
                        <a href="delete.php?id=<?php echo $row['Ma_NV']; ?>">Xoá</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Không có dữ liệu.</td>
            </tr>
        <?php endif; ?>
    </table>

    <!-- Pagination Links -->
    <div class="pagination">
    <?php for($i = 1; $i <= $pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>"<?php if($page == $i) echo ' class="active"'; ?>><?php echo $i; ?></a>
    <?php endfor; ?>
</div>

</div>

</body>
</html>

<?php
$conn->close();
?>
