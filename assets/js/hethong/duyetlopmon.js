$(document).ready(function(){
    $('#container').attr('class', 'container-fliud');

    $('.loc select').change(function(event) {
        get_lopmon();
    });

    $('#search').keyup(delay(function (e) {
        let keySearch = $(this).val().trim();
        searchLopMon(keySearch);
    }, 500));

    function searchLopMon(key){
        $('.lopmon').removeClass('hidden');

        if (key !== '') {
            $.each($('.lopmon'), function(index, lm) {
                if ($(lm).attr('key-search').indexOf(key) === -1) {
                    $(lm).addClass('hidden');
                }
            });
        }
    }
})

function delay(callback, ms) {
    var timer = 0;
    return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}

function get_lopmon(){
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data:{
            'action'    : 'get_lopmon',
            'ma_dvhv'   : $('#dvhv').val(),
            'trangthai' : $('#trangthai').val(),
            'hinhthuc'  : $('#hinhthuc').val(),
        },
        success: function(response){
            data = JSON.parse(response);
            ds_lopmon       = data['ds_lopmon'];
            so_sv           = data['so_sv'];
            ds_giangvien    = data['gv_lopmon'];

            html =``;
            lable='';

            if (ds_lopmon) {
                
                ds_lopmon.forEach(function(el,index){
                    action = ``;
                    let gv = (ds_giangvien[el.ma_lopmon] !== undefined) ? ds_giangvien[el.ma_lopmon] : '';
                    let hoten_gv = (gv[0] !== undefined) ? `${(gv[0].hodem_cb).trim()} ${(gv[0].ten_cb).trim()}` : '';

                    switch(el['madm_trangthai_lopmon']){
                        case 'dukien':  
                            lable   = 'warning';
                            action = `
                                <button type="button" class="btn btn-success btn-xs duyetlop" value="`+el['ma_lopmon']+`" data-toggle="tooltip" data-placement="left" data-original-title="Duyệt lớp môn"><i class="fa fa-check"></i></button>
                                <button type="button" class="btn btn-danger btn-xs huylop" value="`+el['ma_lopmon']+`" data-toggle="tooltip" data-placement="left" data-original-title="Hủy lớp môn"><i class="fa fa-times"></i></button>
                            `;
                            break;
                        case 'daduyet': lable   = 'success ';
                            action = `<button type="button" class="btn btn-danger btn-xs ketthuc" value="`+el['ma_lopmon']+`" data-toggle="tooltip" data-placement="left" data-original-title="Kết thúc lớp môn"><i class="fa fa-check-square-o"></i></button>`;break;
                        case 'huy':     lable   = 'danger';break;
                        case 'ketthuc': lable   = 'info';break;
                        case 'huykhaosat': lable   = 'primary';break;
                        default: '';
                    }
                    if (typeof so_sv[el['ma_lopmon']] !== 'undefined'){
                        so = so_sv[el['ma_lopmon']];
                    }
                    else{
                        so = 0;
                    }

                    if (quyen == 'phongkhaothi') {
                        action = (el['madm_trangthai_lopmon'] == 'huykhaosat') ? '' : `<button class="btn btn-danger btn-xs huykhaosat" value="${el['ma_lopmon']}" data-toggle="tooltip" data-placement="left" data-original-title="Hủy khảo sát lớp môn"><i class="fa fa-ban"></i></button>`;
                    }


                    html +=`
                    <tr class="lopmon" key-search="${el.ma_lopmon}|${el.ten_lopmon}">
                        <td class="text-center">`+(index+1)+`</td>
                        <td>${el.ten_lopmon}</td>
                        <td class="text-center">`+el['ngaybd']+`</td>
                        <td class="text-center">`+el['ngaykt']+`</td>
                        <td class="text-center">`+so+`</td>
                        <td class="text-center">`+el['ma_hinhthuc']+`</td>
                        <td class="text-center">
                            <span class="tt label label-`+lable+`"><strong>`+el['tendm_trangthai_lopmon']+`</strong></span>
                        </td>
                        <td class="text-center">
                            <a href="lop_hocphan?inlp=`+el['ma_lopmon']+`" type="button" target="_blank" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="left" data-original-title="In danh sách sinh viên lớp môn"><i class="fa fa-print"></i></a>
                            <span class="action">`+action+`</span>
                            <a href="chitietlopmon?mlp=`+el['ma_lopmon']+`" type="button" target="_blank" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="left" data-original-title="Chi tiết lớp môn"><i class="fa fa-eye"></i></button></a>
                        </td>
                        
                    </tr>
                    `;
                })
            }
            $('table tbody').html(html);
            $('[data-toggle="tooltip"]').tooltip();
            if(html==''){
                $('table tbody').html(`<tr><td colspan='8' class='text-center'>Không có dữ liệu ...</td></tr>`);
            }
        }
    })
}
$(document).on('click','.duyetlop',function(){
    tr = $(this).closest('tr');
    trangthai_capnhat = 'daduyet';
    ma_lopmon = $(this).val();
    capnhat_lopmon(ma_lopmon,trangthai_capnhat,tr);
})
$(document).on('click','.huylop',function(){
    tr = $(this).closest('tr');
    trangthai_capnhat = 'huy';
    ma_lopmon = $(this).val();
    capnhat_lopmon(ma_lopmon,trangthai_capnhat,tr);
})
$(document).on('click','.ketthuc',function(){
    tr = $(this).closest('tr');
    $trangthai_capnhat = 'ketthuc';
    $ma_lopmon = $(this).val();
    capnhat_lopmon($ma_lopmon,$trangthai_capnhat,tr);
})
$(document).on('click','.huykhaosat',function(){
    if (confirm('Bạn có muốn hủy khát lớp môn này?')) {
        tr = $(this).closest('tr');
        $trangthai_capnhat = 'huykhaosat';
        $ma_lopmon = $(this).val();
        capnhat_lopmon($ma_lopmon,$trangthai_capnhat,tr);
    }
})
function capnhat_lopmon(ma_lopmon,trangthai_capnhat,tr){
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {
            'action'    : 'capnhat_lopmon',
            'trangthai' : trangthai_capnhat,
            'ma_lopmon' : ma_lopmon
        },
        success: function(response){
            data = JSON.parse(response);
            if(data['success'] == 1){
                switch(data['madm_trangthai_lopmon']){
                    case 'dukien':  lable   = 'warning';break;
                    case 'daduyet': lable   = 'success ';break;
                    case 'huy':     lable   = 'danger';break;
                    case 'ketthuc': lable   = 'info';break;
                    case 'huykhaosat': lable   = 'primary';break;
                    default: '';
                }
                html=``;
                if(data['trangthai_new']['madm_trangthai_lopmon'] =='daduyet'){
                    html+=`<button type="button" class="btn btn-danger btn-xs ketthuc" value="`+ma_lopmon+`"><i class="fa fa-check-square-o"></i></button>`;
                }
                tr.children('td').children('.tt').html('<strong>' + data['trangthai_new']['tendm_trangthai_lopmon'] + '</strong>');
                tr.children('td').children('.tt').attr('class','tt label label-' + lable);
                tr.children('td').children('.action').html(html);
                showMessage('success',data['trangthai_new']['tendm_trangthai_lopmon']+' lớp môn');
            }
            else{
                showMessage('warning','Cập nhật lớp môn thất bại');
            }
        }
    })
}
