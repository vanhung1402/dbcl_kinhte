<?php

	/**
	 * 
	 */
	class Cbaocaokhaosathoctap extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('khaosat/Mbaocaokhaosathoctap', 'baocao');
		}

		public function index(){
			$action 				= $this->input->post('action');

			$dskhaosat 				= $this->baocao->layKhaoSatHocTap();
			if (!$action) {
				$hinhthuc 			= $dskhaosat[0]['ma_khaosat'];
				$dsdot 				= $this->baocao->layDotKhaoSat($hinhthuc, '0');
				$ma_dks 			= ($dsdot) ? $dsdot[0]['ma_dotkhaosat'] : -1;
			}

			switch ($action) {
				case 'loc':
					$hinhthuc 		= $this->input->post('hinhthuc');
					$dsdot 			= $this->baocao->layDotKhaoSat($hinhthuc, '0');
					$ma_dks 		= $this->input->post('hocvu');
					break;
				case 'load-dotkhaosat':
					$makhaosat 		= $this->input->post('khaosat');
					echo json_encode($this->baocao->layDotKhaoSat($makhaosat, '0'));
					exit();
					break;
				default:
					# code...
					break;
			}

			$baocao 				= $this->layBaoCao($ma_dks);

			$data = array(
				'dskhaosat' 		=> $dskhaosat,
				'dsdot' 			=> $dsdot,
				'baocao' 			=> $baocao,
				'map_linhvuc' 		=> array(),
			);

			$temp['data'] 			= $data;
			$temp['template'] 		= 'luutru/Vbaocaokhaosathoctap';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function layBaoCao($ma_dks){
			$filePath 				= './DATA/dotkhaosat/' . $ma_dks . '/baocao.json';
			$json 					= file_get_contents($filePath);
			$data 					= json_decode($json, true);
			return $data;
		}
	}

?>