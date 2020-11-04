<link href="{$url}assets/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
<link href="{$url}assets/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="{$url}assets/css/quanly/dotkhaosat.css">

<div class="row p-t-10">
	<div class="col-md-4">
		<div class="panel panel-default m-t-5">
		    <div class="panel-heading">
		    	Quản lý đợt khảo sát
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
                                <a class="tab ds_loaiks active" val="ds_loaiks">
                                    <div class="card--display">
                                        <p class="pointer" >
                                            Danh sách đợt khảo sát
                                        </p>
                                    </div>
                                </a>
                                <div class="card--border"></div>
                            </div>
                        </div>
                        <div class="card-container"> 
                            <div class="card">
                                <a class="tab them_dotks" val="them_dotks">
                                    <div class="card--display">
                                        <p class="pointer" >
                                            Thêm đợt khảo sát
                                        </p>
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
		<div class="panel panel-default m-t-5 tab-content ds_loaiks active">
		    <div class="panel-heading">
		    	Danh sách đợt khảo sát
		        <div class="panel-action">
		        </div>
		    </div>
		    <div class="panel-wrapper collapse in">
		        <div class="panel-body">
                    <div class="row filter">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dvhv">Đơn vị học vụ</label>
                                <select name="dvhv" id="dvhv" class="form-control" >
                                    <option value="">Tất cả</option>
                                    {foreach $list_dvhv as $key => $dvhv}
                                        {if $dvhv.ma_donvihocvu == $ma_dvhv}
                                        <option value="{$dvhv.ma_donvihocvu}" selected>{$dvhv.ma_donvihocvu}</option>
                                        {else}
                                        <option value="{$dvhv.ma_donvihocvu}">{$dvhv.ma_donvihocvu}</option>
                                        {/if}
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    </div>
			        <table class="table table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">STT</th>
                                <th class="text-center">Loại khảo sát</th>
                                <th class="text-center">Thời gian BĐ</th>
                                <th class="text-center">Thời gian KT</th>
                                <th class="text-center">ĐVHV</th>
                                <th class="text-center">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody class="list_dotks">
                            {if count($list_dotks) == 0}
                            <tr>
                                <td colspan="6">
                                    <p class="text-danger p-l-20 p-t-10">Chưa có đợt khảo sát nào tại đơn vị học vụ này!</p>
                                </td>
                            </tr>
                            {else}
                            {foreach $list_dotks as $key => $dotks}
                            <tr>
                                <td class="text-center">{$key+1}</td>
                                <td>
                                    <a class="pointer" href="{$url}chude?khaosat={$dotks.ma_ks}">{$dotks.tieude}</a>
                                </td>
                                <td class="text-center">{$dotks.bd}</td>
                                <td class="text-center">{$dotks.kt}</td>
                                <td class="text-center">
                                    <a class="pointer" val="{$dotks.ma_dvhv}">{$dotks.ma_dvhv}</a>
                                </td>
                                <td class="text-right">
                                    <button class="btn btn-sm btn-danger xoa_dotks" value="{$dotks.ma}">Xóa</button>
                                    <a class="btn btn-sm btn-info" href="{$url}cauhoi?khaosat={$dotks.ma_ks}">Chi tiết</a>
                                </td>
                            </tr>
                            {/foreach}
                            {/if}
                        </tbody>
                    </table>
		        </div>
		    </div>
		</div>
		<div class="panel panel-default m-t-5 tab-content them_dotks">
		    <div class="panel-heading">
		    	Thêm đợt khảo sát
		        <div class="panel-action">
		        </div>
		    </div>
		    <div class="panel-wrapper collapse in">
                <form action="">
                    <div class="panel-body">
                        <div id="list-topic">	
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="loai">Loại khảo sát</label>
                                    <select name="" id="loai" class="form-control" >
                                        <option value="">Chọn loại khảo sát</option>
                                        {foreach $list_ks as $key => $ks}
                                            <option value="{$ks.ma}">{$ks.tieude}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="add_dvhv">Đơn vị học vụ</label>
                                    <select name="" id="add_dvhv" class="form-control" >
                                        <option value="">Chọn đơn vị học vụ</option>
                                        {foreach $list_dvhv as $key => $dvhv}
                                            {if $dvhv.ma_donvihocvu == $ma_dvhv}
                                            <option value="{$dvhv.ma_donvihocvu}" selected>{$dvhv.ma_donvihocvu}</option>
                                            {else}
                                            <option value="{$dvhv.ma_donvihocvu}">{$dvhv.ma_donvihocvu}</option>
                                            {/if}
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="thoigian_ks">Thời gian khảo sát</label>
                                    <input type="text" class="form-control datepicker" id="thoigian_ks" placeholder="Từ ngày - đến ngày">         
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-info text-right">
                        <button class="btn btn-danger" type="reset">Hủy</button>
                        <button class="btn btn-success" id="them_dotks" type="button">Thêm cuộc kháo sát</button>
                    </div>
                </form>
		    </div>
		</div>
	</div>
</div>	

<input type="hidden" class="csrf" name="{$csrf_token_name}" value="{$csrf_token}"/>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{$url}assets/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="{$url}assets/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript">
	const ma_khaosat = '{$ma_khaosat}';
</script>
<script type="text/javascript" src="{$url}assets/js/quanly/dotkhaosat.js"></script>