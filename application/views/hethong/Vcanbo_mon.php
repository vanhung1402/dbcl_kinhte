<link href="{$url}assets/plugins/dual-listbox/bootstrap-duallistbox.css" rel="stylesheet">
<link href="{$url}assets/css/hethong/canbo_mon.css" rel="stylesheet">

<div class="panel panel-default m-t-5">
    <div class="panel-heading text-uppercase text-center">
        <p>Danh sách môn cán bộ giảng dạy</p>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
            <form action="" method="POST">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="input-group">
                            <label class="input-group-addon">Giảng viên</label>
                            <select class="form-control select2" id="canbo" name="canbo">
                                <option value="">--- Chọn cán bộ ---</option>
                            {foreach $ds_canbo as $cb}
                                <option value="{$cb.ma_cb}"{if $tt_cb.ma_cb == $cb.ma_cb }selected{/if}>{if $cb.ma_hocham != '-'}{$cb.ma_hocham}. {/if}{$cb.hodem_cb} {$cb.ten_cb}</option>
                            {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <a href="" id="dichuyen" type="button" class="btn btn-outline btn-warning"><i class="fa fa-space-shuttle"></i></a>
                    </div>
                </div>
                <div style="height: 20px;"></div>
                <div class="alert " style="background-color:#dff9fb;position:relative;">
                    <strong>Cán bộ - giảng viên: <span style="color:#f0932b">{if $tt_cb.ma_hocham != '-'}{$tt_cb.ma_hocham}. {/if}{$tt_cb.hodem_cb} {$tt_cb.ten_cb}</span> ( {$tt_cb.ngaysinh_cb} )</strong>
                    <button style="position:absolute;right:5%;top: 15%;" type="submit" class="btn btn-primary" name="save-change" value="save">Lưu</button>
                </div>
                <div id="mon-giangvien">
                    <select multiple="multiple" size="10" name="canbomonhoc[]" id="canbomonhoc">
                        {foreach $ds_monhoc as $mh}
                            {if isset($mon_cb[$mh.ma_monhoc]) }
                                <option value="{$mh.ma_monhoc}" selected="selected">{$mh.ten_monhoc}</option>
                            {else}
                                <option value="{$mh.ma_monhoc}">{$mh.ten_monhoc}</option>
                            {/if}
                        {/foreach}
                    </select>
                </div>
                <input type="hidden" value="{$chuoimon}" name="chuoimon">
            </form>
        </div> 
    </div>
</div>

<script src="{$url}assets/plugins/dual-listbox/jquery.bootstrap-duallistbox.js"></script>
<script src="{$url}assets/js/hethong/canbo_mon.js"></script>