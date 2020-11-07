<?php

	/**
	 * 
	 */
	class Mbaocaokhaosathoctap extends MY_Model{
		function __construct(){
			parent::__construct();
		}

		public function layChuDeKhaoSat($makhaosat){
			$this->db->from('tbl_nhomcauhoi');

			$this->db->where('ma_khaosat', $makhaosat);
			$this->db->order_by('thutu_nhomcauhoi');

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

		public function getDotKhaoSat($madotkhaosat){
			$this->db->where('ma_dotkhaosat', $madotkhaosat);
			return $this->db->get('tbl_dotkhaosat')->row_array();
		}

		public function layKhaoSat($makhaosat){
			$this->db->where('ma_khaosat', $makhaosat);
			return $this->db->get('tbl_khaosat')->row_array();
		}

		public function layMonGiangVien($hocvu, $hinhthuc){
			$this->db->select('count(dkm.ma_dkm) as sodk, , ten_monhoc, hodem_cb, ten_cb, ma_hocham, tongkhoiluong, cb.ma_cb, mh.ma_monhoc');
			$this->db->from('tbl_lopmon lm');
			$this->db->join('tbl_monhoc mh', 'lm.ma_monhoc = mh.ma_monhoc', 'inner');
			$this->db->join('tbl_canbo_lopmon cblm', 'lm.ma_lopmon = cblm.ma_lopmon', 'inner');
			$this->db->join('tbl_canbo cb', 'cblm.ma_cb = cb.ma_cb', 'inner');
			$this->db->join('tbl_dangkymon dkm', 'lm.ma_lopmon = dkm.ma_lopmon', 'inner');
			$this->db->join('tbl_phieukhaosat_hoctap pht', 'dkm.ma_dkm = pht.ma_dkm', 'inner');

			$this->db->where(array(
				'ma_donvihocvu' 	=> $hocvu,
				'ma_hinhthuc' 		=> $hinhthuc
			));

			$this->db->where_in('lm.madm_trangthai_lopmon', array('daduyet', 'ketthuc'));

			$this->db->group_by('cblm.ma_cb, lm.ma_monhoc');
			$this->db->order_by('ten_cb, hodem_cb, ten_monhoc');
			return $this->db->get()->result_array();
		}

		public function layKetQuaKhaoSat($dotkhaosat){
			$this->db->select('count(pht.ma_phieu) as sophieu, cblm.ma_cb, lm.ma_monhoc, count(pht.thoigian_khaosat) as dakhaosat');
			$this->db->from('tbl_phieukhaosat_hoctap pht');
			$this->db->join('tbl_dangkymon dkm', 'pht.ma_dkm = dkm.ma_dkm', 'inner');
			$this->db->join('tbl_lopmon lm', 'dkm.ma_lopmon = lm.ma_lopmon', 'inner');
			$this->db->join('tbl_canbo_lopmon cblm', 'lm.ma_lopmon = cblm.ma_lopmon', 'inner');
			$this->db->group_by('cblm.ma_cb, lm.ma_monhoc');

			$this->db->where(array(
				'pht.ma_dotkhaosat' => $dotkhaosat,
			));
			return $this->db->get()->result_array();
		}

		public function layChiTietKetQua($dotkhaosat){
			$this->db->select('ch.ma_nhomcauhoi, cblm.ma_cb, lm.ma_monhoc, count(ch.ma_nhomcauhoi) as tongnhom');
			$this->db->from('tbl_phieukhaosat_hoctap pht');
			$this->db->join('tbl_chitietphieu_hoctap ctpht', 'pht.ma_phieu = ctpht.ma_phieu', 'inner');
			$this->db->join('tbl_cauhoi ch', 'ctpht.ma_cauhoi = ch.ma_cauhoi', 'inner');
			$this->db->join('tbl_dapan da', 'ctpht.ma_dapan = da.ma_dapan', 'inner');
			$this->db->join('tbl_dangkymon dkm', 'pht.ma_dkm = dkm.ma_dkm', 'inner');
			$this->db->join('tbl_lopmon lm', 'dkm.ma_lopmon = lm.ma_lopmon', 'inner');
			$this->db->join('tbl_canbo_lopmon cblm', 'lm.ma_lopmon = cblm.ma_lopmon', 'inner');

			$this->db->where(array(
				'pht.ma_dotkhaosat' => $dotkhaosat,
				'ch.tinhdiem' 		=> '1',
				'da.giatri_dapan' 	=> '1',
			));
			$this->db->group_by('ch.ma_nhomcauhoi, cblm.ma_cb, lm.ma_monhoc');
			return $this->db->get()->result_array();
		}

		public function layNhomCauHoiKhaoSat($hinhthuc){
			$this->db->select('nch.*, count(ma_cauhoi) as socauhoi');
			$this->db->from('tbl_nhomcauhoi nch');
			$this->db->join('tbl_cauhoi ch', 'nch.ma_nhomcauhoi = ch.ma_nhomcauhoi', 'inner');

			$this->db->where(array(
				'nch.ma_khaosat' 	=> $hinhthuc,
				'ch.tinhdiem' 		=> '1',
			));

			$this->db->order_by('thutu_nhomcauhoi');
			$this->db->group_by('nch.ma_nhomcauhoi');
			return $this->db->get()->result_array();
		}

		public function layDanhSachKhaoSat(){
			$this->db->select('ks.*, lks.*, htks.*, (ks.ma_khaosat * 1) as mks, ma_dotkhaosat');
			$this->db->from('tbl_khaosat ks');
			$this->db->join('dm_loaikhaosat lks', 'ks.madm_loaikhaosat = lks.madm_loaikhaosat', 'left');
			$this->db->join('dm_hinhthuc_khaosat htks', 'ks.ma_hinhthuc = htks.ma_hinhthuc', 'left');
			$this->db->join('tbl_dotkhaosat dks', 'ks.ma_khaosat = dks.ma_khaosat', 'left');
			$this->db->order_by('mks');
			$this->db->group_by('ks.ma_khaosat');
			return $this->db->get()->result_array();
		}

		public function layKhaoSatHocTap(){
			$this->db->from('tbl_khaosat');
			$this->db->where('madm_loaikhaosat', 'khaosathoctap');
			
			return $this->db->get()->result_array();
		}
		
		public function layThongTinDotKhaoSat($dot){
			$this->db->from('tbl_dotkhaosat dks');
			$this->db->join('tbl_khaosat ks', 'dks.ma_khaosat = ks.ma_khaosat', 'inner');
			$this->db->where('ma_dotkhaosat', $dot);
			return $this->db->get()->row_array();
		}
	}

?>