$(document).ready(function () {
    $('#mykey').keyup(function () {
        var key = $(this).val().toLowerCase();
        key = tonormalword(key);
        if (key == '') {
            $('#tbl-mon tr').show();
            var count =$('#tbl-mon >tbody > *').filter(function() {
                return $(this).css('display') !== 'none';
            }).length;

        } else {
            $('#tbl-mon tr').not('tr:first').each(function () {
                var string = $(this).children('td:first').next().text().toLowerCase();
                string = tonormalword(string);
                if (string.indexOf(key) == 0) {
                    $(this).show();
                } else {
                    $(this).hide();
                }

            });
            var count =$('#tbl-mon >tbody > *').filter(function() {
                return $(this).css('display') !== 'none';
            }).length;
        }
    });
    function tonormalword(str) {
        return str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a").replace(/\ /g, '-').replace(/đ/g, "d").replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y").replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u").replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ.+/g, "o").replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ.+/g, "e").replace(/ì|í|ị|ỉ|ĩ/g, "i");
    }
    $(document).on('click', '.del', function () {
        var tr = $(this).closest('tr');
        var mon = tr.children('td:first').next().text();
        var x = confirm('Bạn có chắc chắn muốn xóa môn ' + mon);
        if (x == true) {
            $.ajax({
                type: "POST",
                url: window.location.href,
                data: {
                    'action' : 'delete_monhoc',
                    'id'     : $(this).data('id')
                },
                success: function (response) {
                    console.log(response);
                    if (response > 0) {
                        tr.remove();
                        var i = 0;
                        $('table > tbody >tr').each(function () {
                            $('td:first', this).text(i);
                            i++;
                        });
                        i = i - 1;
                        showMessage('success','Đã xóa môn '+mon);

                    } else {
                        showMessage('error', 'Có lỗi xảy ra');
                    }

                }
            });
        }
    });
    $('table').click(function () {
        $('#idmh').val("");
        $('#tmh').val("");
        $('#tvt').val("");
        $('#kllt').val("");
        $('#klth').val("");
        $('#update').val('Lưu');
        $('#update').attr('id', 'save');
        $('tr').css('background-color', 'rgb(255, 255, 255)');
    });
    $(document).on('click', '#update', function () {
        $('#update').prop('disabled', true);
        if (chkform()) {
            $.ajax({
                type: "POST",
                url: window.location.href,
                data: {
                    'action': 'capnhat_monhoc',
                    'idmh'  : $('#idmh').val(),
                    'tmh'   : $('#tmh').val(),
                    'tvt'   : $('#tvt').val(),
                    'kllt'  : $('#kllt').val(),
                    'klth'  : $('#klth').val()
                },
                success: function (response) {
                    var array = JSON.parse(response);
                    var newrow = '<tr class="" style="background-color: rgb(246, 150, 150);">';
                    newrow += '<td class="text-center">1</th>';
                    newrow += '<td>' + array['ten_monhoc'] + '</td>';
                    newrow += '<td>' + array['ten_viettat_monhoc'] + '</td>';
                    newrow += '<td class="text-center">' + array['kllt'] + '</td>';
                    newrow += '<td class="text-center">' + array['klth'] + '</td>';
                    newrow += '<td class="text-center">' + array['tongkhoiluong'] + '</td>';
                    newrow += '<td class="text-center"> <button class="btn btn-info btn-xs upd" data-id="' + array['ma_monhoc'] + '" style="margin-right: 4px"><i class="fa fa-edit"></i></button><button class="btn btn-danger btn-xs del" data-id="' + array['ma_monhoc'] + '"><i class="fa fa-trash"></i></button></td>';
                    newrow += '</tr>';
                    $('button[data-id="'+ array["ma_monhoc"] +'"]').closest('tr').hide();
                    $(newrow).insertAfter($('button[data-id="'+ array["ma_monhoc"] +'"]').closest('tr')).hide().fadeIn('slow',function(){
                        $(this).attr("style", "background-color: F4F4F4;-webkit-transition: background-color 3.5s ease;-moz-transition: background-color 3.5s ease;-o-transition: background-color 3.5s ease;transition: background-color 3.5s ease;");
                    })
                    $('#idmh').val("");
                    $('#tmh').val("");
                    $('#tvt').val("");
                    $('#kllt').val("");
                    $('#klth').val("");
                    $('#update').prop('disabled', false);
                    $('#update').val('Lưu');
                    $('#update').attr('id', 'save');
                    $('tr').css('background-color', 'rgb(255, 255, 255)');
                    showMessage('success','Cập nhật môn học thành công');
                }
            });
        }
    });
    $(document).on('click', '.upd', function () {
        var tr = $(this).closest('tr');
        $('#idmh').val($(this).data('id'));
        $('#tmh').val(tr.children('td:first').next().text());
        $('#tvt').val(tr.children('td:first').next().next().text());
        $('#kllt').val(tr.children('td:first').next().next().next().text());
        $('#klth').val(tr.children('td:first').next().next().next().next().text());
        $('#save').val('Cập nhật');
        $('#save').attr('id', 'update');
        $('tr').css('background-color', 'rgb(255, 255, 255)');

        tr.attr('style', 'display: table-row; background-color: rgb(218, 243, 219);');
    });
    function chkform() {
        if ($('#tmh').val() == '' || $('#kllt').val() == '' || $('#klth').val() == '' || $('#tvt').val() == '') {
            var err = "";
            if ($('#tmh').val() == '') {
                err += "- Tên môn học <br/>";
            }
            if ($('#tvt').val() == '') {
                err += "- Tên viết tắt <br/>";
            }
            if ($('#kllt').val() == '') {
                err += "- Khối lượng lý thuyết <br/>";
            }
            if ($('#klth').val() == '') {
                err += "- Khối lượng thực hành";
            }
            showMessage('warning', 'Xin hãy nhập:<br/> <b>' + err + '</b>');
            return false;
        }
        if (isNaN($('#kllt').val()) || isNaN($('#klth').val())) {
            var err = "";
            if (isNaN($('#kllt').val())) {
                err += "- Khối lượng lý thuyết phải là số  <br/>";
            }
            if (isNaN($('#klth').val())) {
                err += "- Khối lượng thực hành phải là số  <br/>";
            }
            showMessage('warning', '<b>' + err + '</b>');
            return false;
        }
        if ($('#kllt').val() > 10 || $('#klth').val() > 10) {
            var err = "";
            if ($('#kllt').val() > 10) {
                err += "- Khối lượng lý thuyết phải < 10 <br/>";
            }
            if ($('#klth').val() > 10) {
                err += "- Khối lượng thực hành phải < 10 <br/>";
            }
            showMessage('warning', '<b>' + err + '</b>');
            return false;
        }
        return true;
    }

    $(document).on('click', '#save', function () {
        if (chkform()) {
            $(this).prop('disabled', true);
            /* startLoading('#mytable'); */
            $.ajax({
                type: "POST",
                url: window.location.href,
                data: {
                    'action': 'them_monhoc',
                    'tmh'   : $('#tmh').val(),
                    'tvt'   : $('#tvt').val(),
                    'kllt'  : $('#kllt').val(),
                    'klth'  : $('#klth').val()
                },
                success: function (response) {
                    var array = JSON.parse(response);
                    window.location.href = `${url}monhoc`;
                    /*var newrow = '<tr class="" style="background-color: rgb(246, 150, 150);">';

                    newrow += '<td class="text-center">1</th>';
                    newrow += '<td>' + array['ten_monhoc'] + '</td>';
                    newrow += '<td>' + array['ten_viettat_monhoc'] + '</td>';
                    newrow += '<td class="text-center">' + array['kllt'] + '</td>';
                    newrow += '<td class="text-center">' + array['klth'] + '</td>';
                    newrow += '<td class="text-center">' + array['tongkhoiluong'] + '</td>';
                    newrow += '<td class="text-center"> <button class="btn btn-info btn-xs upd" data-id="' + array['ma_monhoc'] + '" style="margin-right: 4px"><i class="fa fa-edit"></i></button><button class="btn btn-danger btn-xs del" data-id="' + array['ma_monhoc'] + '"><i class="fa fa-trash"></i></button></td>';
                    newrow += '</tr>';
                    $(newrow).insertAfter('table > tbody > tr:first').hide().fadeIn('slow', function () {
                        $(this).attr("style", "background-color: F4F4F4;-webkit-transition: background-color 3.5s ease;-moz-transition: background-color 3.5s ease;-o-transition: background-color 3.5s ease;transition: background-color 3.5s ease;");
                    });
                    var i = 0;
                    $('table > tbody >tr').each(function () {
                        $('td:first', this).text(i);
                        i++;
                    });
                    i = i - 1;
                    var options = {
                        currentPage: 1,
                        totalPages: Math.ceil(i / 10)
                    };
                    $('#page').bootstrapPaginator(options);
                    $('#idmh').val("");
                    $('#tmh').val("");
                    $('#tvt').val("");
                    $('#kllt').val("");
                    $('#klth').val("");

                    $('#save').prop('disabled', false);
                    showMessage('success','Thêm mới thành công');
                    paging(parseInt($('#page ul .active').text()) - 1,10);*/
                }
            })
        }
    });

});