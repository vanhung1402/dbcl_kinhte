<?php

	/**
	 * 
	 */
	class Mdanhsachsinhvien extends MY_Model{
		function __construct(){
			parent::__construct();
		}

		public function layDanhSachLop($macb = null){
			if ($macb != null) {
				$this->db->where('ma_canbo_quanly', $macb);
			}
			$this->db->from('tbl_lop');
			$this->db->order_by('ten_lop');
			return $this->db->get()->result_array();
		}

		public function layDanhSachSinhVienLop($malop){
			$this->db->select('*, DATE_FORMAT(ngaysinh_sv, "%d/%m/%Y") as ns');
			$this->db->where('ma_lop', $malop);
			$this->db->from('tbl_sinhvien sv');
			$this->db->join('dm_trangthai_sinhvien ttsv', 'sv.ma_trangthai_sinhvien = ttsv.ma_trangthai_sinhvien', 'inner');
			$this->db->order_by('ten_sv');
			return $this->db->get()->result_array();
		}

		public function doiMatKhauSinhVien($username, $password){
			$where 			= array(
				'ten_dangnhap' 	=> $username,
				'ma_sv' 		=> $username,
				'ma_quyen' 		=> 'sinhvien',
			);
			$this->db->where($where);
			$this->db->update('tbl_dangnhap', array(
				'matkhau_dangnhap' 	=> sha1($password)
			));

			return $this->db->affected_rows();
		}
	}

?>