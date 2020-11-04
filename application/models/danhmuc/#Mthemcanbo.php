<?php 
	class Mthemcanbo extends CI_Model{
		public function getListcanbo(){ 
			$this->db->select('tbl_canbo.*,tbl_donvi.ten_donvi, dm_hochamhocvi.ten_hocham, dm_hocvi.ten_hocvi');
			$this->db->from('tbl_canbo');
			$this->db->join('tbl_donvi','tbl_canbo.ma_donvi = tbl_donvi.ma_donvi','inner');
			$this->db->join('dm_hochamhocvi','tbl_canbo.ma_hocham = dm_hochamhocvi.ma_hocham','inner');
			$this->db->join('dm_hocvi','tbl_canbo.ma_hocvi = dm_hocvi.ma_hocvi','inner');
			return $this->db->get()->result_array();
		}
		public function getMacanboSuDung(){
			$this->db->select("ma_canbo_quanly");
			$this->db->distinct();
			$cb = $this->db->get('tbl_lop')->result_array();

			foreach ($cb as $k => $v) {
				$cb[$k] = $v['ma_canbo_quanly'];
			}
			$res = array_unique($cb);
			return $res;
		}
		public function getDonvi(){

			$res = $this->db->get('tbl_donvi')->result_array();
			return $res;
		}

		public function getHocham(){

			$res = $this->db->get('dm_hochamhocvi')->result_array();
			return $res;
		}

		public function getHocvi(){
			$res = $this->db->get('dm_hocvi')->result_array();
			return $res;
		}
		public function insert($data){ 
			$this->db->insert('tbl_canbo',$data);
			return $this->db->affected_rows(); 
		}

		public function delete($ma){
			$this->db->where('ma_cb',$ma);
			$this->db->delete('tbl_canbo');
			return $this->db->affected_rows();
		}
		public function getdata($ma){
			$this->db->where('ma_cb',$ma);
			return $this->db->get('tbl_canbo')->row_array();
		}
		public function updateData($ma,$data){
			$this->db->where('ma_cb',$ma);
			$this->db->update('tbl_canbo',$data);
			return $this->db->affected_rows();
		}
		
		public function checkfk($ma)
		{
			$this->db->where('ma_canbo_quanly',$ma);
			return $this->db->get('tbl_lop')->row_array();
			
		}
		//excel
		public function getDonviConfig(){
			$this->db->select("ma_donvi, ten_donvi");
			$temp = $this->db->get("tbl_donvi")->result_array();
			$res = array();
			foreach ($temp as $k => $v) {
				$res[$v['ten_donvi']] = $v['ma_donvi'];
			}
			return $res;
		}

		public function getHochamConfig(){
			$this->db->select("ma_hocham, ten_hocham");
			$temp = $this->db->get("dm_hochamhocvi")->result_array();
			$res = array();
			foreach ($temp as $k => $v) {
				$res[$v['ten_hocham']] = $v['ma_hocham'];
			}
			return $res;
		}
		public function getHocviConfig(){
			$this->db->select("ma_hocvi, ten_hocvi");
			$temp = $this->db->get("dm_hocvi")->result_array();
			$res = array();
			foreach ($temp as $k => $v) {
				$res[$v['ten_hocvi']] = $v['ma_hocvi'];
			}
			return $res;
		}

	}
?>
