<link rel="stylesheet" href="{$url}assets/css/danhmuc/danhsachsinhvien.css">
<div class="panel panel-default block m-t-5">
    <div class="panel-heading">
        <p class="text-uppercase text-center">Danh sách sinh viên</p>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
        	<div class="row loc">
        		<form method="post" accept-charset="utf-8">
    				<div class="col-md-3">
	    				<div class="area-heading">
	        				<h4 class="text-info"><strong>Chọn lớp</strong></h4>
	        			</div>
	        			<div class="form-group">
		        			<select name="lop" id="lop" class="select2 form-control" required>
		                        <option value="" selected disabled>--- Chọn lớp ---</option>
		                        {foreach $dslop as $l}
		                        {if $lop && $lop == $l.ma_lop}
		                        <option value="{$l.ma_lop}" selected="">{$l.ten_lop}</option>
		                        {else}
		                        <option value="{$l.ma_lop}">{$l.ten_lop}</option>
		                        {/if}
		                        {/foreach}
		                    </select>
	        			</div>

	                    <div class="form-group text-center">
	                    	<button class="fcbtn btn btn-sm btn-outline btn-info btn-1e" name="action" value="loc">
		                        <strong><i class="fa fa-search"></i> &nbsp; LỌC</strong>
		                    </button>
	                    </div>
        			</form>
        		</div>
        		<div class="col-md-9 table-responsive">
        			<table class="table table-bordered table-hover datatable">
		                <thead>
		                    <tr>
		                        <th>STT</th>
		                        <th>Mã sinh viên</th>
		                        <th>Họ tên</th>
		                        <th>Ngày sinh</th>
		                        <th>Giới tính</th>
		                        <th>Trạng thái</th>
		                        <th>Tác vụ</th>
		                    </tr>
		                </thead>
		                <tbody>
		                    {$stt = 1}
		                    {foreach $dssinhvien as $sv}
		                    <tr>
		                        <td class="text-center">{$stt++}</td>
		                        <td class="text-center">{$sv.ma_sv}</td>
		                        <td>
		                            <a>{trim($sv.hodem_sv)} {$sv.ten_sv}</a>
		                        </td>
		                        <td class="text-center">{$sv.ns}</td>
		                        <td class="text-center">{$sv.gioitinh_sv}</td>
		                        <td class="text-center">{$sv.ten_trangthai_sinhvien}</td>
		                        <td class="text-center">
		                            {if $quyen != 'covanhoctap'}
		                            <a class="btn btn-info btn-xs waves-effect waves-light" href="sinhvien?masv={$sv.ma_sv}" data-toggle="tooltip" data-placement="left" data-original-title="Cập nhật thông tin sinh viên">
		                            	<i class="fa fa-edit"></i>
                                    </a>
		                            {/if}

		                            <button class="btn btn-xs btn-warning btn-doimatkhau" value="{$sv.ma_sv}" tensv="{trim($sv.hodem_sv)} {$sv.ten_sv}" data-toggle="tooltip" data-placement="left" data-original-title="Đổi mật khẩu">
		        						<i class="fa fa-key"></i>
		        					</button>
		                        </td>
		                    </tr>
		                    {/foreach}
		                </tbody>
		            </table>

                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="tensinhvien">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Đổi mật khẩu cho sinh viên <strong id="tensinhvien"></strong></h4>
                                </div>
                                <div class="modal-body">
                                	<div class="row">
                                		<div class="col-sm-6">
                                			<label for="password" class="control-label">Mật khẩu mới:</label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="...">
                                		</div>
                                		<div class="col-sm-6">
                                			<label for="confirmpassword" class="control-label">Nhập lại mật khẩu:</label>
                                            <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="...">
                                		</div>
                                	</div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                    	<i class="fa fa-times"></i> &nbsp; Đóng
                                    </button>
                                    <button type="button" class="btn btn-info" id="luu">
                                    	<i class="fa fa-check"></i> &nbsp; Xác nhận đổi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
        		</div>
        	</div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{$url}assets/js/danhmuc/danhsachsinhvien.js?ver=1.01"></script>