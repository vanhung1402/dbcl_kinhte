<div class="panel panel-default m-t-5">
    <div class="panel-heading text-uppercase text-center">
        <p>QUẢN LÝ KHÓA HỌC</p>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-4 m-b-30">
                        <div class="area-heading">
                            <h4 class="text-center text-info">Thêm khóa học</h4>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">CTĐT</span>
                            <select name="ctdt" id="ctdt" class="form-control select2">
                                <option value="" selected disabled>--- Chọn chương trình đào tạo ---</option>
                                {foreach $ds_ctdt as $ct}
                                <option value="{$ct.ma_ctdt}">{$ct.tendm_nganh} - {$ct.nam}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">Năm học</span>
                            <select name="namhoc" id="namhoc" class="form-control select2">
                                <option value="" selected disabled>--- Chọn năm học ---</option>
                                {foreach $namhoc as $nh}
                                <option value="{$nh}">{$nh}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="text-center m-t-15">
                            <button type="button" class="btn btn-success waves-effect waves-light" id="them_kh" name="thaydoi" value="save">
                                <span class="btn-label">
                                    <i class="fa fa-check"></i>
                                </span>
                                LƯU
                            </button>
                        </div>
                    </div>
                    <div class="col-md-8 m-b-30">
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">STT</th>
                                    <th class="text-center">Chương trình đào tạo</th>
                                    <th class="text-center">Ngày tạo</th>
                                    <th class="text-center">Năm học</th>
                                    <th class="text-center">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach $khoahoc as $k => $kh}
                                <tr>
                                    <td class="text-center">{$k+1}</td>
                                    <td>{$kh.tendm_nganh} - {$kh.namctdt}</td>
                                    <td class="text-center">{$kh.ngaytao}</td>
                                    <td class="text-center">{$kh.namhoc}</td>
                                    <td class="text-center">
                                    {if !isset($chk_khoahoc.{$kh.ma_khoahoc})}
                                        <button type="button" class="btn btn-info sua btn-xs" value="{$kh.ma_khoahoc}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button name="xoa_khoahoc" class="btn btn-danger del_kh btn-xs" type="button" value="{$kh.ma_khoahoc}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    {else}
                                    <button type="button" class="btn btn-default btn-xs" title="Khóa học đang được đang hoạt động">
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

<script src="{$url}assets/js/hethong/khoahoc.js?ver=1.1"></script>
