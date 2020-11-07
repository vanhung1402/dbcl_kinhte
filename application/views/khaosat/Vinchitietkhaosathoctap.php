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
    	p{
    		margin: 0 0 5px 0;
    	}
    	.trang{
    		width: 215mm;
    		margin: 0 auto;
    		page-break-after: always;
    		margin-bottom: 50px;
    	}
    	.head{
    		width: 40%;
    	}
    	.head h4{
    		margin-top: 0;
    	}
    	.class-title{
    		margin-bottom: 10px;
    	}
    	.class-title h3{
    		margin: 8px 0 5px 0;
    	}
    	.class-detail{
    		padding-bottom: 15px;
    		overflow: auto;
    	}
    	.class-detail .left, .class-detail .right{
    		display: inline-block;
    		float: left;
    	}
    	.class-detail .left{
    		width: 65%;
    	}
    	.class-detail .right{
    		width: 35%;
    	}
		.hodem{
			width: 70%;
			display: inline-block;
		}
		.ten{
			width: 30%;
			display: inline-block;
		}
    	.text-center{
    		text-align: center;
    	}
    	table{
    		border-collapse: collapse;
    		font-size: 11pt;
    	}th{
    		border: 1px solid #000;
    		padding: 5px;
    	}
    	td{
    		border: 1px solid #000;
    		padding: 5px;
    		border-top: none;
    	}
    	table tr:not(:last-child) td{
    		border-bottom: 1px dotted #000 !important;
    	}
    	.result{
    		padding: 15px 0;
    	}
    	.foot>div{
    		display: inline-block;
    		float: left;
    		width: 50%;
            min-height: 175px;
    	}
    </style>
</head>
<body>
	<div class="trang">
		<div class="head">
			<div class="khoa text-center">
				<p>TRƯỜNG ĐẠI HỌC MỞ HÀ NỘI</p>	
				<h4><u>KHOA {$ttlm.donvi}</u></h4>
			</div>
		</div>
		<div class="class-title text-center">
			<h3>DANH SÁCH SINH VIÊN LỚP MÔN</h3>
			<p><b>Môn học: {$ttlm.ten_monhoc}</b></p>
		</div>
		<div class="class-detail">
			<div class="left">
				<p><b>Ký hiệu lớp môn: {$ttlm.ma_lopmon}</b></p>
				<p><b>Kỳ học: {substr($ttlm.ma_donvihocvu, 0, 1)} - Năm học: {substr($ttlm.ma_donvihocvu, 2, 4)} - {substr($ttlm.ma_donvihocvu, 7, 4)}</b></p>
			</div>
			<div class="right">
				<p><b>Ngày bắt đầu: {$ttlm.nbd}</b></p>
				<p><b>Ngày kết thúc: {$ttlm.nkt}</b></p>
			</div>
		</div>
		<div class="student-list">
			<table width="100%">
				<thead>
					<tr>
						<th class="text-center">STT</th>
						<th class="text-center">MÃ SV</th>
						<th class="text-center">HỌ VÀ TÊN</th>
						<th class="text-center">NGÀY SINH</th>
						<th class="text-center">GT</th>
						<th class="text-center">LỚP</th>
						<th class="text-center">T.THÁI / THỜI GIAN KHẢO SÁT</th>
					</tr>
				</thead>
				<tbody>
					{foreach $dssinhvien as $key => $sv}
					<tr>
						<td class="text-center" width="5%">{$key + 1}</td>
						<td class="text-center" width="12%">{$sv.ma_sv}</td>
        				<td><span class="hodem">{$sv.hodem_sv}</span><span class="ten">{$sv.ten_sv}</span></td>
                        <td class="text-center" width="10%">{$sv.ngaysinh}</td>
                        <td class="text-center" width="7%">{$sv.gioitinh_sv}</td>
        				<td class="text-center" width="15%">{$sv.ten_lop}</td>
        				<td width="20%">
        					{if (isset($dskhaosat[$sv.ma_dkm]))}
        						{if ($dskhaosat[$sv.ma_dkm].thoigian_khaosat != '')}
        						{$dskhaosat[$sv.ma_dkm].thoigian_khaosat}
        						{else}
        						Chưa khảo sát
        						{if !isset($chuaks[$sv.ten_lop])}
        						{$chuaks[$sv.ten_lop] = 0}
        						{/if}
        						{$chuaks[$sv.ten_lop] = $chuaks[$sv.ten_lop] + 1}
        						{/if}
        					{else}
        						Không có phiếu
        						{if !isset($chuacophieu[$sv.ten_lop])}
        						{$chuacophieu[$sv.ten_lop] = 0}
        						{/if}
        						{$chuacophieu[$sv.ten_lop] = $chuacophieu[$sv.ten_lop] + 1}
    						{/if}
        				</td>
					</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
		<div class="result text-center">
			{if empty($chuaks)}
			Đã hoàn thành khảo sát
			{else}
			Số SV chưa KS: 
			{foreach $chuaks as $tenlop => $sl}
			Lớp {$tenlop}: {$sl} sinh viên; 
			{/foreach}
			{/if}
		</div>
		<div class="foot">
			<div class="giaovu text-center">
                <p>&nbsp;</p>
				<b>Giáo vụ</b>
			</div>
			<div class="giangvien text-center">
				<p><i>Hà Nội, ngày ..... tháng ..... năm 20.....</i></p>
				<b>Giáo viên giảng dạy</b>
			</div>
		</div>
	</div>
</body>
</html>