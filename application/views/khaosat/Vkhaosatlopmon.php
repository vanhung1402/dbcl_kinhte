<link rel="stylesheet" href="{$url}assets/css/khaosat/khaosatlopmon.css">

<div class="panel panel-default block m-t-5">
    <div class="panel-heading">
        <p class="text-uppercase text-center">LỚP MÔN KHẢO SÁT HỌC TẬP</p>

        <form method="POST">
            <div class="loc row">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">Hình thức:</span>
                        <select name="hinhthuc" id="hinhthuc" class="loc-item form-control select2" required>
                            {foreach $dskhaosat as $ks}
                            <option value="{$ks.ma_khaosat}" {if $ks.ma_khaosat == $khaosat}selected{/if}>Hình thức đào tạo - {$ks.ma_hinhthuc}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">Đợt:</span>
                        <select name="hocvu" id="hocvu" class="loc-item form-control select2" required>
                            {foreach $dsdot as $d}
                            <option value="{$d.ma_dotkhaosat}" {if $d.ma_dotkhaosat == $dot}selected{/if}>Kỳ {$d.kyhoc} năm học {substr($d.ma_donvihocvu, 2, 4)} - {substr($d.ma_donvihocvu, 7)}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class="col-md-2 text-right">
                    <button class="fcbtn btn btn-sm btn-outline btn-info btn-1e" name="action" value="loc">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            {if !isset($dslopmon)}
            <div class="alert alert-warning text-center">
                <strong class="text-uppercase">Chưa chọn dữ liệu lọc</strong>
            </div>
            {else if empty($dslopmon)}
            <div class="alert alert-warning text-center">
                <strong class="text-uppercase">KKhông có dữ liệu khảo sát</strong>
            </div>
            {else}
            <table class="table table-bordered table-hover datatable" id="list-form">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên lớp môn</th>
                        <th width="75px">Ngày bắt đầu khảo sát</th>
                        <th width="75px">Ngày kết thúc khảo sát</th>
                        <th width="75px">Số phiếu hiện có</th>
                        <th width="75px">Số phiếu đã khảo sát</th>
                        <th width="100px">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    {$tongphieu = 0}
                    {$tongkhaosat = 0}
                    {foreach $dslopmon as $k => $lm}
                    <tr>
                        <td class="text-center">{$k + 1}</td>
                        <td>{$lm.ten_lopmon}</td>
                        <td class="text-center">{$lm.nbdks}</td>
                        <td class="text-center">{$lm.nktks}</td>
                        <td class="text-center">{$lm.sophieu}{$tongphieu = $tongphieu + $lm.sophieu}</td>
                        <td class="text-center">{$lm.hoanthanh}{$tongkhaosat = $tongkhaosat + $lm.hoanthanh}</td>
                        <td class="text-center">
                            <a href="{$url}khaosathoctap/inchitiet?lopmon={$lm.ma_lopmon}&dot={$dot}" class="btn btn-info btn-xs" target="_blank" data-toggle="tooltip" data-placement="left" data-original-title="In danh sách khảo sát lớp môn">
                                <i class="ti-receipt"></i>
                            </a>
                            {if $quyen == 'phongkhaothi' || $quyen == 'chunhiemkhoa'}
                            <a href="{$url}khaosathoctap/chitietphieu?lopmon={$lm.ma_lopmon}&dot={$dot}" class="btn btn-success btn-xs" target="_blank" data-toggle="tooltip" data-placement="left" data-original-title="In danh sách phiếu khảo sát lớp môn">
                                <i class="ti-printer"></i>
                            </a>
                            {/if}
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-center"><strong>Tổng</strong></td>
                        <td class="text-center"><strong>{$tongphieu}</strong></td>
                        <td class="text-center"><strong>{$tongkhaosat}</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            {/if}
        </div>
    </div>
</div>

<div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="mdi mdi-close"></i>
                </button>
                <h4 class="modal-title">Kết quả khảo sát: <i class="text-warning" id="student-name"></i></h4>
            </div>
            <div class="modal-body">
                <div class="list-group" id="list-form">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" id="inketqua"><i class="fa fa-print"></i>&nbsp; In kết quả</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Đóng</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{$url}assets/js/khaosat/khaosatlopmon.js"></script>