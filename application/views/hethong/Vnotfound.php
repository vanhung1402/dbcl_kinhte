<!DOCTYPE html>  
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/logo_hou.png">
    <title>Không tìm thấy trang vừa yêu cầu</title>
    <!-- Bootstrap Core CSS -->
    <link href="{$url}assets/template/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{$url}assets/template/css/animate.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{$url}assets/template/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="{$url}assets/template/css/colors/default.css" id="theme"  rel="stylesheet">
    <style type="text/css">
        h1, h2, h3, h4, h5, h6 {
            color: #313131;
            font-family: Rubik,sans-serif;
            margin: 10px 0;
            font-weight: 300;
        }
    </style>
</head>
<body>
    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h1 class="text-danger">404</h1>
                <h3 class="text-uppercase">NOT FOUND !</h3>
                <p class="text-muted m-t-30 m-b-30">Có vẻ như bạn vừa truy cập một đường dẫn hỏng hoặc không nằm trong quyền hạn của bạn!</p>
                <a href="{$url}" class="btn btn-danger btn-rounded waves-effect waves-light m-b-40">Quay lại trang chủ</a>
            </div>
            <footer class="footer text-center">2017 © Ample Admin.</footer>
        </div>
    </section>
    <!-- jQuery -->
    <script src="{$url}assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{$url}assets/template/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
