$(document).ready(function(){
    $('table').click(function(){
        $('table tr').css('background-color','rgb(255, 255, 255)');
        $('.sua').attr('class', 'btn btn-info sua btn-xs');
        $('.sua').removeAttr('edit');
        $('#capnhat_dvhv').attr('id','them_dvhv');
        $('#them_dvhv').html(`<span class="btn-label"><i class="fa fa-check"></i></span>THÊM ĐVHV`);
        reset_dulieu();
    });
})
function reset_dulieu(){
    $('#namhoc').val("").trigger('change');
    $('input[name=kyhoc]').each(function(){
        $(this).prop("checked", false);
    });
}
function check_input(){
    if($('#namhoc').val() ==""){
        showMessage('warning','Bạn chưa nhập năm học');exit();
    }
    if($('input[name=kyhoc]:checked').length ==0){
        showMessage('warning','Bạn chưa chọn kỳ học');exit();
    }
}
$(document).on('click','.sua',function(){
    $(this).closest('tr').css('background-color','rgb(218, 243, 219)');
    $(this).attr('class', 'btn btn-warning sua btn-xs');
    $(this).children().attr('class', 'fa fa-edit');
    $(this).attr('edit','1');
    $.ajax({
        url: window.location.href,
        type: "POST",
        data:{
            'action': 'getdl',
            'madvhv': $(this).val(),
        },
        success: function(response){
            data = JSON.parse(response);
            $('#namhoc').val(data['namhoc']).trigger('change');
            $('input[name=kyhoc]').each(function(){
                if($(this).val() == data['kyhoc']){
                    $(this).prop("checked", true);
                }
            });
            $('#them_dvhv').attr('id','capnhat_dvhv');
            $('#capnhat_dvhv').html(`<span class="btn-label"><i class="fa fa-check"></i></span>CẬP NHẬT`);
            $('#capnhat_dvhv').val(data['ma_donvihocvu']);
        }
    });
});
$(document).on('click','#capnhat_dvhv',function(){
    check_input();
    data = {
        action : 'capnhat_dvhv',
        madvhv : $(this).val(),
        namhoc : $('#namhoc').val(),
        kyhoc  : $('input[name=kyhoc]:checked').val(),
    };
    $.ajax({
        url: window.location.href,
        type: "POST",
        data: data,
        success: function(response){
            data = JSON.parse(response);
            if(data['ckh'] >0 ){
                tr = $('.sua[edit|="1"]').closest('tr');
                var stt = tr.children('td:first').text();
                html=`
                <tr style="background-color: rgb(246, 150, 150);">
                <td class="text-center">`+stt+`</td>
                <td class="text-center">`+data['dulieu']['ma_donvihocvu']+`</td>
                <td class="text-center">`+data['dulieu']['namhoc']+`</td>
                <td class="text-center">`+data['dulieu']['kyhoc']+`</td>
                <td class="text-center">
                <button type="button" class="btn btn-info sua btn-xs" value="`+data['dulieu']['ma_donvihocvu']+`"><i class="fa fa-edit"></i></button>
                <button class="btn btn-danger del_dvhv btn-xs" type="button" value="`+data['dulieu']['ma_donvihocvu']+`">
                <i class="fa fa-trash"></i>
                </button>
                </td>
                </tr>
                `;
                $(html).insertAfter(tr).fadeIn('slow', function () {
                    $(this).attr("style", "background-color: F4F4F4;-webkit-transition: background-color 3.5s ease;-moz-transition: background-color 3.5s ease;-o-transition: background-color 3.5s ease;transition: background-color 3.5s ease;");
                    $(window).scrollTop($(this).offset().top);
                });
                tr.remove();
                $('#capnhat_dvhv').attr('id','them_dvhv');
                $('#them_dvhv').html(`<span class="btn-label"><i class="fa fa-check"></i></span>THÊM ĐVHV`);
                $('#them_dvhv').val('dvhv');
                reset_dulieu();
                showMessage('success','Cập nhật thành công');
            }else if(data['row'] =='0'){
                showMessage('warning','Thất bại. Học kỳ '+data['content']+' đã tồn tại');exit(); 
            }else{
                showMessage('warning','Cập nhật thất bại!');
            }
        }
    });
});
$(document).on('click','.del_dvhv',function(){
    if(confirm("Bạn có chắc muốn xóa đơn vị học vụ này không?")){
        dvhv = $(this).closest('tr');
        $.ajax({
            url: window.location.href,
            type: "POST",
            data:{
                'action': 'xoa_dvhv',
                'ma_dvhv' : $(this).val(),
            },
            success: function(response){
                if(response>0){
                    dvhv.remove();
                    i=1;
                    $('table tr').not('tr:first').each(function(){
                        $(this).children('td:first').text(i++);
                    })
                    showMessage('success','Xóa đơn vị học vụ thành công!');
                }
                else{
                    showMessage('warning','Xóa đơn vị học vụ thất bại!');
                }
            }
        });
    }
    return false;
})
$(document).on('click','#them_dvhv',function(){
    check_input();
    $.ajax({
        url: window.location.href,
        type: "POST",
        data:{
            'action': 'them_dvhv',
            'namhoc': $('#namhoc').val(),
            'kyhoc' : $('input[name=kyhoc]:checked').val(),
        },
        success: function(response){
            data = JSON.parse(response);
            if(data['row'] == '1'){
                html=`
                    <tr style="background-color: rgb(246, 150, 150);">
                        <td class="text-center"></td>
                        <td class="text-center">`+data['content']['ma_donvihocvu']+`</td>
                        <td class="text-center">`+data['content']['namhoc']+`</td>
                        <td class="text-center">`+data['content']['kyhoc']+`</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info sua btn-xs" value="`+data['content']['ma_donvihocvu']+`"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger del_dvhv btn-xs" type="button" value="`+data['content']['ma_donvihocvu']+`">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $(html).insertBefore('table tbody tr:first').fadeIn('slow', function () {
                    $(this).attr("style", "background-color: F4F4F4;-webkit-transition: background-color 3.5s ease;-moz-transition: background-color 3.5s ease;-o-transition: background-color 3.5s ease;transition: background-color 3.5s ease;");
                    $(window).scrollTop($(this).offset().top);
                });
                i=0;
                $('table tr').each(function(){
                    $('td:first',this).text(i);
                    i++;
                });
                reset_dulieu();
                showMessage('success','Thêm đơn vị học vụ thành công');
            }
            if(data['row'] =='0'){
                showMessage('warning','Thất bại. Học kỳ '+data['content']+' đã tồn tại');
            }
        }
    });
});