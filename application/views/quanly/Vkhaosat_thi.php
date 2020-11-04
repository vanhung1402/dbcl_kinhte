<link href="{$url}assets/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
<link href="{$url}assets/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
<style type="text/css">
body {
        display: flex;
    }
    body * {
        box-sizing: border-box;
    }

    .card-container {
        flex: 300px;
    }
    .card-container .card {
        font-weight: bold;
        position: relative;
        height: 40px;
        width: 100%;
    }
    .card-container:not(:first-child) .card{
        margin-top: 15px;
    }
    .card-container .card a {
        padding: 5px 10px 10px 10px;
        width: 100%;
        height: 40px;
        border: 2px solid black;
        background: white;
        text-decoration: none;
        color: black;
        display: block;
        position: absolute;
        z-index: 100;
        transition: 0.25s ease;
    }
    .card-container .card:hover a, .card-container .card a.active{
        transform: translate(-10px, -10px);
        border-color: #5bc0eb;
    }
    .card-container .card .card--border {
        position: absolute;
        padding: 10px;
        width: 100%;
        height: 40px;
        left: 0;
        top: 0;
        border: 2px dashed black;
        z-index: 1;
    }
    .pointer{
        cursor: pointer;
    }
    .tab{
        border: 2px solid #fff;
    }
    .tab.active{
        color: red;
    }
    .tab-content{
        display: none;
    }
    .tab-content.active{
        display: block;
    }
    .swal2-popup{
        font-size: 1em;
    }
    textarea{
        resize: none;
    }
    .table-condensed>tbody>tr>td{
        padding: 1px;
    }
    .datepicker{
        padding-left: 10px;
    }
    .pointer{
        cursor: pointer;
    }
</style>
<div class="row p-t-10">
	<div class="col-md-4">
		<div class="panel panel-default m-t-5">
		    <div class="panel-heading">
		    	Quản lý khảo sát
		        <div class="panel-action">
		        	<a href="javascript:void(0)" data-perform="panel-collapse">
		        		<i class="ti-minus"></i>
                    </a>
		        </div>
		    </div>
		    <div class="panel-wrapper collapse in">
		        <div class="panel-body">
		            <div id="list-topic">	
                        <div class="card-container"> 
                            <div class="card">
                                <a class="tab ds_ks active" val="ds_ks">
                                    <div class="card--display">
                                        <p class="pointer" val="ds_ks">Danh sách khảo sát</p>
                                    </div>
                                </a>
                                <div class="card--border"></div>
                            </div>
                        </div>
                        <div class="card-container"> 
                            <div class="card">
                                <a class="tab them_ks" val="them_ks">
                                    <div class="card--display">
                                        <p class="pointer">Thêm khảo sát</p>
                                    </div>
                                </a>
                                <div class="card--border"></div>
                            </div>
                        </div>
                        
			        </div>
		        </div>
		    </div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="panel panel-default m-t-5 tab-content ds_ks active">
		    <div class="panel-heading">
		    	Danh sách khảo sát
		        <div class="panel-action">
		        </div>
		    </div>
		    <div class="panel-wrapper collapse in">
		        <div class="panel-body">
			        <table class="table table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Loại khảo sát</th>
                                <th class="text-center">Tiêu đề khảo sát</th>
                                <th class="text-center">Ghi chú</th>
                                <th class="text-center">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody class="list_ks">
                            {assign var="i" value="1"}
                            {foreach $list_ks as $key => $ks}
                            <tr>
                                <td class="text-center">{$i++}</td>
                                <td>{$ks.ten_loai}</td>
                                <td>{$ks.tieude}</td>
                                <td>{$ks.ghichu}</td>
                                <td class="text-center">
                                    {if $ks.sl_cauhoi == 0 && $ks.sl_dotks == 0}
                                    <button class="btn btn-sm btn-danger xoa_ks" value="{$ks.ma}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    {else if}
                                    <button class="btn btn-sm btn-danger" value="{$ks.ma}" title="Khảo sát đã được thêm câu hỏi và tạo đợt khảo sát nên không thể xóa" disabled>
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    {/if}
                                    <a class="btn btn-sm btn-info" href="{$url}chude?khaosat={$ks.ma}"><i class="fa fa-info"></i></a>
                                    <a class="btn btn-sm btn-info" href="{$url}khaosathoctap?khaosat={$ks.ma}">Đợt khảo sát</a>
                                </td>
                            </tr>
                            {/foreach}
                        </tbody>
                    </table>
		        </div>
		    </div>
		</div>
		<div class="panel panel-default m-t-5 tab-content them_ks">
		    <div class="panel-heading">
		    	Thêm khảo sát
		        <div class="panel-action">
		        </div>
		    </div>
		    <div class="panel-wrapper collapse in">
                <form action="">
                    <div class="panel-body">
                        <div id="list-topic">	
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="tieude">Tiêu đề khảo sát</label>
                                    <input type="text" class="form-control" id="tieude" placeholder="Nhập tiêu đề khảo sát">         
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="loai">Loại khảo sát</label>
                                    <select name="" id="loai" class="form-control" >
                                        <option value="">Chọn loại khảo sát</option>
                                        {foreach $list_loaiks as $key => $loaiks}
                                            <option value="{$loaiks.madm_loaikhaosat}">{$loaiks.tendm_loaikhaosat}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="noidung">Nội dung</label>
                                    <textarea class="form-control"  name="" id="noidung" cols="30" rows="6" placeholder="Nội dung khảo sát"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ghichu">Ghi chú</label>
                                    <textarea class="form-control"  name="" id="ghichu" cols="30" rows="6" placeholder="Ghi chú khảo sát"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-info text-right">
                        <button class="btn btn-danger" type="reset">Hủy</button>
                        <button class="btn btn-success" id="them_ks" type="button">Thêm kháo sát</button>
                    </div>
                </form>
		    </div>
		</div>
	</div>
</div>	

<input type="hidden" class="csrf" name="{$csrf_token_name}" value="{$csrf_token}"/>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{$url}assets/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="{$url}assets/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript">
	const ma_khaosat = '{$ma_khaosat}';
</script>
{literal}
<script type="text/javascript">
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
        function danh_stt(){
            var list_tr = $(".list_ks").find("tr");
            for(var i = 0; i < list_tr.length; i++)
            {
                $(list_tr[i]).children().first().text(i++);
            }
        }
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
        $(document).on('click', '.tab', function(){
            tab_name = $(this).attr('val');
            $('.tab-content').removeClass('active');
            $('.'+tab_name).addClass('active');
            $('.tab').removeClass('active');
            $(this).addClass('active');
        });
        $(document).on('click', '.xoa_ks', function(){
            var btn = $(this);
            Swal.fire({
                title: 'Xác nhận',
                text: "Bạn có chắc chắn muốn xóa khảo sát này?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xác nhận!',
                cancelButtonText: 'Hủy! '
                }).then((result) => {
                if (result.value) {
                    const data = {
                        action: 'xoa_ks',
                        id: $(btn).val()
                    }
                    $.ajax({
                        url: location.pathname,
                        type: 'POST',
                        data: data,
                    }).done(function (res) {
                        if (res != false) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Xóa khảo sát thành công!'
                            });
                            $(btn).parent().parent().remove();
                            danh_stt();
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Xóa khảo sát thất bại!'
                            })
                        }
                    }).fail(function () {
                    }).always(function () {
                    });
                }
            })
        });
        
        $(document).on('click', '#them_ks', function(){
            check = true;
            const data = {
                action: 'them_ks',
                tieude: $('#tieude').val(),
                loai: $('#loai').val(),
                ten_loai: $('#loai option:selected').text(),
                noidung: $('#noidung').val(),
                ghichu: $('#ghichu').val()
            }
            check_emty($('#noidung'), 'Cán bộ cần nhập nội dung khảo sát!');
            check_emty($('#loai'), 'Cán bộ cần chọn loại khảo sát!');
            check_emty($('#tieude'), 'Cán bộ cần nhập tiêu đề!');
            if(check == false)
            {
                return;
            }
            $.ajax({
                url: location.pathname,
                type: 'POST',
                data: data,
            }).done(function (res) {
                if (res != false) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Thêm khảo sát thành công!'
                    });
                    html = `
                        <tr>
                            <td class="text-center"></td>
                            <td>`+ data['ten_loai'] +`</td>
                            <td>`+ data['tieude'] +`</td>
                            <td>`+ data['ghichu'] +`</td>
                            <td class="text-right">
                                <button class="btn btn-sm btn-danger xoa_ks" value="`+ res +`">Xóa</button>
                                <a class="btn btn-sm btn-info" href="`+ location.pathname +`cauhoi?khaosat=`+ res +`">Chi tiết</a>
                            </td>
                        </tr>
                    `
                    $('.list_ks').append(html);
                    $('.tab-content').removeClass('active');
                    $('.tab').removeClass('active');
                    $('.tab-content:first-child').addClass('active');
                    $('.tab').first().addClass('active');
                    danh_stt();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Thêm khảo sát thất bại!'
                    })
                }
            }).fail(function () {
            }).always(function () {
            });
        });
	});
</script>
{/literal}