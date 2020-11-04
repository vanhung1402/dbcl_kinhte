<?php

	/**
	 * 
	 */
	class Cchitietphieuhoctap extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('khaosat/Mchitietphieuhoctap', 'chitiet');
		}

		public function index(){
			$maphieu 			= $this->input->get('maphieu');
			$lopmon 			= $this->input->get('lopmon');
			$canbo 	 	 		= $this->input->get('canbo');
			$monhoc 	 	 	= $this->input->get('monhoc');
			$masv 		 	 	= $this->input->get('masv');
			$dot 	 	 		= $this->input->get('dot');

			if ($maphieu) {
				$dsphieu 			= array($maphieu);
			}else if ($lopmon) {
				$dsphieu 		= $this->chitiet->layDanhSachPhieuLopMon($lopmon, $dot);
				if (!$dsphieu) {
					echo '<h1>Không có dữ liệu</h1>';
					exit();
				}
				$dsphieu 		= array_column($dsphieu, 'ma_phieu');
				$maphieu 		= $dsphieu[0];
			}else if ($canbo && $monhoc){
				$dsphieu 		= $this->chitiet->layDanhSachPhieuCanBoMonHoc($canbo, $monhoc, $dot);
				if (!$dsphieu) {
					echo '<h1>Không có dữ liệu</h1>';
					exit();
				}
				$dsphieu 		= array_column($dsphieu, 'ma_phieu');
				$maphieu 		= $dsphieu[0];
			}else if ($masv) {
				$dsphieu 		= $this->chitiet->layDanhSachPhieuSinhVien($masv, $dot);
				if (!$dsphieu) {
					echo '<h1>Không có dữ liệu</h1>';
					exit();
				}
				$dsphieu 		= array_column($dsphieu, 'ma_phieu');
				$maphieu 		= $dsphieu[0];
			}else{
				$maphieu 		= $this->chitiet->layPhieuDot($dot);
				$maphieu 		= $maphieu['ma_phieu'];
				$thongtinphieu 	= $this->chitiet->layThongTinPhieuDot($dot);
				$ketquakhaosat 	= $this->chitiet->layKetQuaKhaoSatDot($dot);
			}

			if (isset($thongtinphieu)) {
				$data 				= $this->xuLyDuLieu($maphieu, array(), $thongtinphieu, $ketquakhaosat);
			}else{
				$data 				= $this->xuLyDuLieu($maphieu, $dsphieu);
			}

			$this->parser->parse('khaosat/Vchitietphieuhoctap', $data);
		}

		private function xuLyDuLieu($maphieu, $dsphieu, $thongtinphieu = null, $ketquakhaosat = null){
			$khaosat 			= $this->chitiet->layMaKhaoSat($maphieu);

			$dschude 			= $this->chitiet->layChuDeKhaoSat($khaosat['ma_khaosat']);
			$dscauhoi 			= $this->chitiet->layCauHoiChuDe(array_column($dschude, 'ma_nhomcauhoi'));
			$mch_tinhdiem 			= '';
			foreach ($dscauhoi as $ch) {
				if ($ch['tinhdiem'] == '1') {
					$mch_tinhdiem 	= $ch['ma_cauhoi'];
					break;
				}
			}
			$dsdapan 			= $this->chitiet->layDapAnCauHoi(array_column($dscauhoi, 'ma_cauhoi'));
			if (!$thongtinphieu && !$ketquakhaosat) {
				$thongtinphieu 		= $this->chitiet->layThongTinPhieu($dsphieu);
				$ketquakhaosat 		= $this->chitiet->layKetQuaKhaoSat($dsphieu);
			}

			$ketquakhaosat 		= $this->handingForm($ketquakhaosat);

			$dschude 			= handingArrayToMap($dschude, 'ma_nhomcha');
			$dscauhoi 			= handingArrayToMap($dscauhoi, 'ma_nhomcauhoi');
			$dsdapan 			= handingArrayToMap($dsdapan, 'ma_cauhoi');

			$data 				= array(
				'url' 			=> base_url(),
				'maphieu' 		=> $maphieu,
				'khaosat' 		=> $khaosat,
				'dschude' 		=> $dschude,
				'dscauhoi' 		=> $dscauhoi,
				'dsdapan' 		=> $dsdapan,
				'ttphieu' 		=> $thongtinphieu,
				'kqphieu' 		=> $ketquakhaosat,
				'mapdapan' 		=> $dsdapan[$mch_tinhdiem],
			);

			return $data;
		}

		private function handingForm($result){
			$result 			= handingArrayToMap($result, 'ma_phieu');
			foreach ($result as $mp => $nd) {
				$result[$mp] 	= $this->handingAnswer($nd);
			}
			
			return $result;
		}

		private function handingAnswer($listAnswer){
			$answer 			= array();

			foreach ($listAnswer as $ans) {
				if (!isset($answer[$ans['ma_cauhoi']])) {
					$answer[$ans['ma_cauhoi']] 	= array();
				}

				if ($ans['tinhdiem']) {
					$answer[$ans['ma_cauhoi']][$ans['dapan']] 		= $ans['noidung_dapan'];
				}else{
					$answer[$ans['ma_cauhoi']][$ans['ma_dapan']] 	= $ans['noidung_dapan'];
				}
			}

			return $answer;
		}
	}


?>