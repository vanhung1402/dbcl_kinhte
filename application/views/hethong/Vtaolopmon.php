<div class="panel panel-default m-t-5">
    <div class="panel-heading text-uppercase text-center">
        <p>DỰ KIẾN LỚP MÔN</p>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-5">
                    <div class="input-group">
                        <span class="input-group-addon">Chương trình đào tạo</span>
                        <select name="ctdt" id="ctdt" class="form-control select2">
                            <option value="">--- Chọn CTĐT ---</option>
                            {foreach $ds_ctdt as $ctdt}
                                <option value="{$ctdt.ma_ctdt}">
                                    {$ctdt.tendm_nganh} - {$ctdt.nam}
                                </option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-sm-4"> 
                    <div class="input-group">
                        <label class="input-group-addon">Giảng viên</label>
                        <select class="form-control select2" id="giangvien" name="giangvien">
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-addon">Ngày bắt đầu</span>
                        <input class="form-control datepicker-autoclose" type="text" name="nbd" id="ngay_bd">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <div class="input-group">
                        <label class="input-group-addon">Môn học</label>
                        <select class="form-control" id="monhoc" name="monhoc">
                        </select>
                    </div>
                </div>
                <div class="col-sm-4"> 
                    <div class="input-group">
                        <span class="input-group-addon">Đơn vị học vụ</span>
                        <select name="dvhv" id="dvhv" class="form-control select2">
                            {foreach $ds_dvhv as $dvhv}
                                <option value="{$dvhv.ma_donvihocvu}">
                                    {$dvhv.ma_donvihocvu}
                                </option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <span class="input-group-addon">Ngày kết thúc</span>
                        <input class="form-control datepicker-autoclose" type="text" name="nkt" id="ngay_kt">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <div class="input-group">
                        <span class="input-group-addon">Hình thức giảng dạy</span>
                        <select name="hinhthuc" id="hinhthuc" class="form-control select2">
                            <option value="offline">Offline</option>
                            <option value="online">Online</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="input-group">
                        <span class="input-group-addon">Tên lớp môn</span>
                        <input class="form-control" type="text" name="tenlm" id="ten_lm">
                    </div>
                </div>
                <div class="col-sm-4 hidden">
                    <div class="input-group">
                        <span class="input-group-addon">Số tiết học</span>
                        <input class="form-control" type="number" min="1" value="3" name="so_tiet" id="so_tiet">
                    </div>
                </div>
            </div>
            <div class="row m-t-15">
                <div class="col-sm-12 text-center">
                    <button class="btn btn-info waves-effect waves-light" data-toggle="modal"  type="button" name="luu" value="luu" title="Thêm" id="luu">
                        <span class="btn-label">
                            <i class="fa fa-plus"></i>
                        </span>THÊM
                    </button>
                </div>
            </div>
            <div class="row m-t-30 hidden" id="result-copy">
                <div class="col-md-6 form-group">
                    <input type="text" class="form-control" disabled="">
                </div>
                <div class="col-md-6 form-group">
                    <div class="col-sm-12 text-center">
                        <button class="btn btn-primary waves-effect waves-light" id="copy-vuatao">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>COPY MÃ LỚP MÔN VỪA TẠO
                        </button>
                    </div>
                </div>
            </div>
            <div class="row m-t-30">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="dslopmon">
                        <thead>
                            <tr>
                                <th class="text-center">Mã lớp môn</th>
                                <th class="text-center">Tên lớp môn</th>
                                <th class="text-center">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12" style="position: absolute; left: -9999px; top: 0;">
                    <input type="text" id="copy-text" class="form-control">
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{$url}assets/js/hethong/taolopmon.js?ver={time()}"></script>
