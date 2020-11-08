<div class="panel panel-default block m-t-5">
    <div class="panel-heading">
        <p class="text-uppercase text-center">Cập nhật Email</p>
        <!-- <h4 class="text-danger text-center">{$email}</h4> -->
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <div class="present"><i class="mdi mdi-gmail"></i> <span class="present-email">{$email}</span></div>
        	<form method="post">
	        	<div class="row">
	        		<div class="col-md-5">	
	        			<div class="input-group">
	        				<span class="input-group-addon">Email mới:</span>
                            <input type="email" class="form-control" name="email_new" id="email_new" placeholder="..." >
	        			</div>
                        <p id="error" class="text-danger mt-5"></p>
	        		</div>
	        		<div class="col-md-2 text-right">
	        			<div class="form-group">
							<button class="btn btn-warning waves-effect waves-light" type="submit" name="action" value="doimatkhau" id="luu">
								<span class="btn-label">
									<i class="fa fa-check"></i>
								</span>
								THAY ĐỔI
							</button>
						</div>
	        		</div>
	        	</div>
            </form>
            {if empty($email)}
            <p class="text-danger">*Chú ý: Bạn phải cập nhật email trước khi sử dụng hệ thống</p>
            {/if}
        </div>
    </div>
</div>
<style>
    .present{
        margin-bottom: 20px;
        /* text-align: right; */
    }
    .present-email{
        color:#00b894;
    }
</style>
{literal}
<script type="text/javascript">
    $(document).ready(function() {
        var pattern = /^[a-z][a-z0-9_\.]{5,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/;
        var email = document.getElementById('email_new');
        email.onkeyup = function(){
            if(pattern.test(email.value) || email.value ==""){
                document.getElementById('error').innerText ="";
            }else{
                document.getElementById('error').innerText ="Email không hợp lệ";
            }
        }
        $('#luu').click(function(){
            if(!pattern.test(email.value)){
                email.focus();
                event.preventDefault();
                return false;
            }
        });
    });
</script>
{/literal}
