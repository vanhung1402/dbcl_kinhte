<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="{$url}assets/images/logo_hou.png">
    <title>{$title}</title>
    <!-- Bootstrap Core CSS -->
    <link href="{$url}assets/template/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{$url}assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="{$url}assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{$url}assets/template/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{$url}assets/template/css/style.css?ver=1.15" rel="stylesheet">
    <!-- color CSS -->
    <link href="{$url}assets/template/css/colors/green.css" id="theme" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="{$url}assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- DataTable -->
    <link href="{$url}assets/plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="{$url}assets/plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />
    <!-- Custom css by Hung  -->
    <link href="{$url}assets/css/main.css?ver=1.105" rel="stylesheet">
    <!-- All Jquery -->
    <script src="{$url}assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <base href="{$url}">
    <script src="assets/js/bootstrap-paginator.js"></script>
</head>

<body class="fix-header">
    <!-- Preloader -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Topbar header - style you can find in pages.scss -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="{$url}home">
                        <b class="hidden-xs hidden-sm">HỆ THỐNG ĐẢM BẢO CHẤT LƯỢNG - TRƯỜNG ĐẠI HỌC MỞ HÀ NỘI</b>
                        <b class="hidden-md hidden-lg">HOU</b>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-left">
                    <li><a class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>
                </ul>
            </div>
        </nav>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav">
                <div class="sidebar-head">
                    <h3><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span></h3>
                </div>
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="{$url}home" class="waves-effect active">
                            <i class="mdi mdi-home fa-fw"></i> <span class="hide-menu">Trang chủ</span>
                        </a>
                    </li>
                    {foreach $menu as $m}
                    {if $m['0'].hienthi_menu == '0'}
                    {foreach $m as $r}
                    <li>
                        <a href="{$url}{$r.id_route}" class="waves-effect active">
                            <i class="{$r.icon_route} fa-fw"></i> <span class="hide-menu">{$r.ten_route}</span>
                        </a>
                    </li>
                    {/foreach}
                    {else}
                    <li>
                        <a class="waves-effect" id="menu-{$m['0'].id_menu}">
                            <i class="{$m['0'].icon_menu} fa-fw" data-icon="v"></i>
                            <span class="hide-menu"> {$m['0'].ten_menu} <span class="fa arrow"></span></span>
                        </a>
                        <ul class="nav nav-second-level">
                            {foreach $m as $r}
                            <li> <a href="{$url}{$r.id_route}" id-menu="{$r.id_menu}"><i class="{$r.icon_route} fa-fw"></i> <span class="hide-menu"> {$r.ten_route}</span></a> </li>
                            {/foreach}
                        </ul>
                    </li>
                    {/if}
                    {/foreach}
                    <li class="pull-right">
                        <a class="waves-effect" id="menu-{$m['0'].id_menu}">
                            <i class="mdi mdi-account fa-fw" data-icon="v"></i>
                            <span class="hide-menu"> <small class="hidden-xs hidden-sm">Xin chào, </small>{$ten}<span class="fa arrow"></span></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{$url}doimatkhau" class="waves-effect"><i class="mdi mdi-key-change fa-fw"></i> <span class="hide-menu">Đổi mật khẩu</span></a>
                            </li>
                            <li>
                                <a href="{$url}logout" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu">Đăng xuất</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div id="page-wrapper">
            <div class="container" id="container">
                <div class="row">
                    <div class="col-lg-12 no-padding">
                        
                            