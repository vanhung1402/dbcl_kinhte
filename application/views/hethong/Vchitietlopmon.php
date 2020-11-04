<link href="{$url}assets/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{$url}assets/css/hethong/chitietlopmon.css">

<div class="panel panel-default m-t-5">
    <div class="panel-heading text-uppercase text-center">
        <p>CHI TIẾT LỚP MÔN</p>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
            <div class="row" id="thongtin_lopmon">
                <div class="col-sm-7">
                    <div class="row">
                        <dt class="col-sm-3">Mã lớp môn:</dt>
                        <dd class="col-sm-8">{$dl_lopmon.ma_lopmon}</dd>
                        <dt class="col-sm-3">Tên lớp:</dt>
                        <dd class="col-sm-8" id="tenlop">{$dl_lopmon.ten_lopmon}</dd>
                        <dt class="col-sm-3">Môn học:</dt>
                        <dd class="col-sm-8" id="tenmh">{$dl_lopmon.ten_monhoc} ({$dl_lopmon.tongkhoiluong} {$dl_lopmon.donvitinh})</dd>
                        <dt class="col-sm-3">Giảng viên:</dt>
                        <dd class="col-sm-8" id="tengv">{$dl_lopmon.ma_cb} - {$dl_lopmon.hodem_cb} {$dl_lopmon.ten_cb}</dd>
                        <dt class="col-sm-3">Học vụ:</dt>
                        <dd class="col-sm-8">{$dl_lopmon.ma_donvihocvu}</dd>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="row">
                        <dt class="col-sm-4">Số sinh viên đ.ký:</dt>
                        <dd class="col-sm-8">{$so_sv}</dd>
                        <dt class="col-sm-4">Trạng thái:</dt>
                        <dd class="col-sm-8" id="trangthai">{$dl_lopmon.tendm_trangthai_lopmon}</dd>
                        <dt class="col-sm-4">Ngày bắt đầu:</dt>
                        <dd class="col-sm-8">{$dl_lopmon.ngaybd}</dd>
                        <dt class="col-sm-4">Ngày kết thúc:</dt>
                        <dd class="col-sm-8">{$dl_lopmon.ngaykt}</dd>
                        <dt class="col-sm-4">Hình thức:</dt>
                        <dd class="col-sm-8" id="hinhthuc">{$dl_lopmon.ma_hinhthuc}</dd>
                    </div>
                </div>
            </div>
            <div class="action">
                <button type="button" class="btn btn-warning btn-sm" id="suatl" value="{$dl_lopmon.ma_lopmon}"><i class="fa fa-edit"></i> &nbsp; Sửa tên lớp</button>&emsp;
                {if $dl_lopmon.madm_trangthai_lopmon === 'dukien' || $quyen == 'phongkhaothi'}
                <button type="button" class="btn btn-primary btn-sm" id="sua_cbm" value="{$dl_lopmon.ma_lopmon}"  data-toggle="modal" data-target="#capnhat-lopmon-modal"><i class="fa fa-pencil"></i> &nbsp; Cập nhật lớp</button>&emsp;
                {/if}
                {if $dl_lopmon.madm_trangthai_lopmon === 'dukien'}
                    <button id="duyetlop" type="button" class="btn btn-success btn-sm" value="{$dl_lopmon.ma_lopmon}"><i class="fa fa-check"></i> &nbsp; Duyệt lớp </button>&emsp;
                    <button id="huylop" type="button" class="btn btn-danger btn-sm" value="{$dl_lopmon.ma_lopmon}"><i class="fa fa-times"></i> &nbsp; Hủy lớp</button>&emsp;
                {/if}
                {if $dl_lopmon.madm_trangthai_lopmon === 'daduyet'}
                    <button id="ketthuc" type="button" class="btn btn-danger btn-sm" value="{$dl_lopmon.ma_lopmon}"><i class="fa fa-check-square-o"></i> &nbsp; Kết thúc lớp</button>&emsp;
                {/if}
                {if empty($dl_lopmon.sophieu)}
                <input type="checkbox" id="tg-hinhthuc" class="giatri-cauhoi" data-toggle="toggle" data-size="small" data-on="online" data-off="offline" data-onstyle="primary" {if $dl_lopmon.ma_hinhthuc == 'online'}checked{/if}>
                {/if}
            </div>
            <div id="capnhat-lopmon-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title text-info">Cập nhật môn học - giảng viên</h4> </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="monhoc" class="control-label">Môn học:</label>
                                    <select class="form-control select2" id="monhoc" name="monhoc">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="canbo" class="control-label">Giảng viên:</label>
                                    <select class="form-control select2" id="giangvien" name="giangvien">
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">
                                <i class="fa fa-times"></i> &nbsp; Hủy
                            </button>
                            <button id="capnhat_mon_cb" type="button" class="btn btn-warning waves-effect waves-light" data-dismiss="modal">
                                <i class="fa fa-save"></i> &nbsp; Cập nhật
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{$url}assets/js/hethong/chitietlopmon.js?ver1.2"></script>
<script src="{$url}assets/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>