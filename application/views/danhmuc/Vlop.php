<style type="text/css">
    th{
        font-weight: 700;
    }
    table.table tbody td, table.table thead th{
        padding: 10px;
        vertical-align: middle;
    }
</style>
<div class="panel panel-default m-t-5">
    <div class="panel-heading text-uppercase text-center">
        <p>QUẢN LÝ LỚP HÀNH CHÍNH</p>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <form method="post" action="" data-toggle="validator"><br>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1">Tên lớp</label>
                        <input type="text" name="ten_lop" class="form-control" value="{if isset($sua)}{$sua.ten_lop}{/if}" placeholder="Nhập tên lớp..." required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="khoahoc">Năm học</label>
                        <select class="form-control select2" name="khoahoc" id="khoahoc">
                            <option value="empty" selected disabled>Chọn năm học</option>
                            {foreach $khoahoc as $key => $value}
                            <option value="{$value['ma_khoahoc']}"{if !empty($sua)&&$sua.ma_khoahoc==$value.ma_khoahoc} selected=""{/if}>{$value['namhoc']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="canbo">Tên cán bộ quản lý</label>
                        <select class="form-control select2" name="canbo" id="canbo">
                            <option value="empty" selected disabled>Chọn cán bộ</option>
                            {foreach $canbo as $key => $value}
                            <option value="{$value['ma_cb']}"{if !empty($sua)&&$sua.ma_canbo_quanly==$value.ma_cb} selected=""{/if}>{$value['hodem_cb']} {$value['ten_cb']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="text-center">
                        <label for="">&nbsp;</label>
                        <br> 
                        {if isset($sua)}
                        <button class="btn btn-success waves-effect waves-light" data-toggle="modal"  type="submit" name="capnhat" value="{$sua.ma_lop}" title="Cập nhật">
                            <span class="btn-label">
                                <i class="fa fa-edit"></i>
                            </span>Cập nhập
                        </button>
                        {else}
                        <button class="btn btn-info waves-effect waves-light" data-toggle="modal"  type="submit" name="them" value="+" title="Thêm" id="them">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>Thêm
                            </button>
                        {/if}
                    </div>
                </form>
                </div>
                <div class="col-md-8">
                    <form method="POST" action="">
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">STT</th>
                                    <th class="text-center">Mã lớp</th>
                                    <th class="text-center">Tên lớp</th>
                                    <th class="text-center">Năm học</th>
                                    <th class="text-center">Tên cán bộ quản lý</th>
                                    <th class="text-center" style="width: 100px;">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach $ds as $key=>$val}
                                <tr>
                                    <td class="text-center">{$key+1}</td>
                                    <td class="text-center">{$val.ma_lop}</td>
                                    <td class="text-center">{$val.ten_lop}</td>
                                    <td class="text-center">{$val.namhoc}</td>
                                    <td>{$val.hodem_cb} {$val.ten_cb}</td>
                                    <td>
                                        <div class="text-center">
                                            <a class="btn btn-info btn-xs waves-effect waves-light" href="lop?malop={$val.ma_lop}" name="edit" title="Sửa"><i class="fa fa-edit"></i>
                                            </a>
                                            {if in_array($val.ma_lop, $Malop_sudung)}
                                                <button class="btn btn-xs remove" type="button" style="color: #fff"><i class="fa fa-trash"></i>
                                                </button>
                                            {else}
                                                <button class="btn btn-xs btn-danger" type="submit" value="{$val.ma_lop}" name="delete" onclick="return confirm('Bạn có chắc muốn xóa không?')" title="Xóa"><i class="fa fa-trash"></i>
                                                </button>
                                            {/if}
                                        </div>
                                    </td>
                                </tr>
                                {/foreach}
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/template/js/validator.js"></script>
<script type="text/javascript">
    $(document).ready(() => {
        $(".remove").on("click", e => {
            showMessage("error", "Giá trị này đang được sử dụng");
        });

        $("#them").on("click", e=>{
            if($("#khoahoc").val() === null || $("#canbo").val() === null) {
                e.preventDefault();
                showMessage("error","Thông tin lớp học  chưa đầy đủ");
            }
        });
    });
</script>
