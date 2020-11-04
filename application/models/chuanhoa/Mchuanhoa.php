<?php

	/**
	 * 
	 */
	class Mchuanhoa extends MY_Model{
		function __construct(){
			parent::__construct();
            $this->tmas = $this->load->database('tmas', TRUE);
		}

		public function getTmasTable($table){
			return $this->tmas->get($table)->result_array();
		}

		public function layKhoaHoc(){
			$this->tmas->select('kh.*, ma_ctdt');
			$this->tmas->from('tbl_khoahoc kh');
			$this->tmas->join('tbl_donvi_ctdt dvctdt', 'kh.id_dv_ctdt = dvctdt.id_dv_ctdt', 'inner');
			return $this->tmas->get()->result_array();
		}

		public function laylopMon(){
			$this->tmas->select('*, STR_TO_DATE(ngaybatdau, "%d/%m/%Y") as ngaybatdau, STR_TO_DATE(ngayketthuc, "%d/%m/%Y") as ngayketthuc');
			$this->tmas->from('tbl_lopmon');
			$this->tmas->where_in('trangthai_hientai', array('dukien', 'daduyet', 'ketthuc'));
			$this->tmas->where('ma_donvihocvu', '1-2020:2021');
			return $this->tmas->get()->result_array();
		}

		public function laylopMonChuanHoa(){
			$this->tmas->select('tbl_lopmon_monctdt.*');
			$this->tmas->from('tbl_lopmon lm');
			$this->tmas->join('tbl_lopmon_monctdt', 'lm.ma_lopmon = tbl_lopmon_monctdt.ma_lopmon', 'inner');
			$this->tmas->where_in('trangthai_hientai', array('dukien', 'daduyet', 'ketthuc'));
			$this->tmas->where('ma_donvihocvu', '1-2020:2021');
			return $this->tmas->get()->result_array();
		}

		public function laylop(){
			$this->tmas->select('l.*, qll.ma_cb');
			$this->tmas->from('tbl_lop l');
			$this->tmas->join('tbl_quanlylop qll', 'l.ma_lop = qll.ma_lop', 'left');
			$this->tmas->group_by('l.ma_lop');
			return $this->tmas->get()->result_array();
		}

		public function laySinhVien(){
			$this->tmas->select('sv.*, ma_lop, STR_TO_DATE(ngaysinh_sv, "%d/%m/%Y") as ngaysinh_sv');
			$this->tmas->from('tbl_sinhvien sv');
			$this->tmas->join('tbl_nhaphoc nh', 'sv.ma_sv = nh.ma_sv', 'inner');
			$this->tmas->join('tbl_sv_lop svl', 'nh.ma_nhaphoc = svl.ma_nhaphoc', 'left');
			return $this->tmas->get()->result_array();
		}

		public function layDangKyMon(){
			$this->tmas->select('dkm.*');
			$this->tmas->from('tbl_dangkymon dkm');
			$this->tmas->join('tbl_lopmon lm', 'dkm.ma_lopmon = lm.ma_lopmon', 'inner');
			$this->tmas->where_in('trangthai_hientai', array('dukien', 'daduyet', 'ketthuc'));
			$this->tmas->where('ma_donvihocvu', '1-2020:2021');
			$this->tmas->group_by('ma_dkm');
			return $this->tmas->get()->result_array();
		}
	}

?>