<style type="text/css">
    th{
        font-weight: 700;
        text-align: center;
    }
    table.table tbody td, table.table thead th{
        padding: 5px;
        vertical-align: middle;
    }
</style>
<div class="panel panel-default m-t-5">
    <form method="post">
        <div class="panel-heading">
            <p class="text-uppercase text-center">QUẢN LÝ LỚP MÔN</p>
            <div class="loc row">
                <div class="col-sm-4"> 
                    <div class="input-group">
                        <span class="input-group-addon">Đơn vị học vụ</span>
                        <select name="ma_dvhv" id="dvhv" class="form-control select2">
                            <option value="">Chọn đơn vị học vụ</option>
                            {foreach $ds_dvhv as $k => $dvhv}
                                <option value="{$dvhv.ma_donvihocvu}">
                                    {$dvhv.ma_donvihocvu}
                                </option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-sm-3"> 
                    <div class="input-group">
                        <span class="input-group-addon">Trạng thái</span>
                        <select name="trangthai" id="trangthai" class="form-control select2">
                            <option value="">Tất cả</option>
                            {foreach $trangthai_lm as $tt}
                                <option value="{$tt.madm_trangthai_lopmon}">
                                    {$tt.tendm_trangthai_lopmon}
                                </option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-sm-3"> 
                    <div class="input-group">
                        <span class="input-group-addon">Hình thức</span>
                        <select name="hinhthuc" id="hinhthuc" class="form-control select2">
                            <option value="">Tất cả</option>
                            {foreach $dshinhthuc as $ht}
                            <option value="{$ht.ma_hinhthuc}">{$ht.ten_hinhthuc}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-wrapper collapse in">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" id="search" class="form-control" placeholder="Nhập tên hoặc mã lớp môn để tìm kiếm...">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-info waves-effect waves-light pull-right" type="submit" name="action" id="xuatexcel" value="xuatexcel"  title="Xuất Excel">
                            <i class="fa fa-file-excel-o"></i> &nbsp; Xuất Excel
                        </button>
                    </div>
                </div>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="50">STT</th>
                            <th>Tên lớp môn</th>
                            <!-- <th>Giảng viên</th> -->
                            <!-- <th width="90">Hình thức</th> -->
                            <th width="100">Ngày bắt đầu</th>
                            <th width="100">Ngày kết thúc</th>
                            <th width="85">Số lượng SV</th>
                            <th width="110">Hình thức</th>
                            <th width="110">Trạng thái</th>
                            <th width="150">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
<script src="{$url}assets/js/hethong/duyetlopmon.js?ver=1.05"></script>

<script type="text/javascript">
    let quyen = '{$quyen}';
    $(document).ready(function() {
        $('#dvhv').val('{$ds_dvhv[0]['ma_donvihocvu']}');
        $('#dvhv').trigger('change');
    });
</script>