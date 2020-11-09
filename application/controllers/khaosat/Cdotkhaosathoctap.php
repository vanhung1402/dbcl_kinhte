<?php
 
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Cdotkhaosathoctap extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('khaosat/Mdotkhaosathoctap');
		}

		public function index(){
			$ma_khaosat 			= $this->input->get('khaosat');
			$action 				= $this->input->post('action');
			$maxoadot 				= $this->input->post('xoadot');
			$masuadot 				= $this->input->post('luu-dotkhaosat');
			$makhoadot 				= $this->input->post('khoadot');

			$dskhaosat 				= $this->Mdotkhaosathoctap->layKhaoSatHocTap();

			if ($dskhaosat && !$ma_khaosat) {
				return redirect('khaosathoctap/dot?khaosat=' . $dskhaosat[0]['ma_khaosat'], 'refresh');
			}

			if ($makhoadot) {
				$this->khoaDotKhaoSat($makhoadot);
			}

			if ($maxoadot != '') {
				$row_changed 		= $this->Mdotkhaosathoctap->xoaDotKhaoSat($maxoadot);

				if ($row_changed > 0) {
					setMessage('success', 'Đã xóa đợt khảo sát');
				}else{
					setMessage('error', 'Chưa có dữ liệu nào được xóa!');
				}
				return redirect('khaosathoctap/dot?khaosat=' . $ma_khaosat, 'refresh');
				exit();
			}

			if ($masuadot) {
				$this->changeMocKhaoSatDotKhaoSat($masuadot);
			}

			switch ($action) {
				case 'load-lopmon':
					$this->loadLopMon();
					break;
				case 'change-mockhaosat-lopmon':
					$this->changeMocKhaoSatLopMon();
					break;
				case 'change-mockhaosat-all':
					$this->changeMocKhaoSat();
					break;
				case 'create-survey-form':
					$this->createSurveyForm();
					break;
				case 'remove-survey-form':
					$this->removeSurveyForm();
					break;
				case 'them-dotkhaosat':
					$this->themDotKhaoSat();
					break;
				default:
					break;
			}
			

			$ds_dotkhaosat 			= $this->Mdotkhaosathoctap->layDanhSachDotKhaoSat($ma_khaosat, '1');

			$data 					= array(
				'ma_khaosat' 		=> $ma_khaosat,
				'dskhaosat' 		=> $dskhaosat,
				'khaosat' 			=> $this->Mdotkhaosathoctap->layThongTinKhaoSat($ma_khaosat),
				'ds_dotkhaosat' 	=> $ds_dotkhaosat,
				'today' 			=> date('Y-m-d'),
				'donvihocvu' 		=> $this->Mdotkhaosathoctap->layDonViHocVu(),
			);

			$temp['data'] 			= $data;
			$temp['template'] 		= 'khaosat/Vdotkhaosathoctap';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function loadLopMon(){
			$ma_khaosat 			= $this->input->get('khaosat');
			$ma_dotkhaosat 			= $this->input->post('ma_dotkhaosat');

			$khaosat 				= $this->Mdotkhaosathoctap->layThongTinKhaoSat($ma_khaosat);
			$dotkhaosat 			= $this->Mdotkhaosathoctap->layDotKhaoSat($ma_dotkhaosat);

			$dslopmon 				= $this->Mdotkhaosathoctap->layDanhSachLopMon($khaosat['ma_hinhthuc'], $dotkhaosat['ma_donvihocvu'], $ma_dotkhaosat);

			echo json_encode($dslopmon);
			exit();
		}

		private function changeMocKhaoSatLopMon(){
			$ma_lopmon 				= $this->input->post('lopmon');
			// $mockhaosat 			= $this->input->post('moc');
			$nbdks 					= $this->input->post('nbdks');
			$nktks 					= $this->input->post('nktks');

			// $row_changed 			= $this->Mdotkhaosathoctap->setMocKhaoSatLopMon(array($ma_lopmon), $mockhaosat);
			$row_changed 			= $this->Mdotkhaosathoctap->setThoiGianSatLopMon(array($ma_lopmon), $nbdks, $nktks);

			echo json_encode($row_changed);
			exit();
		}

		private function changeMocKhaoSat(){
			$mockhaosat 			= $this->input->post('moc');
			// $ma_dotkhaosat 			= $this->input->post('dotkhaosat');
			$nbdks 					= $this->input->post('nbdks');
			$nktks 					= $this->input->post('nktks');
			$ds_lopmon 				= json_decode($this->input->post('lopmon'), true);

			if ($ds_lopmon <= 0) {
				exit();
			}

			// $row_changed 			= $this->Mdotkhaosathoctap->setMocKhaoSatLopMon($ds_lopmon, $mockhaosat);
			$row_changed 			= $this->Mdotkhaosathoctap->setThoiGianSatLopMon($ds_lopmon, $nbdks, $nktks);

			echo json_encode($row_changed);
			exit();
		}

		private function createSurveyForm(){
			$ma_dotkhaosat 			= $this->input->post('dotkhaosat');
			$ds_lopmon 				= json_decode($this->input->post('lopmon'), true);

			if ($ds_lopmon <= 0) {
				exit();
			}

			$row_changed 			= $this->Mdotkhaosathoctap->createSurveyForm($ds_lopmon, $ma_dotkhaosat);

			echo json_encode($row_changed);
			exit();
		}

		private function removeSurveyForm(){
			$ma_dotkhaosat 			= $this->input->post('dotkhaosat');
			$ds_lopmon 				= json_decode($this->input->post('lopmon'), true);

			if ($ds_lopmon <= 0) {
				exit();
			}

			$row_changed 			= $this->Mdotkhaosathoctap->removeSurveyForm($ds_lopmon, $ma_dotkhaosat);

			echo json_encode($row_changed);
			exit();
		}

		private function themDotKhaoSat(){
			$ma_khaosat 			= $this->input->get('khaosat');
			$donvihocvu 			= $this->input->post('dvhv');
			$timerange 				= $this->input->post('daterange');
			$timerange 				= explode(' - ', $timerange);

			$max_madotkhaosat 		= $this->Mdotkhaosathoctap->getMaxMaDotKhaoSat();

			$check 					= $this->Mdotkhaosathoctap->kiemTraDotKhaoSat($ma_khaosat, $donvihocvu);

			if ($check) {
				setMessage('error', 'Đơn vị học vụ này đã có đợt khảo sát!');
			}else{
				$dotkhaosat 			= array(
					'ma_dotkhaosat' 	=> $max_madotkhaosat + 1,
					'thoigianbd' 		=> date('Y-m-d'),
					'thoigiankt' 		=> date('Y-m-d'),
					'ma_donvihocvu' 	=> $donvihocvu,
					'ma_khaosat' 		=> $ma_khaosat,
					'madm_trangthai_dotkhaosat'	=> '1',
				);

				$row_changed 			= $this->Mdotkhaosathoctap->themDotKhaoSat($dotkhaosat);

				if ($row_changed > 0) {
					setMessage('success', 'Đã thêm đợt khảo sát mới');
				}else{
					setMessage('error', 'Chưa có dữ liệu nào được thêm!');
				}
			}

			return redirect('khaosathoctap/dot?khaosat=' . $ma_khaosat, 'refresh');
			exit();
		}

		private function reverseDate($date){
			$new_date 					= explode('/', $date);
			$new_date 					= array_reverse($new_date);
			$new_date 					= implode('-', $new_date);

			return $new_date;
		}
		
		private function changeMocKhaoSatDotKhaoSat($ma_dotkhaosat){
			$ma_khaosat 			= $this->input->get('khaosat');
			$timerange 				= $this->input->post('daterange-change');
			$timerange 				= explode(' - ', $timerange);

			$array_change 			= array(
				'thoigianbd' 		=> $this->reverseDate($timerange[0]),
				'thoigiankt' 		=> $this->reverseDate($timerange[1]),
			);

			$row_changed 			= $this->Mdotkhaosathoctap->updateDotKhaoSat($ma_dotkhaosat, $array_change);
			if ($row_changed) {
				setMessage('success', 'Đã lưu thay đổi.');
			}else{
				setMessage('error', 'Không có thay đổi nào được ghi nhận!');
			}

			return redirect('khaosathoctap/dot?khaosat=' . $ma_khaosat, 'refresh');
		}

		private function khoaDotKhaoSat($makhoadot){
			$ma_khaosat 			= $this->input->get('khaosat');
			$baocao 				= $this->saveBaoCao($makhoadot);
			$danhgia 				= $this->saveDanhGia($makhoadot);
			$phieu 					= $this->savePhieu($makhoadot);
			
			if ($baocao && $danhgia && $phieu) {
				$row_changed 			= $this->Mdotkhaosathoctap->khoaDotKhaoSat($makhoadot);
				if ($row_changed) {
					setMessage('success', 'Đã khóa đợt khảo sát thành công.');
				}else{
					setMessage('error', 'Không có thay đổi nào được ghi nhận!');
				}
			}

			return redirect('khaosathoctap/dot?khaosat=' . $ma_khaosat, 'refresh');
		}

		private function saveBaoCao($makhoadot){
			$ma_khaosat 			= $this->input->get('khaosat');
			$baocao 				= $this->duLieuBaoCao($ma_khaosat, $makhoadot);
			$baocao 				= json_encode($baocao);

			if (!is_dir('./DATA/dotkhaosat'))
			{
			   //Tạo thư mục
				mkdir('./DATA/dotkhaosat', 0777, true);
			}
			if (!is_dir('./DATA/dotkhaosat/' . $makhoadot))
			{
			   //Tạo thư mục
				mkdir('./DATA/dotkhaosat/' . $makhoadot, 0777, true);
			}
			$filePath 				= './DATA/dotkhaosat/' . $makhoadot . '/baocao.json';
			$objFile 				= fopen($filePath, "w") or die("Unable to open file 'baocao'!");
			$fileWrite 				= fwrite($objFile, $baocao);
			fclose($objFile);
			return $fileWrite;
		}

		private function saveDanhGia($makhoadot){
			$danhgia 				= $this->duLieuDanhGia($makhoadot);
			$danhgia 				= json_encode($danhgia);

			if (!is_dir('./DATA/dotkhaosat'))
			{
			   //Tạo thư mục
				mkdir('./DATA/dotkhaosat', 0777, true);
			}
			if (!is_dir('./DATA/dotkhaosat/' . $makhoadot))
			{
			   //Tạo thư mục
				mkdir('./DATA/dotkhaosat/' . $makhoadot, 0777, true);
			}
			$filePath 				= './DATA/dotkhaosat/' . $makhoadot . '/danhgia.json';
			$objFile 				= fopen($filePath, "w") or die("Unable to open file 'danhgia'!");
			$fileWrite 				= fwrite($objFile, $danhgia);
			fclose($objFile);
			return $fileWrite;
		}

		private function savePhieu($makhoadot){
			$phieu 					= $this->duLieuPhieu($makhoadot);
			$phieu 					= json_encode($phieu);

			if (!is_dir('./DATA/dotkhaosat'))
			{
			   //Tạo thư mục
				mkdir('./DATA/dotkhaosat', 0777, true);
			}
			if (!is_dir('./DATA/dotkhaosat/' . $makhoadot))
			{
			   //Tạo thư mục
				mkdir('./DATA/dotkhaosat/' . $makhoadot, 0777, true);
			}
			$filePath 				= './DATA/dotkhaosat/' . $makhoadot . '/phieu.json';
			$objFile 				= fopen($filePath, "w") or die("Unable to open file 'phieu'!");
			$fileWrite 				= fwrite($objFile, $phieu);
			fclose($objFile);
			return $fileWrite;
		}

		private function duLieuPhieu($dot){
			$this->load->model('khaosat/Mchitietphieuhoctap', 'chitiet');
			$maphieu 			= $this->chitiet->layPhieuDot($dot);
			$maphieu 			= $maphieu['ma_phieu'];
			$thongtinphieu 		= $this->chitiet->layThongTinPhieuDot($dot);
			$ketquakhaosat 		= $this->chitiet->layKetQuaKhaoSatDot($dot);
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
			$ketquakhaosat 		= $this->handingForm($ketquakhaosat);

			$dschude 			= handingArrayToMap($dschude, 'ma_nhomcha');
			$dscauhoi 			= handingArrayToMap($dscauhoi, 'ma_nhomcauhoi');
			$dsdapan 			= handingArrayToMap($dsdapan, 'ma_cauhoi');
			return array(
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

		private function duLieuDanhGia($dot, $canbo = null, $monhoc = null){
			$this->load->model('khaosat/Mdanhgiakhaosathoctap', 'danhgia');
			// Học vụ
			$dotkhoasat 		= $this->danhgia->layDotKhaoSat($dot);
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

		private function duLieuBaoCao($hinhthuc, $ma_dks){
			$this->load->model('khaosat/Mbaocaokhaosathoctap', 'baocao');
			$khaosat 				= $this->baocao->layKhaoSat($hinhthuc);
			$dotkhaosat 			= $this->baocao->getDotKhaoSat($ma_dks);
			$linhvuctinhdiem 		= $this->baocao->layNhomCauHoiKhaoSat($hinhthuc);
			$linhvuctinhdiem 		= handingKeyArray($linhvuctinhdiem, 'ma_nhomcauhoi');

			foreach ($linhvuctinhdiem as $key => $lv) {
                $lv['alias_name']       = 'Lĩnh vực ' . $lv['thutu_nhomcauhoi'];
                $lv['hailong']          = 0;
                $lv['tongdanhgia']      = 0;
                $linhvuctinhdiem[$key]  = $lv;
            }

            $mon_giangvien          = $this->baocao->layMonGiangVien($dotkhaosat['ma_donvihocvu'], $khaosat['ma_hinhthuc']);
            $dsphieu                = $this->baocao->layKetQuaKhaoSat($ma_dks);
            $ketquaphieu            = $this->baocao->layChiTietKetQua($ma_dks);

            $map_ketquaphieu        = array();
            foreach ($ketquaphieu as $kq) {
                $map_ketquaphieu[$kq['ma_cb']][$kq['ma_monhoc']][$kq['ma_nhomcauhoi']] = $kq['tongnhom'];
            }

            $map_dsphieu            = array();
            foreach ($dsphieu as $ct) {
                if (!isset($map_dsphieu[$ct['ma_cb']][$ct['ma_monhoc']])) {
                    $map_dsphieu[$ct['ma_cb']][$ct['ma_monhoc']]    = array();
                }
                $map_dsphieu[$ct['ma_cb']][$ct['ma_monhoc']]        = $ct;
            }

            $map_baocao                         = array();
            $stt                                = 0;
            foreach ($mon_giangvien as $m) {
                $baocao                         = array(
                    'stt'                       => ++$stt,
                    'monhoc'                    => $m['ten_monhoc'],
                    'khoiluong'                 => '(' . $m['tongkhoiluong'] . ' TC)',
                    'tencanbo'                  => trim($m['hodem_cb']) . ' ' . $m['ten_cb'],
                    'hocham'                    => ($m['ma_hocham'] != '-') ? $m['ma_hocham'] : '',
                    'sophieu'                   => (isset($map_dsphieu[$m['ma_cb']][$m['ma_monhoc']]['sophieu'])) ? $map_dsphieu[$m['ma_cb']][$m['ma_monhoc']]['sophieu'] : 0,
                    'dakhaosat'                 => (isset($map_dsphieu[$m['ma_cb']][$m['ma_monhoc']]['dakhaosat'])) ? $map_dsphieu[$m['ma_cb']][$m['ma_monhoc']]['dakhaosat'] : 0,
                    'tylekhaosat'               => 0,
                    'tonghailong'               => 0,
                    'hailong'                   => array(),
                );

                if ($baocao['sophieu'] && $baocao['dakhaosat']){
                    $baocao['tylekhaosat']      = round(($baocao['dakhaosat'] * 100) / $baocao['sophieu'], 2);
                }

                foreach ($linhvuctinhdiem as $mn => $lv) {
                    $hailong                    = (isset($map_ketquaphieu[$m['ma_cb']][$m['ma_monhoc']][$mn])) ? $map_ketquaphieu[$m['ma_cb']][$m['ma_monhoc']][$mn] : 0;

                    $lv['hailong']              += $hailong;
                    $lv['tongdanhgia']          += $baocao['dakhaosat'];

                    $baocao['hailong'][$mn]     = 0;

                    if ($baocao['dakhaosat'] > 0) {
                        $baocao['hailong'][$mn] = round(($hailong * 100) / ($lv['socauhoi'] * $baocao['dakhaosat']), 2);
                    }
                    $baocao['tonghailong']      += $baocao['hailong'][$mn];
                    $linhvuctinhdiem[$mn]       = $lv;
                }

                $baocao['tbhailong']            = round($baocao['tonghailong'] / count($linhvuctinhdiem), 2);
                $map_baocao[$m['ma_cb']][$m['ma_monhoc']]   = $baocao;
            }

            $tongchiso                          = array(
                'hailong'                       => 0,
                'danhgia'                       => 0,
            );
            foreach ($linhvuctinhdiem as $mn => $lv) {
                $lv['chiso']                    = round(($lv['hailong'] * 100) / ($lv['tongdanhgia'] * $lv['socauhoi']), 2);
                $linhvuctinhdiem[$mn]           = $lv;

                $tongchiso['hailong']           += $lv['hailong'];
                $tongchiso['danhgia']           += $lv['tongdanhgia'] * $lv['socauhoi'];
            }
            
            return array(
                'hinhthuc'          => $hinhthuc,
                'hocvu'             => $ma_dks,
                'linhvuc'           => $linhvuctinhdiem,
                'mapbaocao'         => $map_baocao,
                'tongchiso'         => $tongchiso,
            );
		}
	}

?>