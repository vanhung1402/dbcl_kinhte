<?php

	class Cchuanhoa extends CI_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('chuanhoa/Mchuanhoa');
		}

		public function index(){
			$table = $this->input->post('table');
			switch ($table) {
				case 'tbl_canbo':
					$this->chuanHoaCanBo();
					break;
				case 'tbl_ctdt':
					$this->chuanHoaCTDT();
					break;
				case 'tbl_khoahoc':
					$this->chuanHoaKhoaHoc();
					break;
				case 'tbl_monhoc':
					$this->chuanHoaMonHoc();
					break;
				case 'tbl_chitiet_monhoc':
					$this->chuanHoaChiTietMonHoc();
					break;
				case 'tbl_mon_ctdt':
					$this->chuanHoaMonCTDT();
					break;
				case 'tbl_canbo_monhoc':
					$this->chuanHoaCanBoMonHoc();
					break;
				case 'tbl_lopmon':
					$this->chuanHoaLopMon();
					break;
				case 'tbl_lopmon_monctdt':
					$this->chuanHoaLopMonMonCTDT();
					break;
				case 'tbl_lop':
					$this->chuanHoaLop();
					break;
				case 'tbl_sinhvien':
					$this->chuanHoaSinhVien();
					break;
				case 'tbl_dangkymon':
					$this->chuanHoaDangKyMon();
					break;
				default:
					# code...
					break;
			}


			$data['dstable'] = array('tbl_dangkymon','tbl_dangnhap','tbl_sinhvien','tbl_lop','tbl_lopmon_monctdt','tbl_canbo_lopmon','tbl_lopmon','tbl_canbo_monhoc','tbl_mon_ctdt','tbl_chitiet_monhoc','tbl_monhoc','tbl_khoahoc','tbl_ctdt','tbl_canbo');
			$temp = array(
				'template'	=> 'chuanhoa/Vchuanhoa', 
				'data' 		=> $data,
			);

			$this->load->view("layout/Vcontent",$temp);
		}

		private function chuanHoaDangKyMon(){
			$data_tmas = $this->Mchuanhoa->layDangKyMon();
			$data_dbcl = array();

			foreach ($data_tmas as $row) {
				$data_dbcl[] 	= array(
					'ma_dkm' 				=> $row['ma_dkm'],
					'ma_sv' 				=> $row['ma_sv'],
					'ma_lopmon' 			=> $row['ma_lopmon'],
					'ma_ttdkm' 				=> $row['madm_ttdkm'],
					'ngaydangky' 			=> $row['thoigian'],
					'nguoidangky' 			=> $row['macb'],
				);
			}

			$this->Mchuanhoa->insertBatch('tbl_dangkymon', $data_dbcl);	
		}

		private function chuanHoaSinhVien(){
			$data_tmas = $this->Mchuanhoa->laySinhVien();
			$data_dbcl = array();

			foreach ($data_tmas as $row) {
				$data_dbcl[] 	= array(
					'ma_sv' 				=> $row['ma_sv'],
					'hodem_sv' 				=> $row['hoten_sv'],
					'ten_sv' 				=> $row['ten_sv'],
					'gioitinh_sv' 			=> $row['gioitinh_sv'],
					'ngaysinh_sv' 			=> $row['ngaysinh_sv'],
					'ma_lop' 				=> ($row['ma_lop'] == '') ? '1' : $row['ma_lop'], 
					'ma_trangthai_sinhvien' => 'danghoc',
				);
			}

			$this->Mchuanhoa->insertBatch('tbl_sinhvien', $data_dbcl);
		}

		private function chuanHoaLop(){
			$data_tmas = $this->Mchuanhoa->laylop();
			$data_dbcl = array();

			if (!empty($data_tmas)) {
				$data_dbcl[] = array(
					'ma_lop' 			=> '1',
					'ten_lop' 			=> 'Chưa phân',
					'ma_khoahoc' 		=> $data_tmas[0]['id_khoahoc'],
					'ma_canbo_quanly' 	=> '0',
				);
			}
			foreach ($data_tmas as $row) {
				$data_dbcl[] 	= array(
					'ma_lop' 			=> $row['ma_lop'],
					'ten_lop' 			=> $row['ten_lop'],
					'ma_khoahoc' 		=> $row['id_khoahoc'],
					'ma_canbo_quanly' 	=> ($row['ma_cb'] == '') ? '0' : $row['ma_cb'],
				);
			}

			$this->Mchuanhoa->insertBatch('tbl_lop', $data_dbcl);
		}


		private function chuanHoaLopMonMonCTDT(){
			$data_tmas = $this->Mchuanhoa->laylopMonChuanHoa();
			$data_dbcl = array();

			foreach ($data_tmas as $row) {
				$data_dbcl[] 	= array(
					'ma_lopmon' 	=> $row['ma_lopmon'],
					'ma_mon_ctdt' 	=> $row['ma_mon_ctdt'],
				);
			}

			$this->Mchuanhoa->insertBatch('tbl_lopmon_monctdt', $data_dbcl);
		}


		private function chuanHoaLopMon(){
			$data_tmas = $this->Mchuanhoa->laylopMon();
			$data_dbcl = array();
			$data_extend = array();
			$time = time();

			foreach ($data_tmas as $row) {
				$data_dbcl[] 	= array(
					'ma_lopmon'			 	=> $row['ma_lopmon'],
					'ten_lopmon' 			=> $row['ten_lopmon'],
					'ngaybd' 				=> $row['ngaybatdau'],
					'ngaykt' 				=> $row['ngayketthuc'],
					'ma_canbo_tao' 			=> $row['nguoitao'],
					'ma_monhoc'		 		=> $row['madm_mh'],
					'madm_trangthai_lopmon' => $row['trangthai_hientai'],
					'ma_donvihocvu' 		=> $row['ma_donvihocvu'],
					'ma_hinhthuc' 			=> 'offline',
				);
				$data_extend[] 	= array(
					'ma_cb_lm' 	=> $time++,
					'ma_lopmon' => $row['ma_lopmon'],
					'ma_cb' 	=> $row['ma_cbgv'],
				);
			}

			$this->Mchuanhoa->insertBatch('tbl_lopmon', $data_dbcl);
			$this->Mchuanhoa->insertBatch('tbl_canbo_lopmon', $data_extend);
		}

		private function chuanHoaCanBoMonHoc(){
			$data_tmas = $this->Mchuanhoa->getTmasTable('tbl_canbo_monhoc');
			$data_dbcl = array();

			foreach ($data_tmas as $row) {
				$data_dbcl[] 	= array(
					'ma_canbo' 		=> $row['ma_cb'],
					'ma_monhoc' 	=> $row['madm_mh'],
				);
			}

			$this->Mchuanhoa->insertBatch('tbl_canbo_monhoc', $data_dbcl);
		}

		private function chuanHoaMonCTDT(){
			$data_tmas = $this->Mchuanhoa->getTmasTable('tbl_mon_ctdt');
			$data_dbcl = array();

			foreach ($data_tmas as $row) {
				$data_dbcl[] 	= array(
					'ma_mon_ctdt' 		=> $row['ma_mon_ctdt'],
					'ma_monhoc' 		=> $row['ma_monhoc'],
					'ma_ctdt' 			=> $row['ma_ctdt'],
					'thutu_mon_ctdt' 	=> $row['stt'],
				);
			}

			$this->Mchuanhoa->insertBatch('tbl_mon_ctdt', $data_dbcl);
		}

		private function chuanHoaChiTietMonHoc(){
			$data_tmas = $this->Mchuanhoa->getTmasTable('tbl_chitietmon');
			$data_dbcl = array();

			foreach ($data_tmas as $row) {
				$data_dbcl[] 	= array(
					'ma_monhoc' 		=> $row['madm_mh'],
					'ma_hinhthucmon' 	=> $row['madm_hinhthucmon'],
					'khoiluong' 		=> $row['khoiluong'],
				);
			}

			$this->Mchuanhoa->insertBatch('tbl_chitiet_monhoc', $data_dbcl);
		}

		private function chuanHoaMonHoc(){
			$data_tmas = $this->Mchuanhoa->getTmasTable('dm_monhoc');
			$data_dbcl = array();

			foreach ($data_tmas as $row) {
				$data_dbcl[] 	= array(
					'ma_monhoc' 			=> $row['madm_mh'],
					'ten_monhoc' 			=> trim($row['ten_mh']),
					'ten_viettat_monhoc' 	=> $row['ten_vt_mh'],
					'donvitinh' 			=> $row['donvitinh'],
					'tongkhoiluong' 		=> $row['khoiluong'],
				);
			}

			$this->Mchuanhoa->insertBatch('tbl_monhoc', $data_dbcl);
		}

		private function chuanHoaKhoaHoc(){
			$data_tmas = $this->Mchuanhoa->layKhoaHoc();
			$data_dbcl = array();

			foreach ($data_tmas as $row) {
				$data_dbcl[] 	= array(
					'ma_khoahoc' 	=> $row['id_khoahoc'],
					'namhoc' 		=> $row['nam_khoahoc'],
					'ngaytao' 		=> date('Y-m-d'),
					'ma_ctdt' 		=> $row['ma_ctdt'],
				);
			}

			$this->Mchuanhoa->insertBatch('tbl_khoahoc', $data_dbcl);
		}

		private function chuanHoaCTDT(){
			$data_tmas = $this->Mchuanhoa->getTmasTable('tbl_ctdt');
			$data_dbcl = array();

			foreach ($data_tmas as $row) {
				$data_dbcl[] 	= array(
					'ma_ctdt' 		=> $row['ma_ctdt'],
					'madm_trinhdo' 	=> $row['madm_td'],
					'madm_hedaotao' => $row['madm_hdt'],
					'madm_nganh' 	=> $row['madm_nganh'],
					'nam' 			=> $row['nam'],
				);
			}

			$this->Mchuanhoa->insertBatch('tbl_ctdt', $data_dbcl);
		}

		private function chuanHoaCanBo(){
			$data_tmas = $this->Mchuanhoa->getTmasTable('tbl_canbo');
			$data_dbcl = array();

			foreach ($data_tmas as $row) {
				$data_dbcl[] 	= array(
					'ma_cb' 		=> $row['ma_cb'],
					'hodem_cb' 		=> $row['hoten_cb'],
					'ten_cb' 		=> $row['ten_cb'],
					'gioitinh_cb' 	=> $row['gioitinh_cb'],
					'ngaysinh_cb' 	=> $row['ngaysinh_cb'],
					'ma_donvi' 		=> '06',
					'ma_hocham' 	=> ($row['ma_hochamhocvi'] == '') ? '-' : $row['ma_hochamhocvi'],
				);
			}

			$this->Mchuanhoa->insertBatch('tbl_canbo', $data_dbcl);
		}
	}

?>