<?php

	/**
	 * 
	 */
	class Mthongkekhaosathoctap extends MY_Model{
		function __construct(){
			parent::__construct();
		}

		public function layDotKhaoSat($makhaosat, $trangthai = null){
			$this->db->select('*, (ma_dotkhaosat * 1) as mdot');
			$this->db->where('ma_khaosat', $makhaosat);
			$this->db->from('tbl_dotkhaosat dks');
			$this->db->join('tbl_donvihocvu dvhv', 'dks.ma_donvihocvu = dvhv.ma_donvihocvu', 'inner');
			$this->db->order_by('namhoc', 'desc');
			$this->db->order_by('kyhoc', 'desc');
			$this->db->order_by('mdot');
			if ($trangthai != null) {
				$this->db->where('madm_trangthai_dotkhaosat', $trangthai);
			}
			return $this->db->get()->result_array();
		}

		public function layDanhSachLop(){
			$this->db->select('l.ma_lop, ten_lop, hodem_cb, ten_cb, count(ma_sv) as sosinhvien');
			$this->db->from('tbl_lop l');
			$this->db->join('tbl_canbo cb', 'l.ma_canbo_quanly = cb.ma_cb', 'inner');
			$this->db->join('tbl_sinhvien sv', 'l.ma_lop = sv.ma_lop', 'left');
			$this->db->order_by('l.ma_lop');
			$this->db->group_by('l.ma_lop');

			return $this->db->get()->result_array();
		}

		public function layDanhSachKhaoSatLop($dot){
			$this->db->select('sv.ma_sv, ma_lop, count(dkm.ma_dkm) as sodkm, count(pht.ma_phieu) as sophieu, count(pht.thoigian_khaosat) as dakhaosat');
			$this->db->from('tbl_sinhvien sv');
			$this->db->join('tbl_dangkymon dkm', 'sv.ma_sv = dkm.ma_sv', 'inner');
			$this->db->join('tbl_phieukhaosat_hoctap pht', 'dkm.ma_dkm = pht.ma_dkm', 'inner');
			$this->db->where('ma_dotkhaosat', $dot);
			$this->db->group_by('sv.ma_sv');
			return $this->db->get()->result_array();
		}

		public function layKhaoSatHocTap(){
			$this->db->from('tbl_khaosat');
			$this->db->where('madm_loaikhaosat', 'khaosathoctap');
			
			return $this->db->get()->result_array();
		}
	}

?>