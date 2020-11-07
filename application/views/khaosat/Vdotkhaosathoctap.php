<link rel="stylesheet" href="{$url}assets/plugins/icheck/skins/all.css?v=1.0.2">
<link href="{$url}assets/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
<link href="{$url}assets/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<link rel="stylesheet" href="{$url}assets/css/khaosat/dotkhaosat.css?ver=1.0">

<div class="panel panel-default m-t-5">
    <div class="panel-heading">
    	<p class="text-uppercase text-center">ĐỢT KHẢO SÁT HỌC TẬP</p>

    	<form method="POST">
            <div class="loc row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="input-group">
                        <span class="input-group-addon">Khảo sát:</span>
                        <select name="khaosat" id="khaosat" class="loc-item form-control select2" required>
                            {foreach $dskhaosat as $ks}
                            <option value="{$ks.ma_khaosat}" {if $ma_khaosat == $ks.ma_khaosat}selected{/if}>Hình thức đào tạo - {$ks.ma_hinhthuc}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {if (!$khaosat)}
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
        	<div class="alert alert-warning text-center">
                <strong class="text-uppercase">Chưa chọn dữ liệu lọc</strong>
            </div>
        </div>
    </div>
    {else}
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
        	{if empty($ds_dotkhaosat)}
        	<div class="alert alert-warning text-center text-uppercase">Chưa có đợt khảo sát</div>
        	{else}
        	<form method="POST">
				<div class="table-responsive" id="table-lopmon">
	                <table class="table table-bordered datatable">
	                    <thead>
	                        <tr>
	                            <th class="text-center">STT</th>
	                            <th class="text-center" width="100">Đơn vị học vụ</th>
	                            <!-- <th class="text-center">Đợt khảo sát</th> -->
	                            <!-- <th class="text-center" width="160">Thời gian</th> -->
	                            <th class="text-center">Tổng số lớp môn</th>
	                            <th class="text-center">Tổng số sinh viên</th>
	                            <th class="text-center">Số phiếu khả dụng</th>
	                            <th class="text-center">Số phiếu đã tạo</th>
	                            <th class="text-center">Số phiếu đã khảo sát</th>
	                            <th class="text-center" width="100">Tác vụ</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	{$map_dot = array()}
	                    	{foreach $ds_dotkhaosat as $key => $dks}
	                        <tr>
	                            <td class="text-center">{$key + 1}</td>
	                            <td class="donvihocvu" id="hocvu-{$dks.ma_dotkhaosat}">{$dks.ma_donvihocvu}</td>
	                            <!-- <td class="donvihocvu" id="tendot-{$dks.ma_dotkhaosat}">
	                            	{if !isset($map_dot[$dks.ma_donvihocvu])}
	                            	{$map_dot[$dks.ma_donvihocvu] = 1}
	                            	{/if}
	                            	Đợt {$map_dot[$dks.ma_donvihocvu]++}
	                            </td> -->
	                            <!-- <td class="text-center" id="timerange-{$dks.ma_dotkhaosat}">
	                            	{$dks.nbd} - {$dks.nkt}
	                            </td> -->
	                            <td class="text-center">
	                            	{if isset($dks.tonglopmon)}
	                            	{$dks.tonglopmon}
	                            	{else}
	                            	0
	                            	{/if}
	                            </td>
	                            <td class="text-center">
	                            	<span class="">
	                            	{if isset($dks.tongsinhvien)}
	                            	{$dks.tongsinhvien}
	                            	{else}
	                            	0
	                            	{/if}
		                            </span>
		                        </td>
	                            <td class="text-center">
	                            	<span class="">
	                            	{if isset($dks.sophieukhadung)}
	                            	{$dks.sophieukhadung}
	                            	{else}
	                            	0
	                            	{/if}
	                            	</span>
	                            </td>
	                            <td class="text-center">
	                            	<span class="">
	                            	{if isset($dks.phieudatao)}
	                            	{$dks.phieudatao}
	                            	{else}
	                            	0
	                            	{/if}
	                            	</span>
	                            </td>
	                            <td class="text-center">
	                            	<span class="">
	                            	{if isset($dks.dakhaosat)}
	                            	{$dks.dakhaosat}
	                            	{else}
	                            	0
	                            	{/if}
	                            	</span>
	                            </td>
	                            <td class="tacvu-dotkhaosat text-center">
	                            	<a href="{$url}khaosathoctap/dot?khaosat={$ma_khaosat}#danhsach-lopmon" value="{$dks.ma_dotkhaosat}" data-id="{$dks.ma_dotkhaosat}" name="load-dot" class="btn btn-xs btn-primary load-dot" data-toggle="tooltip" data-placement="top" data-original-title="Quản lý lớp môn khảo sát">
	                        			<i class="ti-pencil-alt"></i>
	                        		</a>
	                        		<!-- <button type="button" class="btn btn-xs btn-info btn-change-timerange" value="{$dks.ma_dotkhaosat}" data-toggle="modal" data-target="#sua-dotkhaosat-modal">
	                        			<i class="ti-calendar"></i>
	                        		</button> -->
	                        		<button type="submit" name="khoadot" value="{$dks.ma_dotkhaosat}" class="btn btn-xs btn-warning" onclick="return confirm('Bạn đã chắc chắn đóng đợt khảo sát này?')" data-toggle="tooltip" data-placement="top" data-original-title="Đóng gói đợt khảo sát">
	                        			<i class="ti-archive"></i>
	                        		</button>
	                            	{if !isset($dks.phieudatao) || $dks.phieudatao < 1}
	                        		<button type="submit" name="xoadot" value="{$dks.ma_dotkhaosat}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Xóa đợt khảo sát">
	                        			<i class="ti-trash"></i>
	                        		</button>
	                        		{/if}
	                            </td>
	                        </tr>
	                    	{/foreach}
	                    </tbody>
	                </table>
	            </div>
	        </form>
            {/if}
        </div>
    </div>
    <div class="panel-footer text-info">
    	<div class="form-group text-center">
			<button id="them-dotkhaosat" class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target="#them-dotkhaosat-modal">
				<span class="btn-label">
					<i class="fa fa-plus"></i>
				</span>
				THÊM ĐỢT KHẢO SÁT
			</button>
		</div>
    </div>
    {/if}
</div>

{if ($khaosat)}
<form class="form-material form-horizontal" method="POST">
	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" id="them-dotkhaosat-modal">
	    <div class="modal-dialog modal-sm">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                <h4 class="modal-title">Thêm đợt khảo sát mới</h4> </div>
	            <div class="modal-body">
	            	<div class="form-group">
	                    <label class="col-md-12">Chọn đơn vị học vụ</label>
	                    <div class="col-md-12">
	                        <select name="dvhv" class="form-control">
	                        	{foreach $donvihocvu as $dvhv}
	                        	<option value="{$dvhv.ma_donvihocvu}">{$dvhv.ma_donvihocvu}</option>
	                        	{/foreach}
	                        </select>
	                    </div>
	                    <!-- <div class="col-md-12">
	                        <h5 class="box-title m-t-30">Thời gian áp dụng:</h5>
	                        <input class="form-control input-daterange-datepicker" type="text" name="daterange" />
                    	</div> -->
	            	</div>
	            </div>
	            <div class="modal-footer">
	            	<input type="hidden" class="csrf" name="{$csrf_token_name}" value="{$csrf_token}"/>
	                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Đóng</button>
	                <button type="submit" name="action" value="them-dotkhaosat" class="btn btn-info">
	                	<i class="fa fa-check"></i>&nbsp; Thêm
	                </button>
	            </div>
	        </div>
	    </div>
	</div>
</form>

<form class="form-material form-horizontal" method="POST">
	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" id="sua-dotkhaosat-modal">
	    <div class="modal-dialog modal-sm">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                <h4 class="modal-title">Thay đổi thời gian khảo sát</h4> </div>
	            <div class="modal-body">
	            	<div class="form-group">
	                    <div class="col-md-12">
	                        <h5 class="box-title m-t-30">Thời gian áp dụng:</h5>
	                        <input class="form-control input-daterange-datepicker" type="text" name="daterange-change" id="time-range-change" />
	                    </div>
	            	</div>
	            </div>
	            <div class="modal-footer">
	            	<input type="hidden" class="csrf" name="{$csrf_token_name}" value="{$csrf_token}"/>
	                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Đóng</button>
	                <button type="submit" name="luu-dotkhaosat" value="" class="btn btn-info" id
	                ="btn-luu-dotkhaosat">
	                	<i class="fa fa-check"></i>&nbsp; Lưu
	                </button>
	            </div>
	        </div>
	    </div>
	</div>
</form>

<div class="panel panel-default m-t-5 hidden" id="load-dot">
    <div class="panel-heading text-uppercase text-center">
    	Đợt khảo sát học vụ: <span id="donvihocvu"></span>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
        	<div class="row">
        		<div class="col-md-3">
        			<div class="form-group">
        				<div class="input-group">
	                        <span class="input-group-addon">T.gian khảo sát:</span>
	                        <select name="locngay" id="locngay" class="form-control select2 loc-lopmon-item">
	                            <option value="all">--- Không lọc ---</option>
	                            <option value="chuadat">Chưa đặt ngày</option>
	                            <option value="dadat">Đã đặt ngày</option>
	                        </select>
	                    </div>
        			</div>
        		</div>
        		<div class="col-md-3">
        			<div class="form-group">
        				<div class="input-group">
	                        <span class="input-group-addon">Tình trạng phiếu:</span>
	                        <select name="locphieu" id="locphieu" class="form-control select2 loc-lopmon-item">
	                            <option value="all">--- Không lọc ---</option>
	                            <option value="chuadu">Chưa đủ phiếu</option>
	                            <option value="dadu">Đã đủ phiếu</option>
	                        </select>
	                    </div>
        			</div>
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-md-6" id="timkiem">
        			<div class="form-group">
        				<input type="text" class="form-control loc-lopmon-item" placeholder="Nhập tên hoặc mã lớp môn để lọc...">
        			</div>
        		</div>
        		<div class="col-md-6" id="config">
        			<div class="form-group text-right">
	    				<button class="btn btn-info btn-outline" id="config-dotkhaosat" title="Đặt mốc khảo sát cho các lớp môn đã chọn">
	    					<i class="fa fa-spin fa-cog"></i> &nbsp; Đặt mốc khảo sát
	    				</button>
	    				<button class="btn btn-primary btn-outline" id="create-all-form" title="Tạo đủ phiếu khỏa sát cho các lớp môn đã chọn">
	    					<i class="ti-files"></i> &nbsp; Tạo phiếu khảo sát
	    				</button>
	    				<button class="btn btn-warning btn-outline" id="remove-all-form" title="Tạo đủ phiếu khỏa sát cho các lớp môn đã chọn">
	    					<i class="ti-cut"></i> &nbsp; Hủy phiếu khảo sát
	    				</button>
	    			</div>
        		</div>
        	</div>
        	<div class="table-responsive">
	        	<table class="table table-bordered table-hover" id="dslopmon">
	        		<thead>
	        			<tr>
	        				<th width="35">
	        					<div class="skin skin-square">
		                            <input id="check-all" type="checkbox">
		                        </div>
		                    </th>
	        				<th width="35">TT</th>
	        				<th>Lớp môn</th>
	        				<th width="100">Thời gian học</th>
	        				<th width="100">Thời gian khảo sát</th>
	        				<th width="100">Hình thức</th>
	        				<th width="50">Số sinh viên</th>
	        				<th width="50">Số phiếu đã tạo</th>
	        				<th width="50">Số phiếu đã khảo sát</th>
	        				<th width="200">Tác vụ</th>
	        			</tr>
	        		</thead>
	        		<tbody id="danhsach-lopmon" class="skin skin-square">
	        			
	        		</tbody>
	        		<tfoot>
	        			<tr>
	        				<th colspan="6">Tổng:</th>
	        				<th><span id="phieukhadung"></span><br>phiếu khả dụng</th>
	        				<th><span id="phieudatao"></span><br>phiếu đã tạo</th>
	        				<th><span id="phieudakhaosat"></span><br>phiếu đã khảo sát</th>
	        				<th></th>
	        			</tr>
	        		</tfoot>
	        	</table>
        	</div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-lopmon" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="title-lopmon">Thay đổi mốc khảo sát</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-12">
                    	<p><strong>Khoảng thời gian khảo sát</strong></p>
                        <input class="form-control input-daterange-datepicker" type="text" name="daterange" id="moclopmon" />
                	</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Đóng</button>
                <button type="button" id="luumockhaosat" class="btn btn-info">
                	<i class="fa fa-check"></i>&nbsp; Lưu lại
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-dotkhaosat" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Thay đổi mốc khảo sát cho các lớp môn đã chọn</h4> </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-12">
                    	<p><strong>Khoảng thời gian khảo sát</strong></p>
                        <input class="form-control input-daterange-datepicker" type="text" name="daterange" id="mocdachon" />
                	</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Đóng</button>
                <button type="button" id="luumockhaosatchecked" class="btn btn-info">
                	<i class="fa fa-check"></i>&nbsp; Lưu lại
                </button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" class="csrf" name="{$csrf_token_name}" value="{$csrf_token}"/>
{/if}

<script type="text/javascript" src="{$url}assets/plugins/icheck/icheck.js?v=1.0.2"></script>
<script type="text/javascript" src="{$url}assets/js/smoothscroll.js"></script>
<script src="{$url}assets/plugins/bower_components/sweetalert/sweetalert.min.js"></script>

<!-- Date rangepicker -->
<script type="text/javascript" src="{$url}assets/plugins/bower_components/moment/moment.js"></script>
<script src="{$url}assets/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<script type="text/javascript" src="{$url}assets/js/khaosat/dotkhaosat.js?ver=1.02"></script>
