<?php 
	class Msinhvien extends CI_Model{
		public function getListsinhvien(){
			$this->db->select('tbl_sinhvien.*,tbl_lop.ten_lop, dm_trangthai_sinhvien.ten_trangthai_sinhvien');
			$this->db->from('tbl_sinhvien');
			$this->db->join('tbl_lop','tbl_sinhvien.ma_lop = tbl_lop.ma_lop','inner');
			$this->db->join('dm_trangthai_sinhvien','tbl_sinhvien.ma_trangthai_sinhvien = dm_trangthai_sinhvien.ma_trangthai_sinhvien','inner');
			return $this->db->get()->result_array();
		}
		public function locSinhVien($key){
			$this->db->where('CONCAT(hodem_sv, " ", ten_sv) LIKE "%' . $key . '%" OR ma_sv LIKE "%' . $key . '%"');
			$this->db->select('tbl_sinhvien.*,tbl_lop.ten_lop, dm_trangthai_sinhvien.ten_trangthai_sinhvien');
			$this->db->from('tbl_sinhvien');
			$this->db->join('tbl_lop','tbl_sinhvien.ma_lop = tbl_lop.ma_lop','inner');
			$this->db->join('dm_trangthai_sinhvien','tbl_sinhvien.ma_trangthai_sinhvien = dm_trangthai_sinhvien.ma_trangthai_sinhvien','inner');
			return $this->db->get()->result_array();
		}
		public function getMasinhvienSuDung(){
			$this->db->select("ma_sv");
			$this->db->distinct();
			$sv = $this->db->get('tbl_dangkymon')->result_array();

			foreach ($sv as $k => $v) {
				$sv[$k] = $v['ma_sv'];
			}
			$res = array_unique($sv);
			return $res;
		}
		public function getLop(){
			$res = $this->db->get('tbl_lop')->result_array();
			return $res;
		}
		public function getTrangthai(){
			$res = $this->db->get('dm_trangthai_sinhvien')->result_array();
			return $res;
		}
		public function insert($data){
			$this->db->insert('tbl_sinhvien',$data); 
			return $this->db->affected_rows();
		}
		public function delete($ma){
			$this->db->where('ma_sv',$ma);
			$this->db->delete('tbl_sinhvien');
			return $this->db->affected_rows();
		}
		public function getdata($ma){
			$this->db->where('ma_sv',$ma);
			return $this->db->get('tbl_sinhvien')->row_array();
		}
		public function updateData($ma,$data){
			$this->db->where('ma_sv',$ma);
			$this->db->update('tbl_sinhvien',$data);
			return $this->db->affected_rows();
		} 
		public function checkfk($ma)
		{
			$this->db->where('ma_sv',$ma);
			return $this->db->get('tbl_dangkymon')->row_array();
		}
		public function kiemTrasinhvien($madv, $key = null){
			if ($key) {
				$this->db->where('ma_sv !=', $key);
			}
			$this->db->where('ma_sv', $madv);
			return $this->db->get('tbl_sinhvien')->result_array();
		}
		public function getmasv(){
			$this->db->select("ma_sv");
			$temp = $this->db->get("tbl_sinhvien")->result_array();
			foreach ($temp as $k => $v) {
				$res[] = $v['ma_sv'];
			}
			return $res;
		}
		public function getLopConfig(){
			$this->db->select("ma_lop, ten_lop");
			$temp = $this->db->get("tbl_lop")->result_array();
			$res = array();
			foreach ($temp as $k => $v) {
				$res[$v['ten_lop']] = $v['ma_lop'];
			}
			return $res;
		}

		public function getTrangthaiConfig(){
			$this->db->select("ma_trangthai_sinhvien, ten_trangthai_sinhvien");
			$temp = $this->db->get("dm_trangthai_sinhvien")->result_array();
			$res = array();
			foreach ($temp as $k => $v) {
				$res[$v['ten_trangthai_sinhvien']] = $v['ma_trangthai_sinhvien'];
			}
			return $res;
		}

		public function capTaiKhoanSinhVien($taikhoan){
			$this->db->insert('tbl_dangnhap', $taikhoan);
			return $this->db->affected_rows();
		}
	}
?>