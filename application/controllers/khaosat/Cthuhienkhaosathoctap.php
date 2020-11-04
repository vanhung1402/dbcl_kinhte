<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Cthuhienkhaosathoctap extends MY_Controller{
		private $__masv;
		function __construct(){
			parent::__construct();
			$this->__masv 			= $this->_session['ma_sv'];
			$this->load->model('khaosat/Mthuhienkhaosathoctap', 'khaosat');
		}

		public function index(){
			$action 				= $this->input->post('action');
			switch ($action) {
				case 'load-phieu':
					$this->loadPhieu();
					break;
				case 'submit-phieu':
					$this->savePhieu();
					break;
				
				default:
					
					break;
			}

			$dsphieuhoctap 			= $this->khaosat->layPhieuHocTapSinhVien($this->__masv);

			$dsphieu 				= array();
			foreach ($dsphieuhoctap as $p) {
				if (!isset($dsphieu[$p['ma_donvihocvu']])) {
					$dsphieu[$p['ma_donvihocvu']] 	= array();
				}
				$dsphieu[$p['ma_donvihocvu']][] 	= $p;
			}

			$donvihocvu 			= $this->khaosat->layDonViHocVu();
			$donvihocvu 			= array($donvihocvu[0]);

			$data 					= array(
				'donvihocvu' 		=> $donvihocvu,
				'dsphieu' 			=> $dsphieu,
			);
			$temp['data'] 			= $data;
			$temp['template'] 		= 'khaosat/Vthuhienkhaosathoctap';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function loadPhieu(){
			$maphieu 				= $this->input->post('maphieu');

			$dscauhoi_phieu 		= $this->khaosat->layCauHoiPhieu($maphieu);
			$chitiet_phieu 			= $this->khaosat->layChiTietPhieu($maphieu);
			$thongtin_phieu 		= $this->khaosat->layThongTinPhieu($maphieu);

			echo json_encode(array(
				'thongtin' 			=> $thongtin_phieu,
				'cauhoi' 			=> $dscauhoi_phieu,
				'chitiet' 			=> $chitiet_phieu,
			));
			exit();
		}

		private function savePhieu(){
			$maphieu 				= $this->input->post('maphieu');
			$chitiet 				= json_decode($this->input->post('chitiet'), true);
			$today 					= date('Y-m-d');

			$row_changed 			= 0;
			$ngaykhaosat 			= $this->khaosat->getDateAvailable($maphieu);

			if ($ngaykhaosat) {
				$ngaybatdau 		= $ngaykhaosat['ngaybatdau_khaosat'];
				$ngayketthuc 		= $ngaykhaosat['ngayketthuc_khaosat'];

				if ($ngayketthuc && $ngayketthuc) {
					if ($ngaybatdau <= $today && $today <= $ngayketthuc) {
						$row_changed 	= $this->khaosat->savePhieu($maphieu, $chitiet);
					}
				}

			}

			echo json_encode($row_changed);
			exit();
		}
	}

?>