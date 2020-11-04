
<div class="panel panel-default m-t-5">
    <div class="panel-heading text-uppercase text-center">
        <p>QUẢN LÝ MÔN HỌC</p>
    </div>
    <div class="panel-wrapper collapse in">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="area-heading">
                        <h4 class="text-center text-info">Thêm môn học</h4>
                    </div>
                    <div>
                        <div class="input-group">
                            <span class="input-group-addon">Tên môn:</span>
                            <input id="tmh" type="text" class="form-control" placeholder="..."> 
                        </div>
                    </div>
                    <div>
                        <div class="input-group">
                            <span class="input-group-addon">Viết tắt:</span>
                            <input id="tvt" type="text" class="form-control" placeholder="..."> 
                        </div>
                    </div>
                    <div>
                        <div class="input-group">
                            <span class="input-group-addon">KL lý thuyết:</span>
                            <input id="kllt" type="text" class="form-control" placeholder="...">
                        </div>
                    </div>
                    <div>
                        <div class="input-group">
                            <span class="input-group-addon">KL thực hành:</span>
                            <input id="klth" type="text" class="form-control" placeholder="..."> 
                        </div>
                    </div>
                    <input type="hidden" id="idmh" />
                    <div class="text-center m-t-15">
                        <button class="btn btn-success waves-effect waves-light" type="submit" id="save" value="Lưu" name="luu">
                            <span class="btn-label">
                                <i class="fa fa-check"></i>
                            </span>
                            LƯU
                        </button>
                    </div>
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th width="50" class="text-center">STT</th>
                                <th class="text-center">Tên môn học</th>
                                <th class="text-center">Tên viết tắt</th>
                                <th width="75" class="text-center">Lý thuyết</th>
                                <th width="75" class="text-center">Thực hành</th>
                                <th width="75" class="text-center">Tổng khối lượng</th>
                                <th width="100" class="text-center">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            {$i=1}
                            {$monhoc=''}
                            {foreach $dsmonhoc as $mh}
                            <tr>
                                <td class="text-center">{$i++}</td>
                                <td class="td-200">{$mh.ten_monhoc}</td>
                                <td class="td-100">{$mh.ten_viettat_monhoc}</td>
                                <td class="td-100 text-center">{if !empty($kllt[$mh.ma_monhoc])}{$kllt[$mh.ma_monhoc]}{/if}</td>
                                <td class="td-100 text-center">{if !empty($klth[$mh.ma_monhoc])}{$klth[$mh.ma_monhoc]}{/if}</td>
                                <td class="td-100 text-center">{$mh.tongkhoiluong} </td>
                                <td class="text-center">
                                    {if !isset($chk_mon.{$mh.ma_monhoc})}
                                    <button class="btn btn-info btn-xs upd" style="margin-right: 4px" data-id="{$mh.ma_monhoc}"><i class="fa fa-edit"></i></button><button class="btn btn-danger btn-xs del" data-id="{$mh.ma_monhoc}"><i class="fa fa-trash"></i></button>
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
        </div>
    </div>
</div>

<script src="{$url}assets/js/hethong/taomonhoc.js?ver=1.0"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#container').attr('class', 'container-fliud');
    });
</script>