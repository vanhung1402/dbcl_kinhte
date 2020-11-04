$(document).ready(function(){
    $('#canbo').change(function(){
        if( $(this).val() == ''){
            $("#dichuyen").css('display','none');
        }else{
            $("#dichuyen").css('display','inline-block');
        }

        let ma_cb = $(this).val();

        window.location.href = `${url}canbo_mon?idcb=${ma_cb}`;
    });
})

var demo1 = $('#canbomonhoc').bootstrapDualListbox({
    bootstrap2compatible: false,
    moveonselect: false,
    filterplaceholder: 'Tìm theo tên',
    selectedlistlabel: '<p><strong>Môn học đang giảng dạy</strong></p>',
    infotext: false,
    nonselectedlistlabel: '<p><strong>Danh sách môn học</strong></p>',
    filterTextClear:true,

});