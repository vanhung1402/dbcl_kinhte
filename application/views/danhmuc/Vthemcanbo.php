<div class="panel panel-default m-t-5">
    <div class="panel-heading text-uppercase text-center">
        <p>THÊM NHIỀU CÁN BỘ</p>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
            <form method="POST" action="" enctype="multipart/form-data" role="form" data-toggle="validator">
                    <div class="col-sm-5">
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput"> 
                                <i class="glyphicon glyphicon-file fileinput-exists"></i> 
                                <span class="fileinput-filename"></span>
                            </div> <span class="input-group-addon btn btn-default btn-file"> 
                                <span class="fileinput-new">Thêm file</span> <span class="fileinput-exists">Sửa</span>
                            <input type="file" name="insert_excel" accept=".xlsx, .xls"  id="uploadExcel" required=""> </span> <a href="javascript:void(0)" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Xóa</a> 
                        </div>
                    </div>
                    <button type="submit" name="action" value="themcanbo" class="btn btn-success waves-effect waves-light" data-toggle="modal" >
                        <span class="btn-label">
                            <i class="fa fa-plus"></i>
                        </span>Upload
                    </button>
                <a class="btn btn-info waves-effect waves-light pull-right" href="uploads/Mau_import_can_bo.xlsx?ver=1.0" name="excel" title="File Excel mẫu">
                   <i class="fa fa-download"></i> File Excel mẫu
                </a>        
            </form><br>
            {if isset($dscb_err)}
            <h2 class="text-info text-center">DANH SÁCH CÁN BỘ KHÔNG HỢP LỆ</h2>
            
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Mã đối tượng</th>
                                <th class="text-center">Họ và tên</th>
                                <th class="text-center">Giới tính</th>
                                <th class="text-center">Ngày sinh</th>
                                <th class="text-center">Đơn vị</th>
                                <th class="text-center">Học hàm</th>
                                <th class="text-center">Chức vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $dscb_err as $k => $v}
                            <tr>
                                <td class="text-center">{$k+1}</td>
                                <td>{$v.0}</p>
                         
                                </td>
                                <td>{$v.1}</td>
                                <td class="text-center">{$v.2}</td>
                                <td class="text-center">{$v.3}</td>
                                <td>{if isset($donviconfig[$v[4]])}{$v.4}{else}
                                    <p style="color: red; ">{$v.4}</p>{/if}</td>
                                <td>{if isset($hochamconfig[$v[5]])}{$v.5}{else}
                                    <p style="color: red; ">{$v.5}</p>{/if}</td>
                                <td>{if isset($chucvuconfig[$v[6]])}{$v.6}{else}
                                    <p style="color: red; ">{$v.6}</p>{/if}</td>
                            </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
            {/if}
        </div>
    </div>
</div>
<script src="{$url}assets/js/jasny-bootstrap.js"></script>
<script src="assets/template/js/validator.js"></script>

