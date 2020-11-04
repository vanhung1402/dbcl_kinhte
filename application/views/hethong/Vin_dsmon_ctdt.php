<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/png" href="{$url}assets/images/logo_hou.png">
    <title>In danh sách môn chương trình đào tạo</title>
    <style>
        body{
            font-size: 13pt;
        }
        p{
            margin: 0 0 5px 0;
        }
        #container{
            width: 215mm;
            margin: 0 auto;
            padding: 10px;
        }
        .head{
            width: 40%;
        }
        .head h4{
            margin-top: 0;
            text-transform: uppercase;
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
            width: 55%;
        }
        .class-detail .right{
            width: 45%;
        }
        .text-center{
            text-align: center;
        
        }
        table{
            width: 100%;
            border-collapse: collapse;
        }
        table td, table th{
            border: solid 1px #000;
        }
        table tr:not(:first-child) td{
            border-top: none;
        }
        table tr:not(:last-child) td{
            border-bottom: dotted 1px #000;
        }
    </style>
</head>

<body>
    <div id="container">
        <div class="head">
            <div class="khoa text-center">
                <p>TRƯỜNG ĐẠI HỌC MỞ HÀ NỘI</p> 
                <h4><u>KHOA {$donvi}</u></h4>
            </div>
        </div>
        <div class="class-title text-center">
            <h3>DANH SÁCH MÔN CHƯƠNG TRÌNH ĐÀO TẠO</h3>
        </div>
        <div class="class-detail">
            <div class="left">
                <p><b>Ngành: {$tt_ctdt.tendm_nganh}</b></p>
                <p><b>Hệ: {$tt_ctdt.tendm_hedaotao}</b></p>
            </div>
            <div class="right">
                <p><b>CTĐT: {$tt_ctdt.tendm_nganh} - {$tt_ctdt.nam}</b></p>
                <p><b>Bậc học: {$tt_ctdt.tendm_trinhdo}</b></p>
            </div>
        </div>
        <div>
            <table class="table" Cellpadding="5" Cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 8%" class="text-center">STT</th>
                        <th class="text-center">Tên môn học</th>
                        <th style="width: 12%" class="text-center">Số TC</th>
                        <th style="width: 20%" class="text-center">Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $mon_ctdt as $k => $m}
                    <tr>
                        <td class="text-center">{$k+1}</td>
                        <td>{$m.ten_monhoc}</td>
                        <td class="text-center">{$m.tongkhoiluong}</td>
                        <td></td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
