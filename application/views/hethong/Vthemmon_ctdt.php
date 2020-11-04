<link rel="stylesheet" href="{$url}assets/css/hethong/monctdt.css">

<div class="panel panel-default m-t-5">
    <div class="panel-heading text-uppercase text-center">
        <p>Danh sách môn chương trình đào tạo</p>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
            <b id="inform"><div class="alert alert-info">Chương trình đào tạo này đang có hiệu lực, không thể thay đổi !</div></b>
            <form action="" method="POST">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="input-group">
                            <span class="input-group-addon">Chương trình đào tạo</span>
                            <select name="ctdt" id="ctdt" class="form-control select2">
                                <option value="">Chọn chương trình đào tạo</option>
                                {foreach $ds_ctdt as $ctdt}
                                    <option value="{$ctdt.ma_ctdt}" {if $ctdt_chk==$ctdt.ma_ctdt} selected {/if}>
                                        {$ctdt.tendm_nganh}-{$ctdt.nam}
                                    </option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="addlist" value=''/>
                    <input type="hidden" name="dellist" value=''/>
                    <div class="col-sm-3 text-right">
                        <button type="submit" name="save" value="save" class="btn btn-info" id="save">Lưu</button>
                    </div>
                    <div class="col-sm-3 text-right">
                        <a id="inctdt" type="button" class="btn btn-primary" target="_blank" href="" style="display: none;">In môn CTĐT</a>
                    </div>
                </div>
                <div class="alert"></div>
                <div class="row">
                    <div class="col-sm-5">
                        <p><strong>Danh sách môn chưa xếp</strong></p>
                        <div class="input-group">
                            <label class="input-group-addon">Tìm kiếm</label>
                            <input class="form-control" placeholder="Tìm kiếm...." id="left-key">
                        </div>
                        <div class="pre-scrollable" style="overflow-x: scroll;margin-top: 10px;">
                            <table class="table table-bordered table-striped" id="table-left" style="margin-bottom: 0px;">
                                <tr>
                                    <th><input type="checkbox" class="chkall"></th>
                                    <th class="td-300">Tên môn</th>
                                    <th class="td-50">Khối lượng</th>
                                    <th class="td-50">ĐV tính</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-2 td-150 text-center" style="margin-top: 80px; margin-bottom: 200px;">
                        <button type="button" class="btn btn-success" id="add"><span class="glyphicon glyphicon-arrow-right"></span></button>
                        <br/>
                        <br/>
                        <button type="button" class="btn btn-danger" id="rmv"><span class="glyphicon glyphicon-arrow-left"></span></button>
                    </div>
                    <div class="col-sm-5">
                        <p><strong>Danh sách môn trong CTĐT</strong></p>
                        <div class="input-group">
                            <label class="input-group-addon">Tìm kiếm</label>
                            <input class="form-control" placeholder="Tìm kiếm...." id="right-key">
                        </div>
                        <div class="pre-scrollable" style="overflow-x: scroll;margin-top: 10px;">
                            <table class="table table-bordered table-striped" id="table-right" style="margin-bottom: 0px;">
                                <tr>
                                    <th><input type="checkbox" name="chk_all" class="chkall"></th>
                                    <th class="td-300">Tên môn</th>
                                    <th class="td-50">Khối lượng</th>
                                    <th class="td-50">ĐV tính</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div> 
    </div>
</div>

<script src="{$url}assets/js/hethong/themmon_ctdt.js"></script>