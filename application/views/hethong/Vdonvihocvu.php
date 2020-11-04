<link rel="stylesheet" href="{$url}assets/css/hethong/donvihocvu.css">

<div class="panel panel-default m-t-5">
    <div class="panel-heading text-uppercase text-center">
        <p>QUẢN LÝ ĐƠN VỊ HỌC VỤ</p>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-4 m-b-30">
                        <div class="area-heading">
                            <h4 class="text-center text-info">Thêm đơn vị học vụ</h4>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Chọn Năm học</span>
                            <select name="namhoc" id="namhoc" class="form-control select2">
                                <option value="">-- Chọn năm học --</option>
                                {foreach $nam as $n}
                                <option value="{$n}">{$n}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="kyhoc">
                            <label class="radio-inline" for="hk1">
                                <input id="hk1" type="radio" name="kyhoc" value="1" required=""> 
                                Học kỳ 1
                            </label>
                            &nbsp;&nbsp;&nbsp;
                            <label class="radio-inline" for="hk2">
                                <input id="hk2" type="radio" name="kyhoc" value="2" required=""> 
                                Học kỳ 2
                            </label>
                            &nbsp;&nbsp;&nbsp;
                            <label class="radio-inline" for="hk3">
                                <input id="hk3" type="radio" name="kyhoc" value="3" required=""> 
                                Học kỳ 3
                            </label>
                        </div>
                        <div class="text-center m-t-15">
                            <button type="button" class="btn btn-success waves-effect waves-light" name="dvhv" id="them_dvhv" value="dvhv">
                                <span class="btn-label">
                                    <i class="fa fa-check"></i>
                                </span>
                                THÊM ĐVHV
                            </button>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-7 m-b-30">
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:10%">STT</th>
                                    <th class="text-center" style="width:30%">Mã đơn vị học vụ</th>
                                    <th class="text-center" style="width:15%">Năm học</th>
                                    <th class="text-center" style="width:15%">Kỳ học</th>
                                    <th class="text-center" style="width:25%">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                            {foreach $ds_dvhv as $k => $dvhv}
                                <tr>
                                    <td class="text-center">{$k+1}</td>
                                    <td class="text-center">{$dvhv.ma_donvihocvu}</td>
                                    <td class="text-center">{$dvhv.namhoc}</td>
                                    <td class="text-center">{$dvhv.kyhoc}</td>
                                    <td class="text-center">
                                    {if !isset($chk_dvhv.{$dvhv.ma_donvihocvu})}
                                        <button type="button" class="btn btn-info sua btn-xs" value="{$dvhv.ma_donvihocvu}"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-danger del_dvhv btn-xs" type="button" value="{$dvhv.ma_donvihocvu}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    {else}
                                        <button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="left" data-original-title="Đơn vị học vụ này đang hoạt động">
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

<script src="{$url}assets/js/hethong/donvihocvu.js"></script>
