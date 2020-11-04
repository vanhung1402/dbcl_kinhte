<?php

	/**
	 * 
	 */
	class Mdanhgiakhaosathoctap extends MY_Model{
		
		function __construct(){
			parent::__construct();
		}

		public function layNhomCauHoiKhaoSat($dot){
			$this->db->select('nch.*, count(ch.ma_nhomcauhoi) as socauhoi');
			$this->db->from('tbl_dotkhaosat dks');
			$this->db->join('tbl_nhomcauhoi nch', 'dks.ma_khaosat = nch.ma_khaosat', 'inner');	
			$this->db->join('tbl_cauhoi ch', 'nch.ma_nhomcauhoi = ch.ma_nhomcauhoi', 'inner');
			$this->db->where(array(
				'dks.ma_dotkhaosat'	=> $dot,
				'ch.tinhdiem' 		=> '1',
			));

			$this->db->order_by('thutu_nhomcauhoi');
			$this->db->group_by('nch.ma_nhomcauhoi');
			return $this->db->get()->result_array();
		}

		public function layCauHoiYKien($dot){
			$this->db->select('ch.ma_cauhoi, ch.noidung_cauhoi');
			$this->db->from('tbl_dotkhaosat dks');
			$this->db->join('tbl_nhomcauhoi nch', 'dks.ma_khaosat = nch.ma_khaosat', 'inner');	
			$this->db->join('tbl_cauhoi ch', 'nch.ma_nhomcauhoi = ch.ma_nhomcauhoi', 'inner');
			$this->db->where(array(
				'dks.ma_dotkhaosat'	=> $dot,
				'ch.tinhdiem' 		=> '0',
			));
			$this->db->where_in('ma_loaicauhoi', array('doan', 'traloingan'));
			$this->db->order_by('thutu_cauhoi');
			return $this->db->get()->result_array();
		}

		public function layChuDeKhaoSat($dot){
			$this->db->select('nch.*');
			$this->db->from('tbl_nhomcauhoi nch');
			$this->db->join('tbl_dotkhaosat dks', 'nch.ma_khaosat = dks.ma_khaosat', 'inner');
			$this->db->where('ma_dotkhaosat', $dot);
			$this->db->order_by('thutu_nhomcauhoi');

			return $this->db->get()->result_array();
		}

		public function layCauHoiChuDe($dsmachude){
			$this->db->from('tbl_cauhoi');
			$this->db->where_in('ma_nhomcauhoi', $dsmachude);
			$this->db->order_by('thutu_cauhoi');

			return $this->db->get()->result_array();
		}

		public function layCanBo($canbo){
			$this->db->select('ma_cb, hodem_cb, ten_cb, ten_donvi');
			$this->db->from('tbl_canbo cb');
			$this->db->join('tbl_donvi dv', 'cb.ma_donvi = dv.ma_donvi', 'inner');
			if ($canbo) {
				$this->db->where('ma_cb', $canbo);
			}
			return $this->db->get()->result_array();
		}

		public function layMonHoc($monhoc){
			$this->db->select('ma_monhoc, ten_monhoc');
			if ($monhoc) {
				$this->db->where('ma_monhoc', $monhoc);
			}
			return $this->db->get('tbl_monhoc')->result_array();
		}

		public function layDotKhaoSat($dot){
			$this->db->where('ma_dotkhaosat', $dot);
   			return $this->db->get('tbl_dotkhaosat')->row_array();
		}

		public function layDanhGiaGiangDay($dot, $canbo, $monhoc){
			$this->db->select('pht.ma_phieu, ch.ma_nhomcauhoi, ctpht.ma_cauhoi, giatri_dapan, da.thutu_dapan, ctpht.noidung_dapan as ndtraloi');
			$this->db->from('tbl_lopmon lm');
			$this->db->join('tbl_dangkymon dkm', 'lm.ma_lopmon = dkm.ma_lopmon', 'inner');
			$this->db->join('tbl_phieukhaosat_hoctap pht', 'dkm.ma_dkm = pht.ma_dkm', 'inner');
			$this->db->join('tbl_chitietphieu_hoctap ctpht', 'pht.ma_phieu = ctpht.ma_phieu', 'inner');
			$this->db->join('tbl_dapan da', 'ctpht.ma_dapan = da.ma_dapan', 'inner');
			$this->db->join('tbl_cauhoi ch', 'ctpht.ma_cauhoi = ch.ma_cauhoi', 'inner');
			$this->db->join('tbl_canbo_lopmon cblm', 'lm.ma_lopmon = cblm.ma_lopmon', 'inner');

			$this->db->where(array(
				'ma_dotkhaosat' 	=> $dot,
				'cblm.ma_cb' 		=> $canbo,
				'lm.ma_monhoc' 		=> $monhoc,
			));

			return $this->db->get()->result_array();
		}

		public function layDapAn($mch){
			$this->db->where('ma_cauhoi', $mch);
			$this->db->from('tbl_dapan');
			$this->db->order_by('thutu_dapan');
			return $this->db->get()->result_array();
		}

		public function layKetQuaDanhGia($dot, $monhoc = null, $canbo = null){
			$this->db->select('pht.ma_phieu, ch.ma_nhomcauhoi, ch.tinhdiem, ctpht.ma_cauhoi, giatri_dapan, da.thutu_dapan, da.noidung_dapan, ctpht.noidung_dapan as ndtraloi, cblm.ma_cb, lm.ma_monhoc');
			$this->db->from('tbl_lopmon lm');
			$this->db->join('tbl_dangkymon dkm', 'lm.ma_lopmon = dkm.ma_lopmon', 'inner');
			$this->db->join('tbl_phieukhaosat_hoctap pht', 'dkm.ma_dkm = pht.ma_dkm', 'inner');
			$this->db->join('tbl_chitietphieu_hoctap ctpht', 'pht.ma_phieu = ctpht.ma_phieu', 'inner');
			$this->db->join('tbl_dapan da', 'ctpht.ma_dapan = da.ma_dapan', 'inner');
			$this->db->join('tbl_cauhoi ch', 'ctpht.ma_cauhoi = ch.ma_cauhoi', 'inner');
			$this->db->join('tbl_canbo_lopmon cblm', 'lm.ma_lopmon = cblm.ma_lopmon', 'inner');

			$this->db->where('ma_dotkhaosat', $dot);
			if ($canbo) {
				$this->db->where('cblm.ma_cb', $canbo);
			}
			if ($monhoc) {
				$this->db->where('lm.ma_monhoc', $monhoc);
			}
			$this->db->where("((ch.tinhdiem = 1) OR ma_loaicauhoi = 'doan' OR ma_loaicauhoi = 'traloingan')");

			return $this->db->get()->result_array();	
		}
	}

?>