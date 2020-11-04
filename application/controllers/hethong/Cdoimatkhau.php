<?php

	/**
	 * 
	 */
	class Cdoimatkhau extends CI_Controller{
		function __construct(){
			parent::__construct();
			$user 						= $this->session->userdata('user');
			if (!$user) {
				redirect('login','refresh');
			}
			$this->load->model('hethong/Mlogin');
		}

		public function index(){
			$action						= $this->input->post('action');
			switch ($action) {
				case 'doimatkhau':
					$this->doiMatKhau();
					break;
				
				default:
					# code...
					break;
			}
			$temp['template'] 			= 'hethong/Vdoimatkhau';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function doiMatKhau(){
			$password 					= $this->input->post('password');
			$confirmpassword 			= $this->input->post('confirmpassword');

			if ($password == $confirmpassword) {
				$user 					= $this->session->userdata('user');
				$this->Mlogin->doiMatKhau($user['username'], $password);
				setMessage('success', 'Đổi mật khẩu thành công.');

				$session 				= $this->session->userdata('user');
				$session['trangthai'] 	= 1;
				$this->session->set_userdata('user', $session);

				return redirect(base_url('home'), 'refresh');
			}else{
				setMessage('error', 'Đã có lỗi xảy ra, vui lòng thử lại sau.');
				return redirect(base_url('doimatkhau'), 'refresh');
			}
		}
	}

?>