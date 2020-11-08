<link rel="stylesheet" href="{$url}assets/css/danhmuc/canbo.css">
<div class="panel panel-default m-t-5">
    <div class="panel-heading text-uppercase text-center">
        <p>CÁN BỘ</p>
    </div>
    <div class="panel-body">
        <form method="POST" action="" role="form" data-toggle="validator" >
            <div class="form-group">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Mã đối tượng </label>
                        <input type="text" name="ma_doituong" class="form-control" value="{if isset($sua)}{$sua.ma_doituong}{/if}" placeholder="Nhập mã cán bộ..."   required>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Họ và tên </label>
                        <input type="text" name="hodem_cb" class="form-control" value="{if isset($sua)}{$sua.hodem_cb} {$sua.ten_cb}{/if}" placeholder="Nhập họ tên..." required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="ngaysinh">Ngày sinh</label>
                        <input type="text"  class="form-control" data-mask="99/99/9999" id="ngaysinh" name="ngaysinh_cb" value="{if isset($sua)}{$sua.ngaysinh_cb}{/if}" placeholder="Nhập ngày sinh..." required autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="gioitinh">Giới tính</label><br>
                        <label class="radio-inline" for="gtnam" >
                            <input id="gtnam" type="radio" name="gioitinh_cb" value="Nam" {if isset($sua) && $sua.gioitinh_cb=="Nam"} checked="" {/if} required=""> 
                            Nam
                        </label>
                        &nbsp;&nbsp;&nbsp;
                        <label class="radio-inline" for="gtnu">
                            <input id="gtnu" type="radio" name="gioitinh_cb" value="Nữ" {if isset($sua) && $sua.gioitinh_cb=="Nữ"} checked="" {/if} required=""> 
                            Nữ
                        </label>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="donvi">Đơn vị</label>
                        <select class="form-control select2" name="donvi" id="donvi">
                            <option value="empty" selected disabled>Chọn đơn vị</option>
                            {foreach $donvi as $key => $value}
                            <option value="{$value['ma_donvi']}"{if !empty($sua)&&$sua.ma_donvi==$value.ma_donvi} selected=""{/if}>{$value['ten_donvi']}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="hocham">Học hàm</label>
                        <select class="form-control select2" name="hocham" id="hocham">
                            <option value="empty" selected disabled>Chọn học hàm</option>
                            {foreach $hocham as $key => $value}
                            <option value="{$value['ma_hocham']}"{if !empty($sua)&&$sua.ma_hocham==$value.ma_hocham} selected=""{/if}>{$value['ten_hocham']}&nbsp;</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="chucvu">Chức vụ</label>
                        <select class="form-control select2" name="chucvu" id="chucvu">
                            <option value="empty" selected disabled>Chọn chức vụ</option>
                            {foreach $chucvu as $key => $value}
                            <option value="{$value['ma_chucvu']}"{if !empty($sua)&&$sua.ma_chucvu==$value.ma_chucvu} selected=""{/if}>{$value['ten_chucvu']}&nbsp;</option>
                            {/foreach}
                        </select>
                    </div>
                    <br>
                    <div class="text-center">
                        {if isset($sua)}
                        <button class="btn btn-success waves-effect waves-light" data-toggle="modal" type="submit" name="capnhat" value="{$sua.ma_cb}" title="Cập nhật">
                            <span class="btn-label">
                                <i class="fa fa-edit"></i>
                            </span> Cập nhập
                        </button>
                        {else}
                        <button class="btn btn-info waves-effect waves-light" data-toggle="modal"  type="submit" name="them" value="+" title="Thêm" id="them">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>Thêm
                        </button>
                        {/if}
                    </div>
                </div>
            </div>
        </form>
        <br>
        <form method="post" action="">
            <div class="row table-scroll">
                <div class="col-md-12">
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Mã đối tượng</th>
                                <th class="text-center" style="width: 175px;">Họ và tên</th>
                                <th class="text-center">Ngày sinh</th>
                                <th class="text-center">Giới tính</th>
                                <th class="text-center">Học hàm</th>
                                <th class="text-center">Chức vụ</th>
                                <th class="text-center">Môn giảng dạy</th>
                                <th class="text-center" style="width: 30px;">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $thongtin as $key=>$val}
                            <tr>
                                <td class="text-center">{$key+1}</td>
                                <td>{$val.ma_doituong}</td>
                                <td>{$val.hodem_cb} {$val.ten_cb}</td>
                                <td class="text-center">{$val.ngaysinh_cb}</td>
                                <td class="text-center">{$val.gioitinh_cb}</td>
                                <td>{$val.ten_hocham}</td>
                                <td>{$val.ten_chucvu}</td>
                                <td>
                                    {if isset($mongiangday[$val.ma_cb])}
                                    {foreach $mongiangday[$val.ma_cb] as $stt => $m}
                                    {if $stt < 10}
                                    {$stt + 1}. {$m}<br>
                                    {else if $stt == 10}
                                    <a href="canbo_mon?idcb={$val.ma_cb}" name="edit" data-toggle="tooltip" data-placement="left" data-original-title="Quản lý môn giảng dạy của cán bộ">Xem thêm...</a>
                                    {/if}
                                    {/foreach}
                                    {/if}
                                </td>
                                <td>
                                    <div class="text-center">
                                        <a class="btn btn-info btn-xs waves-effect waves-light" href="canbo?macb={$val.ma_cb}" name="edit"  data-toggle="tooltip" data-placement="left" data-original-title="Cập nhật thông tin"><i class="fa fa-edit"></i></a>
                                        {if in_array($val.ma_cb, $Macanbo_sudung)}
                                        <button class="btn btn-xs btn-default remove" type="button" data-toggle="tooltip" data-placement="left" data-original-title="Không thể xóa cán bộ">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        {else}
                                        <button class="btn btn-xs btn-danger" type="submit" value="{$val.ma_cb}" name="delete" onclick="return confirm('Bạn có chắc muốn xóa không?')" data-toggle="tooltip" data-placement="left" data-original-title="Xóa cán bộ">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        {/if}
                                        <a class="btn btn-primary btn-xs waves-effect waves-light" href="canbo_mon?idcb={$val.ma_cb}" name="edit" data-toggle="tooltip" data-placement="left" data-original-title="Quản lý môn giảng dạy của cán bộ">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
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
<script type="text/javascript" src="{$url}assets/plugins/icheck/icheck.js?v=1.0.2"></script>
<script src="{$url}assets/js/mask.js"></script>
<script src="{$url}assets/template/js/validator.js"></script>
<script src="{$url}assets/js/danhmuc/canbo.js"></script>