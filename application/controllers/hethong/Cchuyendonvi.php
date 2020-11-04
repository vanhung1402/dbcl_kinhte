<?php
	
	class Cchuyendonvi extends CI_Controller{	
		private $_session;
		function __construct(){
			parent::__construct();
			$this->load->library('encryption');
			$this->load->model('hethong/Mlogin');
			$this->_session 			= $this->session->userdata('user');
		}

		public function index(){
			$donvi 						= $this->input->get('donvi');
			$session 					= $this->input->get('session');

			if ($donvi) {
				$this->chuyenDonVi($donvi);
				exit();
			}

			if ($session) {
				$this->luuDonVi($session);
				exit();
			}

			$data['dsdonvi'] 			= array(
				'01' 					=> array(
					'ten_donvi' 		=> 'Công nghệ thông tin',
					'anh' 				=> 'cntt.png',
					'url' 				=> 'cntt',
				),
				'02' 					=> array(
					'ten_donvi' 		=> 'Điện tử thông tin',
					'anh' 				=> 'logo_hou.png',
					'url' 				=> 'dientu',
				),
				'03' 					=> array(
					'ten_donvi' 		=> 'Kiến trúc',
					'anh' 				=> 'kientruc.png',
					'url' 				=> 'kientruc',
				),
				'04' 					=> array(
					'ten_donvi' 		=> 'Công nghệ sinh học',
					'anh' 				=> 'logo_hou.png',
					'url' 				=> 'sinhhoc',
				),
				'05' 					=> array(
					'ten_donvi' 		=> 'Kinh tế',
					'anh' 				=> 'logo_hou.png',
					'url' 				=> 'kinhte',
				),
				'06' 					=> array(
					'ten_donvi' 		=> 'Du lịch',
					'anh' 				=> 'logo_hou.png',
					'url' 				=> 'dulich',
				),
				'07' 					=> array(
					'ten_donvi' 		=> 'Tài chính ngân hàng',
					'anh' 				=> 'logo_hou.png',
					'url' 				=> 'tcnh',
				),
				'08' 					=> array(
					'ten_donvi' 		=> 'Luật',
					'anh' 				=> 'logo_hou.png',
					'url' 				=> 'luat',
				),
				'09' 					=> array(
					'ten_donvi' 		=> 'Tạo dáng công nghiệp',
					'anh' 				=> 'tdcn.png',
					'url' 				=> 'tdcn',
				),
				'10' 					=> array(
					'ten_donvi' 		=> 'Tiếng Anh',
					'anh' 				=> 'logo_hou.png',
					'url' 				=> 'tienganh',
				),
				'11' 					=> array(
					'ten_donvi' 		=> 'Tiếng Trung Quốc',
					'anh' 				=> 'logo_hou.png',
					'url' 				=> 'trungquoc',
				),
			);

			$data['title'] 				= 'Chuyển đơn vị | Hệ thống Đảm bảo chất lượng Trường Đại học Mở Hà Nội';
			$data['url'] 				= base_url();

			$temp['data'] 				= $data;
			$temp['template'] 			= 'hethong/Vchuyendonvi';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function chuyenDonVi($donvi){
			if ($this->_session['quyen'] != 'phongkhaothi') {
				return redirect('logout', 'refresh');
			}
			$user 						= $this->Mlogin->getInfor($this->_session['username']);
			if ($user) {
				$session 				= urlencode($this->encryption->encrypt($user['ten_dangnhap'] . '|' . $user['matkhau_dangnhap']));
				$protocol = strtolower(current(explode('/',$_SERVER['SERVER_PROTOCOL'])));
				return redirect($protocol . '://' . $_SERVER['HTTP_HOST'] . '/' . $donvi . '/chuyenkhoa?session=' . $session);
			}else{
				return redirect('logout', 'refresh');
			}
		}

		private function luuDonVi($session){
			$session 				= urldecode($this->encryption->decrypt($session));
			$session 				= explode('|', $session);
			$username 				= $session[0];
			$password 				= $session[1];

			$user_info 	= $this->Mlogin->getHightUser($username, $password);

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
	}

?>