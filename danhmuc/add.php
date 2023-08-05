<?php
include_once('../database/connection.php');

?>

<?php
if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    // bắt lỗi khi người dùng không nhập đủ thông tin

    $sql = "INSERT INTO categories (name)
    VALUES ('$name')";
    $result = $dbConn->exec($sql);
    // chuyển hướng trang web về index.php
    header("Location: table.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>add</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Thêm mới danh mục</h2>
        <form id="form" action="add.php" method="post" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="name">Tên danh mục:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
            </div>

            <br/>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        const form = document.querySelector('#form');
        form.addEventListener('submit', function(e) {
            const name = document.querySelector('#name').value;
            if (!name || name.trim().length === 0) {
                swal('Vui lòng nhập tên sp');
                e.preventDefault();
                return false;
            }
            return true;
        });
    </script>

</body>

</html>