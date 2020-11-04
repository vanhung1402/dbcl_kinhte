<?php

	/**
	 * 
	 */
	class Cdanhgiakhaosathoctap extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('khaosat/Mdanhgiakhaosathoctap', 'danhgia');
		}

		public function index(){
			$dot 				= $this->input->get('dot');
			$monhoc 			= $this->input->get('monhoc');
			$canbo 				= $this->input->get('canbo');

			$data 				= $this->layThongTinChung($dot, $monhoc, $canbo);
			$data['url'] 		= base_url();
			$this->parser->parse('khaosat/Vdanhgiakhaosathoctap', $data);
		}

		private function layThongTinChung($dot, $monhoc = null, $canbo = null){
			// Học vụ
			$dotkhoasat 		= $this->danhgia->layDotKhaoSat($dot);
			if ($dotkhoasat['madm_trangthai_dotkhaosat'] == '0') {
				$filePath 				= './DATA/dotkhaosat/' . $dot . '/danhgia.json';
				$json 					= file_get_contents($filePath);
				$data 			= json_decode($json, true);
				
				if ($monhoc && $canbo) {
					$data['canbomon'] 	= array(
						$canbo 	=> array(
							$monhoc 	=> $data['canbomon'][$canbo][$monhoc],
						),
					);
				}

				return $data;
			}
			$hocky 				= substr($dotkhoasat['ma_donvihocvu'], 0, 1);
			$namhoc 			= substr($dotkhoasat['ma_donvihocvu'], 2);

			// Lĩnh vục tính điểm
			$dslinhvuc 			= $this->danhgia->layNhomCauHoiKhaoSat($dot);
			$dscauhoi 			= $this->danhgia->layCauHoiChuDe(array_column($dslinhvuc, 'ma_nhomcauhoi'));
			$dsdapan 			= $this->danhgia->layDapAn($dscauhoi[0]['ma_cauhoi']);

			// Câu hỏi đóng góp ý kiến
			$dscauhoikhac 		= $this->danhgia->layCauHoiYKien($dot);

			// Cán bộ và môn học
			$dsmonhoc 			= $this->danhgia->layMonHoc($monhoc);
			$dsmonhoc 			= handingKeyArray($dsmonhoc, 'ma_monhoc');
			$dscanbo 			= $this->danhgia->layCanBo($canbo);
			$dscanbo 			= handingKeyArray($dscanbo, 'ma_cb');

			// Đáp án chuẩn cho tính điểm
			$map_dapan 			= array();
			foreach ($dsdapan as $key => $da) {
				$map_dapan[$key] 	= $da['noidung_dapan'];
			}

			// Lấy kết quả các phiếu
			$dsketqua 			= $this->danhgia->layKetQuaDanhGia($dot, $monhoc, $canbo);
			$map_ketqua 		= array();
			$map_phieu			= array();

			foreach ($dsketqua as $kq) {
				if (!isset($map_ketqua[$kq['ma_cb']][$kq['ma_monhoc']])) {
					$map_ketqua[$kq['ma_cb']][$kq['ma_monhoc']] = array(
						'canbo' 		=> trim($dscanbo[$kq['ma_cb']]['hodem_cb']) . ' ' . $dscanbo[$kq['ma_cb']]['ten_cb'],
						'monhoc' 		=> $dsmonhoc[$kq['ma_monhoc']]['ten_monhoc'],
						'khoa' 			=> $dscanbo[$kq['ma_cb']]['ten_donvi'],
						'nhom' 			=> array(),
						'cauhoi' 		=> array(),
						'tongphieu' 	=> 0,
					);

					$map_phieu[$kq['ma_cb']][$kq['ma_monhoc']] 	= array();
				}


				if ($kq['tinhdiem']) {
					if ($kq['giatri_dapan']) {
						if (!isset($map_ketqua[$kq['ma_cb']][$kq['ma_monhoc']]['nhom'][$kq['ma_nhomcauhoi']])) {
							$map_ketqua[$kq['ma_cb']][$kq['ma_monhoc']]['nhom'][$kq['ma_nhomcauhoi']] 	= 0;
						}

						$map_ketqua[$kq['ma_cb']][$kq['ma_monhoc']]['nhom'][$kq['ma_nhomcauhoi']]++;
					}

					if (!isset($map_ketqua[$kq['ma_cb']][$kq['ma_monhoc']]['cauhoi'][$kq['ma_cauhoi']][$kq['noidung_dapan']])) {
						$map_ketqua[$kq['ma_cb']][$kq['ma_monhoc']]['cauhoi'][$kq['ma_cauhoi']][$kq['noidung_dapan']] = 0;
					}

					$map_ketqua[$kq['ma_cb']][$kq['ma_monhoc']]['cauhoi'][$kq['ma_cauhoi']][$kq['noidung_dapan']]++;
					if (!isset($map_phieu[$kq['ma_cb']][$kq['ma_monhoc']][$kq['ma_phieu']])) {
						$map_phieu[$kq['ma_cb']][$kq['ma_monhoc']][$kq['ma_phieu']] 				= 1;
						$map_ketqua[$kq['ma_cb']][$kq['ma_monhoc']]['tongphieu']++;	
					}
				}else{
					if ($kq['ndtraloi']) {
						if (!isset($map_ketqua[$kq['ma_cb']][$kq['ma_monhoc']]['cauhoi'][$kq['ma_cauhoi']])) {
							$map_ketqua[$kq['ma_cb']][$kq['ma_monhoc']]['cauhoi'][$kq['ma_cauhoi']]	= array();
						}

						$map_ketqua[$kq['ma_cb']][$kq['ma_monhoc']]['cauhoi'][$kq['ma_cauhoi']][] 	= $kq['ndtraloi'];
					}
						
				}

			}

			return array(
				'canbomon' 		=> $map_ketqua,
				'hocky' 		=> $hocky,
				'namhoc' 		=> $namhoc,
				'linhvuc' 		=> $dslinhvuc,
				'map_dapan' 	=> $map_dapan,
				'dscauhoi' 		=> handingArrayToMap($dscauhoi, 'ma_nhomcauhoi'),
				'dscauhoikhac' 	=> $dscauhoikhac,
			);
		}
	}

?>