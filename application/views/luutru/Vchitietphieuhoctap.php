<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{$url}assets/images/logo_hou.png">
	<title>Chi tiết phiếu khảo sát học tập</title>

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

    	.truong div{
    		width: 275px;
    		text-align: center;
    	}
    	.truong h4{
    		margin: 5px 0;
    	}
    	.truong hr{
    		margin: 0 15px 10px;
    	}
    	.truong img{
    		width: 30%;
    		height: 100%;
    	}
    	.tieude-khaosat{
    		margin: 5px 50px;
    		text-align: center;
    		text-transform: uppercase;
    	}
    	.phamvi-khaosat{
    		text-align: center;
    		margin: 10px;
    	}
    	.ten-sinhvien, .ma-sinhvien{
    		display: inline-block;
    		float: left;
    	}
    	.ten-sinhvien{
    		width: 60%;
    	}
    	.ma-sinhvien{
    		width: 40%;
    	}

    	.clear{
    		overflow: auto;
    	}
    	p{
    		margin: 10px 0;
    		text-align: justify;
    	}
    	.text-center{
    		text-align: center;
    	}
    	.text-justify{
    		text-align: justify;
    	}
    	table, th, td{
    		border: 1px solid #000;
    		border-collapse: collapse;
    		vertical-align: middle;
    	}
    	.ghichu-dapan, .ketqua-dapan{
    		width: 100%;
    		margin-bottom: 10px;
    	}
    	.ghichu-dapan td, .ketqua-dapan td{
    		padding: 5px;
    	}
    	.ykien{
    		margin-left: 20px;
    	}
    	.title-lv-1{
    		font-weight: 600;
    		margin: 20px 0 10px;
    	}
    	.flex{
    		display: flex;
    		flex-direction: row;
    	}
    	.flex p{
    		margin-top: 0;
    	}
    	.lopmon .flex:last-child p, .thongtin-banthan .flex p{
    		width: 100%;
    		margin-bottom: 0;
    	}
    	.box{
    		border: 1px solid #000;
    		padding: 0 5px;
    		font-size: 13pt;
    	}
    	.col-4{
    		flex: 33.3333%;
    		width: 33.3333%;
    	}
    	.col-8{
    		flex: 66.6666%;
    		width: 66.6666%;	
    	}
    </style>
</head>
<body>
	{foreach $ttphieu as $p}
	<div class="phieu">
		<div class="truong">
			<div>
				<h4>TRƯỜNG ĐẠI HỌC MỞ HÀ NỘI</h4>
				<hr>
				<img src="{$url}assets/images/logo_hou.png" alt="Trường Đai học Mở HÀ Nội">
			</div>
		</div>
		<div class="khaosat">
			<h2 class="tieude-khaosat">{$khaosat.tieude_khaosat}</h2>
			<h4 class="phamvi-khaosat"><i>{$khaosat.ghichu_khaosat}</i></h4>

			<p class="noidung-khaosat">{$khaosat.noidung_khaosat}</p>
		</div>
		<div class="lopmon">
			<div class="flex">
				<div class="col-8">
					<p>Tên học phần: <i><b>{$p.ten_monhoc}</b></i></p>
				</div>
				<div class="col-4">
					<p>Mã học phần: .......................................</p>
				</div>
			</div>
			<div class="flex">
				<div class="col-8">
					<p>Học kỳ: <i><b>{substr($p.dvhv, 0, 1)}</b></i></p>
				</div>
				<div class="col-4">
					<p>Năm học: <i><b>{substr($p.dvhv, 2, 4)} - {substr($p.dvhv, 7)}</b></i></p>
				</div>
			</div>
			<div class="flex">
				<div class="col-4">
					<p>Khoa: <i><b>{$p.ten_donvi}</b></i></p>
				</div>
				<div class="col-4">
					<p>Ngành: <i><b>{$p.tendm_nganh}</b></i></p>
				</div>
				<div class="col-4">
					<p>Lớp: {$p.ten_lop}</p>
				</div>
			</div>
			<div class="flex">
				<p>Họ và tên giảng viên (GV): <i><b>{implode(' - ', $p.cblm)}</b></i></p>
			</div>
		</div>
		<div class="chitiet">
			<div class="thongtin-banthan">
				{$chude = $dschude[$khaosat.ma_khaosat][0]}
				<p class="title-lv-1">{$chude.chimuc_nhomcauhoi}. {$chude.ten_nhomcauhoi}</p>
				<p class="clear">
					{$stt = 1}
					<span class="ten-sinhvien">{$stt++}. Họ và tên sinh viên (SV): {trim($p.hodem_sv)} {$p.ten_sv}</span>
					<span class="ma-sinhvien">Mã sinh viên: {$p.ma_sv}</span>
				</p>
				<p>{$stt++}. Giới tính: {$p.gioitinh_sv}</p>

				{foreach $dscauhoi[$chude.ma_nhomcauhoi] as $ch}
				<div>
					<p class="text-justify">{$stt++}. {$ch.noidung_cauhoi}</p>
					<div class="flex">
						{foreach $dsdapan[$ch.ma_cauhoi] as $da}
						<p>
							{$da.noidung_dapan}
							{if isset($kqphieu[$p.ma_phieu][$ch.ma_cauhoi][$da.ma_dapan])}
							<span class="box"><b>×</b></span>
							{else}
							<span class="box">&nbsp;&nbsp;</span>
							{/if}
						</p>
						{/foreach}
					</div>
				</div>
				{/foreach}
			</div>

			<div class="danhgia-giangday">
				{$chude = $dschude[$khaosat.ma_khaosat][1]}
				{$stt = 1}
				<p class="title-lv-1">{$chude.chimuc_nhomcauhoi}. {$chude.ten_nhomcauhoi}</p>
				<p>Hãy đọc kĩ các câu sau và ghi dấu cộng (+) vào phương án trả lời phù hợp với ý kiến của riêng anh (chị).</p>
				
				<table class="ghichu-dapan">
					<tbody>
						<tr>
							{foreach $mapdapan as $k => $da}
							<td>{$k + 1}. {$da.noidung_dapan}</td>
							{/foreach}
						</tr>
					</tbody>
				</table>

				<table class="ketqua-dapan">
					<thead>
						<tr>
							<td colspan="2" class="text-center">Các vấn đề ý kiến của anh (chị)</td>
							<td colspan="{count($mapdapan)}">Ghi dấu (+) vào ô lựa chọn</td>
						</tr>
					</thead>
					<tbody>
						{foreach $dschude[$chude.ma_nhomcauhoi] as $cd}
						<tr>
							<td width="30" class="text-center"><b>{$cd.chimuc_nhomcauhoi}.</b></td>
							<td class="text-justify"><b>{$cd.ten_nhomcauhoi}</b></td>
							{foreach $mapdapan as $k => $da}
							<td width="25" class="text-center"><b>{$da.thutu_dapan + 1}</b></td>
							{/foreach}
						</tr>
						{foreach $dscauhoi[$cd.ma_nhomcauhoi] as $ch}
						<tr>
							<td class="text-center">{$stt++}.</td>
							<td class="text-justify">{$ch.noidung_cauhoi}</td>

							{foreach $dsdapan[$ch.ma_cauhoi] as $da}
							<td class="text-center">
								{if isset($kqphieu[$p.ma_phieu][$ch.ma_cauhoi][$da.noidung_dapan])}+{/if}
							</td>
							{/foreach}
						</tr>
						{/foreach}
						{/foreach}
					</tbody>
				</table>
			</div>

			<div class="ykien-donggop">
				{$chude = $dschude[$khaosat.ma_khaosat][2]}
				{$stt = 1}
				<p class="title-lv-1">{$chude.chimuc_nhomcauhoi}. {$chude.ten_nhomcauhoi}</p>
				{foreach $dscauhoi[$chude.ma_nhomcauhoi] as $key => $ch}
				<div>
					<p class="text-justify">{$stt++}. {$ch.noidung_cauhoi}</p>
					<p class="ykien text-justify">- {if isset($kqphieu[$p.ma_phieu][$ch.ma_cauhoi])}{htmlspecialchars(addslashes($kqphieu[$p.ma_phieu][$ch.ma_cauhoi]['dapantext']))}{/if}</p>
				</div>
				{/foreach}
			</div>
		</div>
	</div>
	{/foreach}
</body>
</html>