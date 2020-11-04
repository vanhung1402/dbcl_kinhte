<?php

	/**
	 * 
	 */
	class Mchitietphieuhoctap extends MY_Model{
		function __construct(){
			parent::__construct();
		}


		public function layMaKhaoSat($maphieu){
			$this->db->select('ks.*');
			$this->db->select('ks.ma_khaosat');
			$this->db->where('ma_phieu', $maphieu);
			$this->db->from('tbl_phieukhaosat_hoctap pht');
			$this->db->join('tbl_dotkhaosat dks', 'pht.ma_dotkhaosat = dks.ma_dotkhaosat', 'inner');
			$this->db->join('tbl_khaosat ks', 'dks.ma_khaosat = ks.ma_khaosat', 'inner');

			return $this->db->get()->row_array();
		}

		public function layChuDeKhaoSat($makhaosat){
			$this->db->from('tbl_nhomcauhoi');

			$this->db->where('ma_khaosat', $makhaosat);
			$this->db->order_by('thutu_nhomcauhoi');

			return $this->db->get()->result_array();
		}

		public function layCauHoiChuDe($dsmachude){
			$this->db->from('tbl_cauhoi');
			$this->db->where_in('ma_nhomcauhoi', $dsmachude);
			$this->db->order_by('thutu_cauhoi');

			return $this->db->get()->result_array();
		}

		public function layDapAnCauHoi($dsmacauhoi){
			$this->db->from('tbl_dapan');
			$this->db->where_in('ma_cauhoi', $dsmacauhoi);
			$this->db->order_by('thutu_dapan');

			return $this->db->get()->result_array();
		}

		public function layThongTinPhieu($dsmaphieu){
			$this->db->select('ma_phieu, mh.ma_monhoc, mh.ten_monhoc, lm.ma_lopmon, lm.ma_donvihocvu as dvhv, l.ten_lop, sv.ma_sv, sv.hodem_sv, sv.ten_sv, sv.gioitinh_sv, tendm_nganh, ten_donvi');
			$this->db->where_in('ma_phieu', $dsmaphieu);
			$this->db->from('tbl_phieukhaosat_hoctap pht');
			$this->db->join('tbl_dangkymon dkm', 'pht.ma_dkm = dkm.ma_dkm', 'inner');
			$this->db->join('tbl_sinhvien sv', 'dkm.ma_sv = sv.ma_sv', 'inner');
			$this->db->join('tbl_lopmon lm', 'dkm.ma_lopmon = lm.ma_lopmon', 'inner');
			$this->db->join('tbl_lop l', 'sv.ma_lop = l.ma_lop', 'left');
			$this->db->join('tbl_monhoc mh', 'lm.ma_monhoc = mh.ma_monhoc', 'inner');
			$this->db->join('tbl_khoahoc kh', 'l.ma_khoahoc = kh.ma_khoahoc', 'inner');
			$this->db->join('tbl_ctdt ctdt', 'kh.ma_ctdt = ctdt.ma_ctdt', 'inner');
			$this->db->join('dm_nganh n', 'ctdt.madm_nganh = n.madm_nganh', 'inner');
			$this->db->join('tbl_donvi dv', 'n.ma_donvi = dv.ma_donvi', 'inner');

			$dsthongtin 			= $this->db->get()->result_array();
			$dscanbolop 			= $this->layCanBoLopMon(array_column($dsthongtin, 'ma_lopmon'));

			foreach ($dsthongtin as $key => $tt) {
				$tt['cblm'] 		= $dscanbolop[$tt['ma_lopmon']];
				$dsthongtin[$key] 	= $tt;
			}
			return $dsthongtin;
		}

		public function layThongTinPhieuDot($dot){
			$this->db->select('ma_phieu, mh.ma_monhoc, mh.ten_monhoc, lm.ma_lopmon, lm.ma_donvihocvu as dvhv, l.ten_lop, sv.ma_sv, sv.hodem_sv, sv.ten_sv, sv.gioitinh_sv, tendm_nganh, ten_donvi');
			$this->db->from('tbl_phieukhaosat_hoctap pht');
			$this->db->join('tbl_dangkymon dkm', 'pht.ma_dkm = dkm.ma_dkm', 'inner');
			$this->db->join('tbl_sinhvien sv', 'dkm.ma_sv = sv.ma_sv', 'inner');
			$this->db->join('tbl_lopmon lm', 'dkm.ma_lopmon = lm.ma_lopmon', 'inner');
			$this->db->join('tbl_lop l', 'sv.ma_lop = l.ma_lop', 'left');
			$this->db->join('tbl_monhoc mh', 'lm.ma_monhoc = mh.ma_monhoc', 'inner');
			$this->db->join('tbl_khoahoc kh', 'l.ma_khoahoc = kh.ma_khoahoc', 'inner');
			$this->db->join('tbl_ctdt ctdt', 'kh.ma_ctdt = ctdt.ma_ctdt', 'inner');
			$this->db->join('dm_nganh n', 'ctdt.madm_nganh = n.madm_nganh', 'inner');
			$this->db->join('tbl_donvi dv', 'n.ma_donvi = dv.ma_donvi', 'inner');
			$this->db->where('ma_dotkhaosat', $dot);
			$this->db->where('thoigian_khaosat IS NOT NULL');

			$dsthongtin 			= $this->db->get()->result_array();
			$dscanbolop 			= $this->layCanBoLopMon(array_unique(array_column($dsthongtin, 'ma_lopmon')));

			foreach ($dsthongtin as $key => $tt) {
				$tt['cblm'] 		= $dscanbolop[$tt['ma_lopmon']];
				$dsthongtin[$key] 	= $tt;
			}
			return $dsthongtin;
		}

		public function layCanBoLopMon($dslopmon){
			$this->db->select('ma_lopmon, cblm.ma_cb, hodem_cb, ten_cb, sotietday');
			$this->db->where_in('ma_lopmon', $dslopmon);
			$this->db->from('tbl_canbo_lopmon cblm');
			$this->db->join('tbl_canbo cb', 'cblm.ma_cb = cb.ma_cb', 'inner');
			$dscanbolop 	= $this->db->get()->result_array();

			$canbo_lopmon 	= array();

			foreach ($dscanbolop as $cb) {
				if (!isset($canbo_lopmon[$cb['ma_lopmon']])) {
					$canbo_lopmon[$cb['ma_lopmon']]	= array();
				}

				$canbo_lopmon[$cb['ma_lopmon']][$cb['ma_cb']] 	= $cb['hodem_cb'] . ' ' . $cb['ten_cb'];
			}

			return $canbo_lopmon;
		}

		public function layKetQuaKhaoSat($dsmaphieu){
			$this->db->select('ctpht.*, da.noidung_dapan as dapan, tinhdiem');
			$this->db->from('tbl_chitietphieu_hoctap ctpht');
			$this->db->join('tbl_phieukhaosat_hoctap pht', 'ctpht.ma_phieu = pht.ma_phieu', 'inner');
			$this->db->join('tbl_dapan da', 'ctpht.ma_dapan = da.ma_dapan', 'inner');
			$this->db->join('tbl_cauhoi ch', 'da.ma_cauhoi = ch.ma_cauhoi', 'left');
			$this->db->where_in('pht.ma_phieu', $dsmaphieu);
			return $this->db->get()->result_array();
		}

		public function layKetQuaKhaoSatDot($dot){
			$this->db->select('ctpht.*, da.noidung_dapan as dapan, tinhdiem');
			$this->db->from('tbl_chitietphieu_hoctap ctpht');
			$this->db->join('tbl_phieukhaosat_hoctap pht', 'ctpht.ma_phieu = pht.ma_phieu', 'inner');
			$this->db->join('tbl_dapan da', 'ctpht.ma_dapan = da.ma_dapan', 'inner');
			$this->db->join('tbl_cauhoi ch', 'da.ma_cauhoi = ch.ma_cauhoi', 'left');
			$this->db->where('ma_dotkhaosat', $dot);
			$this->db->where('thoigian_khaosat IS NOT NULL');
			return $this->db->get()->result_array();
		}

		public function layDanhSachPhieuLopMon($lopmon, $dot){
			$where 			= array(
				'ma_lopmon' 	=> $lopmon,
				'ma_dotkhaosat' => $dot,
			);
			$this->db->select('ma_phieu');
			$this->db->from('tbl_dangkymon dkm');
			$this->db->join('tbl_phieukhaosat_hoctap pht', 'dkm.ma_dkm = pht.ma_dkm', 'inner');
			$this->db->where($where);
			$this->db->where('thoigian_khaosat IS NOT NULL');
			return $this->db->get()->result_array();
		}

		public function layDanhSachPhieuCanBoMonHoc($canbo, $monhoc, $dot){
			$this->db->select('ma_phieu');
			$this->db->from('tbl_dangkymon dkm');
			$this->db->join('tbl_phieukhaosat_hoctap pht', 'dkm.ma_dkm = pht.ma_dkm', 'inner');
			$this->db->join('tbl_lopmon lm', 'dkm.ma_lopmon = lm.ma_lopmon', 'inner');
			$this->db->join('tbl_canbo_lopmon cblm', 'lm.ma_lopmon = cblm.ma_lopmon', 'inner');
			$this->db->where(array(
				'cblm.ma_cb' 		=> $canbo,
				'lm.ma_monhoc' 		=> $monhoc,
				'pht.ma_dotkhaosat' => $dot,
			));
			$this->db->where('thoigian_khaosat IS NOT NULL');
			return $this->db->get()->result_array();
		}

		public function layDanhSachPhieuSinhVien($masv, $dot){
			$this->db->select('ma_phieu');
			$this->db->from('tbl_dangkymon dkm');
			$this->db->join('tbl_phieukhaosat_hoctap pht', 'dkm.ma_dkm = pht.ma_dkm', 'inner');

			$this->db->where(array(
				'dkm.ma_sv' 		=> $masv,
				'pht.ma_dotkhaosat' => $dot,
			));
			$this->db->where('thoigian_khaosat IS NOT NULL');
			return $this->db->get()->result_array();
		}

		public function layPhieuDot($dot){
			$this->db->select('ma_phieu');
			$this->db->where('ma_dotkhaosat', $dot);
			$this->db->where('thoigian_khaosat IS NOT NULL');
			return $this->db->get('tbl_phieukhaosat_hoctap')->row_array();
		}
	}

?>