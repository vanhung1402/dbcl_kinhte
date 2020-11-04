<link href="{$url}assets/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
<link href="{$url}assets/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{$url}assets/css/khaosat/cauhoi.css">

<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default m-t-5">
		    <div class="panel-heading">
		    	<i class="fa fa-list-ol fa-fw"></i> CHỦ ĐỀ KHẢO SÁT
		        <div class="panel-action">
		        	<a href="javascript:void(0)" data-perform="panel-collapse">
		        		<i class="ti-minus"></i>
		        	</a>
		        </div>
		    </div>
		    <div class="panel-wrapper collapse in">
		        <div class="panel-body">
		            <div id="list-topic">	
			        </div>
		        </div>
		        <div class="panel-footer text-info">
		        	<p class="text-info"><i class="ti-notepad"></i> Chú ý lưu các thay đổi trước khi chuyển chủ đề!</p>
		        </div>
		    </div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="cauhoi-container m-t-5">
			<ul class="topic-content">
				<li class="empty-topic">
					<div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Chưa chọn chủ đề khảo sát, vui lòng click vào một chủ đề <i class="fa fa-spin fa-spinner"></i>
                    </div>
				</li>
			</ul>
			<div class="tacvu m-t-5 m-b-30 text-center hidden">
				<div class="form-group">
					<button class="btn btn-info waves-effect waves-light" type="button" id="add-cauhoi">
						<span class="btn-label">
							<i class="fa fa-plus"></i>
						</span>
						THÊM CÂU HỎI
					</button>
				</div>
				&nbsp;&nbsp;&nbsp;
				<div class="form-group">
					<button class="btn btn-success waves-effect waves-light" type="button" id="luu">
						<span class="btn-label">
							<i class="fa fa-check"></i>
						</span>
						LƯU
					</button>
				</div>
			</div>
		</div>
	</div>
</div>	

<input type="hidden" class="csrf" name="{$csrf_token_name}" value="{$csrf_token}"/>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{$url}assets/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="{$url}assets/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript">
	const ma_khaosat = '{$ma_khaosat}';
</script>
<script type="text/javascript" src="{$url}assets/js/khaosat/cauhoi.js"></script>