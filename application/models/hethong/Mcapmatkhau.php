<?php

	class Mcapmatkhau extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		public function xacthuc_sinhvien($ma_sv,$email){
            $where 	= array(
				'ma_sv' 	=> $ma_sv,
				'email' 	=> $email,
            );
			$this->db->where($where);
            return $this->db->get('tbl_sinhvien')->row_array();
        }
        public function reset_matkhau($ma_sv,$pass_new){
            $data = array(
                'trangthai' => "0",
                'matkhau_dangnhap' => sha1($pass_new),
            );
            $this->db->where('ma_sv',$ma_sv);
            $this->db->update('tbl_dangnhap',$data);
            return $this->db->affected_rows();
        }
        public function get_email($masv){
			$this->db->where('ma_sv',$masv);
			return $this->db->get('tbl_sinhvien')->row_array();
		}
		public function doiEmail($ma_sv,$email){
			$this->db->set('email',$email);
			$this->db->where('ma_sv',$ma_sv);
			$this->db->update('tbl_sinhvien');
			return $this->db->affected_rows();
        }
        public function insert_token_email($token){
            return $this->db->insert('tbl_token',$token);
        }
        public function get_token($token){
            $this->db->where('token',$token);
            return $this->db->get('tbl_token')->row_array();
        }
        public function get_token_latest($ma_sv){
            $this->db->select_max('time_token');
            $this->db->where('ma_sv',$ma_sv);
            return $this->db->get('tbl_token')->row_array();
        }
	}

?>