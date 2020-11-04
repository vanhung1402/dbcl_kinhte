<?php

	/**
	 * 
	 */
	class Cdanhsachsinhvien extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('danhmuc/Mdanhsachsinhvien');
		}

		public function index(){
			$action					= $this->input->post('action');
			switch ($action) {
				case 'doimatkhau':
					$this->doiMatKhau();
					break;
				case 'loc':
					$data['lop'] 	= $this->input->post('lop');
					break;	
				default:
					# code...
					break;
			}
			if ($this->_session['quyen'] == 'covanhoctap') {
				$data['dslop'] 		= $this->Mdanhsachsinhvien->layDanhSachLop($this->_session['ma_canbo']);
			}else{
				$data['dslop'] 		= $this->Mdanhsachsinhvien->layDanhSachLop();
			}

			if (!isset($data['lop'])) {
				$data['lop'] 		= $data['dslop'][0]['ma_lop'];
			}

			$data['dssinhvien'] 	= $this->Mdanhsachsinhvien->layDanhSachSinhVienLop($data['lop']);

			$temp['data'] 			= $data;
			$temp['template'] 		= 'danhmuc/Vdanhsachsinhvien';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function doiMatKhau(){
			$username 				= $this->input->post('username');
			$password 				= $this->input->post('password');

			$row_affected 			= $this->Mdanhsachsinhvien->doiMatKhauSinhVien($username, $password);

			echo json_encode($row_affected);
			exit();
		}
	}

?>