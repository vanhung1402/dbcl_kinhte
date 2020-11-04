
<link rel="stylesheet" href="{$url}assets/css/khaosat/baocaokhaosat.css">

<div class="panel panel-default block m-t-5">
    <div class="panel-heading">
        <p class="text-uppercase text-center">BÁO CÁO KHẢO SÁT HỌC TẬP</p>

        <form method="POST">
            <div class="loc row">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">Hình thức:</span>
                        <select name="hinhthuc" id="hinhthuc" class="loc-item form-control select2" required>
                            {foreach $dskhaosat as $ks}
                            <option value="{$ks.ma_khaosat}" {if $ks.ma_khaosat == $baocao.hinhthuc}selected{/if}>Hình thức đào tạo - {$ks.ma_hinhthuc}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">Đợt:</span>
                        <select name="hocvu" id="hocvu" class="loc-item form-control select2" required>
                            {foreach $dsdot as $d}
                            <option value="{$d.ma_dotkhaosat}" {if $d.ma_dotkhaosat == $baocao.hocvu}selected{/if}>Kỳ {$d.kyhoc} năm học {substr($d.ma_donvihocvu, 2, 4)} - {substr($d.ma_donvihocvu, 7)}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-md-2 text-right">
                    <button class="fcbtn btn btn-xs btn-outline btn-info btn-1e" name="action" value="loc">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            {if empty($baocao)}
            <div class="alert alert-warning text-center">
                <strong class="text-uppercase">Chưa chọn dữ liệu lọc</strong>
            </div>
            {else if empty($baocao.mapbaocao)}
            <div class="alert alert-warning text-center">
                <strong class="text-uppercase">KKhông có dữ liệu báo cáo</strong>
            </div>
            {else}
            <div class="row">
                <div class="col-md-6">
                    <div class="text-center">
                        <h3 class="box-title text-center">Chỉ số hài lòng đối với toàn đợt</h3>
                        <div id="piechart" style="height: 375px;"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center">
                        <h3 class="box-title text-center">Chỉ số hài lòng đối với từng lĩnh vực</h3>
                        <div id="columnchart" style="height: 375px;"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="text-center" id="note">
                        <span id="hailong" class="text-right">
                            <span class="color"></span><strong> &nbsp; Hài lòng</strong>
                        </span>
                        <span id="khonghailong">
                            <span class="color"></span><strong> &nbsp; Không hài lòng</strong>
                        </span>
                    </div>
                </div>
            </div>
            <div class="linhvuc">
                <ul>
                    {foreach $baocao.linhvuc as $key => $lv}
                    <li><i class="ti-pin-alt"></i> &nbsp; <strong>{$lv.alias_name}: </strong>{$lv.ten_nhomcauhoi}</li>
                    {/foreach}
                </ul>
            </div>

            <div class="baocao m-t-30">
                <table class="table table-bordered table-hover datatable" id="baocao">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Môn học</th>
                            <th>Mã GV</th>
                            <th>Giảng viên</th>
                            <th>Học hàm, học vị</th>
                            <th class="solieu">Số phiếu</th>
                            <th class="solieu">Đã khảo sát</th>
                            <th class="solieu">Tỷ lệ khảo sát</th>
                            {foreach $baocao.linhvuc as $key => $lv}
                            <th class="solieu">{$lv.alias_name}</th>
                            {/foreach}
                            <th class="solieu">Trung bình</th>
                            <th>
                                <a href="luutru/khaosathoctap/danhgia?dot={$baocao.hocvu}" class="btn btn-xs btn-info" title="In phiếu đánh giá" target="_blank">
                                    <i class="fa fa-print"></i>
                                </a>
                                <a href="luutru/khaosathoctap/chitietphieu?dot={$baocao.hocvu}" class="btn btn-xs btn-success" title="In phiếu khảo sát" target="_blank">
                                    <i class="fa fa-file"></i>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $baocao.mapbaocao as $mcb => $gv}
                        {foreach $gv as $mmh => $m}
                        <tr>
                            <td class="text-center">{$m.stt}</td>
                            <td>{$m.monhoc} {$m.khoiluong}</td>
                            <td>{$mcb}</td>
                            <td>{$m.tencanbo}</td>
                            <td>{$m.hocham}</td>
                            <td class="text-center sophieu">{$m.sophieu}</td>
                            <td class="text-center dakhaosat">{$m.dakhaosat}</td>
                            <td class="text-center tylekhaosat">{$m.tylekhaosat}%</td>
                            {foreach $baocao.linhvuc as $mn => $n}
                            <td class="text-center tylelinhvuc">{$m.hailong[$mn]}%</td>
                            {/foreach}
                            <td class="text-center">{$m.tbhailong}%</td>
                            <td class="text-center">
                                {if $m.dakhaosat > 0}
                                <a href="luutru/khaosathoctap/danhgia?canbo={$mcb}&monhoc={$mmh}&dot={$baocao.hocvu}" class="btn btn-xs btn-info" title="In phiếu đánh giá" target="_blank">
                                    <i class="fa fa-print"></i>
                                </a>
                                <a href="luutru/khaosathoctap/chitietphieu?canbo={$mcb}&monhoc={$mmh}&dot={$baocao.hocvu}" class="btn btn-xs btn-success" title="In phiếu khảo sát" target="_blank">
                                    <i class="fa fa-file"></i>
                                </a>
                                {/if}
                            </td>
                        </tr>
                        {/foreach}
                        {/foreach}
                    </tbody>
                </table>
            </div>
            {/if}
        </div>
    </div>
</div>

<script src="{$url}assets/plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
<script src="{$url}assets/plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<script src="{$url}assets/plugins/bower_components/Chart.js/Chart.min.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#container').attr('class', 'container-fluid');

        var map_linhvuc = [];
        {if isset($baocao.linhvuc)}

        {foreach $baocao.linhvuc as $key => $lv}
        map_linhvuc.push({
            'linhvuc_id': '{$key}',
            'linhvuc_name': '{$lv.ten_nhomcauhoi}',
            'alias_name': '{$lv.alias_name}',
            'hailong': '{$lv.chiso}',
        });
        {/foreach} //

        loadPieChart({
            'hailong': Number({$baocao.tongchiso.hailong}),
            'khonghailong': Number({$baocao.tongchiso.danhgia}) - Number({$baocao.tongchiso.hailong}),
        });

        loadColumnChart();

        const hailong_color = "#2cabe3";
        const khonghailong_color = "#b4c1d7";

        $('#hailong .color').css('background-color', hailong_color);
        $('#khonghailong .color').css('background-color', khonghailong_color);
        
        {/if}//
{literal}

        function loadPieChart(dataChart = null){
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Đánh giá', 'Chỉ số trên lĩnh vực'],
                    ['Hài lòng',        dataChart.hailong],
                    ['Không hài lòng',  dataChart.khonghailong]
                    ]);

                var options = {
                    title: '',
                    colors: [hailong_color, khonghailong_color],
                    legend: 'none',
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
            }
        }

        function percentage(value, sum){
            return parseFloat((parseFloat(value * 100) / parseFloat(sum)).toFixed(2));
        }

        function loadColumnChart(dataChart){
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            let dataDraw = [['Lĩnh vực', 'Hài lòng', 'Không hài lòng']];
            map_linhvuc.forEach( function(lv, index) {
                dataDraw.push([
                    lv.alias_name,
                    Number(lv.hailong),
                    100 - Number(lv.hailong),
                ]);
            });

            function drawChart() {
                var data = google.visualization.arrayToDataTable(dataDraw);

                var options = {
                    legend: 'none',
                    isStacked: true,
                    colors: [hailong_color, khonghailong_color],
                };
                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1, 2]);

                var chart = new google.visualization.ColumnChart(document.getElementById("columnchart"));
                chart.draw(view, options);
            }
        }
    });
</script>
{/literal}

<script type="text/javascript" src="{$url}assets/js/khaosat/baocaokhaosat.js"></script>