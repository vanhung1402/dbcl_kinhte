<div class="panel panel-default m-t-5">
    <div class="panel-heading text-uppercase text-center">
        <p>QUẢN LÝ SINH VIÊN</p>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
            <form method="post" action=""  data-toggle="validator">
                <div class="container-fluid">
                    <div class="row">
                        <br>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Mã sinh viên</label>
                            <input type="text" name="ma_sv" class="form-control" value="{if isset($sua)}{$sua.ma_sv}{/if}" placeholder="Nhập mã sinh viên..." required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Họ và tên</label>
                            <input type="text" name="hodem_sv" class="form-control" value="{if isset($sua)}{$sua.hodem_sv} {$sua.ten_sv}{/if}" placeholder="Nhập tên sinh viên..." required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ngaysinh">Ngày sinh</label>
                            <input type="text" id="ngaysinh" name="ngaysinh_sv" value="{if isset($sua)}{date('d/m/Y', strtotime(str_replace('-', '/', $sua.ngaysinh_sv)))}{/if}" class="form-control" data-mask="99/99/9999" placeholder="Nhập ngày sinh..." required autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="gioitinh">Giới tính</label><br>
                            <label class="radio-inline" for="gtnam" >
                                <input id="gtnam" type="radio" name="gioitinh_sv" value="Nam" {if $sua.gioitinh_sv=="Nam"} checked="" {/if} required="" class=""> 
                                Nam
                            </label>
                            &nbsp;&nbsp;&nbsp;
                            <label class="radio-inline" for="gtnu">
                                <input id="gtnu" type="radio" name="gioitinh_sv" value="Nữ" {if $sua.gioitinh_sv=="Nữ"} checked="" {/if} required=""> 
                                Nữ
                            </label>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Email</label>
                            <input type="text" name="email_sv" class="form-control" value="{if isset($sua)}{$sua.email_sv} {/if}" placeholder="Nhập email sinh viên..."     >
                        </div>
                        <div class="form-group col-md-4">
                            <label>Số điện thoại</label>
                            <input type="text" id="sdt_sv" name="sdt_sv" value="{if isset($sua)}{$sua.sdt_sv} {/if}" class="form-control" placeholder="Nhập số điện thoại..." >
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="lop">Lớp</label>
                            <select class="form-control select2" name="lop" id="lop">
                                <option value="empty" selected disabled>Chọn lớp</option>
                                {foreach $lop as $key => $value}
                                <option value="{$value['ma_lop']}"{if !empty($sua)&&$sua.ma_lop==$value.ma_lop} selected=""{/if}>{$value['ten_lop']}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="trangthai">Trạng thái</label>
                            <select class="form-control select2" name="trangthai" id="trangthai">
                                <option value="empty" selected disabled>Chọn trạng thái</option>
                                {foreach $trangthai as $key => $value}
                                <option value="{$value['ma_trangthai_sinhvien']}"{if !empty($sua)&&$sua.ma_trangthai_sinhvien==$value.ma_trangthai_sinhvien} selected=""{/if}>{$value['ten_trangthai_sinhvien']}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <label for="">&nbsp;</label>
                        <br> 
                        {if isset($sua)}
                        <button class="btn btn-success waves-effect waves-light" data-toggle="modal"  type="submit" name="capnhat" value="{$sua.ma_sv}" title="Cập nhật">
                            <span class="btn-label">
                                <i class="fa fa-edit"></i>
                            </span><strong>CẬP NHẬT</strong>
                        </button>
                        {else}
                        <button class="btn btn-info waves-effect waves-light" data-toggle="modal" type="submit" name="them" value="+" title="Thêm" id="them">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span><strong>THÊM</strong>
                        </button>
                        {/if}
                    </div>
                </div>
            </form>
            <hr>
            <form method="POST" action="">
                <div class="panel-body table-responsive">
                    <div class="loc row">
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">Tìm kiếm:</span>
                                <input type="text" class="form-control" name="key" id="key" placeholder="Nhập tên hoặc mã sinh viên...">
                            </div>
                        </div>
                        <div class="col-sm-4 text-right">
                            <button class="fcbtn btn btn-sm btn-outline btn-info btn-1e" name="action" value="loc">
                                    <i class="fa fa-search"></i>
                                </button>
                        </div>
                    </div>
                    <table class="table table-bordered datatable" id=dssinhvien>
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 30px;">STT</th>
                                <th class="text-center">Mã sinh viên</th>
                                <th class="text-center">Tên sinh viên</th>
                                <th class="text-center">Ngày sinh</th>
                                <th class="text-center">Giới tính</th>
                                <th class="text-center">Tên lớp</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center" style="width: 120px;">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $ds as $key=>$val}
                            <tr>
                                <td class="text-center">{$key+1}</td>
                                <td class="text-center">{$val.ma_sv}</td>
                                <td>{$val.hodem_sv} {$val.ten_sv}</td>
                                <td class="text-center">{date('d/m/Y', strtotime(str_replace('-', '/', $val.ngaysinh_sv)))}</td>
                                <td class="text-center">{$val.gioitinh_sv}</td>
                                <td class="text-center">{$val.ten_lop}</td>
                                <td class="text-center">{$val.ten_trangthai_sinhvien}</td>
                               
                                <td>
                                    <div class="text-center">
                                        <a class="btn btn-info btn-xs waves-effect waves-light" href="sinhvien?masv={$val.ma_sv}" name="edit" title="Sửa"><i class="fa fa-edit"></i>
                                        </a>
                                        {if in_array($val.ma_sv, $Masinhvien_sudung)}
                                            <button class="btn btn-xs remove" type="button" style="color: #fff"><i class="fa fa-trash"></i>
                                            </button>
                                        {else}
                                            <button class="btn btn-xs btn-danger" type="submit" value="{$val.ma_sv}" name="delete" onclick="return confirm('Bạn có chắc muốn xóa không?')" title="Xóa"><i class="fa fa-trash"></i>
                                            </button>
                                        {/if}
                                    </div>
                                </td>
                            </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{$url}assets/js/mask.js"></script>
<script src="assets/template/js/validator.js"></script>
<script type="text/javascript">
    $(document).ready(() => {
        $(".remove").on("click", e => {
            showMessage("error", "Giá trị này đang được sử dụng");
        });

        $("#them").on("click", e=>{
            if($("#lop").val() === null || $("#trangthai").val() === null) {
                e.preventDefault();
                showMessage("error","Thông tin sinh viên  chưa đầy đủ");
            }
        });
    });
</script>