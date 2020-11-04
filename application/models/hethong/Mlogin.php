<?php

	class Mlogin extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		public function getBaseUser($username, $password){
			$where 	= array(
				'ten_dangnhap' 		=> $username,
				'matkhau_dangnhap' 	=> sha1($password),
			);

			$this->db->where($where);
			return $this->db->get('tbl_dangnhap')->row_array();
		}

		public function getHightUser($username, $password){
			$where 	= array(
				'ten_dangnhap' 		=> $username,
				'matkhau_dangnhap' 	=> $password,
			);

			$this->db->where($where);
			return $this->db->get('tbl_dangnhap')->row_array();
		}

		public function getInfor($username){
			$user 					= $this->session->userdata('user');
			if ($user && $user['quyen'] == 'phongkhaothi') {
				$where 	= array(
					'ten_dangnhap' 		=> $username,
				);

				$this->db->where($where);
				return $this->db->get('tbl_dangnhap')->row_array();		
			}else{
				return null;
			}
		}

		public function getTen($macb, $masv){
			if ($macb != '') {
				$this->db->select('hodem_cb, ten_cb');
				$this->db->where('ma_cb', $macb);
				$result 			= $this->db->get('tbl_canbo')->row_array();
				return ($result) ? $result['hodem_cb'] . ' ' . $result['ten_cb'] : 'Cán bộ chưa có tên';
			}else if ($masv != '') {
				$this->db->select('hodem_sv, ten_sv');
				$this->db->where('ma_sv', $masv);
				$result 			= $this->db->get('tbl_sinhvien')->row_array();
				return ($result) ? $result['hodem_sv'] . ' ' . $result['ten_sv'] : 'Sinh viên chưa có tên';
			}

			return '';
		}

		public function doiMatKhau($username, $password){
			$this->db->where('ten_dangnhap', $username);
			$this->db->update('tbl_dangnhap', array(
				'matkhau_dangnhap' 	=> sha1($password),
				'trangthai' 		=> 1,
			));
			return $this->db->affected_rows();
		}
	}

?>