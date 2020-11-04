<div class="panel panel-default block m-t-5">
    <div class="panel-heading">
        <p class="text-uppercase text-center">Import đăng ký môn</p>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
        	<form method="POST" enctype="multipart/form-data" role="form" data-toggle="validator">
                <div class="col-sm-5">
                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput"> 
                            <i class="glyphicon glyphicon-file fileinput-exists"></i> 
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-default btn-file"> 
                         	<span class="fileinput-new">Chọn file</span>
                         	<span class="fileinput-exists">Sửa</span>
                        	<input type="file" name="file_import" accept=".xlsx, .xls"  id="uploadExcel" required="">
                        </span> 
                        <a href="javascript:void(0)" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Xóa</a> 
                    </div>
                </div>
                <button type="submit" name="action" value="import" class="btn btn-success waves-effect waves-light" data-toggle="modal" >
                    <span class="btn-label">
                        <i class="fa fa-upload"></i>
                    </span>Upload
                </button>
                <a class="btn btn-info waves-effect waves-light pull-right" href="uploads/Mau_import_dangkymon.xlsx?ver=1.0" name="excel" title="File Excel mẫu">
                	<span class="btn-label">
                        <i class="fa fa-download"></i>
                    </span>Tải file mẫu
                </a>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert text-left" role="alert">
                        <p><strong>Chú ý:</strong> File Excel phải có định dạng .xls hoặc .xlsx và theo một định dạng sau.</p>
                        <p>- Dữ liệu sẽ được đọc từ dòng số 2 trong file Excel, vì vậy cần loại bỏ những trường không cần thiết trước khi import.</p>
                        <p>- Thứ tự các cột: [A] - Số thứ tự, [B] - Mã sinh viên, [C] - Mã lớp môn.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{if !empty($dkmloi)}
<div class="panel panel-default block m-t-5">
    <div class="panel-heading">
        <p class="text-uppercase text-center text-danger">Danh sách đăng ký môn lỗi</p>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <table class="table table-bordered table-hover table-striped datatable">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã sinh viên</th>
                        <th>Mã lớp môn</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $dkmloi as $k => $dkm}
                    <tr>
                        <td class="text-center">{$k + 1}</td>
                        <td class="{if !isset($dssinhvien[$dkm.ma_sv])}text-danger{/if}">{$dkm.ma_sv}</td>
                        <td class="{if !isset($dslopmon[$dkm.ma_lopmon])}text-danger{/if}">{$dkm.ma_lopmon}</td>
                        <td>
                            {if !isset($dssinhvien[$dkm.ma_sv])}
                            <div>- Không có mã sinh viên {$dkm.ma_sv}</div>
                            {/if}
                            {if !isset($dslopmon[$dkm.ma_lopmon])}
                            <div>- Không có mã lớp môn {$dkm.ma_lopmon}</div>
                            {/if}
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>
{/if}
<script src="{$url}assets/js/jasny-bootstrap.js"></script>
<script src="assets/template/js/validator.js"></script>