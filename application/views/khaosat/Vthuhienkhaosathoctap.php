<link rel="stylesheet" href="{$url}assets/plugins/icheck/skins/all.css?v=1.0.2">
<link rel="stylesheet" href="{$url}assets/css/khaosat/thuchienkhaosat.css?v=1.0.2">

<div class="row" id="khaosat">
	<div class="col-md-4" id="list-hocvu">
	{foreach $donvihocvu as $dvhv}
	    <div class="panel panel-default">
	        <div class="panel-heading" data-perform="panel-collapse">
	        	<span class="hocky">
	        		<i class="fa fa-bookmark-o"></i> &nbsp; Kỳ {substr($dvhv.ma_donvihocvu, 0, 1)} năm học {substr($dvhv.ma_donvihocvu, 2, 4)} - {substr($dvhv.ma_donvihocvu, 7)}
	        	</span>
	            <div class="panel-action">
	            	<a href="javascript:void(0)" data-perform="panel-collapse"><i class="ti-minus"></i></a>
	            </div>
	        </div>
	        <div class="panel-wrapper collapse in">
	            <div class="panel-body">
	            	<div class="list-group">
	            	{if isset($dsphieu[$dvhv.ma_donvihocvu])}
	        		{foreach $dsphieu[$dvhv.ma_donvihocvu] as $p}
						<a href="javascript:void(0)" class="list-group-item phieu" phieu-id="{$p.ma_phieu}">
							<i class="fa fa-file-powerpoint-o icon"></i> &nbsp; {$p.ten_monhoc}
							{if ($p.phieuxong != '')}
							<i class="text-success fa fa-check status"></i>
							{else}
							<i class="text-success fa fa-check status hidden"></i>
							{/if}
							<i class="fa fa-spin fa-spinner hidden"></i>
						</a>
	        		{/foreach}
	        		{else}
	        		<div class="list-group-item list-group-item-warning text-center">
	        			Chưa có dữ liệu khảo sát
	        		</div>
	        		{/if}
					</div>
	            </div>
	        </div>
	    </div>
	{/foreach}
	</div>
	<div class="col-md-8">
		<div id="khongcodulieu">
			<div class="alert alert-warning text-center">
                <strong class="text-uppercase">Chưa chọn lớp khảo sát</strong>
            </div>
		</div>	
		<div class="panel panel-default block hidden" id="thongtinphieu">
		    <div class="panel-heading">
		        <h3 class="text-center" id="tenkhaosat"></h3>
		        <h4 class="text-center"><i id="loaikhaosat"></i></h4>
		        <p><span><i class="fa fa-university"></i> &nbsp; Môn học: </span><span id="lopmon"></span></p>
		        <p><span><i class="fa fa-user"></i> &nbsp;&nbsp; Giảng viên: </span><span id="giangvien"></span></p>
		        <div class="row">
		        	<div class="col-xs-6">
		        		<p><span><i class="fa fa-tag"></i> &nbsp;&nbsp; Học kỳ: </span><span id="kyhoc"></span></p>
		        		<p><span><i class="fa fa-space-shuttle"></i> &nbsp; Hình thức học: </span><span id="hinhthuc"></span></p>
		        		<p><span><i class="fa fa-calendar-o"></i> &nbsp;&nbsp; Ngày bắt đầu khảo sát: </span><span id="ngaybatdauks"></span></p>
		        	</div>
		        	<div class="col-xs-6">
		        		<p><span><i class="fa fa-circle-o"></i> &nbsp; Ngày bắt đầu: </span><span id="ngaybatdau"></span></p>
		        		<p><span><i class="fa fa-circle"></i> &nbsp; Ngày kết thúc: </span><span id="ngayketthuc"></span></p>
		        		<p><span><i class="fa fa-calendar"></i> &nbsp; Ngày kết thúc khảo sát: </span><span id="ngayketthucks"></span></p>
		        	</div>
		        </div>
		    </div>
		    <div class="panel-wrapper collapse in" aria-expanded="true">
		        <div class="panel-body" id="khaosat-phieu">

		        </div>
		    </div>
		    <div class="panel-footer text-center"> 
				<button class="btn btn-success waves-effect waves-light hidden" type="button" id="luu">
					<span class="btn-label">
						<i class="fa fa-check"></i>
					</span>
					LƯU
				</button>
		    </div>

		    <div class="alert alert-danger text-center text-uppercase" id="thongbao"></div>
		</div>
	</div>
</div>

<script type="text/javascript" src="{$url}assets/plugins/icheck/icheck.js?v=1.0.2"></script>
<script type="text/javascript" src="{$url}assets/js/khaosat/thuchienkhaosat.js?v=1.0.3"></script>