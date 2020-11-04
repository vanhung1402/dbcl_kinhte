$(document).on('click','#suatl',function(){
    var get_tl = $('#tenlop').text();
    html=`
        <div class="txtb">
            <input autocomplete="off" spellcheck="false" name="tenlop">
            <span></span>
        </div>
    `;
    $('#tenlop').html(html);
    $('.txtb input').focus().val(get_tl);
    $(this).html('<i class="fa fa-save"></i> &nbsp; Sửa tên lớp');
    $(this).attr('class','btn btn-info btn-sm');
    $(this).attr('id','upd_tl');
})
$(document).on('focus','.txtb input',function(){
    $(this).addClass("focus");
})
$(document).on('click','#upd_tl',function(){
    if($('.txtb input').val() ===''){
        $('.txtb input').focus();
        showMessage('warning','Hãy nhập tên lớp môn ');
        return false;
    }
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data:{
            'action': 'capnhap-tenlopmon',
            'ma_lopmon': $(this).val(),
            'tenlop'   : $('.txtb input').val(),
        },
        success: function(response){
            data = JSON.parse(response);
            if(data.success > 0){
                $('#tenlop').html(data.tenlop);
                $('#upd_tl').html('<i class="fa fa-edit"></i> &nbsp; Sửa tên lớp');
                $('#upd_tl').attr('class','btn btn-warning btn-sm');
                $('#upd_tl').attr('id','suatl');
                showMessage('success','Cập nhật tên lớp môn thành công');
            }
            else{
                $('#tenlop').html(data.tenlop);
                $('#upd_tl').html('<i class="fa fa-edit"></i> &nbsp; Sửa tên lớp');
                $('#upd_tl').attr('class','btn btn-warning btn-sm');
                $('#upd_tl').attr('id','suatl');
            }
        },
        error:function(){
            showMessage('warning','Cập nhật tên lớp môn thất bại');
        }
    });
});
$(document).on('click','#duyetlop',function(){
    trangthai_capnhat = 'daduyet';
    ma_lopmon = $(this).val();
    capnhat_lopmon(ma_lopmon,trangthai_capnhat)
})
$(document).on('click','#huylop',function(){
    trangthai_capnhat = 'huy';
    ma_lopmon = $(this).val();
    capnhat_lopmon(ma_lopmon,trangthai_capnhat)
})
$(document).on('click','#ketthuc',function(){
    $trangthai_capnhat = 'ketthuc';
    $ma_lopmon = $(this).val();
    capnhat_lopmon($ma_lopmon,$trangthai_capnhat)
})
function capnhat_lopmon(ma_lopmon,trangthai_capnhat){
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {
            'action': 'capnhap-lopmon',
            'trangthai' : trangthai_capnhat,
            'ma_lopmon' : ma_lopmon
        },
        success: function(response){
            data = JSON.parse(response);
            if(data.success == 1){
                html=``;
                if(data.trangthai_new.madm_trangthai_lopmon =='daduyet'){
                    html+=`<button id="ketthuc" type="button" class="btn btn-danger btn-sm" value="`+ma_lopmon+`"><i class="fa fa-check-square-o"></i> &nbsp; Kết thúc lớp </button>`;
                }
                $('#trangthai').text(data.trangthai_new.tendm_trangthai_lopmon);
                $('.action').html(html);
                showMessage('success',data.trangthai_new.tendm_trangthai_lopmon+' lớp môn');
            }
            else{
                showMessage('warning','Cập nhật lớp môn thất bại');
            }
        }
    })
}

$(document).ready(function() {
    $('#tg-hinhthuc').change(function(event) {
        hinhthuc = ($(this).prop('checked')) ? 'online' : 'offline';
        changeHinhThuc(hinhthuc);
    });

    function changeHinhThuc(hinhthuc){
        let url = new URL(window.location.href);
        let ma_lopmon = url.searchParams.get('mlp');
        let tenlop = $('#tenlop').text();

        tenlop = tenlop.split('-');
        if ((tenlop[tenlop.length - 1]).trim() == 'online' || (tenlop[tenlop.length - 1]).trim() == 'offline') {
            tenlop.pop();
        }
        tenlop.push(' ' + hinhthuc);
        tenlop = tenlop.join('-');

        $.ajax({
            url: window.location.href,
            type: 'POST',
            dataType: 'JSON',
            data: {
                action: 'change-hinhthuc',
                hinhthuc,
                ma_lopmon,
                tenlop,
            },
        })
        .done(function(res) {
            console.log("success");
            $('#hinhthuc').text(hinhthuc);
            $('#tenlop').text(tenlop);
        })
        .fail(function(err) {
            console.log(err);
            console.log("error");
        })
        
    }
});
$(document).on('click','#sua_cbm',function(){
    $.ajax({
        url: window.location.href,
        type: "POST",
        data:{
            'action'    : 'getdl_lopmon',
            'ma_lopmon' : $(this).val(),
        },
        success: function(response){
            data = JSON.parse(response);
            var html_monhoc     = `<option value="">--- Chọn môn học ---</option>`;
            var html_giangvien  = `<option value="">--- Chọn giảng viên ---</option>`;
            data.ds_mon_ctdt.forEach(function(el){
                if(el.ma_monhoc != data.ma_monhoc){
                    html_monhoc+=`<option value="`+el.ma_monhoc+`|`+el.ma_mon_ctdt+`">`+el.ten_monhoc+` (${el.tongkhoiluong} ${el.donvitinh})</option>`;
                }else{
                    html_monhoc+=`<option value="`+el.ma_monhoc+`|`+el.ma_mon_ctdt+`" selected>`+el.ten_monhoc+` (${el.tongkhoiluong} ${el.donvitinh})</option>`;
                }
            })
            data.ds_canbo_mon.forEach(function(el){
                if(el.ma_canbo != data.ma_cb){
                    html_giangvien+=`<option value="`+el.ma_canbo+`">${el.ma_canbo} - `+(el.hodem_cb).trim()+' '+el.ten_cb+`</option>`;
                }else{
                    html_giangvien+=`<option value="`+el.ma_canbo+`" selected>${el.ma_canbo} - `+(el.hodem_cb).trim()+' '+el.ten_cb+`</option>`;
                }
            })
            $('#monhoc').html(html_monhoc);
            $('#giangvien').html(html_giangvien);
            $('#monhoc').select2();
            $('#giangvien').select2();
            $('#capnhat_mon_cb').val(data.ma_lopmon);
        }
    });
});
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
                        <option value="`+el.ma_canbo+`">${el.ma_canbo} - `+(el.hodem_cb).trim()+' '+el.ten_cb+`</option>
                    `;
                })   
            }
            $('#giangvien').html(html);
            $('#giangvien').select2();
        }
    });
})
$(document).on('click','#capnhat_mon_cb',function(){
    if($('#monhoc').val() =='' || $('#giangvien').val() =='' ){
        showMessage('warning','Bạn hãy chọn đầy đủ trước khi cập nhật');
        return;
    }
    ten_mh = $('#monhoc option:selected').text();
    ten_cb = $('#giangvien option:selected').text();
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data:{
            'action'    : 'capnhat_mon_cb',
            'ma_lopmon' : $(this).val(),
            'monhoc'    : $('#monhoc').val(),
            'ma_canbo'  : $('#giangvien').val()
        },
        success:function(reponse){
            data = JSON.parse(reponse);
            $('#tenmh').text(ten_mh);
            $('#tengv').text(ten_cb);
            showMessage('success','Cập nhật thành công!');
        }
    });
})