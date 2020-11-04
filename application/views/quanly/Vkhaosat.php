<link href="{$url}assets/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

<div class="panel panel-default m-t-5">
    <div class="panel-heading text-uppercase text-center">
    	<p>CUỘC KHẢO SÁT</p>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
        	<form class="form-horizontal" method="POST">
                <div class="form-group">
                    <label class="col-md-12" for="tieude"><strong>Tiêu đề khảo sát <span class="text-danger">*</span></strong></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" placeholder="..." name="tieude" id="tieude" required {if isset($khaosatsua.tieude_khaosat)}value="{$khaosatsua.tieude_khaosat}"{/if}>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12" for="noidung"><strong>Nội dung khảo sát</strong></label>
                    <div class="col-md-12">
                        <textarea name="noidung" id="noidung">{if isset($khaosatsua.noidung_khaosat)}{$khaosatsua.noidung_khaosat}{/if}</textarea>
                    </div>
                </div>
                <div class="form-group">
                	<div class="col-md-3 m-b-15" id="loai-khaosat-container">
                		<label for="loai"><strong>Loại khảo sát <span class="text-danger">*</span></strong></label>
                		<select name="loai" id="loai" class="form-control select2" required>
                			<option value="" selected disabled>--- Chọn loại khảo sát ---</option>
                			{foreach $dsloaikhaosat as $lks}
                			<option value="{$lks.madm_loaikhaosat}" {if isset($khaosatsua.madm_loaikhaosat) && $khaosatsua.madm_loaikhaosat == $lks.madm_loaikhaosat}selected{/if}>{$lks.tendm_loaikhaosat}</option>
                			{/foreach}
                        </select>
                	</div>
                	<div class="col-md-3 m-b-15" id="hinhthuc-khaosat-container">
                		<label for="hinhthuc"><strong>Hình thức áp dụng <span class="text-danger">*</span></strong></label>
                		<select name="hinhthuc" id="hinhthuc" class="form-control select2" required>
                			<option value="" selected disabled>--- Chọn hình thức ---</option>
                			{foreach $dshinhthuc as $ht}
                			<option value="{$ht.ma_hinhthuc}" {if isset($khaosatsua.ma_hinhthuc) && $khaosatsua.ma_hinhthuc == $ht.ma_hinhthuc}selected{/if}>Học {$ht.ten_hinhthuc}</option>
                			{/foreach}
                        </select>
                	</div>
                	<div class="col-md-6 m-b-15">
                		<label for="ghichu"><strong>Ghi chú khảo sát</strong></label>
                		<input class="form-control" id="ghichu" name="ghichu" placeholder="..."  {if isset($khaosatsua.ghichu_khaosat)}value="{$khaosatsua.ghichu_khaosat}"{/if} />
                	</div>
                </div>
                <div class="text-center form-group m-t-15">
                	{if empty($khaosatsua)}
	    			<button class="btn btn-success waves-effect waves-light" type="submit" id="luu" name="action" value="save">
						<span class="btn-label">
							<i class="fa fa-check"></i>
						</span>
						LƯU
					</button>
					{else}
	    			<button class="btn btn-info waves-effect waves-light" type="submit" id="luu" name="action" value="change">
						<span class="btn-label">
							<i class="fa fa-check"></i>
						</span>
						Cập nhật
					</button>
					{/if}
	        	</div>
            </form>
        </div>
    </div>
</div>

<div class="panel panel-default m-t-5">
    <div class="panel-heading text-uppercase text-center">
    	<p>DANH SÁCH KHẢO SÁT</p>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
        	{if empty($dskhaosat)}
        	{else}
        	<table class="table table-bordered table-hover datatable" id="quanly">
        		<thead>
        			<tr>
        				<th class="text-center">STT</th>
        				<th class="text-center">Tiêu đề khảo sát</th>
        				<th class="text-center">Nội dung</th>
        				<th class="text-center">Hình thức</th>
        				<th class="text-center">Loại khảo sát</th>
        				<th class="text-center">Ghi chú</th>
        				<th class="text-center" width="25">Tác vụ</th>
        			</tr>
        		</thead>
        		<tbody>
        		{foreach $dskhaosat as $key => $ks}
        			<tr>
        				<td class="text-center">{$key + 1}</td>
        				<td><strong class="text-uppercase">{$ks.tieude_khaosat}</strong></td>
        				<td>{$ks.noidung_khaosat}</td>
        				<td>{$ks.tendm_loaikhaosat}</td>
        				<td>{$ks.ten_hinhthuc}</td>
        				<td>{$ks.ghichu_khaosat}</td>
        				<td class="text-center">
                            <a href="{$url}phieukhaosat/hoctap?ma={$ks.ma_khaosat}" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="left" data-original-title="In mẫu phiếu" target="_blank">
                                <i class="fa fa-file-text-o"></i>
                            </a>
                            <a href="{$url}khaosat?ma={$ks.ma_khaosat}" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="left" data-original-title="Chỉnh sửa nội dung cuộc khảo sát">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{$url}chude?khaosat={$ks.ma_khaosat}" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="left" data-original-title="Quản lý nhóm câu hỏi khảo sát">
                                <i class="fa fa-question-circle"></i>
                            </a>
        					<a href="{$url}khaosathoctap/dot?khaosat={$ks.ma_khaosat}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="left" data-original-title="Quản lý đợt khảo sát">
        						<i class="fa fa-tasks"></i>
        					</a>
        					{if (!$ks.ma_dotkhaosat)}
        					<button class="btn btn-xs btn-danger btn-xoakhaosat" value="{$ks.ma_khaosat}" data-toggle="tooltip" data-placement="left" data-original-title="Xóa cuộc khảo sát">
        						<i class="fa fa-trash"></i>
        					</button>
        					{/if}
        				</td>
        			</tr>
        		{/foreach}
        		</tbody>
        	</table>
        	{/if}
        </div>
    </div>
</div>


<script src="{$url}assets/plugins/ckeditor/ckeditor.js?ver=1"></script>
<script src="{$url}assets/plugins/bower_components/sweetalert/sweetalert.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		CKEDITOR.replace( 'noidung',{
			height: '125px',
		});
		{if isset($khaosatsua.madm_loaikhaosat)}
		switchHinhThuc('{$khaosatsua.madm_loaikhaosat}');
		{/if} ///
{literal}
		function switchHinhThuc(loai){
			if (loai === 'khaosathoctap') {
				$('#loai-khaosat-container').attr('class', 'col-md-3 m-b-15');
				$('#hinhthuc-khaosat-container').removeClass('hidden');
				$('#hinhthuc').attr('required', true);
			}else{
				$('#loai-khaosat-container').attr('class', 'col-md-6 m-b-15');
				$('#hinhthuc-khaosat-container').addClass('hidden');
				$('#hinhthuc').removeAttr('required');
			}
		}

		$(document).on('change', '#loai', function(event) {
			let loai = $(this).val();

			switchHinhThuc(loai);
		});

		$(document).on('click', '.btn-xoakhaosat', function(event) {
			let khaosat = $(this).val();

			swal({   
	            title: "Xóa cuộc khảo sát này?",   
	            text: "Hãy chắc chắn, nếu xóa cuộc khảo sát này, tất cả các dữ liệu liên quan đều sẽ bị xó!",   
	            type: "warning",   
	            showCancelButton: true,   
	            confirmButtonColor: "#DD6B55",   
	            confirmButtonText: "Đồng ý, xóa nó!",
	            closeOnConfirm: true 
	        }, function(){
				xoaKhaoSat(khaosat);
	        });
		});

		function xoaKhaoSat(khaosat){
			$.ajax({
				url: window.location.href,
				type: 'POST',
				dataType: 'JSON',
				data: {
					action: 'xoa-khaosat',
					khaosat: khaosat
				},
			})
			.done(function(res) {
				window.location.reload();
			})
			.fail(function(err) {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		}
	});	
</script>
{/literal}