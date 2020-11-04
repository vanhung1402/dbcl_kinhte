<?php

	/**
	 * 
	 */
	class Cthongkekhaosathoctap extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('khaosat/Mthongkekhaosathoctap', 'thongke');
		}

		public function index(){
			$action 				= $this->input->post('action');

			$dskhaosat 				= $this->thongke->layKhaoSatHocTap();
			if (!$action && $dskhaosat) {
				$hinhthuc 			= $dskhaosat[0]['ma_khaosat'];
				$dsdot 				= $this->thongke->layDotKhaoSat($hinhthuc, '1');
				$dot 				= $dsdot[0]['ma_dotkhaosat'];
			}

			switch ($action) {
				case 'loc':
					$hinhthuc 		= $this->input->post('hinhthuc');
					$dot 			= $this->input->post('hocvu');
					$dsdot 			= $this->thongke->layDotKhaoSat($hinhthuc, '1');

					break;
				case 'load-dotkhaosat':
					$makhaosat 		= $this->input->post('khaosat');
					echo json_encode($this->thongke->layDotKhaoSat($makhaosat, '1'));
					exit();
					break;
				default:
					# code...
					break;
			}
			$data 					= $this->layDuLieu($hinhthuc, $dot);
			$data['dskhaosat'] 		= $dskhaosat;
			$data['dsdot'] 			= isset($dsdot) ? $dsdot : array();	

			$temp['data'] 			= $data;
			$temp['template'] 		= 'khaosat/Vthongkekhaosathoctap';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function layDuLieu($hinhthuc, $dot){
			$dslop 					= handingKeyArray($this->thongke->layDanhSachLop(), 'ma_lop');
			$dssvlop 				= handingArrayToMap($this->thongke->layDanhSachKhaoSatLop($dot), 'ma_lop');

			$dschuakhaosat 			= array();

			foreach ($dssvlop as $ml => $dssv) {
				$dschuakhaosat[$ml] 	= 0;

				foreach ($dssv as $sv) {
					if ($sv['sophieu'] != $sv['dakhaosat']) {
						$dschuakhaosat[$ml]++;
					}
				}
			}

			return array(
				'hinhthuc' 			=> $hinhthuc,
				'hocvu' 			=> $dot,
				'dslop' 			=> $dslop,
				'dschuakhaosat' 	=> $dschuakhaosat,
			);
		}
	}

?>