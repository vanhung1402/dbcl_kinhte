$(document).ready(function() {
	$(document).on('click', 'button[name="xoa-taikhoan"]', function(event) {
		let tendangnhap = $(this).val();

		swal({   
            title: "Xóa tài khoản này?",   
            text: "Hãy chắc chắn, nếu xóa tài khoản này sẽ không còn đăng nhập được vào hệ thống!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Đồng ý, xóa nó!",
            closeOnConfirm: true 
        }, function(){
			deleteAccount(tendangnhap);
        });

	});

	function deleteAccount(tendangnhap){
		$.ajax({
			url: window.location.href,
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'xoa-taikhoan',
				username: tendangnhap
			},
		})
		.done(function(res) {
			window.location.reload();
		})
		.fail(function(err) {
			console.log(err);
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	}
});