<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{$url}assets/images/logo_hou.png">
	<title>Khảo sát giảng dạy</title>
	<style type="text/css">
		body{
    		font-size: 13pt;
    	}
    	.phieu{
    		width: 215mm;
    		margin: 0 auto;
    		page-break-after: always;
    		margin-bottom: 50px;
    	}
    	.phieu .head{
    		display: flex;
    	}
    	.truong{
    		width: 40%;
    	}
    	.tieungu{
    		width: 60%;
    	}
    	.head, .head-title{
    		text-align: center;
    		font-size: 15pt;
    	}
    	.head p, .head-title p{
    		margin: 5px 0;
    	}
    	.head-title{
    		margin: 35px 0;	
    	}
    	.flex{
    		display: flex;
    	}
    	.full-width{
    		width: 100%;
    	}
    	.giangvien .flex .full-width{
    		margin: 0;
    	}
    	.giangvien>div, .ketqua>div{
    		padding: 0 22px;
    	}
    	.text-center{
    		text-align: center;
    	}
    	.text-bold{
    		font-weight: bold;
    	}
    	.table{
    		width: 100%;
    	}
    	.table-bordered{
    		border-collapse: collapse;
    	}
    	.table-bordered td{
    		border: 1px solid #000;
    		padding: 5px;
    	}
    	.chiso-linhvuc tfoot td:first-child{
    		border-right-color: transparent;
    	}
    	.chiso-linhvuc tfoot td:last-child{
    		border-left-color: transparent;
    	}
    	td{
    		text-align: justify;
    	}
    	.ykien{
    		margin-left: 20px;
    	}
    	.ykienkhac p{
    		margin-top: 0;
    	}
    	.text-justify{
    		text-align: justify;
    	}
	</style>
</head>
<body>
	{foreach $canbomon as $mcb => $dsmon}
	{foreach $dsmon as $mm => $tt}
	<div class="giangvien-mon">
		<div class="phieu">
			<div class="head">
				<div class="truong">
					<p><b>BỘ GIÁO DỤC VÀ ĐÀO TẠO</b></p>
					<p><u>TRƯỜNG ĐẠI HỌC MỞ HÀ NỘI</u></p>
				</div>
				<div class="tieungu">
					<p><b>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</b></p>
					<p>Độc lập - Tự do - Hạnh phúc</p>
				</div>
			</div>
			<div class="head-title">
				<p><b>KẾT QUẢ KHẢO SÁT HOẠT ĐỘNG GIẢNG DẠY</b></p>
				<p><b>THEO LĨNH VỰC</b></p>
			</div>
			<div class="giangvien">
				<h4>A. THÔNG TIN VỀ GIẢNG VIÊN</h4>
				<div>
					<p>Họ và tên giảng viên (GV): {$tt.canbo}</p>
					<p>Tên môn học: {$tt.monhoc}</p>
					<div class="flex">
						<p class="full-width">Học kỳ: {$hocky}</p>
						<p class="full-width">Năm học: {$namhoc}</p>
					</div>
					<p>Khoa: {$tt.khoa}</p>
				</div>
			</div>
			<div class="chiso-linhvuc">
				<h4>B. CHỈ SỐ TRUNG BÌNH HÀI LÒNG ĐỐI VỚI TỪNG LĨNH VỰC (Q)</h4>
				<table class="table table-bordered">
					<thead>
						<tr>
							<td class="text-center"><b>Lĩnh vực lấy ý kiến</b></td>
							<td class="text-center"><b>Chỉ số Q</b></td>
						</tr>
					</thead>
					<tbody>
						{$trungbinhhailong = 0}
						{foreach $linhvuc as $key => $lv}
						<tr>
							<td>{$lv.ten_nhomcauhoi}</td>
							<td class="text-center">
								{if isset($tt.nhom[$lv.ma_nhomcauhoi])}
								{$chiso = round(($tt.nhom[$lv.ma_nhomcauhoi] * 100) / ($tt.tongphieu * $lv.socauhoi), 2)}
								{else}
								{$chiso = 0}
								{/if}
								{$chiso}
								{$trungbinhhailong = $trungbinhhailong + $chiso}
							</td>
						</tr>
						{/foreach}
					</tbody>
					<tfoot>
						<tr>
							<td class="text-center"><b>Mức hài lòng trung bình của các lĩnh vực:</b></td>
							<td class="text-center"><b>{round($trungbinhhailong / count($linhvuc), 2)}</b></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>

		<div class="phieu">
			<div class="head">
				<div class="truong">
					<p><b>BỘ GIÁO DỤC VÀ ĐÀO TẠO</b></p>
					<p><u>TRƯỜNG ĐẠI HỌC MỞ HÀ NỘI</u></p>
				</div>
				<div class="tieungu">
					<p><b>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</b></p>
					<p>Độc lập - Tự do - Hạnh phúc</p>
				</div>
			</div>
			<div class="head-title">
				<p><b>KẾT QUẢ KHẢO SÁT HOẠT ĐỘNG GIẢNG DẠY</b></p>
			</div>
			<div class="giangvien">
				<h4>A. THÔNG TIN VỀ GIẢNG VIÊN</h4>
				<div>
					<p>Họ và tên giảng viên (GV): {$tt.canbo}</p>
					<p>Tên môn học: {$tt.monhoc}</p>
					<div class="flex">
						<p class="full-width">Học kỳ: {$hocky}</p>
						<p class="full-width">Năm học: {$namhoc}</p>
					</div>
					<p>Khoa: {$tt.khoa}</p>
				</div>
			</div>

			<div class="ketqua">
				<h4>B. KẾT QUẢ ĐÁNH GIÁ HOẠT ĐỘNG GIẢNG DẠY</h4>
				<div>
					<p>Tổng số phiếu phản hồi của sinh viên: {$tt.tongphieu}</p>
					<p>Trung bình hài lòng đối với quá trình đào tạo: {round($trungbinhhailong / count($linhvuc), 2)}</p>
				</div>
			</div>
			<div class="chitiet">
				<h4>I. Quy định về mức đánh giá</h4>
				<table class="table table-bordered">
					<tr>
						{foreach $map_dapan as $k => $da}
						<td>{$k + 1}. {$da}</td>
						{/foreach}
					</tr>
				</table>
				<h4>II. Nội dung lấy ý kiến</h4>
				<table class="table table-bordered">
					<thead>
						<tr>
							<td rowspan="2" colspan="2" class="text-center"><b>NỘI DUNG LẤY Ý KIẾN</b></td>
							<td colspan="{count($map_dapan)}" class="text-center"><b>Mức đánh giá</b></td>
						</tr>
						<tr>
							<td colspan="{count($map_dapan)}" class="text-center">Tỷ lệ % đối với từng mức</td>
						</tr>
					</thead>
					<tbody>
					{foreach $linhvuc as $manhom => $lv}
						<tr>
							<td class="text-center" width="30"><b>{$lv.chimuc_nhomcauhoi}</b></td>
							<td><b>{$lv.ten_nhomcauhoi}</b></td>
							{foreach $map_dapan as $k => $da}
							<td class="text-center" width="40"><b>{$k + 1}</b></td>
							{/foreach}
						</tr>
						{foreach $dscauhoi[$lv.ma_nhomcauhoi] as $key => $ch}
						<tr>
							<td class="text-center">{$key + 1}</td>
							<td>{$ch.noidung_cauhoi}</td>
							{$tongdanhgia = 0}
							{foreach $map_dapan as $k => $ndda}
							{if $k < count($map_dapan) - 1}
							{$danhgia = (isset($tt.cauhoi[$ch.ma_cauhoi][$ndda])) ? round(($tt.cauhoi[$ch.ma_cauhoi][$ndda] * 100) / $tt.tongphieu, 2) : 0}
							{$tongdanhgia = $tongdanhgia + $danhgia}
							{else}
							{$danhgia = 100 - $tongdanhgia}
							{/if}
							<td class="text-center">{$danhgia}</td>
							{/foreach}
						</tr>
						{/foreach}
					{/foreach}
					</tbody>
				</table>
				<h4>III. Những ý kiến khác</h4>
				{foreach $dscauhoikhac as $key => $ch}
				<div class="ykienkhac">
					<p class="text-justify"><strong><i>{$key + 1}. {$ch.noidung_cauhoi}</i></strong></p>
					{if isset($tt.cauhoi[$ch.ma_cauhoi])}
					{foreach $tt.cauhoi[$ch.ma_cauhoi] as $nd}
					<p class="ykien text-justify">- {htmlspecialchars(addslashes($nd))}</p>
					{/foreach}
					{/if}
				</div>
				{/foreach}
			</div>
		</div>
	</div>
	{/foreach}
	{/foreach}
</body>
</html>