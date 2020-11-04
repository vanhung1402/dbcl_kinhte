<?php 

	/**
	 * 
	 */
	class Ctaikhoan extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('danhmuc/Mtaikhoan');
		}

		public function index(){
			$action 			= $this->input->post('action');
			$tendangnhap 		= $this->input->get('ma');
			$canbosua 			= array();

			if ($tendangnhap) {
				$canbosua 		= $this->Mtaikhoan->layThongTinCanBo($tendangnhap);
			}

			switch ($action) {
				case 'save':
					$this->saveAccount();
					break;
				case 'xoa-taikhoan':
					$this->deletaAccount();
					break;
				default:
					# code...
					break;
			}

			$data  				= array(
				'dsquyen' 		=> $this->Mtaikhoan->layDanhSachQuyen($this->_session['quyen']),
				'chuaco' 		=> $this->Mtaikhoan->layCanBoChuaCoTaiKhoan(),
				'daco' 			=> $this->Mtaikhoan->layCanBoDaCoTaiKhoan($this->_session['quyen']),
				'canbosua' 		=> $canbosua,
			);

			$temp['data'] 		= $data;
			$temp['template'] 	= 'danhmuc/Vtaikhoan';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function deletaAccount(){
			$tendangnhap 		= $this->input->post('username');

			$row 				= $this->Mtaikhoan->deletaAccount($tendangnhap);

			if ($row) {
				setMessage('success', 'Đã xóa tài khoản cho cán bộ ' . $tendangnhap . '.');
			}else{
				setMessage('error', 'Đã có lỗi xảy ra, vui lòng thử lại sau!');
			}

			echo json_decode($row);
			exit();
		}

		private function saveAccount(){
			$ma_canbo 			= $this->input->post('canbo');
			$ten_dangnhap 		= $this->input->post('ten-dangnhap');
			$matkhau 			= $this->input->post('matkhau');
			$quyen 				= $this->input->post('quyen');

			if ($this->Mtaikhoan->checkUser($ten_dangnhap, $ma_canbo)) {
				setMessage('error', "Tên tài khoản *$ten_dangnhap* đã tồn tại!");
			}else{
				if ($this->Mtaikhoan->checkCanBo($ma_canbo)) {
					$row 			= $this->Mtaikhoan->updateAccount($ma_canbo, $ten_dangnhap, $matkhau, $quyen);

					if ($row) {
						setMessage('success', 'Đã cập nhật tài khoản ' . $ten_dangnhap . '.');
					}else{
						setMessage('error', 'Đã có lỗi xảy ra, vui lòng thử lại sau!');
					}
				}else{
					$row 			= $this->Mtaikhoan->insertAccount($ma_canbo, $ten_dangnhap, $matkhau, $quyen);

					if ($row) {
						setMessage('success', 'Đã thêm tài khoản cho tài khoản ' . $ten_dangnhap . '.');
					}else{
						setMessage('error', 'Đã có lỗi xảy ra, vui lòng thử lại sau!');
					}
				}

			}
			
			return redirect(base_url('taikhoan?ma=' . $ma_canbo), 'refresh');
		}
	}

?>