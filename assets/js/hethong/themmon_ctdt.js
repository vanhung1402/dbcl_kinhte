$(document).ready(function(){
    get_data();
    $('#inform').hide();
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
    $('#ctdt').change(function(){
        ctdt = $(this).val();
        $('#inctdt').show();
        if(ctdt == ''){
            $('#inctdt').hide();
        }
        $('#inctdt').attr('href','monhoc_ctdt?id='+ctdt);
        get_data();
    });
    function get_data(){
        $.ajax({
            type: "POST",
            url: window.location.href,
            data:{
                'action' : 'get_mon_ctdt',
                'ma_ctdt': $('#ctdt').val(),
            },
            async: false,
            success:function(reponse){
                data = JSON.parse(reponse);
                ds_mon_ctdt = data['mon_in_ctdt'] || [];
                ds_monhoc   = data['monhoc'] || [];
                chk         = data['check_ctdt'];
                $('#table-right tr').not('tr:first').remove();
                $('#table-left tr').not('tr:first').remove();
                html_monctdt=``;
                for(i=0;i<ds_mon_ctdt.length;i++){
                    html_monctdt += `
                        <tr>
                            <td><input type="checkbox" class="monctdt" value="`+ds_mon_ctdt[i]['ma_mon_ctdt']+`"></td>
                            <td>`+ds_mon_ctdt[i]['ten_monhoc']+`</td>
                            <td class="cangiua">`+ds_mon_ctdt[i]['tongkhoiluong']+`</td>
                            <td class="cangiua">`+ds_mon_ctdt[i]['donvitinh']+`</td>
                        </tr>
                    `;
                }
                $(html_monctdt).insertAfter('#table-right tr:first');
                html_monhoc=``;
                for(i=0;i<ds_monhoc.length;i++){
                    html_monhoc += `
                        <tr>
                            <td><input type="checkbox" class="monhoc" value="`+ds_monhoc[i]['ma_monhoc']+`"></td>
                            <td>`+ds_monhoc[i]['ten_monhoc']+`</td>
                            <td class="cangiua">`+ds_monhoc[i]['tongkhoiluong']+`</td>
                            <td class="cangiua">`+ds_monhoc[i]['donvitinh']+`</td>
                        </tr>
                    `;
                }
                $(html_monhoc).insertAfter('#table-left tr:first');
                if(chk==1){
                    $('#inform').show();
                    $('input:checkbox').prop('disabled',true);
                    $('#save').hide();
                }else{
                    $('#inform').hide();
                    $('input:checkbox').prop('disabled',false);
                    $('#save').show();
                }
            }
        });
    }
})
$(document).on('click','#save',function(){
    var add_mon_ctdt = [];
    var del_mon_ctdt = [];
    $('#table-right tr').not('tr:first').each(function(){
        if($(this).children('td:first').children().attr('class')=='monhoc'){
            add_mon_ctdt.push($(this).children('td:first').children().val());  
        }
    })
    $('#table-left tr').not('tr:first').each(function(){
        if($(this).children('td:first').children().attr('class')=='monctdt'){
            del_mon_ctdt.push($(this).children('td:first').children().val());   
        }
    }) 
    $('input[name="addlist"]').val(JSON.stringify(add_mon_ctdt));
    $('input[name="dellist"]').val(JSON.stringify(del_mon_ctdt));
})
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
$(document).on('keyup','#left-key',function(){
    var tukhoa = $(this).val().toLowerCase();
    tukhoa = tonormalword(tukhoa);
    $('#table-left tr').not('tr:first').each(function(){
        var string = $(this).children('td:first').next().text().toLowerCase();
        string = tonormalword(string);
        if (string.indexOf(tukhoa) == 0) {
            $(this).show();
        } else {
            $(this).hide();
        }
    })
})
$(document).on('keyup','#right-key',function(){
    var tukhoa = $(this).val().toLowerCase();
    tukhoa = tonormalword(tukhoa);
    $('#table-right tr').not('tr:first').each(function(){
        var string = $(this).children('td:first').next().text().toLowerCase();
        string = tonormalword(string);
        if (string.indexOf(tukhoa) == 0) {
            $(this).show();
        } else {
            $(this).hide();
        }
    })
})
function tonormalword(str) {
    return str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a").replace(/\ /g, '-').replace(/đ/g, "d").replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y").replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u").replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ.+/g, "o").replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ.+/g, "e").replace(/ì|í|ị|ỉ|ĩ/g, "i");
}