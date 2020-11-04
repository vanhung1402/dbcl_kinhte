<?php 
	class Mlop extends CI_Model{
		public function getListlop(){
			$this->db->select('tbl_lop.*,tbl_khoahoc.namhoc,tbl_canbo.hodem_cb, tbl_canbo.ten_cb');
			$this->db->from('tbl_lop');
			$this->db->join('tbl_khoahoc','tbl_lop.ma_khoahoc = tbl_khoahoc.ma_khoahoc','inner');
			$this->db->join('tbl_canbo','tbl_lop.ma_canbo_quanly = tbl_canbo.ma_cb','inner');
			return $this->db->get()->result_array();
		}
		public function getMalopSuDung(){
			$this->db->select("ma_lop");
			$this->db->distinct();
			$kh = $this->db->get('tbl_sinhvien')->result_array();

			foreach ($kh as $k => $v) {
				$kh[$k] = $v['ma_lop'];
			}
			$res = array_unique($kh);
			return $res;
		}
		public function getKhoahoc(){

			$res = $this->db->get('tbl_khoahoc')->result_array();
			return $res;
		}
		public function getCanbo(){

			$res = $this->db->get('tbl_canbo')->result_array();
			return $res;
		}
		public function insert($data){
			$this->db->insert('tbl_lop',$data); 
			return $this->db->affected_rows();
		}
		public function delete($ma){
			$this->db->where('ma_lop',$ma);
			$this->db->delete('tbl_lop');
			return $this->db->affected_rows();
		}
		public function getdata($ma){
			$this->db->where('ma_lop',$ma);
			return $this->db->get('tbl_lop')->row_array();
		}
		public function updateData($ma,$data){
			$this->db->where('ma_lop',$ma);
			$this->db->update('tbl_lop',$data);
			return $this->db->affected_rows();
		} 
		public function checkfk($ma)
		{
			$this->db->where('ma_lop',$ma);
			return $this->db->get('tbl_sinhvien')->row_array();
		}
	}
?>