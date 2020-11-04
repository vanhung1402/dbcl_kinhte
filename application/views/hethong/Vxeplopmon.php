<link rel="stylesheet" href="{$url}assets/css/hethong/xeplopmon.css">

<div class="panel panel-default m-t-5">
    <div class="panel-heading text-uppercase text-center">
        <p>XẾP LỚP MÔN</p>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-3"> 
                    <div class="input-group">
                        <span class="input-group-addon">Đơn vị học vụ:</span>
                        <select name="dvhv" id="dvhv" class="form-control select2">
                            <option value="" selected>--- Chọn ---</option>
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
                        <span class="input-group-addon">Lớp hành chính:</span>
                        <select class="form-control select2" id="lop_hc" name="lop_hc">
                            <option value="" selected>--- Chọn ---</option>
                            {foreach $ds_lophc as $hc}
                                <option value="{$hc.ma_lop}">
                                    {$hc.ten_lop}
                                </option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon">Lớp môn:</span>
                        <select class="form-control select2" id="lopmon" name="lopmon">
                            <option value="">------ Chọn -------</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="alert text-center">
                <button class="btn btn-info waves-effect waves-light" data-toggle="modal"  id="luu" type="button" name="luu" value="luu">
                    <span class="btn-label">
                        <i class="fa fa-plus"></i>
                    </span>Thêm
                </button>
            </div>
            <div class="row">
                <div class="col-sm-5">  
                    <div class="text-center">
                        <span>DSSV chưa được xếp vào lớp môn ( <span class="so_sv_chuaxep">0</span> sinh viên )</span>
                    </div>
                    <div class="pre-scrollable" style="overflow-x: scroll;margin-top: 10px;">
                        <table class="table table-bordered" id="table-left" style="margin-bottom: 0px;">
                            <tr>
                                <th class="text-center"><input type="checkbox" class="chkall"></th>
                                <th style="width:60%">Họ tên </th>
                                <th style="width:30%">Ngày sinh</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-sm-1 text-center" style="margin: 80px 20px 200px;">
                    <button type="button" class="btn btn-success" id="add"><span class="glyphicon glyphicon-arrow-right"></span></button>
                    <br/>
                    <br/>
                    <button type="button" class="btn btn-danger" id="rmv"><span class="glyphicon glyphicon-arrow-left"></span></button>
                </div>
                <div class="col-sm-5">
                    <div class="text-center">
                        <span>DSSV trong lớp môn ( <span class="so_sv_lopmon">0</span> sinh viên )</span>
                    </div>
                    <div class="pre-scrollable" style="overflow-x: scroll;margin-top: 10px;">
                        <table class="table table-bordered" id="table-right" style="margin-bottom: 0px;">
                            <tr>
                                <th class="text-center"><input type="checkbox" name="chk_all" class="chkall"></th>
                                <th style="width:60%">Họ tên</th>
                                <th style="width:30%">Ngày sinh</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>

<script src="{$url}assets/js/hethong/xeplopmon.js"></script>