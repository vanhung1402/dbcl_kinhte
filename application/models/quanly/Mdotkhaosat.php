<?php
	class Mdotkhaosat extends CI_Model{
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
            $result = $this->db->get('tbl_khaosat')->result_array();
			return $result;
		}

		public function get_dvhv(){
			$this->db->order_by('namhoc, kyhoc', 'desc');
			return $this->db->get('tbl_donvihocvu')->result_array();
		}

		public function get_dotks($dvhv){
			$this->db->select('
				ma_dotkhaosat as ma,
				DATE_FORMAT(thoigianbd, "%d/%m/%Y") as bd,
				DATE_FORMAT(thoigiankt, "%d/%m/%Y") as kt,
				ma_donvihocvu as ma_dvhv,
				tbl_dotkhaosat.ma_khaosat as ma_ks,
				tieude_khaosat as tieude
			');
			if($dvhv != '')
			{
				$this->db->where('ma_donvihocvu', $dvhv);
			}
			$this->db->join('tbl_khaosat', 'tbl_khaosat.ma_khaosat = tbl_dotkhaosat.ma_khaosat');
			$this->db->order_by('thoigianbd, thoigiankt', 'desc');
			$result = $this->db->get('tbl_dotkhaosat')->result_array();
			return $result;
		}

		public function get_loaiks(){
			return $this->db->get('dm_loaikhaosat')->result_array();
		}

		#end of get data

		#add data
		public function them_dotks($new_dotks){
			return $this->db->insert('tbl_dotkhaosat', $new_dotks);
		}
		#end of add data

		#delete data
		public function xoa_dotks($ma_dotks){
			$this->db->where('ma_dotkhaosat', $ma_dotks);
			$this->db->delete('tbl_dotkhaosat');
			return $this->db->affected_rows();
		}
		#end of delete data
	}

?>