<?php

	/**
	 * 
	 */
	class Mkhaosat extends MY_Model{
		function __construct(){
			parent::__construct();
		}

		public function layLoaiKhaoSat(){
			return $this->db->get('dm_loaikhaosat')->result_array();
		}

		public function layHinhThucKhaoSat(){
			return $this->db->get('dm_hinhthuc_khaosat')->result_array();
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

		public function layThongTinKhaoSat($khaosat){
			if (!$khaosat) {
				return null;
			}

			$this->db->where('ma_khaosat', $khaosat);
			return $this->db->get('tbl_khaosat')->row_array();
		}

		public function insertServey($dataInsert){
			$this->db->insert('tbl_khaosat', $dataInsert);
			return $this->db->affected_rows();
		}

		public function updateServey($khaosat, $dataUpdate){
			$this->db->where('ma_khaosat', $khaosat);
			$this->db->update('tbl_khaosat', $dataUpdate);
			return $this->db->affected_rows();
		}

		public function removeServey($khaosat){
			$this->db->where('ma_khaosat', $khaosat);
			$this->db->delete('tbl_khaosat');
			return $this->db->affected_rows();
		}

		public function layChuDeKhaoSat($makhaosat){
			$this->db->from('tbl_nhomcauhoi');

			$this->db->where('ma_khaosat', $makhaosat);
			$this->db->order_by('thutu_nhomcauhoi');

			return $this->db->get()->result_array();
		}

		public function layCauHoiChuDe($dsmachude){
			$this->db->from('tbl_cauhoi');
			if (!$dsmachude) {
				return null;
			}
			$this->db->where_in('ma_nhomcauhoi', $dsmachude);
			$this->db->order_by('thutu_cauhoi');

			return $this->db->get()->result_array();
		}

		public function layDapAnCauHoi($dsmacauhoi){
			$this->db->from('tbl_dapan');
			if (!$dsmacauhoi) {
				return null;
			}
			$this->db->where_in('ma_cauhoi', $dsmacauhoi);
			$this->db->order_by('thutu_dapan');

			return $this->db->get()->result_array();
		}

	}

?>