<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Mhethong extends MY_Model{
		function __construct(){
			parent::__construct();
		}

		public function layMenuQuyen($quyen){
			$this->db->select('r.id_route, ten_route, icon_route, m.id_menu, ten_menu, icon_menu, hienthi_menu');
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

		public function checkQuyen($route, $quyen){
			$where 		= array(
				'ma_quyen' 	=> $quyen,
				'id_route' 	=> $route
			);

			$this->db->select('id_route');
			$this->db->where($where);
			$has_route 	= $this->db->get('tbl_phanquyen')->row_array();

			return !empty($has_route);
		}

		public function layThongTinCanBo($macb){
			$this->db->select('cb.*, dv.*, hh.*, ngaysinh_cb as ngaysinh, q.ma_quyen, ten_quyen');
			$this->db->from('tbl_canbo cb');
			$this->db->join('tbl_donvi dv', 'cb.ma_donvi = dv.ma_donvi', 'inner');
			$this->db->join('dm_hochamhocvi hh', 'cb.ma_hocham = hh.ma_hocham', 'inner');
			$this->db->join('tbl_dangnhap dn', 'cb.ma_cb = dn.ma_canbo', 'inner');
			$this->db->join('tbl_quyen q', 'dn.ma_quyen = q.ma_quyen', 'inner');
			$this->db->where('cb.ma_cb', $macb);
			return $this->db->get()->row_array();
		}

		public function layThongTinSinhVien($masv){
			$this->db->select('*, DATE_FORMAT(ngaysinh_sv, "%d/%m/%Y") as ngaysinh');
			$this->db->from('tbl_sinhvien sv');
			$this->db->join('tbl_lop l', 'sv.ma_lop = l.ma_lop', 'inner');
			$this->db->join('dm_trangthai_sinhvien ttsv', 'sv.ma_trangthai_sinhvien = ttsv.ma_trangthai_sinhvien', 'left');
			$this->db->where('sv.ma_sv', $masv);
			return $this->db->get()->row_array();
		}

		public function layThongTinKhaoSat($masv, $dvhv){
			$this->db->where(array(
				'ma_sv' 			=> $masv,
				'dks.ma_donvihocvu' => $dvhv
			));
			
			$this->db->select('count(pht.ma_phieu) as sophieutrong');
			$this->db->where('thoigian_khaosat IS NULL');
			$this->db->where('(CURRENT_DATE() BETWEEN lm.ngaybatdau_khaosat AND lm.ngayketthuc_khaosat)');
			$this->db->from('tbl_dangkymon dkm');
			$this->db->join('tbl_lopmon lm', 'dkm.ma_lopmon = lm.ma_lopmon', 'inner');
			$this->db->join('tbl_phieukhaosat_hoctap pht', 'dkm.ma_dkm = pht.ma_dkm', 'inner');
			$this->db->join('tbl_dotkhaosat dks', 'pht.ma_dotkhaosat = dks.ma_dotkhaosat', 'inner');
			return $this->db->get()->row_array();
		}
	}

?>