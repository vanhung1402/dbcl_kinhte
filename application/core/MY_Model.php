<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	class MY_Model extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		public function layDonViHocVu(){
			$this->db->order_by('namhoc', 'desc');
			$this->db->order_by('kyhoc', 'desc');
			return $this->db->get('tbl_donvihocvu')->result_array();
		}

		public function insertBatch($table, $object){
			$this->db->insert_batch($table, $object);
		}

		public function layDonViCanBo($macanbo){
			$this->db->select('dv.*, UPPER(ten_donvi) as ten_donvi_upper');
			$this->db->where('ma_cb', $macanbo);
			$this->db->from('tbl_canbo cb');
			$this->db->join('tbl_donvi dv', 'cb.ma_donvi = dv.ma_donvi', 'inner');
			return $this->db->get()->row_array();
		}
	}

?>