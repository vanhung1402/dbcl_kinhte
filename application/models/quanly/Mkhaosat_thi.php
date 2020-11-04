<?php
	class Mkhaosat extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		#get data
		public function get_ks(){
            $this->db->select('
                tbl_khaosat.ma_khaosat as ma,
                tieude_khaosat as tieude,
				noidung_khaosat as noidung,
				dm_loaikhaosat.madm_loaikhaosat as ma_loai,
				dm_loaikhaosat.tendm_loaikhaosat as ten_loai,
				ghichu_khaosat as ghichu,
				SUM(case when ma_dotkhaosat is not null then 1 else 0 end) as sl_dotks,
				SUM(case when ma_cauhoi is not null then 1 else 0 end) as sl_cauhoi
			');
			$this->db->join('dm_loaikhaosat', 'tbl_khaosat.madm_loaikhaosat = dm_loaikhaosat.madm_loaikhaosat', 'left');
			$this->db->join('tbl_dotkhaosat', 'tbl_dotkhaosat.ma_khaosat = tbl_khaosat.ma_khaosat', 'left');
			$this->db->join('tbl_nhomcauhoi', 'tbl_nhomcauhoi.ma_khaosat = tbl_khaosat.ma_khaosat', 'left');
			$this->db->join('tbl_cauhoi', 'tbl_cauhoi.ma_nhomcauhoi = tbl_nhomcauhoi.ma_nhomcauhoi', 'left');
			$this->db->group_by('ma');
            $resulte = $this->db->get('tbl_khaosat')->result_array();
			return $resulte;
		}

		public function get_loaiks(){
			return $this->db->get('dm_loaikhaosat')->result_array();
		}

		#end of get data

		#add data
		public function them_ks($ks_moi){
			return $this->db->insert('tbl_khaosat', $ks_moi);
		}
		#end of add data

		#delete data
		public function xoa_ks($ma_ks){
			$this->db->where('ma_khaosat', $ma_ks);
			$this->db->delete('tbl_khaosat');
			return $this->db->affected_rows();
		}
		#end of delete data
	}

?>