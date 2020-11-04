<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Mkhoahoc extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		public function layMenuQuyen($quyen){
			$this->db->select('id_route, ten_route, icon_route, m.id_menu, ten_menu, icon_menu, hienthi_menu');
			$this->db->from('tbl_router r');

			if ($quyen !== 'admin') {
				$this->db->where('ma_quyen', $quyen);
				$this->db->join('tbl_phanquyen pq', 'r.id_route = pq.id_route', 'inner');
			}

			$this->db->join('tbl_menu m', 'r.id_menu = m.id_menu', 'inner');
			$this->db->where('r.hienthi_route', '1');
			$this->db->order_by('thutu_menu, thutu_route');
			return $this->db->get()->result_array();
        }
        public function get_nganh_dv($macb){
            $this->db->select('madm_nganh,tendm_nganh');
            $this->db->join('tbl_canbo','tbl_canbo.ma_donvi = dm_nganh.ma_donvi');
            $this->db->where('ma_cb',$macb);
            return $this->db->get('dm_nganh')->result_array();
        }
        public function layChuongTrinhDaoTao($macb){
            $this->db->from('dm_nganh');
            $this->db->join('tbl_canbo','tbl_canbo.ma_donvi = dm_nganh.ma_donvi');
            $this->db->join('tbl_ctdt', 'dm_nganh.madm_nganh = tbl_ctdt.madm_nganh', 'inner');
            $this->db->where('ma_cb',$macb);
            return $this->db->get()->result_array();
        }
        public function get_khoahoc($ma_khoahoc = null,$macb= null){
            $this->db->select('ma_khoahoc,dm_nganh.madm_nganh,tendm_nganh, DATE_FORMAT(ngaytao, "%d/%m/%Y") as ngaytao,namhoc, ctdt.nam as namctdt, ctdt.ma_ctdt');
            $this->db->join('tbl_ctdt ctdt', 'tbl_khoahoc.ma_ctdt = ctdt.ma_ctdt', 'inner');
            $this->db->join('dm_nganh','dm_nganh.madm_nganh = ctdt.madm_nganh');
            if($macb != null){
                $this->db->join('tbl_canbo','tbl_canbo.ma_donvi = dm_nganh.ma_donvi');
                $this->db->where('ma_cb',$macb);
            }
            if($ma_khoahoc != null){
                $this->db->where('ma_khoahoc',$ma_khoahoc);
            }
            $this->db->order_by('tendm_nganh','ASC');
            $this->db->order_by('namhoc','ASC');
            $query =  $this->db->get('tbl_khoahoc')->result_array();
            return $query;
        }
        public function them_khoahoc($khoahoc){
            $this->db->insert('tbl_khoahoc',$khoahoc);
            return $this->db->affected_rows();
        }
        public function delete_khoahoc($ma_khoahoc){
            $this->db->where('ma_khoahoc',$ma_khoahoc);
            $this->db->delete('tbl_khoahoc');
            return $this->db->affected_rows();
        }
        public function capnhat_khoahoc($ma_khoahoc,$khoahoc){
            $this->db->where('ma_khoahoc',$ma_khoahoc);
            $this->db->update('tbl_khoahoc',$khoahoc);
        }
        public function get_lop_khoahoc(){
            $this->db->join('tbl_lop','tbl_lop.ma_khoahoc = tbl_khoahoc.ma_khoahoc');
            return $this->db->get('tbl_khoahoc')->result_array();
        }
	}

?>