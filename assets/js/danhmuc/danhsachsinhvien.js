$(document).ready(function() {
	let fa_spin = '<i class="fa fa-spin fa-spinner"></i> Đang xử lý';
	let btn_xacnhan = '<i class="fa fa-check"></i> &nbsp; Xác nhận đổi';
	
	$(document).on('click', '.btn-doimatkhau', function(event) {
		let tensv = $(this).attr('tensv');
		let masv = $(this).val();

		$('#luu').val(masv);
		$('#tensinhvien').html(tensv);
		$('#myModal').modal();
	});

	$('#luu').click(function(event) {
		let password = $('#password').val();
		let confirmpassword = $('#confirmpassword').val();
		let masv = $('#luu').val();

		if (!password || !confirmpassword) {
			showMessage('warning', 'Không được bỏ trống.');
			return false;
		}

		if (password !== confirmpassword) {
			showMessage('warning', 'Mật khẩu không khớp.');
			return false;
		}

		if (password.length < 6) {
			showMessage('warning', 'Mật khẩu phải có từ 6 ký tự trở lên.');
			return false;
		}

		$('#luu').html(fa_spin);
		doiMatKhau(masv, password);
	});

	function doiMatKhau(masv, password){
		$.ajax({
			url: window.location.href,
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'doimatkhau',
				username: masv,
				password: password
			},
		})
		.done(function() {
			showMessage('success', 'Đổi mật khẩu thành công!');
			$('#myModal').modal('hide');
		})
		.fail(function(err) {
			console.log(err);
			showMessage('error', 'Đã có lỗi xảy ra vui lòng thử lại sau!');
		})
		.always(function() {
			$('#password').val('');
			$('#confirmpassword').val('');

			$('#luu').html(btn_xacnhan);
		});
		
	}
});