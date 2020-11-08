<?php

	class Mchude extends MY_Model{
		function __construct(){
			parent::__construct();
		}

		public function getTopic($ma_khaosat){
			$this->db->select('nch.*, ch.ma_cauhoi');
			$this->db->from('tbl_nhomcauhoi nch');
			$this->db->join('tbl_cauhoi ch', 'nch.ma_nhomcauhoi = ch.ma_nhomcauhoi', 'left');
			$this->db->where('ma_khaosat', $ma_khaosat);
			$this->db->order_by('ma_nhomcha');
			$this->db->group_by('nch.ma_nhomcauhoi');
			return $this->db->get()->result_array();
		}

		public function insertBatchTopic($listtopic){
			$this->db->insert_batch('tbl_nhomcauhoi', $listtopic);
			return $this->db->affected_rows();
		}

		public function updateBatchTopic($listtopic){
			$this->db->update_batch('tbl_nhomcauhoi', $listtopic, 'ma_nhomcauhoi');
			return $this->db->affected_rows();
		}

		public function deleteMultipleTopic($array_id_topic){
			$this->db->where_in('ma_nhomcauhoi', $array_id_topic);
			$this->db->delete('tbl_nhomcauhoi');
			return $this->db->affected_rows();
		}
	}

?>