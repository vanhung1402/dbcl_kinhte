<?php

	/**
	 * 
	 */
	class Mtaikhoan extends MY_Model{
		function __construct(){
			parent::__construct();
		}

		public function layDanhSachQuyen($quyen){
			$quyenkhac 			= array(
				'sinhvien'
			);

			if ($quyen != 'phongkhaothi' && $quyen != 'chunhiemkhoa') {
				$quyenkhac[] 	= 'phongkhaothi';
				$quyenkhac[] 	= 'chunhiemkhoa';
			}

			$this->db->where_not_in('ma_quyen', $quyenkhac);
			$this->db->order_by('uutien_quyen');
			return $this->db->get('tbl_quyen')->result_array();
		}

		public function checkCanBo($ma_canbo){
			$this->db->where('ma_canbo', $ma_canbo);
			return $this->db->get('tbl_dangnhap')->row_array();
		}

		public function checkUser($ten_dangnhap, $ma_canbo){
			$this->db->where('ten_dangnhap', $ten_dangnhap);
			$this->db->where("ma_canbo NOT LIKE '$ma_canbo'");
			return $this->db->get('tbl_dangnhap')->row_array();
		}

		public function layCanBoChuaCoTaiKhoan(){
			$this->db->select('cb.*');
			$this->db->from('tbl_canbo cb');
			$this->db->join('tbl_dangnhap dn', 'cb.ma_cb = dn.ma_canbo', 'left');
			$this->db->where('ten_dangnhap IS NULL');
			return $this->db->get()->result_array();
		}

		public function layCanBoDaCoTaiKhoan($quyen){
			$quyenkhac 			= array(
				'sinhvien'
			);

			if ($quyen != 'phongkhaothi' && $quyen != 'chunhiemkhoa') {
				$quyenkhac[] 	= 'phongkhaothi';
				$quyenkhac[] 	= 'chunhiemkhoa';
			}

			$this->db->where_not_in('dn.ma_quyen', $quyenkhac);
			$this->db->select('cb.ma_cb, hodem_cb, ten_cb, ten_dangnhap, ten_quyen');
			$this->db->from('tbl_canbo cb');
			$this->db->join('tbl_dangnhap dn', 'cb.ma_cb = dn.ma_canbo', 'inner');
			$this->db->join('tbl_quyen q', 'dn.ma_quyen = q.ma_quyen', 'inner');
			return $this->db->get()->result_array();
		}

		public function insertAccount($ma_canbo, $ten_dangnhap, $matkhau, $quyen){
			$this->db->insert('tbl_dangnhap', array(
				'ten_dangnhap' 		=> $ten_dangnhap,
				'matkhau_dangnhap' 	=> sha1($matkhau),
				'ma_canbo' 			=> $ma_canbo,
				'ma_quyen' 			=> $quyen,
				'trangthai' 		=> 0,
			));

			return $this->db->affected_rows();			
		}

		public function updateAccount($ma_canbo, $ten_dangnhap, $matkhau, $quyen){
			$this->db->where('ten_dangnhap', $ten_dangnhap);
			$update 			= array(
				'ten_dangnhap' 	=> $ten_dangnhap,
				'ma_quyen' 		=> $quyen,
				'ma_canbo' 		=> $ma_canbo,
			);
			if ($matkhau) {
				$update['matkhau_dangnhap']	= sha1($matkhau);
			}
			$this->db->update('tbl_dangnhap', $update);
			return $this->db->affected_rows();
		}

		public function layThongTinCanBo($tendangnhap){
			$this->db->select('cb.ma_cb, hodem_cb, ten_cb, ten_dangnhap, dn.ma_quyen');
			$this->db->from('tbl_canbo cb');
			$this->db->join('tbl_dangnhap dn', 'cb.ma_cb = dn.ma_canbo', 'inner');

			$this->db->where('ten_dangnhap', $tendangnhap);

			return $this->db->get()->row_array();
		}

		public function deletaAccount($tendangnhap){
			$this->db->where('ten_dangnhap', $tendangnhap);
			$this->db->delete('tbl_dangnhap');
			return $this->db->affected_rows();
		}
	}

?>