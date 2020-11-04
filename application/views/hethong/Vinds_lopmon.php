<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" type="image/png" href="{$url}assets/images/logo_hou.png">
    <title>Danh sách sinh viên lớp học phần</title>
    <style type="text/css">
        *{
            margin:0 auto;
            padding:0;

        }
        body{
            font-family:"Times New Roman", Times, serif;
            font-size: 15px;
        }
        div{
            margin:7px 0px;
        }
        #container{
            width:215mm;
            margin:0px auto;
            padding:10px;
        }
        .cangiua{
            text-align: center !important;
        }
        .canphai{
            text-align: right !important;
        }
        .cantrai{
            text-align: left !important;
        }
        .left-header{
            float:left;
            width:50%;
            text-align:center;
        }
        .right-header{
            float:right;
            width: 50%;
            text-align:center;
        }
        .text-left{
            text-align:center;
            width:40mm;
            border-right-style:none;
        }
        .c-left{
            float:left;
            width:51%;
            margin-left: 35px;
            text-align:center;
        }
        .c-right{
            float:right;
            width:45%;
            text-align:center;
        }
        .left-footer{
            float:left;
            widows: 190px;mm;
            text-align:center;
        }
        .right-footer{
            float:right;
            width:110mm;
            text-align:center;
        }
        .bold{
            font-weight:bold;
        }
        .indent{
            text-indent:28px;
            margin-top: 4px;
        }
        .width-120{
            width:130px;
        }
        p{
            text-align:justify;
        }
        td{
            padding:3px;
            border-bottom:1px solid #000000;
            border-top:none;

        }
        th{
            padding-left:3px;
            border-bottom:1px solid #000000;
        }
        .bleft-none{
            text-align:left;
            border-left-style:none;
        }
        .th-diem {
            width: 22mm;
        }
        .page-wrapper {
            position: relative;
        }
        .pagenumber {
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size:12px;
        }
        td {
            height: 23px;
            line-height: 23px;
        }

        .td_hoten{
            width: 190px;
        }
        table{
            font-size: 17px !important;
        }
		.break{
			 page-break-inside: avoid;
		}
        .t-left {
            width: 55%;
        }
        .t-right{
            width: 45%;
        }
        .t-left p{
            font-weight: bold;
            padding: 3px;
        }
        .t-right p{
            font-weight: bold;
            padding: 3px;
        }
        table tr th{
            padding: 7px;
        }
        #footer{
            display: flex;
            margin-top: 10px;
            min-height: 175px;
        }
        #footer div{
            width: 17%;
            font-weight: bold;
            margin-left: 9%;
        }
        .hodem{
            display: inline-block;
            width: 70%;
        }
        table tr:not(:last-child) td{
            border-bottom: dotted 1px #000;
        }
        /* @media print {
            .right-header {
                padding-right: 10%;
            }
        } */
    </style>
</head>

<body>
<div id="container">
    <div class="header">
        <div class="left-header">
            <span style="font-size: 14pt">TRƯỜNG ĐẠI HỌC MỞ HÀ NỘI<br /><b> <p style="text-transform: uppercase;" class="cangiua"> KHOA {$donvi}</p></b></span><hr  style="width: 170px;" />
        </div>
    </div>
    <div style="clear:both"></div>
    <div style="text-align:center;margin-top:40px;">
        <span style="font-size: 18pt; font-weight:bold">DANH SÁCH SINH VIÊN LỚP MÔN</span><br />
    </div>

    <div style="margin: 0;" >
        <div style="display: flex;margin: 0;">
            <div class="t-left">
                <p>Bậc học: {$tt_lopmon.tendm_trinhdo}</p>
                <p>Ký hiệu môn học: {$tt_lopmon.ma_lopmon}</p>
                <p>Giảng viên: {$tt_lopmon.hodem_cb} {$tt_lopmon.ten_cb}</p>
            </div>
            <div class="t-right">
                <p>Hệ: {$tt_lopmon.tendm_hedaotao}</p>
                <p>Ngành: {$tt_lopmon.tendm_nganh}</p>
                <p>Hình thức: {$tt_lopmon.ma_hinhthuc}</p>
            </div>
        </div>
    </div>
    <div class="page-wrapper">
        <table border="1px" style="font-size: 10pt;margin-top: 20px;" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th style="width:5%">STT</th>
                    <th style="width:15%">Mã sinh viên</th>
                    <th>Họ và tên</th>
                    <th style="width:12%">Giới tính</th>
                    <th style="width:15%">Ngày sinh</th>
                    <th style="width:20%">Lớp HC</th>
                </tr>
            </thead>
            <tbody>
            {foreach $ds_sv as $k => $sv}
                <tr>
                    <td class="cangiua">{$k+1}</td>
                    <td class="cangiua">{$sv.ma_sv}</td>
                    <td><span class="hodem">{$sv.hodem_sv} </span>{$sv.ten_sv}</td>
                    <td class="cangiua">{$sv.gioitinh_sv}</td>
                    <td class="cangiua">{$sv.ngaysinh_sv}</td>
                    <td class="cangiua">{$sv.ten_lop}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div id="footer">
        <div><p>&nbsp;</p><p>Giáo vụ khoa</p></div>
        <div><p>&nbsp;</p><p>Giảng viên</p></div>
        <div style="width:30%">
            <p style="font-weight: normal;text-align:center;margin-bottom: 5px;font-style: italic;">Hà Nội, ngày.......tháng.......năm.......</p>
            <p class="cangiua">Ban lãnh đạo khoa</p>
        </div>
    </div>
</body>
</html>
