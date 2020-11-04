<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class Cloginadmin extends CI_Controller{
		protected $__msg;
		function __construct(){
			parent::__construct();
			$this->load->model('hethong/Mlogin');
			$this->__msg = array();
			// pr($this->_session);
		}

		public function index(){
			$user 		= $this->session->userdata('user');
			if ($user) {
				return redirect(base_url(), 'refresh');
			}
			$action 	= $this->input->post('action');

			switch ($action) {
				case 'base-login':
					$this->baseLogin();
					break;
				
				default:
					# code...
					break;
			}

			$data 		= array(
				'url' 	=> base_url(),
				'msg' 	=> $this->__msg,
				'csrf_token_name' 	=> $this->security->get_csrf_token_name(),
				'csrf_token' 		=> $this->security->get_csrf_hash()
			);

    		$this->parser->parse('hethong/Vlogin', $data);
		}

		private function baseLogin(){
			$username 	= trim($this->input->post('username'));
			$password 	= trim($this->input->post('password'));
			$user_info 	= $this->Mlogin->getBaseUser($username, $password);

			if (!empty($user_info)) {
				$session 	= array(
					'username' 	=> $user_info['ten_dangnhap'],
					'ma_canbo' 	=> $user_info['ma_canbo'],
					'ma_sv' 	=> $user_info['ma_sv'],
					'ten' 		=> $this->Mlogin->getTen($user_info['ma_canbo'], $user_info['ma_sv']),
					'quyen' 	=> $user_info['ma_quyen'],
					'trangthai' => $user_info['trangthai'],
				);
				$this->session->set_userdata('user', $session);

				return redirect('home', 'refresh');
				exit();
			} else {
				$this->__msg 	= array(
					'type' 		=> 'danger',
					'text' 		=> 'Tài khoản hoặc mật khẩu không chính xác',
				);
			}
		}

		public function logout(){
			$this->session->sess_destroy();
			return redirect('login', 'refresh');
			exit();
		}
	}

?>