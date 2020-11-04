<div class="panel panel-default block m-t-5">
    <div class="panel-heading">
        <p class="text-uppercase text-center">THỐNG KÊ KHẢO SÁT HỌC TẬP</p>

        <form method="POST">
            <div class="loc row">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">Hình thức:</span>
                        <select name="hinhthuc" id="hinhthuc" class="loc-item form-control select2" required>
                            {foreach $dskhaosat as $ks}
                            <option value="{$ks.ma_khaosat}" {if $ks.ma_khaosat == $hinhthuc}selected{/if}>Hình thức đào tạo - {$ks.ma_hinhthuc}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">Đợt:</span>
                        <select name="hocvu" id="hocvu" class="loc-item form-control select2" required>
                            {foreach $dsdot as $d}
                            <option value="{$d.ma_dotkhaosat}" {if $d.ma_dotkhaosat == $hocvu}selected{/if}>Kỳ {$d.kyhoc} năm học {substr($d.ma_donvihocvu, 2, 4)} - {substr($d.ma_donvihocvu, 7)}</option>
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
            {if !isset($dslop)}
            <div class="alert alert-warning text-center">
                <strong class="text-uppercase">Chưa chọn dữ liệu lọc</strong>
            </div>
            {else if empty($dslop)}
            <div class="alert alert-warning text-center">
                <strong class="text-uppercase">KKhông có dữ liệu thống kê</strong>
            </div>
            {else}
            <table class="table table-condensed table-bordered table-hover table-striped datatable" id="thongke">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Lớp</th>
                        <th>Cố vấn học tập</th>
                        <th>Số sinh viên</th>
                        <th>Đã khảo sát / Không cần khảo sát</th>
                        <th>Chưa khảo sát</th>
                    </tr>
                </thead>
                <tbody>
                    {$stt = 1}
                    {foreach $dslop as $ml => $lop}
                    <tr>
                        <td class="text-center">{$stt++}</td>
                        <td>{$lop.ten_lop}</td>
                        <td>{trim($lop.hodem_cb)} {$lop.ten_cb}</td>
                        <td class="text-center">{$lop.sosinhvien}</td>
                        <td class="text-center">
                            {if isset($dschuakhaosat[$ml])}{$lop.sosinhvien - $dschuakhaosat[$ml]}{else}<i class="mdi mdi-close"></i>{/if}
                        </td>
                        <td class="text-center">
                            {if isset($dschuakhaosat[$ml])}{$dschuakhaosat[$ml]}{else}<i class="mdi mdi-close"></i>{/if}
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            {/if}
        </div>
    </div>
</div>

<script type="text/javascript" src="{$url}assets/js/khaosat/thongkekhaosat.js"></script>