$(document).ready(function() {
	$('#luu').click(function(event) {
		let password = $('#password').val();
		let confirmpassword = $('#confirmpassword').val();

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
		return true;
	});
});