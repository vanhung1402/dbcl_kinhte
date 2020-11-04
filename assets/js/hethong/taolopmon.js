$(document).ready(function(){
    $('#monhoc').select2();
    
    $('#so_tiet').keypress(function(){
        return chknum($(this).val());
    })
    $(document).on('change','#giangvien',function(){
        class_name();
    });
    $(document).on('change','#hinhthuc',function(){
        class_name();
    });
    $(document).on('change','#ctdt',function(){
        $('#giangvien').html('');
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data:{
                'action': 'lay-monctdt',
                'ma_ctdt': $(this).val()
            },
            success:function(reponse){
                $ds_mon_ctdt = JSON.parse(reponse);
                var html = `<option value="">--- Chọn môn học ---</option>`;
                $ds_mon_ctdt.forEach(function(el){
                    html+=`
                        <option value="`+el['ma_monhoc']+`|`+el['ma_mon_ctdt']+`">`+el['ten_monhoc']+`</option>
                    `;
                })
                $('#monhoc').html(html);
                $('#monhoc').select2();
                $('#giangvien').select2();
            }
        });
        class_name();
    })

    $(document).on('change','#monhoc',function(){
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data:{
                'action': 'get_canbo_mon',
                'ma_monhoc': $(this).val()
            },
            success:function(reponse){
                $ds_canbo_mon = JSON.parse(reponse);
                var html = `<option value="" selected disabled>--- Chọn ---</option>`;
                if ($ds_canbo_mon) {
                    $ds_canbo_mon.forEach(function(el){
                        html+=`
                            <option value="`+el['ma_canbo']+`">`+(el['hodem_cb']).trim()+' '+el['ten_cb']+`</option>
                        `;
                    })   
                }
                $('#giangvien').html(html);
                $('#giangvien').select2();
                $('#giangvien').trigger('change');
            }
        });
    })
    $(document).on('click','#luu',function(){
/*        if(check_ngay() =='false'){
            return false;
        }*/
        ma_ctdt     = $('#ctdt').val();
        ma_dvhv     = $('#dvhv').val();
        ma_monhoc   = $('#monhoc').val();
        ma_canbo    = $('#giangvien').val();
        ngay_bd     = $('#ngay_bd').val();
        ngay_kt     = $('#ngay_kt').val();
        so_tiet     = $('#so_tiet').val();
        hinhthuc    = $('#hinhthuc').val();
        tenlop      = $('#ten_lm').val();


        if(ma_ctdt=='' || ma_dvhv=='' || ma_monhoc=='' || ma_canbo =='' || ngay_bd=='' || ngay_kt=='' || so_tiet=='' || typeof hinhthuc==='undefined' || tenlop==''){
            showMessage('warning', 'Nhập đầy đủ thông tin trước khi lưu');
            return false;
        }
        inp = {
            'ma_ctdt'   : ma_ctdt,
            'ma_dvhv'   : ma_dvhv,
            'ma_monhoc' : ma_monhoc,
            'ma_canbo'  : ma_canbo,
            'ngay_bd'   : ngay_bd,
            'ngay_kt'   : ngay_kt,
            'so_tiet'   : so_tiet,
            'hinhthuc'  : hinhthuc,
            'tenlop'    : tenlop,
            'ten_monhoc': $('#monhoc option:selected').text(),
            'ten_canbo': $('#giangvien option:selected').text(),
        }
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data:  {
                'action': 'them_lopmon' ,
                'inp': inp,
            },
            success: function(response){
                let lopmon = JSON.parse(response);
                $('#ngay_bd').val('');
                $('#ngay_bd').trigger('change');
                $('#ngay_kt').val('');
                $('#ngay_kt').trigger('change');

                if(lopmon){
                    showMessage('success','Tạo lớp môn thành công');
                    addLopMon(lopmon);
                }else{
                    showMessage('error','Không thể tạo lớp môn, vui lòng kiểm tra lại tại Quản lý lớp môn');
                }
            }
        });
    })

    function addLopMon(lopmon){
        let lopmon_html = `<tr class="text-warning text-bold">
                    <td>${lopmon.ma_lopmon}</td>
                    <td>${lopmon.ten_lopmon}</td>
                    <td class="text-center">
                        <button class="btn btn-xs btn-info btn-copy" value="${lopmon.ma_lopmon}">
                            <i class="fa fa-clipboard"></i> &nbsp; Copy mã lớp môn
                        </button>
                    </td>
                </tr>`;

        $('#dslopmon tbody .text-warning').removeClass('text-warning text-bold');
        $('#dslopmon tbody').html(lopmon_html + $('#dslopmon tbody').html());
    }

    let dvhv_first = $('#dvhv option').eq(0).val();
    loadDanhSachLopMon(dvhv_first);

    $(document).on('change', '#dvhv', function(event) {
        let dvhv = $(this).val();
        loadDanhSachLopMon(dvhv);
    });

    function loadDanhSachLopMon(dvhv){
        $.ajax({
            url: window.location.href,
            type: 'POST',
            dataType: 'JSON',
            data: {
                action: 'load-dslopmon',
                dvhv,
            },
        })
        .done(function(res) {
            renderDanhSachLopMon(res);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    }

    function renderDanhSachLopMon(dslopmon){
        let dslopmon_html = '';

        if (dslopmon) {
            dslopmon.forEach( function(lm, index) {
                dslopmon_html += `<tr>
                    <td>${lm.ma_lopmon}</td>
                    <td>${lm.ten_lopmon}</td>
                    <td class="text-center">
                        <button class="btn btn-xs btn-info btn-copy" value="${lm.ma_lopmon}">
                            <i class="fa fa-clipboard"></i> &nbsp; Copy mã lớp môn
                        </button>
                    </td>
                </tr>`;
            });   
        }else{
            dslopmon_html = `<tr><td colspan="2" class="text-center">Chưa có lớp môn</td><tr>`
        }

        $('#dslopmon tbody').html(dslopmon_html);
    }

    $(document).on('click', '.btn-copy', function(event) {
        let ma_lopmon = $(this).val();
        doCopy(ma_lopmon);
    });

})

function doCopy(value){
    var copyText = document.getElementById("copy-text");
    copyText.value = value;
    copyText.select();
    copyText.setSelectionRange(0, 99999)
    document.execCommand("copy");
}

function class_name(){
    monhoc = $('#monhoc option:selected');
    giangvien = $('#giangvien option:selected');
    hinhthuc = $('#hinhthuc option:selected');
    tenmon = '';
    if($('#monhoc').val() != "" && $('#giangvien').val() && $('#hinhthuc').val() != ""){
        tenmon =monhoc.text()+' - '+giangvien.text() + ' - ' + hinhthuc.text();
        $('#ten_lm').val(tenmon);
    }else{
        $('#ten_lm').val(tenmon);
    }
}
function check_ngay(){
    ngay_bd = $('#ngay_bd').val();
    ngay_kt = $('#ngay_kt').val();
    var arrayngay1 = ngay_bd.split('/');
    var arrayngay2 = ngay_kt.split('/');
    var giatri1 = arrayngay1[2] + "-" + arrayngay1[1] + "-" + arrayngay1[0];
    var giatri2 = arrayngay2[2] + "-" + arrayngay2[1] + "-" + arrayngay2[0];
    if(Date.parse(giatri1) >= Date.parse(giatri2)){
        showMessage('warning', 'Ngày bắt đầu phải nhỏ hơn ngày kết thúc');
    }
    /* if(ngayhople(ngay_bd) == 'false'){
        showMessage('success', 'Ngày bắt đầu không hợp lệ!');
    }
    if(ngayhople(ngay_kt) == 'false'){
        showMessage('success', 'Ngày kết thúc không hợp lệ!');
    }
    if(ngayhople(ngay_ks) == 'false'){
        alert(1);
        showMessage('success', 'Ngày khảo sát không hợp lệ!');
    } */
}
function ngayhople(ngay) {
    pat1 = /[0-9]{2}\/[0-9]{2}\/[0-9]{4}/;
    return pat1.test(ngay);
}
function chknum(num) {
    var keyword = null;
    if (window.event) {
        keyword = window.event.keyCode;
    } else {
        keyword = e.which;
    }
    if (keyword < 48 || keyword > 57) {
        if (keyword != 8 && keyword != 0) {
            return false;
        }
    }
    if (num.length >= 2) {
        return false;
    }
}