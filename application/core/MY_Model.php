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
	}

?>