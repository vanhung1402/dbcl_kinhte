<style type="text/css">
	th{
		font-weight: 700;
	}
	table.table tbody td, table.table thead th{
		padding: 5px 10px;
		vertical-align: middle;
	}
	.user>div{
		margin-bottom: 20px;
	}
	.area-heading{
		margin-bottom: 10px;
		padding: 1px;
	}
    .btn{
        margin: 5px;
    }
</style>
<div class="panel panel-default block m-t-5">
    <div class="panel-heading">
        <p class="text-uppercase text-center">Chuẩn hóa</p>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
        	<form method="post">
			{foreach $dstable as $tb}
				<button class="btn btn-md btn-info" type="submit" name="table" value="{$tb}">
					<i class="fa fa-spin fa-cog"></i> &nbsp; {$tb}
				</button>
			{/foreach}
			</form>
        </div>
    </div>
</div>
