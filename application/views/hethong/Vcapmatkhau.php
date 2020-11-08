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
        <!-- <div class="message">
            <h4 class='white-box text-center text-danger'>Mã sinh viên hoặc email của bạn không chính xác</h4>
        </div> -->
        <div class="new-login-box">
            <div class="white-box">
                {if !empty($rq)}{$rq}{/if}
                <h3 class="box-title m-b-0" onclick="fillPassword();">Cấp lại mật khẩu</h3>
                <!-- <small>Nhập thông tin của bạn bên dưới</small> -->
                <form class="form-horizontal new-lg-form" id="capmatkhau" method="POST" onsubmit="return mySubmitFunction(event)">
                    
                    <div class="form-group  m-t-20">
                        <div class="col-xs-12">
                            <label>Mã sinh viên</label>
                            <input name="masv" class="form-control" type="text" required="" placeholder="..." autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label>Email</label>
                            <input name="email" class="form-control" type="text" required="" placeholder="..." id="email">
                            <p id="error" class="text-danger mt-5"></p>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit" id="xacthuc" name="caplai_mk" value="base-login">Xác thực</button>
                        </div>
                    </div>
                    <div><a href="{$url}">Đăng nhập khảo sát?</a></div>
                    <input type="hidden" class="csrf" name="{$csrf_token_name}" value="{$csrf_token}"/>
                    {if !empty($msg)}
                    <div class="form-group text-{$msg.type} text-center m-t-20">
                        <p>{$msg.text}</p>
                    </div>
                    {/if}
                </form>
            </div>
        </div>  
    </section>
    {literal}
    <script type="text/javascript">
        var pattern = /^[a-z][a-z0-9_\.]{5,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/;
        var email = document.getElementById('email');
        email.onkeyup = function(){
            if(pattern.test(email.value) || email.value ==""){
                document.getElementById('error').innerText ="";
            }else{
                document.getElementById('error').innerText ="Email không hợp lệ";
            }
        }
        function mySubmitFunction(e){
            if(!pattern.test(email.value)){
                email.focus();
                e.preventDefault();
                return false;
            }
        }
    </script>
    {/literal}
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
