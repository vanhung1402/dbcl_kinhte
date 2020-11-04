<?php

	/**
	 * 
	 */
	class Ctinhtrangkhaosathoctap extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('khaosat/Mtinhtrangkhaosathoctap', 'tinhtrang');
		}

		public function index(){
			$action 				= $this->input->post('action');
			$covan 					= ($this->_session['quyen'] == 'covanhoctap') ? $this->_session['ma_canbo'] : null;
			$dslop 					= $this->tinhtrang->layDanhSachLopHanhChinh($covan);
			$dskhaosat 				= $this->tinhtrang->layKhaoSatHocTap();

			if (!$action) {
				$hinhthuc 				= $dskhaosat[0]['ma_khaosat'];
				$malop 					= $dslop[0]['ma_lop'];
				$dsdot 					= $this->tinhtrang->layDotKhaoSat($hinhthuc, '1');
				$dot 					= ($dsdot && $dslop) ? $dsdot[0]['ma_dotkhaosat'] : -1;
			}

			switch ($action) {
				case 'loc':
					$hinhthuc 		= $this->input->post('hinhthuc');
					$malop 			= $this->input->post('lop');
					$dot 			= $this->input->post('hocvu');
					$dsdot 			= $this->tinhtrang->layDotKhaoSat($hinhthuc, '1');
					break;
				
				case 'load-dotkhaosat':
					$makhaosat 		= $this->input->post('khaosat');
					echo json_encode($this->tinhtrang->layDotKhaoSat($makhaosat, '1'));
					exit();
					break;
				case 'load-kiemtra':
					$this->layKiemTraKhaoSat();
					break;
				default:
					# code...
					break;
			}

			$tinhtrang 				= $this->layTinhTrangKhaoSat($hinhthuc, $malop, $dot);
			
			$data = array(
				'dskhaosat' 		=> $dskhaosat,
				'dslop' 			=> $dslop,
				'dsdot' 			=> $dsdot,
				'tinhtrang' 		=> $tinhtrang,
			);

			$temp['data'] 			= $data;
			$temp['template'] 		= 'khaosat/Vtinhtrangkhaosathoctap';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function layTinhTrangKhaoSat($hinhthuc, $malop, $dot){
			$dssinhvien 			= $this->tinhtrang->layDanhSachSinhVien($malop);

			$col_masv 				= array_column($dssinhvien, 'ma_sv');

			$tinhtrang 				= $this->tinhtrang->layTinhTrangKhaoSat($hinhthuc, $col_masv, $dot);

			$tinhtrangkssv 			= array();

			foreach ($tinhtrang as $p) {
				if (!isset($tinhtrangkssv[$p['ma_sv']])) {
					$tinhtrangkssv[$p['ma_sv']]	= array(
						'tongphieu' 	=> 0,
						'dakhaosat' 	=> 0,
						'chuakhaosat' 	=> array(),
					);
				}

				$tinhtrangkssv[$p['ma_sv']]['tongphieu']++;

				if ($p['thoigian_khaosat'] != '') {
					$tinhtrangkssv[$p['ma_sv']]['dakhaosat']++;
				}else{
					$tinhtrangkssv[$p['ma_sv']]['chuakhaosat'][] = $p['ten_monhoc'];
				}
			}

			return array(
				'hinhthuc' 			=> $hinhthuc,
				'lop' 				=> $malop,
				'hocvu' 			=> $dot,
				'dssinhvien' 		=> $dssinhvien,
				'tinhtrang' 		=> $tinhtrangkssv,
			);
		}

		private function layKiemTraKhaoSat(){
			if ($this->_session['quyen'] == 'covanhoctap' || $this->_session['quyen'] == 'giaovukhoa') {
				return null;
			}
			$masv 					= $this->input->post('sv');
			$dot 					= $this->input->post('dot');

			$dsphieu 				= $this->tinhtrang->layPhieuSinhVienDot($masv, $dot);
			$ketquaphieu 			= $this->tinhtrang->layKetQuaPhieu(array_column($dsphieu, 'ma_phieu'));

			echo json_encode(array(
				'dsphieu' 			=> $dsphieu,
				'ketqua' 			=> $ketquaphieu,
			));
			exit();
		}

		public function lopMon(){
			$action 					= $this->input->post('action');

			$data['dskhaosat'] 			= $this->tinhtrang->layKhaoSatHocTap();

			if (!$action) {
				$data['khaosat'] 		= $data['dskhaosat'][0]['ma_khaosat'];
				$data['dsdot']	 		= $this->tinhtrang->layDotKhaoSat($data['khaosat'], '1');
				$data['dot'] 			= ($data['dsdot']) ? $data['dsdot'][0]['ma_dotkhaosat'] : -1;
			}

			switch ($action) {
				case 'load-dotkhaosat':
					$makhaosat 			= $this->input->post('khaosat');
					echo json_encode($this->tinhtrang->layDotKhaoSat($makhaosat, '1'));
					exit();
					break;
				case 'loc':
					$data['dot'] 		= $this->input->post('hocvu');
					$data['khaosat'] 	= $this->input->post('hinhthuc');
					$data['dsdot']	 	= $this->tinhtrang->layDotKhaoSat($data['khaosat'], '1');
					break;
				default:
					# code...
					break;
			}

			$data['dslopmon'] 	= $this->tinhtrang->layLopMonKhaoSat($data['dot']);

			$temp['data'] 				= $data;
			$temp['template'] 			= 'khaosat/Vkhaosatlopmon';
    		$this->load->view('layout/Vcontent', $temp);
		}
	}

?>