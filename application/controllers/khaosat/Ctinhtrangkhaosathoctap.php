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
			$dstieuchi 				= array(
				array(
					'ma_tieuchi' 	=> 'all',
					'ten_tieuchi' 	=> '--- Bỏ trống ---',
				),
				array(
					'ma_tieuchi' 	=> 'hoanthanh',
					'ten_tieuchi' 	=> 'Hoàn thành khảo sát',
				),
				array(
					'ma_tieuchi' 	=> 'chuahoanthanh',
					'ten_tieuchi' 	=> 'Chưa hoàn thành khảo sát',
				),
			);

			if (!$action) {
				$hinhthuc 			= $dskhaosat[0]['ma_khaosat'];
				$malop 				= $dslop[0]['ma_lop'];
				$dsdot 				= $this->tinhtrang->layDotKhaoSat($hinhthuc, '1');
				$dot 				= ($dsdot && $dslop) ? $dsdot[0]['ma_dotkhaosat'] : -1;
				$tieuchi 			= $dstieuchi[0]['ma_tieuchi'];
			}

			switch ($action) {
				case 'loc':
					$hinhthuc 		= $this->input->post('hinhthuc');
					$malop 			= $this->input->post('lop');
					$dot 			= $this->input->post('hocvu');
					$tieuchi 		= $this->input->post('tieuchi');
					$dsdot 			= $this->tinhtrang->layDotKhaoSat($hinhthuc, '1');
					break;
				case 'xuatexcel':
					$this->xuatKiemTraKhaoSat();
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

			$tinhtrang 				= $this->layTinhTrangKhaoSat($hinhthuc, $malop, $dot, $tieuchi);
			
			$data = array(
				'dskhaosat' 		=> $dskhaosat,
				'dslop' 			=> $dslop,
				'dsdot' 			=> $dsdot,
				'tinhtrang' 		=> $tinhtrang,
				'dstieuchi' 		=> $dstieuchi
			);

			$temp['data'] 			= $data;
			$temp['template'] 		= 'khaosat/Vtinhtrangkhaosathoctap';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function layTinhTrangKhaoSat($hinhthuc, $malop, $dot, $tieuchi = null){
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

			$dssinhvienloc 			= array();
			if ($tieuchi && $tieuchi != 'all') {
				foreach ($dssinhvien as $sv) {
					if ($tieuchi == 'hoanthanh') {
						if (!isset($tinhtrangkssv[$sv['ma_sv']]) || $tinhtrangkssv[$sv['ma_sv']]['dakhaosat'] == $tinhtrangkssv[$sv['ma_sv']]['tongphieu']) {
							$dssinhvienloc[]	= $sv;
						}
					}elseif ($tieuchi == 'chuahoanthanh') {
						if (isset($tinhtrangkssv[$sv['ma_sv']]) && $tinhtrangkssv[$sv['ma_sv']]['dakhaosat'] != $tinhtrangkssv[$sv['ma_sv']]['tongphieu']) {
							$dssinhvienloc[]	= $sv;
						}
					}
				}
			}else{
				$dssinhvienloc 		= $dssinhvien;
			}

			return array(
				'hinhthuc' 			=> $hinhthuc,
				'lop' 				=> $malop,
				'hocvu' 			=> $dot,
				'dssinhvien' 		=> $dssinhvienloc,
				'tinhtrang' 		=> $tinhtrangkssv,
				'tieuchi' 			=> $tieuchi,
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
				case 'xuatexcel':
					$this->xuatLopMonKhaoSat();
					break;
				default:
					# code...
					break;
			}

			$data['dslopmon'] 			= $this->tinhtrang->layLopMonKhaoSat($data['dot']);

			$temp['data'] 				= $data;
			$temp['template'] 			= 'khaosat/Vkhaosatlopmon';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function xuatLopMonKhaoSat(){
			$dot 						= $this->input->post('hocvu');
			$dslopmon 					= $this->tinhtrang->layLopMonKhaoSat($dot);
			$thongtin 					= array(
				'khoa' 					=> $this->tinhtrang->layDonViCanBo($this->_session['ma_canbo']),
				'hocvu' 				=> $this->tinhtrang->layThongTinDotKhaoSat($dot),
			);

			$this->load->library('Excel');
			$column_end             	= 'G';

            $filename               	= 'Danh sách lớp môn khảo sát - Hình thức đào tạo ' . $thongtin['hocvu']['ma_hinhthuc'] . ' - Học kỳ ' . $thongtin['hocvu']['ma_donvihocvu'];
            $objPHPExcel            	= new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("Administrator")
                ->setLastModifiedBy("Administrator")
                ->setTitle("Danh sách quản lý lớp môn")
                ->setSubject("Danh sách quản lý lớp môn")
                ->setDescription("Danh sách quản lý lớp môn")
                ->setKeywords("office 2003 openxml php")
                ->setCategory("Information of student");
            $objPHPExcel->getDefaultStyle()->getFont()->setName('Times new Roman');

            $start 							= 1;
            $array_content['A' . $start++]  = 'TRƯỜNG ĐẠI HỌC MỞ HÀ NỘI';
            $array_content['A' . $start++]  = 'KHOA ' . $thongtin['khoa']['ten_donvi_upper'];
            $start++;
            $array_content['A' . $start++]	= 'DANH SÁCH LỚP MÔN KHẢO SÁT';
            $array_content['A' . $start++]	= '(Học kỳ: '. $thongtin['hocvu']['ma_donvihocvu'] . ' - Hình thức đào tạo: ' . $thongtin['hocvu']['ma_hinhthuc'] . ')';

            
            $array_column = array(
                'A' => 5,
                'B' => 90,
                'C' => 12,
                'D' => 12,
                'E' => 10,
                'F' => 10,
                'G' => 10,
            );

            /*Thêm border vào tất cả*/
            $style_array                    = array(
                'borders'                   => array(
                    'allborders'            => array(
                        'style'             => PHPExcel_Style_Border::BORDER_THIN
                    ) 
                )
            );

            /*In đậm*/
            $array_bold                     = array(
            	'A1',
            	'A4',
            	'A7:' . $column_end . '7'
            );
            $array_underline                = array(
                'A2'
            );
            $array_italic                   = array(
            	'A5'
            );

            $array_merge                 	= array(
            	'A1:B1',
            	'A2:B2',
            	'A4:' . $column_end . '4',
            	'A5:' . $column_end . '5',
            );
            $array_font_size             	= array(
            	'A1:A2' => 13,
            	'A4' 	=> 15
            );
            $array_row                   	= array(
            	4 		=> 25,
            	7 		=> 40,
            );
            $array_x_align                  = array(
            	'A1:' . $column_end . '7'
            );
            $array_y_align                  = array(

            );
            $array_rigt_align               = array(
                
            );
            
            $array_format_text              = array(

            );
            $array_wrap_text 				= array(
            );
            $start_border                   = ++$start;

            $array_content['A' . $start] 	= 'STT';
            $array_content['B' . $start] 	= 'Tên lớp môn';
            $array_content['C' . $start] 	= 'Ngày bắt đầu khảo sát';
            $array_content['D' . $start] 	= 'Ngày kết thúc khảo sát';
            $array_content['E' . $start] 	= 'Số phiếu hiện có';
            $array_content['F' . $start] 	= 'Số phiếu đã khảo sát';
            $array_content['G' . $start++] 	= 'Ghi chú';
            $objPHPExcel->getActiveSheet()->freezePane('A' . $start);

            $stt 							= 0;
            $tongsophieu                    = 0; 
            $tongdakhaosat                  = 0; 
            foreach ($dslopmon as $lm) {
            	$array_content['A' . $start] 	= ++$stt;
	            $array_content['B' . $start] 	= $lm['ten_lopmon'];
	            $array_content['C' . $start] 	= $lm['nbdks'];
	            $array_content['D' . $start] 	= $lm['nktks'];
	            $array_content['E' . $start] 	= $lm['sophieu'];
	            $array_content['F' . $start++] 	= $lm['hoanthanh'];
                $tongsophieu                    += $lm['sophieu'];
                $tongdakhaosat                  += $lm['hoanthanh'];
            }
            array_push(
                $array_merge,
                'A' . $start . ':D' . $start
            );
            array_push(
                $array_bold,
                'A' . $start . ':' . $column_end . $start
            );
            array_push(
                $array_x_align,
                'A' . $start . ':' . $column_end . $start
            );

            $array_content['A' . $start]    = 'Tổng:';
            $array_content['E' . $start]    = $tongsophieu;
            $array_content['F' . $start++]    = $tongdakhaosat;

			$objPHPExcel->getActiveSheet()->getStyle('A' . $start_border . ':' . $column_end . ($start-1 ))->applyFromArray($style_array);
			array_push(
				$array_x_align,
				'A8:A' . ($start - 1),
				'C8:F' . ($start - 1),
			);

            for ($i = 1; $i < $start_border; $i++) {
                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(-1);  
            }

            for ($i = ($start_border + 1); $i < $start; $i++) {
                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(20);  
            }

            $objPHPExcel->getActiveSheet()->getStyle('A1:' . $column_end . $start)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

            /*foreach (range('A', 'Z') as $column) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
            }*/
            array_push($array_y_align, 'A1:' . $column_end . $start);
            array_push($array_wrap_text, 'A1:' . $column_end . $start);

            foreach ($array_content as $key => $value) {
                $objPHPExcel->getActiveSheet()->setCellValue($key, $value);
            }

            foreach ($array_row as $key => $value) {
                $objPHPExcel->getActiveSheet()->getRowDimension($key)->setRowHeight($value);
            }

            foreach ($array_column as $key => $value) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($key)->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->getColumnDimension($key)->setWidth($value);
            }
            foreach ($array_merge as $cells) {
                $objPHPExcel->getActiveSheet()->mergeCells($cells);
            }

            foreach ($array_wrap_text as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setWrapText(true);
            }

            foreach ($array_bold as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getFont()->setBold(true);
            }

            foreach ($array_underline as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getFont()->setUnderline(true);
            }

            foreach($array_italic as $cell){
                $objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setItalic(true);
            }

            foreach($array_font_size as $key => $value){
                $objPHPExcel->getActiveSheet()->getStyle($key)->getFont()->setSize($value);
            }
            foreach ($array_center_align as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
            foreach ($array_x_align as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
            foreach ($array_y_align as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            }
            
            foreach ($array_rigt_align as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            }
            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setTop(0.5);
            $objPHPExcel->getActiveSheet()
                ->getPageMargins()->setRight(0.5);
            $objPHPExcel->getActiveSheet()
                ->getPageMargins()->setLeft(0.5);
            $objPHPExcel->getActiveSheet()
                ->getPageMargins()->setBottom(0.5);

            ob_end_clean();
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;filename=$filename.xls");
            header("Cache-Control: max-age=0");

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit();
		}

		private function xuatKiemTraKhaoSat(){
			$hinhthuc 				= $this->input->post('hinhthuc');
			$malop 					= $this->input->post('lop');
			$dot 					= $this->input->post('hocvu');
			$tieuchi 				= $this->input->post('tieuchi');

			$thongtin 				= array(
				'khoa' 				=> $this->tinhtrang->layDonViCanBo($this->_session['ma_canbo']),
				'hocvu' 			=> $this->tinhtrang->layThongTinDotKhaoSat($dot),
				'lop' 				=> $this->tinhtrang->layThongTinLopHanhChinh($malop),
			);

			$tinhtrang 				= $this->layTinhTrangKhaoSat($hinhthuc, $malop, $dot, $tieuchi);

			$this->load->library('Excel');
			$column_end             	= 'G';

            $filename               	= 'Danh sách sinh viên khảo sát lớp hành chính - Hình thức đào tạo ' . $thongtin['hocvu']['ma_hinhthuc'] . ' - Học kỳ ' . $thongtin['hocvu']['ma_donvihocvu'] . ' - Lớp: ' . $thongtin['lop']['ten_lop'];
            $objPHPExcel            	= new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("Administrator")
                ->setLastModifiedBy("Administrator")
                ->setTitle("Danh sách quản lý lớp môn")
                ->setSubject("Danh sách quản lý lớp môn")
                ->setDescription("Danh sách quản lý lớp môn")
                ->setKeywords("office 2003 openxml php")
                ->setCategory("Information of student");
            $objPHPExcel->getDefaultStyle()->getFont()->setName('Times new Roman');

            $start 							= 1;
            $array_content['A' . $start++]  = 'TRƯỜNG ĐẠI HỌC MỞ HÀ NỘI';
            $array_content['A' . $start++]  = 'KHOA ' . $thongtin['khoa']['ten_donvi_upper'];
            $start++;
            $array_content['A' . $start++]	= 'DANH SÁCH SINH VIÊN KHẢO SÁT';
            $array_content['A' . $start++]	= '(Học kỳ: '. $thongtin['hocvu']['ma_donvihocvu'] . ' - Hình thức đào tạo: ' . $thongtin['hocvu']['ma_hinhthuc'] . ' - Lớp: ' . $thongtin['lop']['ten_lop'] . ')';

            
            $array_column = array(
                'A' => 5,
                'B' => 20,
                'C' => 25,
                'D' => 12,
                'E' => 8,
                'F' => 8,
                'G' => 45,
            );

            /*Thêm border vào tất cả*/
            $style_array                    = array(
                'borders'                   => array(
                    'allborders'            => array(
                        'style'             => PHPExcel_Style_Border::BORDER_THIN
                    ) 
                )
            );

            /*In đậm*/
            $array_bold                     = array(
            	'A1',
            	'A4',
            	'A7:' . $column_end . '7'
            );
            $array_underline                = array(
                'A2'
            );
            $array_italic                   = array(
            	'A5'
            );

            $array_merge                 	= array(
            	'A1:C1',
            	'A2:C2',
            	'A4:' . $column_end . '4',
            	'A5:' . $column_end . '5',
            );
            $array_font_size             	= array(
            	'A1:A2' => 13,
            	'A4' 	=> 15
            );
            $array_row                   	= array(
            	4 		=> 25,
            	7 		=> 40,
            );
            $array_x_align                  = array(
            	'A1:' . $column_end . '7'
            );
            $array_y_align                  = array(

            );
            $array_rigt_align               = array(
                
            );
            
            $array_format_text              = array(

            );
            $array_wrap_text 				= array(
            );
            $start_border                   = ++$start;

            $array_content['A' . $start] 	= 'STT';
            $array_content['B' . $start] 	= 'Mã sinh viên';
            $array_content['C' . $start] 	= 'Họ tên';
            $array_content['D' . $start] 	= 'Ngày sinh';
            $array_content['E' . $start] 	= 'Giới tính';
            $array_content['F' . $start] 	= 'Tỷ lệ khảo sát';
            $array_content['G' . $start++] 	= 'Môn chưa khảo sát';
            $objPHPExcel->getActiveSheet()->freezePane('A' . $start);

            $stt 							= 0;
            if (empty($tinhtrang['dssinhvien'])) {
            	array_push(
        			$array_merge,
        			'A' . $start . ':' . $column_end . $start,
        		);
        		array_push(
        			$array_x_align,
        			'A' . $start . ':' . $column_end . $start,
        		);
        		array_push(
        			$array_bold,
        			'A' . $start . ':' . $column_end . $start,
        		);
        		$array_content['A' . $start] 		= 'Danh sách trống';
            }else{
	            foreach ($tinhtrang['dssinhvien'] as $sv) {
	            	$array_content['A' . $start] 	= ++$stt;
		            $array_content['B' . $start] 	= $sv['ma_sv'];
		            $array_content['C' . $start] 	= $sv['hodem_sv'] . ' ' . $sv['ten_sv'];
		            $array_content['D' . $start] 	= $sv['ns'];
		            $array_content['E' . $start] 	= $sv['gioitinh_sv'];
		            $array_content['F' . $start] 	= '0/0';

		            if (isset($tinhtrang['tinhtrang'][$sv['ma_sv']])) {
	            		$ttsv 							= $tinhtrang['tinhtrang'][$sv['ma_sv']];
		            	$array_content['F' . $start] 	= $ttsv['dakhaosat'] . '/' . $ttsv['tongphieu'];

		            	if ($ttsv['dakhaosat'] != $ttsv['tongphieu']) {
		            		$sodong 					= $ttsv['tongphieu'] - $ttsv['dakhaosat'] - 1;
		            		array_push(
		            			$array_merge,
		            			'A' . $start . ':A' . ($start + $sodong),
		            			'B' . $start . ':B' . ($start + $sodong),
		            			'C' . $start . ':C' . ($start + $sodong),
		            			'D' . $start . ':D' . ($start + $sodong),
		            			'E' . $start . ':E' . ($start + $sodong),
		            			'F' . $start . ':F' . ($start + $sodong),
		            		);

		            		foreach ($ttsv['chuakhaosat'] as $mcks) {
		            			$array_content['G' . $start++] 	= $mcks;
		            		}
		            		$start--;
		            	}		            	
		            }

		            $start++;
	            }
            }


			$objPHPExcel->getActiveSheet()->getStyle('A' . $start_border . ':' . $column_end . ($start-1 ))->applyFromArray($style_array);
			array_push(
				$array_x_align,
				'A8:B' . ($start - 1),
				'D8:D' . ($start - 1),
				'F8:F' . ($start - 1),
			);

            for ($i = 1; $i < $start_border; $i++) {
                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(-1);  
            }

            for ($i = ($start_border + 1); $i < $start; $i++) {
                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(20);  
            }

            $objPHPExcel->getActiveSheet()->getStyle('A1:' . $column_end . $start)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

            /*foreach (range('A', 'Z') as $column) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
            }*/
            array_push($array_y_align, 'A1:' . $column_end . $start);
            array_push($array_wrap_text, 'A1:' . $column_end . $start);

            foreach ($array_content as $key => $value) {
                $objPHPExcel->getActiveSheet()->setCellValue($key, $value);
            }

            foreach ($array_row as $key => $value) {
                $objPHPExcel->getActiveSheet()->getRowDimension($key)->setRowHeight($value);
            }

            foreach ($array_column as $key => $value) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($key)->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->getColumnDimension($key)->setWidth($value);
            }
            foreach ($array_merge as $cells) {
                $objPHPExcel->getActiveSheet()->mergeCells($cells);
            }

            foreach ($array_wrap_text as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setWrapText(true);
            }

            foreach ($array_bold as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getFont()->setBold(true);
            }

            foreach ($array_underline as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getFont()->setUnderline(true);
            }

            foreach($array_italic as $cell){
                $objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setItalic(true);
            }

            foreach($array_font_size as $key => $value){
                $objPHPExcel->getActiveSheet()->getStyle($key)->getFont()->setSize($value);
            }
            foreach ($array_center_align as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
            foreach ($array_x_align as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
            foreach ($array_y_align as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            }
            
            foreach ($array_rigt_align as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            }
            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setTop(0.5);
            $objPHPExcel->getActiveSheet()
                ->getPageMargins()->setRight(0.5);
            $objPHPExcel->getActiveSheet()
                ->getPageMargins()->setLeft(0.5);
            $objPHPExcel->getActiveSheet()
                ->getPageMargins()->setBottom(0.5);

            ob_end_clean();
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;filename=$filename.xls");
            header("Cache-Control: max-age=0");

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit();
		}
	}

?>