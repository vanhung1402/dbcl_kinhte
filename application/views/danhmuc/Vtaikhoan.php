<link href="{$url}assets/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{$url}assets/css/danhmuc/taikhoan.css">

<div class="panel panel-default block m-t-5">
    <div class="panel-heading">
        <p class="text-uppercase text-center">QUẢN LÝ TÀI KHOẢN</p>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
        	<div class="row user">
        		<div class="col-md-4">
        			<div class="area-heading">
        				<h4 class="text-center text-info">Thêm tài khoản</h4>
        			</div>
			        <form method="POST">
			        	<div>
		        			<div class="input-group">
		        				<span class="input-group-addon">Cán bộ:</span>
		        				<select name="canbo" id="canbo" class="form-control select2" required>
		        					<option value="" selected disabled>--- Chọn cán bộ ---</option>
		        					{foreach $chuaco as $cb}
		        					<option value="{$cb.ma_cb}">{trim($cb.hodem_cb)} {$cb.ten_cb}</option>
		        					{/foreach}

		        					{if (!empty($canbosua))}
		        					<option value="{$canbosua.ma_cb}" selected>{trim($canbosua.hodem_cb)} {$canbosua.ten_cb}</option>
		        					{/if}
		        				</select>
		        			</div>
			        	</div>
			        	<div>
		        			<div class="input-group">
		        				<span class="input-group-addon">Tên đăng nhập:</span>
		        				<input type="text" class="form-control" name="ten-dangnhap" id="ten-dangnhap" required placeholder="..." value="{(empty($canbosua)) ? '' : $canbosua.ten_dangnhap}">
		        			</div>
			        	</div>
			        	<div>
		        			<div class="input-group">
		        				<span class="input-group-addon">Mật khẩu:</span>
		        				<input type="text" class="form-control" name="matkhau" id="matkhau" {if (empty($canbosua))}required{/if} placeholder="...">
		        			</div>
			        	</div>
			        	<div>	
			        		<div class="input-group">
		        				<span class="input-group-addon">Quyền:</span>
		        				<select name="quyen" id="quyen" class="form-control select2" required>
		        					<option value="" selected disabled>--- Chọn quyền ---</option>
		        					{$mqs = (empty($canbosua)) ? '' : $canbosua.ma_quyen}
		        					{foreach $dsquyen as $q}
		        					{if $q.ma_quyen == $mqs}
		        					<option value="{$q.ma_quyen}" selected>{$q.ten_quyen}</option>
		        					{else}
		        					<option value="{$q.ma_quyen}">{$q.ten_quyen}</option>
		        					{/if}
		        					{/foreach}
		        				</select>
		        			</div>
			        	</div>
			        	<div class="text-center m-t-15">
		        			<button class="btn btn-success waves-effect waves-light" type="submit" id="luu" name="action" value="save">
								<span class="btn-label">
									<i class="fa fa-check"></i>
								</span>
								LƯU
							</button>
			        	</div>
			        </form>
        		</div>
        		<div class="col-md-8">
		        	<table class="table table-bordered table-hover datatable" id="quanly">
		        		<thead>
		        			<tr>
		        				<th width="50" class="text-center">STT</th>
		        				<th class="text-center">Cán bộ</th>
		        				<th class="text-center">Tài khoản</th>
		        				<th class="text-center">Quyền</th>
		        				<th class="text-center">Tác vụ</th>
		        			</tr>
		        		</thead>
		        		<tbody>
		        			{foreach $daco as $key => $cb}
		        			<tr>
		        				<td class="text-center">{$key + 1}</td>
		        				<td>{trim($cb.hodem_cb)} {$cb.ten_cb}</td>
		        				<td>{$cb.ten_dangnhap}</td>
		        				<td>{$cb.ten_quyen}</td>
		        				<td class="text-center">
		        					<a href="{$url}taikhoan?ma={$cb.ten_dangnhap}" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="left" data-original-title="Thay đổi">
		        						<i class="fa fa-pencil-square-o"></i>
		        					</a>
		        					{if $cb.ten_dangnhap != $username}
		        					<button type="button" name="xoa-taikhoan" value="{$cb.ten_dangnhap}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" data-original-title="Loại bỏ tài khoản">
		        						<i class="fa fa-trash"></i>
		        					</button>
		        					{/if}
		        				</td>
		        			</tr>
		        			{/foreach}
		        		</tbody>
		        	</table>
        		</div>
        	</div>
        </div>
    </div>
</div>

<script src="{$url}assets/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="{$url}assets/js/danhmuc/taikhoan.js"></script>