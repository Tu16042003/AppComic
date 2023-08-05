<?php
//GET
include_once('./database/connection.php');

if (!isset($_POST['submit'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];
    if (empty($email) || empty($token)) {
        header("Location: 404.php");
        exit();
    }
    // kt token
    $result = $dbConn->query(" SELECT id from 
                        reset_password where email = '$email' 
                        and token = '$token' 
                        and createdAt >= DATE_SUB(NOW(), INTERVAL 1 HOUR) 
                        and avaiable = 1  ");
    $user = $result->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        header("Location: 404.php");
        exit();
    }
} //POST
else {

    try {
        // doc dl tu form
        $email = $_POST['email'];
        $token = $_POST['token'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password != $confirm_password) {
            echo "Mật khẩu không khớp";
            header("Location: 404.php");
            exit();
        }
        // kt token
        $result = $dbConn->query("select id from reset_password where email = '$email'
                        and token = '$token'
                        and createdAt>=DATE_SUB(NOW(),INTERVAL 1 HOUR)
                        and avaiable = 1 ");
        $user = $result->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            header("Location: 404.php");
            exit();
        }
        // cap nhat
        $password = password_hash($password, PASSWORD_BCRYPT);
        $dbConn->query(" update users set password = '$password' where email = '$email'");
        // huy token
        $dbConn->query(" update reset_password set avaiable = 0 where email = '$email' and token ='$token'");
        header("Location: Login.php");
    } catch (Exception $e) {
        echo json_encode(array(
            "status" => false,
            "message" => $e->getMessage()
        ));
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ResetPassword</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">Admin</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="container mt-3">
                                        <h2>Reset Password</h2>
                                        <form action="resetpassword.php" method="post" class="row g-3 needs-validation" novalidate>
                                            <div class="col-12">
                                                <label for="pwd1" class="form-label">New Password</label>
                                                <input type="password" name="password" placeholder="Mat khau moi" class="form-control" id="pwd1">
                                                <div class="invalid-feedback">Please enter new password.</div>
                                            </div>
                                            <div class="col-12">
                                                <label for="pwd" class="form-label">Confirm Password</label>
                                                <input type="password" name="confirm_password" placeholder="Nhap lai password" class="form-control" id="pwd" required>
                                                <div class="invalid-feedback">Please enter confirm password!</div>
                                            </div>
                                            <input type="hidden" name="email" value="<?php echo $_GET['email'] ?>" />
                                            <input type="hidden" name="token" value="<?php echo $_GET['token'] ?>" />
                                    </div>
                                    <br/>
                                    <div class="col-12">
                                        <button name="submit" class="btn btn-primary w-100" type="submit">Khôi phục</button>
                                    </div>

                                    </form>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
        </div>

        </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>