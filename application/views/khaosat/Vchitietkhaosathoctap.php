<link rel="stylesheet" href="{$url}assets/css/khaosat/chitietkhaosat.css">

<div class="panel panel-default block m-t-5">
    <div class="panel-heading"> 
        <h3 class="text-center">TÌNH TRẠNG KHẢO SÁT LỚP MÔN</h3>
        
        <p><span>Lớp môn: </span><span id="lopmon">{$ttlm.ten_monhoc}</span></p>
        <p><span>Giảng viên: </span><span id="giangvien">{$ttlm.canbo}</span></p>
        <div class="row">
            <div class="col-xs-6">
                <p><span>Học kỳ: </span><span id="kyhoc">{$ttlm.ma_donvihocvu}</span></p>
                <p><span>Hình thức học: </span><span id="hinhthuc">{$ttlm.ma_hinhthuc}</span></p>
                <p><span>Ngày bắt đầu khảo sát: </span><span id="ngaybatdauks">{$ttlm.ngaybdks}</span></p>
            </div>
            <div class="col-xs-6">
                <p><span>Ngày bắt đầu: </span><span id="ngaybatdau">{$ttlm.nbd}</span></p>
                <p><span>Ngày kết thúc: </span><span id="ngayketthuc">{$ttlm.nkt}</span></p>
                <p><span>Ngày kết thúc khảo sát: </span><span id="ngayketthucks">{$ttlm.ngayktks}</span></p>
            </div>
        </div>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
        	{if empty($dssinhvien)}
            <div class="alert alert-warning text-center">
                <strong class="text-uppercase">LỚP MÔN NÀY KHÔNG CÓ SINH VIÊN</strong>
            </div>
        	{else}
            <div class="action">
                <a href="khaosathoctap/inchitiet?lopmon={$ma_lopmon}&dot={$ma_dotkhaosat}" target="_blank">
                    <i class="ti-receipt"></i> &nbsp;In DS khảo sát
                </a>
                <a href="khaosathoctap/chitietphieu?lopmon={$ma_lopmon}&dot={$ma_dotkhaosat}" target="_blank">
                    <i class="ti-printer"></i> &nbsp;In phiếu
                </a>
            </div>
        	<table class="table table-bordered" id="danhsach-sinhvien">
        		<thead>
        			<tr>
        				<th>STT</th>
        				<th>Mã sinh viên</th>
        				<th>Họ và tên</th>
                        <th>Giới tính</th>
                        <th>Ngày sinh</th>
                        <th>Lớp hành chính</th>
        				<th>Thời gian khảo sát</th>
        				<th>Xem chi tiết</th>
        			</tr>
        		</thead>
        		<tbody>
        			{foreach $dssinhvien as $key => $sv}
        			<tr>
        				<td class="text-center" width="5%">{$key + 1}</td>
        				<td class="text-center" width="12%">{$sv.ma_sv}</td>
        				<td><span class="hodem">{$sv.hodem_sv}</span><span class="ten">{$sv.ten_sv}</span></td>
                        <td class="text-center" width="7%">{$sv.gioitinh_sv}</td>
                        <td class="text-center" width="10%">{$sv.ngaysinh}</td>
        				<td class="text-center" width="10%">{$sv.ten_lop}</td>
        				<td class="text-center" width="20%">
        					{if (isset($dskhaosat[$sv.ma_dkm]))}
        						{if ($dskhaosat[$sv.ma_dkm].thoigian_khaosat != '')}
        						{$dskhaosat[$sv.ma_dkm].thoigian_khaosat}
        						{else}
        						<label class="label label-warning">Chưa khảo sát</label>
        						{/if}
        					{else}
        						<label class="label label-danger">Không có phiếu</label>
        					{/if}
        				</td>
        				<td class="text-center" width="12%">
        					{if isset($dskhaosat[$sv.ma_dkm]) && ($dskhaosat[$sv.ma_dkm].thoigian_khaosat != '')}
        					<a href="khaosathoctap/chitietphieu?maphieu={$dskhaosat[$sv.ma_dkm].ma_phieu}" class="" title="Xem chi tiết phiếu" target="_blank">
        						<i class="fa fa-eye"></i> &nbsp;Xem chi tiết
        					</a>
        					{/if}
        				</td>
        			</tr>
        			{/foreach}
        		</tbody>	
        	</table>
        	{/if}
        </div>
    </div>
</div>