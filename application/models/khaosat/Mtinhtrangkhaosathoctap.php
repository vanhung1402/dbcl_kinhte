<?php

	/**
	 * 
	 */
	class Mtinhtrangkhaosathoctap extends MY_Model{
		function __construct(){
			parent::__construct();
		}

		public function layDanhSachLopHanhChinh($covan = NULL){
			if ($covan) {
				$this->db->where('ma_canbo_quanly', $covan);
			}
			$this->db->order_by('ten_lop');
			return $this->db->get('tbl_lop')->result_array();
		}

		public function layDanhSachSinhVien($malop){
			$this->db->select('*, DATE_FORMAT(ngaysinh_sv, "%d/%m/%Y") as ns');
			$this->db->where('ma_lop', $malop);
			$this->db->order_by('ten_sv');
			return $this->db->get('tbl_sinhvien')->result_array();
		}

		public function layTinhTrangKhaoSat($hinhthuc, $col_masv, $dot){
			if (!$col_masv) {
				return array();
			}
			$this->db->select('dkm.ma_sv, pht.*, ten_monhoc');
			$this->db->from('tbl_dangkymon dkm');
			$this->db->join('tbl_phieukhaosat_hoctap pht', 'dkm.ma_dkm = pht.ma_dkm', 'inner');
			$this->db->join('tbl_dotkhaosat dks', 'pht.ma_dotkhaosat = dks.ma_dotkhaosat', 'inner');
			$this->db->join('tbl_lopmon lm', 'dkm.ma_lopmon = lm.ma_lopmon', 'inner');
			$this->db->join('tbl_monhoc mh', 'lm.ma_monhoc = mh.ma_monhoc', 'inner');

			$this->db->where_in('dkm.ma_sv', $col_masv);
			$this->db->where('dks.ma_dotkhaosat', $dot);
			$this->db->where('dks.ma_khaosat', $hinhthuc);
			return $this->db->get()->result_array();
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

		public function layPhieuSinhVienDot($masv, $dot){
			$this->db->select('ten_monhoc, ma_phieu');
			$this->db->from('tbl_dangkymon dkm');
			$this->db->join('tbl_lopmon lm', 'dkm.ma_lopmon = lm.ma_lopmon', 'inner');
			$this->db->join('tbl_monhoc mh', 'lm.ma_monhoc = mh.ma_monhoc', 'inner');
			$this->db->join('tbl_phieukhaosat_hoctap pht', 'dkm.ma_dkm = pht.ma_dkm', 'inner');
			$this->db->where(array(
				'dkm.ma_sv' 		=> $masv,
				'pht.ma_dotkhaosat' => $dot,
			));
			$this->db->where('pht.thoigian_khaosat IS NOT NULL');
			$this->db->order_by('ten_monhoc');
			return $this->db->get()->result_array();
		}

		public function layKetQuaPhieu($dsphieu){
			if (!$dsphieu) {
				return null;
			}
			$this->db->select('ctpht.ma_phieu, ctpht.noidung_dapan as noidungnhap, da.noidung_dapan, noidung_cauhoi');
			$this->db->from('tbl_cauhoi ch');
			$this->db->join('tbl_chitietphieu_hoctap ctpht', 'ch.ma_cauhoi = ctpht.ma_cauhoi', 'inner');
			$this->db->join('tbl_dapan da', 'ctpht.ma_dapan = da.ma_dapan', 'inner');

			$this->db->where_in('ctpht.ma_phieu', $dsphieu);
			$this->db->order_by('ma_nhomcauhoi, thutu_cauhoi');
			return $this->db->get()->result_array();
		}		

		public function layKhaoSatHocTap(){
			$this->db->from('tbl_khaosat');
			$this->db->where('madm_loaikhaosat', 'khaosathoctap');
			
			return $this->db->get()->result_array();
		}

		public function layLopMonKhaoSat($madot){
			$this->db->select('lm.ma_lopmon, ten_lopmon, DATE_FORMAT(ngaybatdau_khaosat, "%d/%m/%Y") as nbdks, DATE_FORMAT(ngayketthuc_khaosat, "%d/%m/%Y") as nktks, count(pht.ma_phieu) as sophieu, count(thoigian_khaosat) as hoanthanh');
			$this->db->from('tbl_lopmon lm');
			$this->db->join('tbl_dangkymon dkm', 'lm.ma_lopmon = dkm.ma_lopmon', 'inner');
			$this->db->join('tbl_phieukhaosat_hoctap pht', 'dkm.ma_dkm = pht.ma_dkm', 'left');
			$this->db->where('ma_dotkhaosat', $madot);
			$this->db->group_by('lm.ma_lopmon');
			$this->db->order_by('ten_lopmon');
			return $this->db->get()->result_array();
		}
	}

?>
