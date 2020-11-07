<link rel="stylesheet" href="{$url}assets/css/khaosat/tinhtrangkhaosat.css">

<div class="panel panel-default block m-t-5">
    <div class="panel-heading">
        <p class="text-uppercase text-center">KIỂM TRA KHẢO SÁT HỌC TẬP</p>

        <form method="POST">
            {if empty($dslop)}
            <div class="alert alert-warning text-center m-t-10">
                <strong class="text-uppercase">CÁN BỘ CHƯA CÓ LỚP MÔN QUẢN LÝ</strong>
            </div>
            {else}
            <div class="loc row">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Hình thức:</span>
                        <select name="hinhthuc" id="hinhthuc" class="loc-item form-control select2" required>
                            {foreach $dskhaosat as $ks}
                            <option value="{$ks.ma_khaosat}" {if $ks.ma_khaosat == $tinhtrang.hinhthuc}selected{/if}>Hình thức đào tạo - {$ks.ma_hinhthuc}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Đợt:</span>
                        <select name="hocvu" id="hocvu" class="loc-item form-control select2" required>
                            {foreach $dsdot as $d}
                            <option value="{$d.ma_dotkhaosat}" {if $d.ma_dotkhaosat == $tinhtrang.hocvu}selected{/if}>Kỳ {$d.kyhoc} năm học {substr($d.ma_donvihocvu, 2, 4)} - {substr($d.ma_donvihocvu, 7)}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">Lớp:</span>
                        <select name="lop" id="lop" class="loc-item form-control select2" required>
                            {foreach $dslop as $l}
                            <option value="{$l.ma_lop}" {if $l.ma_lop == $tinhtrang.lop}selected{/if}>{$l.ten_lop}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-md-4 m-t-5">
                    <div class="input-group">
                        <span class="input-group-addon">Tiêu chí:</span>
                        <select name="tieuchi" id="tieuchi" class="loc-item form-control select2" required>
                            {foreach $dstieuchi as $tc}
                            <option value="{$tc.ma_tieuchi}" {if $tc.ma_tieuchi == $tinhtrang.tieuchi}selected{/if}>{$tc.ten_tieuchi}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-md-8 m-t-5 text-right">
                    <button class="fcbtn btn btn-xs btn-outline btn-info btn-1e" name="action" value="loc">
                        <strong><i class="fa fa-search"></i> &nbsp; LỌC</strong>
                    </button>
                    <button class="fcbtn btn btn-sm btn-outline btn-success btn-1e" name="action" value="xuatexcel">
                        <strong><i class="fa fa-file-excel-o"></i> &nbsp; XUẤT EXCEL</strong>
                    </button>
                </div>
            </div>
            {/if}
        </form>
    </div>
    {if (!empty($dslop))}
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            {if empty($tinhtrang)}
            <div class="alert alert-warning text-center">
                <strong class="text-uppercase">Chưa chọn dữ liệu lọc</strong>
            </div>
            {else if empty($tinhtrang.dssinhvien)}
            <div class="alert alert-warning text-center">
                <strong class="text-uppercase">Không có dữ liệu kiểm tra</strong>
            </div>
            {else}
            <table class="table table-bordered table-hover datatable">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã sinh viên</th>
                        <th>Họ tên</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Hoàn thành</th>
                    </tr>
                </thead>
                <tbody>
                    {$stt = 1}
                    {foreach $tinhtrang.dssinhvien as $sv}
                    <tr>
                        <td class="text-center">{$stt++}</td>
                        <td class="text-center">{$sv.ma_sv}</td>
                        <td>
                            {if ($quyen == 'covanhoctap' || $quyen == 'giaovukhoa')}
                            <a type="button">{trim($sv.hodem_sv)} {$sv.ten_sv}</a>
                            {else}
                            <a type="button" class="kiemtra-khaosat" masv="{$sv.ma_sv}" dot="{$tinhtrang.hocvu}">{trim($sv.hodem_sv)} {$sv.ten_sv}</a>
                            {/if}
                        </td>
                        <td class="text-center">{$sv.ns}</td>
                        <td class="text-center">{$sv.gioitinh_sv}</td>
                        <td class="text-center">
                            <a class="mytooltip tooltip-effect-8" href="javascript:void(0)">
                                
                                <span class="tooltip-content3 tinhtrang-khaosat">
                                    
                                </span>
                            </a>
                            <a class="mytooltip" href="javascript:void(0)">
                                <label for="" class="label label-info">
                                    {if isset($tinhtrang.tinhtrang[$sv.ma_sv])}
                                    {$tinhtrang.tinhtrang[$sv.ma_sv].dakhaosat}|{$tinhtrang.tinhtrang[$sv.ma_sv].tongphieu}
                                    {else}0|0{/if}
                                </label>
                                {if !empty($tinhtrang.tinhtrang[$sv.ma_sv].chuakhaosat)}
                                <span class="tooltip-content5">
                                    <span class="tooltip-text3">
                                        <span class="tooltip-inner2 tinhtrang-khaosat">
                                            <p class="text-center">Môn chưa khảo sát</p>
                                            {foreach $tinhtrang.tinhtrang[$sv.ma_sv].chuakhaosat as $k => $tenmon}
                                            <p>{$k + 1}. {$tenmon}</p>
                                            {/foreach}
                                        </span>
                                    </span>
                                </span>
                                {/if}
                            </a>
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            {/if}
        </div>
    </div>
    {/if}
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

<script type="text/javascript" src="{$url}assets/js/khaosat/tinhtrangkhaosat.js"></script>