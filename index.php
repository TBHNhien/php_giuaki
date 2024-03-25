<?php
session_start();

session_destroy(); 

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
<body>

<div class="table-container">
    <h1>Thông Tin Nhân Viên</h1>
    <table>
        <!-- Table headers -->
        <tr>
            <th>Mã Nhân Viên</th>
            <th>Tên Nhân Viên</th>
            <th>Giới Tính</th>
            <th>Nơi Sinh</th>
            <th>Tên Phòng</th>
            <th>Lương</th>
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
