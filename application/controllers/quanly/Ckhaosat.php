<?php

	/**
	 * 
	 */
	class Ckhaosat extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('quanly/Mkhaosat');
		}

		public function index(){
			$action 				= $this->input->post('action');
			$khaosat 				= $this->input->get('ma');

			switch ($action) {
				case 'save':
					$this->saveServey();
					break;
				case 'change':
					$this->updateServey($khaosat);
					break;
				case 'xoa-khaosat':
				$this->removeServey();
					break;
				default:
					# code...
					break;
			}

			$data 					= array(
				'dsloaikhaosat' 	=> $this->Mkhaosat->layLoaiKhaoSat(),
				'dshinhthuc' 		=> $this->Mkhaosat->layHinhThucKhaoSat(),
				'dskhaosat' 		=> $this->Mkhaosat->layDanhSachKhaoSat(),
				'khaosatsua' 		=> $this->Mkhaosat->layThongTinKhaoSat($khaosat),
			);

			$temp['data'] 			= $data;
			$temp['template'] 		= 'quanly/Vkhaosat';
    		$this->load->view('layout/Vcontent', $temp);
		}

		public function layDuLieu(){
			$tieude 				= $this->input->post('tieude');
			$noidung 				= $this->input->post('noidung');
			$loai 					= $this->input->post('loai');
			$hinhthuc 				= $this->input->post('hinhthuc');
			$ghichu 				= $this->input->post('ghichu');

			$dataInsert 			= array(
				'tieude_khaosat' 	=> $tieude,
				'madm_loaikhaosat' 	=> $loai,
				'noidung_khaosat' 	=> $noidung,
				'ghichu_khaosat' 	=> $ghichu,
			);

			if ($hinhthuc) {
				$dataInsert['ma_hinhthuc']	= $hinhthuc;
			}

			return $dataInsert;
		}

		private function saveServey(){
			$ma_khaosat 			= time();

			$dataInsert 			= $this->layDuLieu();
			$dataInsert['ma_khaosat'] 	= $ma_khaosat;

			$row_affected 			= $this->Mkhaosat->insertServey($dataInsert);

			if ($row_affected) {
				setMessage('success', 'Đã thêm tạo cuộc khảo sát thành công.');
			}else{
				setMessage('error', 'Đã có lỗi xảy ra, vui lòng thử lại sau!');
			}

			return redirect(base_url('khaosat'), 'refresh');
		}

		private function updateServey($khaosat){
			$dataUpdate 			= $this->layDuLieu();

			$row_affected 			= $this->Mkhaosat->updateServey($khaosat, $dataUpdate);

			if ($row_affected) {
				setMessage('success', 'Đã cập nhập thông tin khảo sát thành công.');
			}else{
				setMessage('error', 'Đã có lỗi xảy ra, vui lòng thử lại sau!');
			}

			return redirect(base_url('khaosat?ma=' . $khaosat), 'refresh');
		}

		private function removeServey(){
			$khaosat 				= $this->input->post('khaosat');

			$row_affected 			= $this->Mkhaosat->removeServey($khaosat);

			if ($row_affected) {
				setMessage('success', 'Đã xóa cuộc khảo sát thành công.');
			}else{
				setMessage('error', 'Đã có lỗi xảy ra, vui lòng thử lại sau!');
			}

			echo json_encode($row_affected);
			exit();
		}

		public function printForm(){
			$ma_khaosat 			= $this->input->get('ma');
			$khaosat 				= $this->Mkhaosat->layThongTinKhaoSat($ma_khaosat);

			$dschude 				= $this->Mkhaosat->layChuDeKhaoSat($ma_khaosat);
			$dscauhoi 				= $this->Mkhaosat->layCauHoiChuDe(array_column($dschude, 'ma_nhomcauhoi'));
			$dsdapan 				= $this->Mkhaosat->layDapAnCauHoi(array_column($dscauhoi, 'ma_cauhoi'));
			$mch_tinhdiem 			= '';
			foreach ($dscauhoi as $ch) {
				if ($ch['tinhdiem'] == '1') {
					$mch_tinhdiem 	= $ch['ma_cauhoi'];
					break;
				}
			}

			$dschude 				= handingArrayToMap($dschude, 'ma_nhomcha');
			$dscauhoi 				= handingArrayToMap($dscauhoi, 'ma_nhomcauhoi');
			$dsdapan 				= handingArrayToMap($dsdapan, 'ma_cauhoi');

			$data		 			= array(
				'url' 				=> base_url(),
				'khaosat' 			=> $khaosat,
				'dschude' 			=> $dschude,
				'dscauhoi' 			=> $dscauhoi,
				'dsdapan' 			=> $dsdapan,
				'mapdapan' 			=> $dsdapan[$mch_tinhdiem],
			);
			$this->parser->parse('quanly/Vphieuhoctap', $data);
		}
	}

?>