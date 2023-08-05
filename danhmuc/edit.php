<?php
//http://127.0.0.1:3456/edit.php?id=1
//including the database connection file
include("../database/connection.php");

try {
    $id = $_GET['id'];
    if (empty($id) || !is_numeric($id)) {
        # code...
        header("Location: 404.php");
    }
    $categories = $dbConn->query("SELECT id,name FROM categories where id=$id");

    while ($row = $categories->fetch(PDO::FETCH_ASSOC)) {
        # code...
        $id = $row['id'];
        $name = $row['name'];
       
    }
} catch (Exception $e) {
    //throw $th;
    header("Location:table.php");
}
?>


<?php
if (isset($_POST['submit'])) {


    $id = $_POST['id'];
    $name = $_POST['name'];
 
    $sql = "Update categories set name = '$name' WHERE id=$id";
    $result = $dbConn->exec($sql);
    // chuyển hướng trang web về index.php
    header("Location: table.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>edit</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Chỉnh sửa danh mục</h2>
        <form action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="name">Tên danh mục:</label>
                <input value="<?php echo $id; ?>" type="hidden" name="id">
                <input value="<?php echo $name; ?>" type="text" class="form-control" id="name" placeholder="Enter name" name="name">
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        const form = document.querySelector('#form');
        form.addEventListener('submit', function(e) {
            const name = document.querySelector('#name').value;
            if (!name || name.trim().length === 0) {
                swal('Vui lòng nhập tên');
                e.preventDefault();
                return false;
            }
            return true;
        });
    </script>

</body>

</html>