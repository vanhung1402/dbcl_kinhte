<link rel="stylesheet" href="{$url}assets/css/hethong/home.css?ver=1.0
">

<div class="box fadeIn">
	<div class="box-body">
		{if isset($sinhvien)}
		<div class="row">
			<div class="col-md-12">
				<h3 class="text-center">Chào mừng bạn đến với hệ thống <span class="text-block">Đảm bảo chất lượng</span></h3>
				<h3 class="text-center"><strong class="text-uppercase">Trường Đại học Mở <span class="text-block">Hà Nội</span></strong></h3>
			</div>
			<div class="col-md-6 {if $sinhvien.ks.sophieutrong == 0}hidden{/if}">
				<hr>
				<div class="white-box">
	                <h3 class="box-title text-info text-center"><strong>THÔNG BÁO</strong></h3>
	                <h4 class="text-center"><i>Kỳ: {substr($dvhv, 0, 1)} năm học {substr($dvhv, 2, 4)} - {substr($dvhv, 7)}</i></h4>
	                {if $sinhvien.ks.sophieutrong > 0}
	                <ul class="feeds">
	                    <li class="text-center">
	                        <div class="bg-warning"><i class="fa fa-bell-o text-white"></i></div> Bạn đang có <strong class="text-danger chuahoanthanh">{$sinhvien.ks.sophieutrong}</strong> khảo sát chưa hoàn thành trong kỳ này, <a href="{$url}khaosathoctap/sinhvien" class="text-primary"><strong>khảo sát ngay.</strong></a>
	                    </li>
	                </ul>
	                {else}
	                <ul class="feeds">
	                    <li>
	                        <div class="bg-success"><i class="fa fa-check text-white"></i></div> Không có lớp môn cần khảo sát
	                    </li>
	                </ul>
	                {/if}
	            </div>
			</div>
			<div class="col-md-6{if $sinhvien.ks.sophieutrong == 0} col-md-offset-3{/if} text-center">
				<hr>
				<div class="white-box">
	                <h3 class="box-title text-info text-center"><strong>THÔNG TIN SINH VIÊN</strong></h3>
	                <div class="info">
	                	<p><i class="ti-user"></i> &nbsp; Họ và tên: <strong><i>{trim($sinhvien.tt.hodem_sv)} {$sinhvien.tt.ten_sv}</i></strong></p>
	                	<p><i class="ti-bookmark-alt"></i> &nbsp; Lớp hành chính: <strong><i>{$sinhvien.tt.ten_lop}</i></strong></p>
	                	<p><i class="ti-email"></i> &nbsp; Email: <strong><i>{if $sinhvien.tt.email_sv != ''}{$sinhvien.tt.email_sv}{else}<a href="{$url}email_user">Cập nhật mail ngay</a>{/if}</i></strong></p>
	                	<p><i class="ti-layout-media-overlay"></i> &nbsp; Trạng thái: <strong><i>{trim($sinhvien.tt.ten_trangthai_sinhvien)}</i></strong></p>
	                </div>
	            </div>
			</div>
        </div>
        {else}
		<div class="row">
			<div class="col-md-12">
				<h3 class="text-center">Chào mừng cán bộ <strong class="ten">{trim($canbo.tt.hodem_cb)} {$canbo.tt.ten_cb}</strong> đến với hệ thống Đảm bảo chất lượng</h3>
				<h3 class="text-center">Trường Đại học Mở Hà Nội</h3>
			</div>
        </div>
        {/if}
	</div>
</div>
<script type="text/javascript">
    function testAnim(x) {
        $('#animationSandbox').removeClass().addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
            $(this).removeClass();
        });
    };
	testAnim('fadeInUp');
</script>