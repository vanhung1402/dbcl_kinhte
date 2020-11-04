<?php

	class Cimportdangkymon extends MY_Controller{
		function __construct(){
			parent::__construct();
        	$this->load->Model('hethong/Mxeplopmon');
		}

		public function index(){
			$action 					= $this->input->post('action');
			switch ($action) {
				case 'import':
					$data 				= $this->importDangKyMon();

					if (!$data) {
						return redirect('importdangkymon', 'refresh');
					}
					break;
				case 'xoadkmtam':
					$this->Mxeplopmon->removeDangKyMonTam(0);
					break;
				default:
					break;
			}

			$data['title'] 				= 'Import đăng ký môn | Hệ thống Đảm bảo chất lượng Trường Đại học Mở Hà Nội';
			$temp['data'] 				= $data;
			$temp['template'] 			= 'import/Vimportdangkymon';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function importDangKyMon(){
			$this->load->library('Excel');
			$dsdangkymon 			= array();
			$dsdangkymonloi 		= array();

			if($_FILES['file_import']['error'] == 0){
	            $data 				= PHPExcel_IOFactory::load($_FILES['file_import']['tmp_name']);
	            $sheetData 			= $data->getActiveSheet()->toArray(null, true, true, true);
	            $sohang 			= 1;
				$madk 				= 'SVLM' . date("dmyhi") . 'import';
				$macanbo 			= $this->_session['ma_canbo'];
				$date 				= date('d/m/Y');

				$dssinhvien 		= $this->Mxeplopmon->layDanhSachSinhVien();
				$dssinhvien 		= handingKeyArray($dssinhvien, 'ma_sv');

				$dslopmon 			= $this->Mxeplopmon->layDanhSachLopMon();
				$dslopmon 			= handingKeyArray($dslopmon, 'ma_lopmon');

				$hasError 			= false;

	            foreach ($sheetData as $row){
	                if ($sohang >= 2 && !empty($row['B']) && !empty($row['C'])) {
	                    $masinhvien = trim($row['B']);
	                    $malopmon 	= trim($row['C']);
	                    $madkmon 	= $madk . ($sohang);

	                    if (!isset($dssinhvien[$masinhvien]) || !isset($dslopmon[$malopmon])) {
	                    	$dsdangkymonloi[] 	= array(
		                        'ma_sv'      	=> $masinhvien,
		                        'ma_lopmon'  	=> $malopmon,
		                    );
		                    $hasError 			= true;
	                    }

	                    if (!$hasError) {
		                	$dsdangkymon[] = array(
		                        'ma_dkm'     	=> $madkmon,
		                        'ma_sv'      	=> $masinhvien,
		                        'ma_lopmon'  	=> $malopmon,
		                        'ngaydangky' 	=> $date,
		                        'ma_ttdkm' 		=> 'dukien',
		                        'nguoidangky' 	=> $macanbo,
		                    );
	                    }
	                }
	                $sohang++;
	            }
	            unlink($_FILES['file_import']['tmp_name']);
	        }

			if ($dsdangkymon && empty($dsdangkymonloi)) {
	            $insertRow 			= $this->Mxeplopmon->insertBatch('tbl_dangkymon', $dsdangkymon);

	            if ($insertRow) {
	            	setMessage('success', 'Đã import các đăng ký môn hợp lệ');
	            }else{
	            	setMessage('error', 'Không thành công, vui lòng kiểm tra danh sách lỗi');
	            }

	            return null;
			}else if (!empty($dsdangkymonloi)) {
				return array(
					'dkmloi' 		=> $dsdangkymonloi,
					'dssinhvien' 	=> $dssinhvien,
					'dslopmon' 		=> $dslopmon,
				);
			}

		}
	}

?>