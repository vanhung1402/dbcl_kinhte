$(document).ready(function(){
    $(document).on('click','#them_kh',function(){
        them_khoahoc($('#ctdt').val(), $('#namhoc').val(), $('#ctdt :selected').text());
    })
    $('table').click(function () {
        $('table tr').attr('style', 'background-color: rgb(255, 255, 255);');
        $('.sua').prop('disabled', false);
        $('.sua').attr('class', 'btn btn-info sua btn-xs');
        $('.sua').children().attr('class', 'fa fa-edit');
        $('#nganh option[value=""]').prop('selected', true);
        $('#namhoc option[value=""]').prop('selected', true);
        $('#capnhat_kh').attr('id', 'them_kh');
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
        async: false,
        data: {
            'action': 'getdlkhoa',
            'makhoahoc': $(this).val()
        },
        success: function (data) {
            ds = JSON.parse(data);
            let ctdt = ds[0];

            $('#ctdt').val(ctdt.ma_ctdt).trigger('change');
            $('#namhoc').val(ctdt.namhoc).trigger('change');

            $('#them_kh').attr('id', 'capnhat_kh');
            $('#capnhat_kh').val(ds[0]['ma_khoahoc']); 
        }
    });

});
$(document).on('click','.del_kh',function(){
    if (confirm("Bạn có chắc muốn xóa khóa học này?")) {
        $(this).closest('tr').remove();
        $.ajax({
            type: "POST",
            url: window.location.href,
            async: false,
            data: {
                'action'    :'xoa_khoahoc',
                'ma_khoahoc': $(this).val()
            },
            success: function (response) {
                $i=1;
                $('table tr').not('tr:first').each(function(){
                    $(this).children('td:first').text($i);
                    $i++;
                })
                showMessage('success', 'Đã xóa khóa học');
            }
        });
    }
    return false;
});
$(document).on('click', '#capnhat_kh', function () {
    $.ajax({
        type: "POST",
        url: window.location.href,
        async: false,
        data: {
            'action'    :'capnhat_khoahoc',
            'ma_ctdt'  : $('#ctdt').val(),
            'namhoc'    : $('#namhoc').val(),
            'ten_ctdt' : $('#ctdt :selected').text(),
            'ma_khoahoc': $('#capnhat_kh').val()
        },
        success: function (response) {
            khoahoc_new = JSON.parse(response);
            var stt = $('table tr[check=1] td:first').text();
            html =`
                <tr style="background-color: rgb(246, 150, 150);">
                    <td class="text-center">`+stt+`</td>
                    <td>` + $('#ctdt :selected').text() + `</td>
                    <td class="text-center">`+khoahoc_new[0]['ngaytao']+`</td>
                    <td class="text-center">`+khoahoc_new[0]['namhoc']+`</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-info btn-xs sua" value="`+khoahoc_new[0]['ma_khoahoc']+`">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button name="xoa_khoahoc" class="btn btn-danger del_kh btn-xs" type="button" onClick="return confirm('Bạn có chắc muốn xóa?');" value="`+khoahoc_new[0]['ma_khoahoc']+`">
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
            $('#capnhat_kh').attr('id', 'them_kh');
            $('#nganh [value=""]').prop('selected', true);
            $('#namhoc [value=""]').prop('selected', true);
            showMessage('success', 'Cập nhật thành công!');
        }
    });
});

function them_khoahoc(ma_ctdt, namhoc, ten_ctdt){
    var values = {
        'action'    :'them_khoahoc',
        'ma_ctdt'  : ma_ctdt,
        'namhoc'    : namhoc,
        'ten_ctdt' : ten_ctdt,
    }
    $.ajax({
        type: 'POST',
        url: window.location.href,
        data: values,
        success: function(data){
            khoahoc_new = JSON.parse(data);
            html =`
                <tr style="background-color: rgb(246, 150, 150);">
                    <td class="text-center"></td>
                    <td>${ten_ctdt}</td>
                    <td class="text-center">`+khoahoc_new['ngaytao']+`</td>
                    <td class="text-center">`+khoahoc_new['namhoc']+`</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-info btn-xs sua" value="`+khoahoc_new['ma_khoahoc']+`">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button name="xoa_khoahoc" class="btn btn-danger del_kh btn-xs" type="button" onClick="return confirm('Bạn có chắc muốn xóa?');" value="`+khoahoc_new['ma_khoahoc']+`">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $(html).insertAfter('table > tbody > tr:first').hide().fadeIn('slow', function () {
                $(this).attr("style", "background-color: F4F4F4;-webkit-transition: background-color 3.5s ease;-moz-transition: background-color 3.5s ease;-o-transition: background-color 3.5s ease;transition: background-color 3.5s ease;");
                $(window).scrollTop($(this).offset().top);
            });
            i=0;
            $('table > tbody >tr').each(function(){
                $('td:first',this).text(++i);
            });
            $('#nganh [value=""]').prop('selected', true);
            $('#namhoc [value=""]').prop('selected', true);
            showMessage('success', 'Thêm thành công!');
        }
    });

}
