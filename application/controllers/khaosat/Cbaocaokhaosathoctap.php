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
				$dsdot 				= $this->baocao->layDotKhaoSat($hinhthuc, '1');
				$ma_dks 			= ($dsdot) ? $dsdot[0]['ma_dotkhaosat'] : -1;
			}

			switch ($action) {
				case 'loc':
					$hinhthuc 		= $this->input->post('hinhthuc');
					$dsdot 			= $this->baocao->layDotKhaoSat($hinhthuc, '1');
					$ma_dks 		= $this->input->post('hocvu');
					break;
				case 'load-dotkhaosat':
					$makhaosat 		= $this->input->post('khaosat');
					echo json_encode($this->baocao->layDotKhaoSat($makhaosat, '1'));
					exit();
					break;
				default:
					# code...
					break;
			}

			$baocao 				= $this->createModelData($hinhthuc, $ma_dks);

			$data = array(
				'dskhaosat' 		=> $dskhaosat,
				'dsdot' 			=> $dsdot,
				'baocao' 			=> $baocao,
				'map_linhvuc' 		=> array(),
			);

			$temp['data'] 			= $data;
			$temp['template'] 		= 'khaosat/Vbaocaokhaosathoctap';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function createModelData($hinhthuc, $ma_dks){
			$khaosat 				= $this->baocao->layKhaoSat($hinhthuc);
			$dotkhaosat 			= $this->baocao->getDotKhaoSat($ma_dks);
			$linhvuctinhdiem 		= $this->baocao->layNhomCauHoiKhaoSat($hinhthuc);
			$linhvuctinhdiem 		= handingKeyArray($linhvuctinhdiem, 'ma_nhomcauhoi');

			foreach ($linhvuctinhdiem as $key => $lv) {
				$lv['alias_name'] 		= 'Lĩnh vực ' . $lv['thutu_nhomcauhoi'];
				$lv['hailong'] 			= 0;
				$lv['tongdanhgia'] 		= 0;
				$linhvuctinhdiem[$key] 	= $lv;
			}

			$mon_giangvien 			= $this->baocao->layMonGiangVien($dotkhaosat['ma_donvihocvu'], $khaosat['ma_hinhthuc']);
			$dsphieu 				= $this->baocao->layKetQuaKhaoSat($ma_dks);
			$ketquaphieu 			= $this->baocao->layChiTietKetQua($ma_dks);

			$map_ketquaphieu 		= array();
			foreach ($ketquaphieu as $kq) {
				$map_ketquaphieu[$kq['ma_cb']][$kq['ma_monhoc']][$kq['ma_nhomcauhoi']] = $kq['tongnhom'];
			}

			$map_dsphieu 			= array();
			foreach ($dsphieu as $ct) {
				if (!isset($map_dsphieu[$ct['ma_cb']][$ct['ma_monhoc']])) {
					$map_dsphieu[$ct['ma_cb']][$ct['ma_monhoc']] 	= array();
				}
				$map_dsphieu[$ct['ma_cb']][$ct['ma_monhoc']] 		= $ct;
			}

			$map_baocao 						= array();
			$stt 								= 0;
			foreach ($mon_giangvien as $m) {
				$baocao 						= array(
					'stt' 						=> ++$stt,
					'monhoc' 					=> $m['ten_monhoc'],
					'khoiluong' 				=> '(' . $m['tongkhoiluong'] . ' TC)',
					'tencanbo' 					=> trim($m['hodem_cb']) . ' ' . $m['ten_cb'],
					'hocham' 					=> ($m['ma_hocham'] != '-') ? $m['ma_hocham'] : '',
					'sophieu' 					=> (isset($map_dsphieu[$m['ma_cb']][$m['ma_monhoc']]['sophieu'])) ? $map_dsphieu[$m['ma_cb']][$m['ma_monhoc']]['sophieu'] : 0,
					'dakhaosat' 				=> (isset($map_dsphieu[$m['ma_cb']][$m['ma_monhoc']]['dakhaosat'])) ? $map_dsphieu[$m['ma_cb']][$m['ma_monhoc']]['dakhaosat'] : 0,
					'tylekhaosat' 				=> 0,
					'tonghailong' 				=> 0,
					'hailong' 					=> array(),
				);

				if ($baocao['sophieu'] && $baocao['dakhaosat']){
					$baocao['tylekhaosat'] 		= round(($baocao['dakhaosat'] * 100) / $baocao['sophieu'], 2);
				}

				foreach ($linhvuctinhdiem as $mn => $lv) {
					$hailong 					= (isset($map_ketquaphieu[$m['ma_cb']][$m['ma_monhoc']][$mn])) ? $map_ketquaphieu[$m['ma_cb']][$m['ma_monhoc']][$mn] : 0;

					$lv['hailong'] 				+= $hailong;
					$lv['tongdanhgia'] 			+= $baocao['dakhaosat'];

					$baocao['hailong'][$mn] 	= 0;

					if ($baocao['dakhaosat'] > 0) {
						$baocao['hailong'][$mn] = round(($hailong * 100) / ($lv['socauhoi'] * $baocao['dakhaosat']), 2);
					}
					$baocao['tonghailong'] 		+= $baocao['hailong'][$mn];
					$linhvuctinhdiem[$mn] 		= $lv;
				}

				$baocao['tbhailong'] 			= round($baocao['tonghailong'] / count($linhvuctinhdiem), 2);
				$map_baocao[$m['ma_cb']][$m['ma_monhoc']] 	= $baocao;
			}

			$tongchiso 							= array(
				'hailong' 						=> 0,
				'danhgia' 						=> 0,
			);
			foreach ($linhvuctinhdiem as $mn => $lv) {
				$lv['chiso'] 					= round(($lv['hailong'] * 100) / ($lv['tongdanhgia'] * $lv['socauhoi']), 2);
				$linhvuctinhdiem[$mn] 			= $lv;

				$tongchiso['hailong'] 			+= $lv['hailong'];
				$tongchiso['danhgia'] 			+= $lv['tongdanhgia'] * $lv['socauhoi'];
			}
			
			return array(
				'hinhthuc' 			=> $hinhthuc,
				'hocvu' 			=> $ma_dks,
				'linhvuc' 			=> $linhvuctinhdiem,
				'mapbaocao' 		=> $map_baocao,
				'tongchiso' 		=> $tongchiso,
			);
		}
	}

?>