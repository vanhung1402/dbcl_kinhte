<link href="{$url}assets/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
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
        <p>QUẢN LÝ ĐƠN VỊ</p>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body"> 
            <div class="row">
                <div class="col-md-4">
                    <form method="post" action="" data-toggle="validator"><br>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1">Mã đơn vị</label>
                        <input type="text" name="ma_donvi" class="form-control" value="{if isset($sua)}{$sua.ma_donvi}{/if}" placeholder="Nhập mã đơn vị..." data-error="Mã đơn vị không được để trống" required>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1">Tên đơn vị</label>
                        <input type="text" name="ten_donvi" class="form-control" value="{if isset($sua)}{$sua.ten_donvi}{/if}" placeholder="Nhập tên đơn vị..." data-error="Tên đơn vị không được để trống" required>
                        <div class="help-block with-errors"></div>
                    </div>
                   
                    <div class="form-group col-md-12 text-center">
                        <br> 
                        {if isset($sua)}
                        <button class="btn btn-success waves-effect waves-light" data-toggle="modal"  type="submit" name="capnhat" value="{$sua.ma_donvi}" title="Cập nhật">
                            <span class="btn-label">
                                <i class="fa fa-edit"></i>
                            </span>
                                Cập nhập
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
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">STT</th>
                                    <th class="text-center">Mã đơn vị</th>
                                    <th class="text-center">Tên đơn vị</th>
                                    
                                    <th class="text-center" style="width: 100px;">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach $ds as $key=>$val}
                                <tr>
                                    <td class="text-center">{$key+1}</td>
                                    <td>{$val.ma_donvi}</td>
                                    <td>{$val.ten_donvi}</td>
                                   
                                    <td>
                                        <div class="text-center">
                                            <a class="btn btn-info btn-xs waves-effect waves-light" href="donvi?madv={$val.ma_donvi}" name="edit" title="Sửa"><i class="fa fa-edit"></i>
                                            </a>
                                            {if in_array($val.ma_donvi, $Madonvi_sudung)}
                                                <button class="btn btn-xs  remove" type="button" style="color: #fff"><i class="fa fa-trash"></i>
                                                </button>
                                            {else}
                                                <button class="btn btn-xs btn-danger" type="submit" value="{$val.ma_donvi}" name="delete" onclick="return confirm('Bạn có chắc muốn xóa không?')" title="Xóa"><i class="fa fa-trash"></i>
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
<script src="{$url}assets/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="assets/template/js/validator.js"></script>
    <script type="text/javascript">
    $(document).ready(() => {
        $(".remove").on("click", e => {
            showMessage("error", "Giá trị này đang được sử dụng");
        });
    });
</script>