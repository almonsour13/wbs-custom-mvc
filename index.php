<?php
require 'core/App.php';
require 'core/Router.php';
require_once 'core/Controller.php';
$router = new Router();

// Include your custom routes from routes.php
require 'routes.php';

$url = isset($_GET['url']) ? $_GET['url'] : '/';
$method = $_SERVER['REQUEST_METHOD'];
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Water Billing System</title>

    <!-- Custom fonts for this template -->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/logo.png" type="image/x-icon">

    <!-- Custom styles for this page -->
    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>
    <script src="assets/js/jquery/jquery-3.6.3.min.js"></script>

    

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php 
            if(isset( $_SESSION['id'])){
                require 'app/views/template/side-bar.php';
                ?>
                    <!-- Content Wrapper -->
                    <div id="content-wrapper" class="d-flex flex-column">
                        <div id="content">
                            <!-- header -->
                            <?php require 'app/views/template/header.php';  ?>
                        <!-- Main Content -->
                            <?php
                                $router->route($url, $method);
                            ?> 
                            <!-- End of Main Content -->
                            <!-- Footer -->
                        <!-- End of Footer -->
                        </div>
                            <?php require 'app/views/template/footer.php'; ?>
                        
                    </div>
                <?php 
            }else{
                require 'app/views/form/login-form.php'; 
            }
        ?>
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/js/jquery/jquery-3.7.1.min.js"></script><!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <!-- <script src="assets/js/demo/datatables-demo.js"></script> -->
    <script src="assets/js/jquery/jquery-3.7.1.min.js"></script>
    

</body>

</html>
