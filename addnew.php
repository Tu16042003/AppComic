<?php
include_once('./database/connection.php');

$categories = $dbConn->query("SELECT id,name FROM categories")
?>

<?php
if (isset($_POST['submit'])) {

    // $currentDirectory = getcwd();
    // $uploadDirectory = "/uploads/";
    // $fileName = $_FILES['image']['name'];
    // $fileTmpName  = $_FILES['image']['tmp_name'];
    // $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);
    // // upload file
    // move_uploaded_file($fileTmpName, $uploadPath);

    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image = $_POST['imgUrl'];// đổi image thành imgUrl
    $categoryId = $_POST['categoryId'];
    $description = $_POST['description'];
    // bắt lỗi khi người dùng không nhập đủ thông tin

    // lấy link
    // $image = "http://127.0.0.1:3456/uploads/" . $fileName;

    $sql = "INSERT INTO products (name, price, quantity, image, categoryId, description)
    VALUES ('$name', '$price', '$quantity', '$image', '$categoryId', '$description')";
    $result = $dbConn->exec($sql);
    // chuyển hướng trang web về index.php
    header("Location: index.php");
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

    <!-- firebase -->
    <script src="https://www.gstatic.com/firebasejs/5.4.0/firebase.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Thêm mới sản phẩm</h2>
        <form id="form" action="addnew.php" method="post" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="name">Tên sản phẩm:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
            </div>
            <div class="mb-3 mt-3">
                <label for="price">Giá sản phẩm:</label>
                <input type="number" class="form-control" id="price" placeholder="Enter price" name="price">
            </div>
            <div class="mb-3 mt-3">
                <label for="quantity">Số lượng:</label>
                <input type="number" class="form-control" id="quantity" placeholder="Enter quantity" name="quantity">
            </div>
            <div class="mb-3 mt-3">
                <label for="image">Hình ảnh:</label>
                <input onchange="onChangeImage()" type="file" class="form-control" id="image" placeholder="Enter image" name="image">
            </div>
            <img id="image-display" alt="Hình ảnh" width="200" />
            <input type="hidden" name="imgUrl" id="imgUrl" />

            <div class="mb-3 mt-3">
                <label for="category">Danh mục:</label>
                <select class="form-control" id="categoryId" name="categoryId">
                    <?php
                    while ($row = $categories->fetch(PDO::FETCH_ASSOC)) {
                        # code...
                        echo "<option value='" . $row['id'] . " '> " . $row['name'] . " </option>";
                    }
                    ?>

                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="description">Mô tả:</label>
                <textarea class="form-control" id="description" placeholder="Enter description" name="description"></textarea>
            </div>
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
        //hiển thị hình
        // const image = document.querySelector('#image');
        // const imageDisplay = document.querySelector('#image-display');
        // image.addEventListener('change', function(e) {
        //     const file = this.files[0];
        //     const url = URL.createObjectURL(file);
        //     imageDisplay.src = url;
        // });

        // firebase
        const firebaseConfig = {
            apiKey: "AIzaSyAl6l7bwfR2TooYL9gkbuKqXOLxpMIAVJo",
            authDomain: "tuabc-38208.firebaseapp.com",
            projectId: "tuabc-38208",
            storageBucket: "tuabc-38208.appspot.com",
            messagingSenderId: "795631925043",
            appId: "1:795631925043:web:d3fe964631eec94b25f046",
            measurementId: "G-F0RMJY3TJX"
        };
        firebase.initializeApp(firebaseConfig);

        // xử lý ảnh
        const onChangeImage = () => {
            const file = document.getElementById('image').files[0];
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('image-display').src = e.target.result;
            }
            reader.readAsDataURL(file);
            // upload firebase
            const ref = firebase.storage().ref(new Date().getTime() + '-' + file.name);
            const uploadTask = ref.put(file);
            uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
                (snapshot) => {},
                (error) => {
                    console.log('firebase error: ', error)
                },
                () => {
                    uploadTask.snapshot.ref.getDownloadURL().then(url => {
                        console.log('>>>>> File available at:', url);
                        document.getElementById('imgUrl').value = url;
                    })
                }
            );
        }
    </script>

</body>

</html>