$(document).ready(function(){
    $('table').click(function () {
        $('table tr').attr('style', 'background-color: rgb(255, 255, 255);');
        $('.sua').prop('disabled', false);
        $('.sua').attr('class', 'btn btn-info sua btn-xs');
        $('.sua').children().attr('class', 'fa fa-edit');
        $('#nganh option[value=""]').prop('selected', true);
        $('#hedaotao option[value=""]').prop('selected', true);
        $('#nam option[value=""]').prop('selected', true);
        $('#trinhdo option[value=""]').prop('selected', true);
        $('#capnhat_ctdt').html(`<span class="btn-label"><i class="fa fa-check"></i></span>THÊM CTĐT`);
        $('#capnhat_ctdt').attr('id', 'them_ctdt');
        $('#them_ctdt').attr('name', 'them_ctdt');
    });
})

$(document).on('click', '.sua', function () {
    $('table tr').attr('style', 'background-color: rgb(255, 255, 255);');
    $('table tr').attr('check', '0');
    $(this).closest('tr').attr('style', 'background-color: rgb(218, 243, 219);');
    $(this).closest('tr').attr('check', '1');
    $('.sua').prop('disabled', false);
    $('.sua').attr('class', 'btn btn-info sua btn-xs');
    $('.sua').children().attr('class', 'fa fa-edit');
    $(this).prop('disabled', true);
    $(this).attr('class', 'btn btn-warning sua btn-xs');
    $(this).children().attr('class', 'fa fa-edit');
    $.ajax({
        type: "POST",
        url: window.location.href,
        data: {
            'action' : 'getdl',
            'ma_ctdt': $(this).val()
        },
        success: function (data) {
            ds = JSON.parse(data);

            $('#nganh').val(ds['madm_nganh']).trigger('change');
            $('#hedaotao').val(ds['madm_hedaotao']).trigger('change');
            $('#trinhdo').val(ds['madm_trinhdo']).trigger('change');
            $('#nam').val(ds['nam']).trigger('change');
            $('#nganh').val(ds['madm_nganh']).trigger('change');
            $('#nganh').val(ds['madm_nganh']).trigger('change');
            
            $('#them_ctdt').attr('id', 'capnhat_ctdt');
            $('#capnhat_ctdt').attr('name', 'capnhat_ctdt');
            $('#capnhat_ctdt').html(`<span class="btn-label"><i class="fa fa-check"></i></span>CẬP NHẬT`);
            $('#capnhat_ctdt').val(ds['ma_ctdt']); 
        }
    });

});
$(document).on('click', '#capnhat_ctdt', function () {
    hdt    = $('#hedaotao').val();
    tt     = $('#trinhdo').val();
    nganh  = $('#nganh').val();
    nam    = $('#nam').val();
    if(hdt ==''){showMessage('warning', 'Bạn chưa nhập hệ đào tạo ');return false;}
    if(tt ==''){showMessage('warning', 'Bạn chưa nhập trình độ ');return false;}
    if(nganh ==''){showMessage('warning', 'Bạn chưa nhập ngành ');return false;}
    if(nam ==''){showMessage('warning', 'Bạn chưa nhập năm');return false;}
    $.ajax({
        type: "POST",
        url: window.location.href,
        data: {
            'action'    :'capnhat_ctdt',
            'ma_ctdt': $(this).val(),
            'hedaotao': hdt,
            'trinhdo': tt,
            'nganh': nganh,
            'nam': nam,
        },
        success: function (response) {
            data = JSON.parse(response);
            console.log(data);
            var stt = $('table tr[check=1] td:first').text();
            html =`
                <tr style="background-color: rgb(246, 150, 150);">
                    <td class="text-center">`+stt+`</td>
                    <td>`+data['tendm_hedaotao']+`</td>
                    <td>`+data['tendm_trinhdo']+`</td>
                    <td>`+data['tendm_nganh']+`</td>
                    <td class="text-center">`+data['nam']+`</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-success sua btn-xs" value="`+data['ma_ctdt']+`">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btnxoa btn-xs" type="button" onClick="return confirm('Bạn có chắc muốn xóa?');">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('table tr[check=1]').hide();
            $(html).insertAfter('table tr[check=1]').hide().fadeIn('slow', function () {
                $(this).attr("style", "background-color: F4F4F4;-webkit-transition: background-color 3.5s ease;-moz-transition: background-color 3.5s ease;-o-transition: background-color 3.5s ease;transition: background-color 3.5s ease;");
                $(window).scrollTop($(this).offset().top);
            });
            $('table tr[check=1]').remove();
            $('#capnhat_ctdt').html(`<span class="btn-label"><i class="fa fa-check"></i></span>THÊM CTĐT`);
            $('#capnhat_ctdt').attr('id', 'them_ctdt');
            $('#hedaotao [value=""]').prop('selected', true);
            $('#trinhdo [value=""]').prop('selected', true);
            $('#nganh [value=""]').prop('selected', true);
            $('#nam [value=""]').prop('selected', true);
            showMessage('success', 'Cập nhật thành công!');
        }
    });
});
$(document).on('click', '#them_ctdt', function () {
    hdt    = $('#hedaotao').val();
    tt     = $('#trinhdo').val();
    nganh  = $('#nganh').val();
    nam    = $('#nam').val();
    if(hdt ==''){showMessage('warning', 'Bạn chưa nhập hệ đào tạo ');return false;}
    if(tt ==''){showMessage('warning', 'Bạn chưa nhập trình độ ');return false;}
    if(nganh ==''){showMessage('warning', 'Bạn chưa nhập ngành ');return false;}
    if(nam ==''){showMessage('warning', 'Bạn chưa nhập năm');return false;}
    $.ajax({
        type: "POST",
        url: window.location.href,
        data: {
            'action' : 'them_ctdt',
            'hedaotao': hdt,
            'trinhdo': tt,
            'nganh': nganh,
            'nam': nam,
        },
        success: function (response) {

            data = JSON.parse(response);
            html =`
                <tr style="background-color: rgb(246, 150, 150);">
                    <td class="text-center"></td>
                    <td>`+data['tendm_hedaotao']+`</td>
                    <td>`+data['tendm_trinhdo']+`</td>
                    <td>`+data['tendm_nganh']+`</td>
                    <td class="text-center">`+data['nam']+`</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-info sua btn-xs" value="`+data['ma_ctdt']+`">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger del_ctdt btn-xs" type="button" value="`+data['ma_ctdt']+`">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $(html).insertAfter('table tbody tr:first').hide().fadeIn('slow', function () {
                $(this).attr("style", "background-color: F4F4F4;-webkit-transition: background-color 3.5s ease;-moz-transition: background-color 3.5s ease;-o-transition: background-color 3.5s ease;transition: background-color 3.5s ease;");
                $(window).scrollTop($(this).offset().top);
            });
            i=0;
            $('table tr').each(function(){
                $('td:first',this).text(i);
                i++;
            });
            $('#hedaotao [value=""]').prop('selected', true);
            $('#trinhdo [value=""]').prop('selected', true);
            $('#nganh [value=""]').prop('selected', true);
            $('#nam [value=""]').prop('selected', true);
            showMessage('success', 'Đã thêm chương trình đào đạo');
        }
    });

});
$(document).on('click','.del_ctdt',function(){
    if (confirm("Bạn có chắc muốn xóa chương trình đào tạo này?")) {
        $(this).closest('tr').remove();
        $.ajax({
            type: "POST",
            url: window.location.href,
            async: false,
            data: {
                'action'    :'xoa_ctdt',
                'ma_ctdt': $(this).val()
            },
            success: function (response) {
                $i=1;
                $('table tr').not('tr:first').each(function(){
                    $(this).children('td:first').text($i);
                    $i++;
                })
                showMessage('success', 'Đã xóa chương trình đào tạo');
            }
        });
    }
    return false;
});

