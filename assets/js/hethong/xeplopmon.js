$(document).ready(function(){
/*    $('#lop_hc').select2();
    $('#lopmon').select2();*/
    $('.chkall').change(function(){
        $(this).closest('table').find('input:checkbox').not(this).each(function(){
            if($(this).is(':checked')){
                $(this).prop('checked',false);
            }
            else{
                $(this).prop('checked',true);
            }
        });
    });
})
/* var loading = `
    <tr>
    <td colspan="3">
        <div class="loading">
            <div class="ojb"></div>
            <div class="ojb"></div>
            <div class="ojb"></div>
        </div>
    </td>
    </tr>
`; */
var loading = `
    <tr>
    <td colspan="3">
        <div class="loading">
        <i class="fa fa-spin fa-spinner"></i>
        </div>
    </td>
    </tr>
`;
$(document).on('change','input[name="trangthai"]',function(){
    $('#dvhv').val(null).trigger('change');
})
$(document).on('change','#dvhv',function(){
    $('#lopmon').val(null).trigger('change');
    $('#lop_hc').val(null).trigger('change');
    
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data:{
            'action': 'get_lopmon',
            'dvhv'             : $(this).val(),
            'trangthai_lopmon' : 'dukien',
        },
        success: function(response){
            data = JSON.parse(response);
            html=`<option value="" selected>--- Chọn ---</option>`;
            data.forEach(function(el,index){
                html+=`
                    <option value="`+el['ma_lopmon']+`">`+el['ten_lopmon']+`</option>
                `;
            })
            $('#lopmon').html(html);
        }
    });
})
$(document).on('change','#lop_hc',function(){
    ma_lopmon = $('#lopmon').val();
    ma_dvhv   = $('#dvhv').val();
    if(ma_lopmon === '' || ma_dvhv ===''){
        $('#table-left tr').not('tr:first').remove();
        $(loading).insertAfter('#table-left tr:first');
        return false;
    }
    get_sv_lophc(ma_lopmon);
})
$(document).on('change','#lopmon',function(){
    ma_lopmon = $('#lopmon').val();
    ma_lophc = $('#lop_hc').val();
    if(ma_lopmon === ''){
        $('#table-left tr').not('tr:first').remove();
        $('#table-right tr').not('tr:first').remove();
        $(loading).insertAfter('#table-left tr:first');
        return false;
    }
    get_sv_lophc(ma_lopmon);
});
function get_sv_lophc(){
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data:{
            'action' : 'get_sv_lophc',
            'lophc'  :$('#lop_hc').val(),
            'lopmon' :ma_lopmon,
        },
        success: function(response){
            sv = JSON.parse(response);
            $('#table-left tr').not('tr:first').remove();
            lophc=``;
            sv['ds_sv_lophc'].forEach(function(el,index){
                lophc+=`
                    <tr>
                        <td class="text-center"><input type="checkbox" name="sv_lophc[]" value="`+el['ma_sv']+`"></td>
                        <td>`+el['hodem_sv']+` `+el['ten_sv']+`</td>
                        <td>`+el['ngaysinh_sv']+`</td>
                    </tr>
                `;
            });
            $('.so_sv_chuaxep').html(sv['so_sv_chuaxep']);
            $(lophc).insertAfter('#table-left tr:first');
            lopmon=``;
            sv['ds_sv_lopmon'].forEach(function(el,index){
                lopmon+=`
                    <tr>
                        <td class="text-center"><input type="checkbox" name="sv_lopmon[]" value="`+el['ma_dkm']+`"></td>
                        <td>`+el['hodem_sv']+` `+el['ten_sv']+`</td>
                        <td>`+el['ngaysinh_sv']+`</td>
                    </tr>
                `;
            });
            $('#table-right tr').not('tr:first').remove();
            $('.so_sv_lopmon').html(sv['so_sv_lopmon']);
            $(lopmon).insertAfter('#table-right tr:first');
        }
    });
}
$(document).on('click','#add',function(){
    $('#table-left tr').not('tr:first').each(function(){
        if($(this).children('td:first').children().is(':checked')){
            $(this).insertAfter('#table-right tr:first');
        }           
    })
    $('input:checkbox').prop('checked', false);
})
$(document).on('click','#rmv',function(){
    $('#table-right tr').not('tr:first').each(function(){
        if($(this).children('td:first').children().is(':checked')){
            $(this).insertAfter('#table-left tr:first');
        }           
    })
    $('input:checkbox').prop('checked', false);
})
$(document).on('click','#luu',function(){
    var add_sv_lm = $('#table-right input[name^=sv_lophc]').map(function(idx, elem) {
        return $(elem).val();
    }).get();
    var del_sv_lm = $('#table-left input[name^=sv_lopmon]').map(function(idx, elem) {
        return $(elem).val();
    }).get();
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data:{
            'action'    : 'change_sv_lopmon',
            'add_sv_lm' : add_sv_lm,
            'del_sv_lm' : del_sv_lm,
            'lopmon' : $('#lopmon').val(),
        },
        success: function(response){
            showMessage('success','Lưu thành công');
            $('#lop_hc').trigger('change');
        }
    });
});

