<!DOCTYPE html>  
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/logo_hou.png">
    <title>Login - Hệ thống đảm bảo chất lượng | Trường Đại học Mở Hà Nội</title>
    <!-- Bootstrap Core CSS -->
    <link href="{$url}assets/template/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{$url}assets/template/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{$url}assets/template/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="{$url}assets/template/css/colors/default.css" id="theme"  rel="stylesheet">
    <style type="text/css">
        .new-login-register .lg-info-panel .lg-content{
            padding: 0 40px;
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="new-login-register">
        <div class="lg-info-panel">
            <div class="inner-panel">
                <div class="lg-content">
                    <h2>HỆ THỐNG ĐẢM BẢO CHẤT LƯỢNG</h2>
                    <h2>TRƯỜNG ĐẠI HỌC MỞ HÀ NỘI</h2>
                    <!-- <p class="text-muted">FFC</p> -->
                    <!-- <a href="{$url}assets/template/javascript:void(0)" class="btn btn-rounded btn-danger p-l-20 p-r-20"> Buy now</a> -->
                </div>
            </div>
        </div>
        <div class="new-login-box">
            <div class="white-box">
                <h3 class="box-title m-b-0">KHOA KINH TẾ</h3>
                <form class="form-horizontal new-lg-form" id="loginform" method="POST">

                    <div class="form-group  m-t-20">
                        <div class="col-xs-12">
                            <label>Tài khoản</label>
                            <input name="username" class="form-control" type="text" required="" placeholder="..." autofocus autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label>Mật khẩu</label>
                            <input name="password" class="form-control" type="password" required="" placeholder="..." id="password">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit" name="action" value="base-login">Đăng nhập</button>
                        </div>
                    </div>
                    <input type="hidden" class="csrf" name="{$csrf_token_name}" value="{$csrf_token}"/>
                    {if !empty($msg)}
                    <div class="form-group text-{$msg.type} text-center m-t-20">
                        <p>{$msg.text}</p>
                    </div>
                    {/if}
                </form>
                <p>Hỗ trợ kỹ thuật: <strong>0399 220 924 - 0394 684 487</strong></p>
                <small>Sinh viên quên mật khẩu vui lòng liên hệ giáo vụ khoa hoặc cố vấn học tập</small>
            </div>
        </div>            


    </section>
    <script type="text/javascript">
        function fillPassword(){
            document.getElementById('password').value = 'ffc_dbcl2020';
        }
    </script>
    <!-- jQuery -->
    <script src="{$url}assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{$url}assets/template/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{$url}assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

    <!--slimscroll JavaScript -->
    <script src="{$url}assets/template/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="{$url}assets/template/js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{$url}assets/template/js/custom.min.js"></script>
    <!--Style Switcher -->
    <script src="{$url}assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>
</html>
