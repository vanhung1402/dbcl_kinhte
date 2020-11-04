$(window).scroll(function() {
    var height = $(window).scrollTop();
    if (height > 100) {
        $('#back2Top').fadeIn();
    } else {
        $('#back2Top').fadeOut();
    }
});

$(document).ready(function() {
    $(".select2").select2();

    $("#back2Top").click(function(event) {
        event.preventDefault();
        $("html, body").animate({ scrollTop: 0 });
        return false;
    });

});

var url = document.getElementsByTagName('base')[0].href;

function showMessage(type, msg){
    (type === 'success') ? type = 'info' : '';
    const title_msg = {
        'success': 'Thành công',
        'warning': 'Cảnh báo',
        'info': 'Thông báo',
        'error': 'Lỗi',
    };

    $.toast({
        heading: title_msg[type],
        text: msg,
        position: 'top-right',
        loaderBg: '#ff6849',
        icon: type,
        hideAfter: 2000,
        stack: 6
    });
}
$('.mydatepicker').datepicker();

$('.datepicker-autoclose').datepicker({
    autoclose: true,
    todayHighlight: true,
    format: 'dd/mm/yyyy'
});

$('.datatable').DataTable({
    "bLengthChange" : false,
    "pageLength": 50,
    "language": {
        "lengthMenu": "Hiển thị _MENU_ dòng",
        "zeroRecords": "Không có dữ liệu",
        "info": "Trang _PAGE_ / _PAGES_",
        "infoEmpty": "Không có dữ liệu",
        "infoFiltered": "(lọc từ _MAX_ dòng)",
        "search":         "Tìm kiếm:",
        "paginate": {
            "first":      "<i class='ti-angle-double-left'></i>",
            "last":       "<i class='ti-angle-double-right'></i>",
            "next":       "<i class='ti-arrow-right'></i>",
            "previous":   "<i class='ti-arrow-left'></i>"
        },

    }
});