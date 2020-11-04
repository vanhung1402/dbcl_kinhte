<link rel="stylesheet" href="{$url}assets/css/hethong/ctdt.css">

<div class="panel panel-default m-t-5">
    <div class="panel-heading text-uppercase text-center">
        <p>QUẢN LÝ CHƯƠNG TRÌNH ĐÀO TẠO</p>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-4 m-b-30">
                        <div class="area-heading">
                            <h4 class="text-center text-info">Thêm trình đào tạo</h4>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Hệ đào tạo</span>
                            <select name="hedaotao" id="hedaotao" class="form-control select2">
                                <option value="">--- Chọn hệ đào tạo ---</option>
                                {foreach $hedaotao as $hdt}
                                <option value="{$hdt.madm_hedaotao}">{$hdt.tendm_hedaotao}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Trình độ</span>
                            <select name="trinhdo" id="trinhdo" class="form-control select2">
                                <option value="">--- Chọn trình độ ---</option>
                                {foreach $trinhdo as $td}
                                <option value="{$td.madm_trinhdo}">{$td.tendm_trinhdo}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Ngành học</span>
                            <select name="nganh" id="nganh" class="form-control select2">
                                <option value="">--- Chọn ngành ---</option>
                                {foreach $nganh as $n}
                                <option value="{$n.madm_nganh}">{$n.tendm_nganh}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Năm</span>
                            <select name="nam" id="nam" class="form-control select2">
                                <option value="">-- Chọn năm --</option>
                                {foreach $nam as $n}
                                <option value="{$n}">{$n}</option>
                                {/foreach}
                            </select>
                        </div>

                        <div class="text-center m-t-15">
                            <button type="button" class="btn btn-success waves-effect waves-light" name="them_ctdt" id="them_ctdt" value="them_ctdt">
                                <span class="btn-label">
                                    <i class="fa fa-check"></i>
                                </span>
                                THÊM CTĐT
                            </button>
                        </div>
                    </div>
                    <div class="col-md-8 m-b-30">
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%">STT</th>
                                    <th class="text-center" style="width:20%">Hệ đào tạo</th>
                                    <th class="text-center" style="width:20%">Trình độ</th>
                                    <th class="text-center" style="width:30%">Ngành</th>
                                    <th class="text-center" style="width:10%">Năm</th>
                                    <th class="text-center" style="width:30%">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                            {foreach $ds_ctdt as $k => $ctdt}
                                <tr>
                                    <td class="text-center">{$k+1}</td>
                                    <td>{$ctdt.tendm_hedaotao}</td>
                                    <td>{$ctdt.tendm_trinhdo}</td>
                                    <td>{$ctdt.tendm_nganh}</td>
                                    <td class="text-center">{$ctdt.nam}</td>
                                    <td class="text-center">
                                    {if $ctdt.ma_khoahoc == ''}
                                        <button type="button" class="btn btn-info sua btn-xs" value="{$ctdt.ma_ctdt}"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-danger del_ctdt btn-xs" type="button" value="{$ctdt.ma_ctdt}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    {else}
                                        <button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="left" data-original-title="Chương trình đào tạo này đang được áp dụng được đang hoạt động">
                                            <i class="fa fa-lock"></i>
                                        </button>
                                    {/if}
                                    </td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{$url}assets/js/hethong/chuongtrinhdaotao.js"></script>
