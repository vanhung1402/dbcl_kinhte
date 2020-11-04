$(document).ready(function() {
	$('#container').removeClass('container');
	$('#container').addClass('container-fluid');
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    var check = true;
    function check_emty(input, message){
        $(input).parent().find('label').removeClass('text-danger');
        $(input).parent().removeClass('has-error has-feedback');
        if($(input).val() == '' || $(input).val() == undefined)
        {
            $(input).parent().find('label').addClass('text-danger');
            $(input).parent().addClass('has-error has-feedback');
            check = false;
            Toast.fire({
                icon: 'error',
                title: message
            })
        }
    }
    function _filter(control){
        const dvhv = $('#dvhv').val();
        let url = window.location.pathname;
        if(dvhv != "")
        url = url + "?dvhv=" + dvhv;
        window.history.pushState("object or string", "Title", url);
        const data = {
            action: 'filter',
        }
        $.ajax({
            url: location.href,
            type: 'POST',
            data: data,
        }).done(function (res) {
            var html = '';
            if (res.length != '') {
                res = JSON.parse(res);
                if(res.length != 0){
                    Object.entries(res).forEach(entry => {
                        const [key, value] = entry;
                        html += `
                            <tr>
                                <td class="text-center">` + (parseInt(key)+1) + `</td>
                                <td>
                                    <a class="pointer" href="/dbcl/chude?khaosat=`+ value.ma_ks +`">`+ value.tieude +`</a>
                                </td>
                                <td class="text-center">`+ value.bd +`</td>
                                <td class="text-center">`+ value.kt +`</td>
                                <td class="text-center">
                                    <a class="pointer" val="`+ value.ma_dvhv +`">`+ value.ma_dvhv +`</a>
                                </td>
                                <td class="text-right">
                                    <button class="btn btn-sm btn-danger xoa_dotks" value="`+ value.ma +`">Xóa</button>
                                    <a class="btn btn-sm btn-info" href="/dbcl/cauhoi?khaosat=`+ value.ma_ks +`">Chi tiết</a>
                                </td>
                            </tr>
                        `;
                    });
                }else{
                    html += `
                        <tr>
                            <td colspan="6">
                                <p class="text-danger p-l-20 p-t-10">Chưa có đợt khảo sát nào tại đơn vị học vụ này!</p>
                            </td>
                        </tr>
                    `;
                }
            }
            $('.list_dotks').html(html);
        }).fail(function () {
        }).always(function () {
        });
    }
    $(document).on('change', '#dvhv', function(){
        _filter('dvhv');
    });
    $(document).on('click', '.tab', function(){
        tab_name = $(this).attr('val');
        $('.tab').removeClass('active');
        $('.tab-content').removeClass('active');
        $('.'+tab_name).addClass('active');
    });
    $(document).on('click', '.xoa_dotks', function(){
        var btn = $(this);
        Swal.fire({
            title: 'Xác nhận',
            text: "Bạn có chắc chắn muốn xóa đợt khảo sát này?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xác nhận!',
            cancelButtonText: 'Hủy! '
            }).then((result) => {
            if (result.value) {
                const data = {
                    action: 'xoa_dotks',
                    id: $(btn).val()
                }
                $.ajax({
                    url: location.pathname,
                    type: 'POST',
                    data: data,
                }).done(function (res) {
                    if (res == 'xoa_thanhcong') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Xóa đợt khảo sát thành công!'
                        });
                        _filter('dvhv');
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Đợt khảo sát đã được tạo phiếu nên không thể xóa!'
                        })
                    }
                }).fail(function () {
                }).always(function () {
                });
            }
        })
    });
    $(document).on('click', '#them_dotks', function(){
        check = true;
        const data = {
            action:      'them_dotks',
            loai:        $('#loai').val(),
            add_dvhv:    $('#add_dvhv').val(),
            thoigian_ks: $('#thoigian_ks').val(),
        }
        check_emty($('#loai'), 'Cán bộ cần chọn loại khảo sát!');
        check_emty($('#add_dvhv'), 'Cán bộ cần chọn đơn vị học vụ!');
        check_emty($('#thoigian_ks'), 'Cán bộ cần chọn thời gian khảo sát!');
        if(check == false)
        {
            return;
        }
        $.ajax({
            url: location.pathname,
            type: 'POST',
            data: data,
        }).done(function (res) {
            if (res == 'error date')
            {
                Toast.fire({
                    icon: 'error',
                    title: `Định dạng ngày tháng chưa chính xác!`,
                    text: 'VD: 20/02/2020 - 20/03/2020!'
                    });
                return;
            }
            if (res != false) {
                Toast.fire({
                    icon: 'success',
                    title: 'Thêm đợt khảo sát thành công!'
                });
                html = `
                    <tr>
                        <td class="text-center"></td>
                        <td>`+ data['tieude'] +`</td>
                        <td>
                            <a class="pointer" val="`+ data['loai'] +`">`+ data['ten_loai'] +`</a>
                        </td>
                        <td>`+ data['ghichu'] +`</td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-danger xoa_loaiks" value="`+ res +`">Xóa</button>
                            <a class="btn btn-sm btn-info" href="`+ location.pathname +`cauhoi?khaosat=`+ res +`">Chi tiết</a>
                        </td>
                    </tr>
                `;
                $('.list_ks').append(html);
                $('.tab-content').removeClass('active');
                $('.tab-content:first-child').addClass('active');
                $('.tab').removeClass('active');
                $('.tab').first().addClass('active');
                _filter('dvhv');
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Thêm đợt khảo sát thất bại!'
                })
            }
        }).fail(function () {
        }).always(function () {
        });
    });
    $('.datepicker').daterangepicker({
        "singleDatePicker": false,
        "timePicker": false,
        "drops": "down",
        "locale": {
            "autoApply": true,
            "format": "DD/MM/YYYY",
            "applyLabel": "Áp dụng",
            "cancelLabel": "Hủy",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "CN",
                "T2",
                "T3",
                "T4",
                "T5",
                "T6",
                "T7"
            ],
            "monthNames": [
                "Tháng 1",
                "Tháng 2",
                "Tháng 3",
                "Tháng 4",
                "Tháng 5",
                "Tháng 6",
                "Tháng 7",
                "Tháng 8",
                "Tháng 9",
                "Tháng 10",
                "Tháng 11",
                "Tháng 12",
            ],
            "firstDay": 1
        }
    });
    $('.datepicker').val('');
});