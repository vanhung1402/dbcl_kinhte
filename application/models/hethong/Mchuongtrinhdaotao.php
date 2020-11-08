<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Mchuongtrinhdaotao extends MY_Model{
		function __construct(){
			parent::__construct();
		}
		public function get_trinhdo(){
			return $this->db->get('dm_trinhdo')->result_array();
		}
		public function get_hedaotao(){
			return $this->db->get('dm_hedaotao')->result_array();
		}
		public function get_nganh_dv($macb, $quyen = null){
            $this->db->select('madm_nganh,tendm_nganh');
            if ($quyen != 'phongkhaothi') {
	            $this->db->join('tbl_canbo','tbl_canbo.ma_donvi = dm_nganh.ma_donvi');
	            $this->db->where('ma_cb', $macb);
            }

            return $this->db->get('dm_nganh')->result_array();
		}
		public function get_ctdt($macb, $quyen = null){
			$this->db->select('tendm_hedaotao,tendm_trinhdo,tendm_nganh,tbl_ctdt.ma_ctdt,nam, kh.ma_khoahoc');
			$this->db->join('dm_hedaotao','dm_hedaotao.madm_hedaotao = tbl_ctdt.madm_hedaotao');
			$this->db->join('dm_trinhdo','dm_trinhdo.madm_trinhdo = tbl_ctdt.madm_trinhdo');
			$this->db->join('dm_nganh','dm_nganh.madm_nganh = tbl_ctdt.madm_nganh');
			$this->db->join('tbl_khoahoc kh', 'tbl_ctdt.ma_ctdt = kh.ma_ctdt', 'left');
			if ($quyen != 'phongkhaothi') {
	            $this->db->join('tbl_canbo','tbl_canbo.ma_donvi = dm_nganh.ma_donvi');
				$this->db->where('ma_cb',$macb);
            }
			
			$this->db->order_by('tendm_nganh','ASC');
			$this->db->order_by('nam','ASC');
			$this->db->group_by('tbl_ctdt.ma_ctdt');
			return $this->db->get('tbl_ctdt')->result_array();
		}
		public function get_mon_ctdt(){
			$this->db->select('ma_ctdt');
			$this->db->group_by('ma_ctdt');
			return $this->db->get('tbl_mon_ctdt')->result_array();
		}
		public function get_ctdt_ma($ma_ctdt){
			$this->db->join('dm_hedaotao','dm_hedaotao.madm_hedaotao = tbl_ctdt.madm_hedaotao');
			$this->db->join('dm_trinhdo','dm_trinhdo.madm_trinhdo = tbl_ctdt.madm_trinhdo');
			$this->db->join('dm_nganh','dm_nganh.madm_nganh = tbl_ctdt.madm_nganh');
			$this->db->where('ma_ctdt',$ma_ctdt);
			return $this->db->get('tbl_ctdt')->row_array();
		}
		public function insert_ctdt($ctdt){
			$this->db->insert('tbl_ctdt',$ctdt);
			return $this->db->affected_rows();
		}
		public function get_dl_ctdt($ma_ctdt){
			$this->db->where('ma_ctdt',$ma_ctdt);
			return $this->db->get('tbl_ctdt')->row_array();
		}
		public function update_ctdt($ctdt,$ma_ctdt){
			$this->db->where('ma_ctdt',$ma_ctdt);
			return $this->db->update('tbl_ctdt',$ctdt);
		}
		public function delete_chuongtrinhdaotao($ma_ctdt){
			$this->db->where('ma_ctdt',$ma_ctdt);
			return $this->db->delete('tbl_ctdt');								
		}
		public function get_id_max(){
			$query = $this->db->query("SELECT MAX(`ma_ctdt`*1)+1 AS newid FROM tbl_ctdt");
        	return $query->result_array();
		}
	}

?>