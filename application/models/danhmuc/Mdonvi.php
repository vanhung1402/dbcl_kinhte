<?php 
	class Mdonvi extends CI_Model{
		public function getListdonvi(){
			return $this->db->get('tbl_donvi')->result_array();
		}
		public function getMaDonViSuDung(){
			$this->db->select("ma_donvi");
			$this->db->distinct();
			$dv1 = $this->db->get('tbl_canbo')->result_array();

			foreach ($dv1 as $k => $v) {
				$dv1[$k] = $v['ma_donvi'];
			}
			$res = array_unique($dv1);
			return $res;
		}
		public function insert($data){
			$this->db->insert('tbl_donvi',$data); 
			return $this->db->affected_rows();
		}
		public function delete($ma){
			$this->db->where('ma_donvi',$ma);
			$this->db->delete('tbl_donvi');
			return $this->db->affected_rows();
		}
		public function getdata($ma){
			$this->db->where('ma_donvi',$ma);
			return $this->db->get('tbl_donvi')->row_array();
		}
		public function updateData($ma,$data){
			$this->db->where('ma_donvi',$ma);
			$this->db->update('tbl_donvi',$data);
			return $this->db->affected_rows();
		} 
		public function checkfk($ma)
		{
			$this->db->where('ma_donvi',$ma);
			return $this->db->get('tbl_canbo')->row_array();
		}
		public function kiemTraDonVi($madv, $key = null){
			if ($key) {
				$this->db->where('ma_donvi !=', $key);
			}
			$this->db->where('ma_donvi', $madv);
			return $this->db->get('tbl_donvi')->result_array();
		}
	}
?>