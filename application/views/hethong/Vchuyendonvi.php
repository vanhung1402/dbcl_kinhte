<link rel="stylesheet" href="{$url}assets/css/hethong/chuyendonvi.css">

<div class="box fadeIn">
	<div class="box-body">
		<form method="POST">
			<div class="row">
				{foreach $dsdonvi as $mdv => $dv}
				<div class="col-sm-3">
					<div class="khoa text-center">
						<a href="{$url}chuyenkhoa?donvi={$dv.url}">
							<div class="img"><img src="{$url}assets/images/{$dv.anh}" alt="{$dv.ten_donvi}"></div>
							<h4 class="text-uppercase text-info">{$dv.ten_donvi}</h4>
						</a>
					</div>
				</div>
				{/foreach}
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" src="{$url}assets/js/hethong/chuyendonvi.js"></script>