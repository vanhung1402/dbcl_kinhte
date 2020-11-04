<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class Mdotkhaosathoctap extends MY_Model{
		function __construct(){
			parent::__construct();
		}

		public function layThongTinKhaoSat($ma_khaosat){
			$this->db->select('ks.*, tendm_loaikhaosat');
			$this->db->from('tbl_khaosat ks');
			$this->db->where('ma_khaosat', $ma_khaosat);
			$this->db->join('dm_loaikhaosat lks', 'ks.madm_loaikhaosat = lks.madm_loaikhaosat', 'inner');
			return $this->db->get()->row_array();
		}

		public function layDanhSachDotKhaoSat($ma_khaosat, $trangthai = null){
			$this->db->select('dks.*, ma_hinhthuc, DATE_FORMAT(thoigianbd, "%d/%m/%Y") as nbd, DATE_FORMAT(thoigiankt, "%d/%m/%Y") as nkt');
			$this->db->from('tbl_dotkhaosat dks');
			$this->db->join('tbl_khaosat ks', 'dks.ma_khaosat = ks.ma_khaosat', 'inner');
			$this->db->where('dks.ma_khaosat', $ma_khaosat);
			if ($trangthai) {
				$this->db->where('dks.madm_trangthai_dotkhaosat', $trangthai);
			}
			$this->db->order_by('dks.ma_donvihocvu', 'desc');

			$dsdotkhaosat 		= $this->db->get()->result_array();

			if (empty($dsdotkhaosat)) {
				return $dsdotkhaosat;
			}

			$dsma_dks 			= array_column($dsdotkhaosat, 'ma_dotkhaosat');

			$hinhthuc 			= $dsdotkhaosat[0]['ma_hinhthuc'];
			$donvihocvu 		= array_unique(array_column($dsdotkhaosat, 'ma_donvihocvu'));
			$dotkhaosat 		= array();
			$lopmondot 			= $this->layLopMonKhaoSat($donvihocvu, $hinhthuc);
			$chitietdot 		= $this->layChiTietKhaoSat($dsma_dks);
			$chitietdot 		= handingKeyArray($chitietdot, 'ma_dotkhaosat');

			foreach ($dsdotkhaosat as $dot) {
				if (isset($lopmondot[$dot['ma_donvihocvu']])) {
					$dot 		= array_merge($dot, $lopmondot[$dot['ma_donvihocvu']]);
				}

				if (isset($chitietdot[$dot['ma_dotkhaosat']])) {
					$dot 		= array_merge($dot, $chitietdot[$dot['ma_dotkhaosat']]);
				}

				$dotkhaosat[]  	= $dot;
			}

			return $dotkhaosat;
		}

		public function layLopMonKhaoSat($donvihocvu, $hinhthuc){
			$this->db->select('lm.ma_donvihocvu, count(DISTINCT lm.ma_lopmon) as tonglopmon, count(DISTINCT dkm.ma_sv) as tongsinhvien, count(dkm.ma_dkm) as sophieukhadung');
			$this->db->from('tbl_lopmon lm');
			$this->db->join('tbl_dangkymon dkm', 'lm.ma_lopmon = dkm.ma_lopmon', 'inner');
			$this->db->where('lm.ma_hinhthuc', $hinhthuc);
			$this->db->where_in('lm.ma_donvihocvu', $donvihocvu);
			$this->db->where_in('lm.madm_trangthai_lopmon', array('daduyet', 'ketthuc'));
			$this->db->group_by('lm.ma_donvihocvu');

			$lopmonkhaosat 		= $this->db->get()->result_array();
			$khaosat 			= array();

			foreach ($lopmonkhaosat as $dvhv) {
				$khaosat[$dvhv['ma_donvihocvu']] 	= $dvhv;
			}

			return $khaosat;
		}

		public function layChiTietKhaoSat($dsma_dks){
			if (empty($dsma_dks)) {
				return $dsma_dks;
			}

			$this->db->select('pht.ma_dotkhaosat, count(pht.ma_phieu) as phieudatao, count(pht.thoigian_khaosat) as dakhaosat');
			$this->db->from('tbl_phieukhaosat_hoctap pht');
			$this->db->where_in('pht.ma_dotkhaosat', $dsma_dks);
			$this->db->group_by('pht.ma_dotkhaosat');
			return $this->db->get()->result_array();
		}

		public function layDotKhaoSat($ma_dotkhaosat){
			$this->db->where('ma_dotkhaosat', $ma_dotkhaosat);
			$this->db->order_by('ma_donvihocvu', 'desc');
			return $this->db->get('tbl_dotkhaosat')->row_array();
		}

		public function xoaDotKhaoSat($maxoadot){
			$this->db->where('ma_dotkhaosat', $maxoadot);
			$this->db->delete('tbl_dotkhaosat');
			return $this->db->affected_rows();
		}

		public function layDanhSachLopMon($hinhthuc, $donvihocvu, $dotkhaosat){
			$where 				= array(
				'ma_donvihocvu'	=> $donvihocvu,
				'ma_hinhthuc' 	=> $hinhthuc,
			);

			$this->db->select('
				lm.ma_lopmon,
				ten_lopmon, 
				DATE_FORMAT(ngaykhaosat, "%d/%m/%Y") as thoigianks, 
				DATE_FORMAT(ngaybatdau_khaosat, "%d/%m/%Y") as nbdks, 
				DATE_FORMAT(ngayketthuc_khaosat, "%d/%m/%Y") as nktks, 
				DATE_FORMAT(ngaybd, "%d/%m/%Y") as nbd, 
				DATE_FORMAT(ngaykt, "%d/%m/%Y") as nkt, 
				lm.madm_trangthai_lopmon, 
				tendm_trangthai_lopmon, 
				ma_hinhthuc');
			$this->db->from('tbl_lopmon lm');
			$this->db->where_in('lm.madm_trangthai_lopmon', array('daduyet', 'ketthuc'));
			$this->db->where($where);
			$this->db->join('dm_trangthai_lopmon ttlm', 'lm.madm_trangthai_lopmon = ttlm.madm_trangthai_lopmon', 'inner');
			$this->db->order_by('ten_lopmon');
			$ds_lopmon 			= $this->db->get()->result_array();

			$col_ma_lopmon 		= array_column($ds_lopmon, 'ma_lopmon');
			$canbo_lopmon 		= $this->layCanBoLopMon($col_ma_lopmon);
			$chitiet_lopmon 	= $this->layChiTietLopMon($col_ma_lopmon, $dotkhaosat);

			$lopmon 			= array();
			foreach ($ds_lopmon as $lm) {
				$lm['canbo'] 	= (isset($canbo_lopmon[$lm['ma_lopmon']])) ? $canbo_lopmon[$lm['ma_lopmon']] : array();
				$lm['chitiet'] 	= $chitiet_lopmon[$lm['ma_lopmon']];
				$lopmon[] 	= $lm;
			}

			return $lopmon;
		}

		public function layCanBoLopMon($dslopmon){
			if (empty($dslopmon)) {
				return null;
			}

			$this->db->where_in('ma_lopmon', $dslopmon);
			$this->db->select('ma_lopmon, cb.ma_cb, hodem_cb, ten_cb, sotietday');
			$this->db->from('tbl_canbo_lopmon cblm');
			$this->db->join('tbl_canbo cb', 'cblm.ma_cb = cb.ma_cb', 'inner');
			$ds_canbo 			= $this->db->get()->result_array();

			$canbo_lopmon 		= array();
			foreach ($ds_canbo as $cb) {
				if (!isset($canbo_lopmon['ma_lopmon'])) {
					$canbo_lopmon['ma_lopmon'] 		= array();
				}
				$canbo_lopmon[$cb['ma_lopmon']][] 	= $cb;
			}

			return $canbo_lopmon;
		}

		public function layChiTietLopMon($dslopmon, $dotkhaosat){
			if (empty($dslopmon)) {
				return null;
			}

			$this->db->select('ma_lopmon, count(dkm.ma_dkm) as sosinhvien');
			$this->db->from('tbl_dangkymon dkm');
			$this->db->where_in('ma_lopmon', $dslopmon);
			$this->db->group_by('ma_lopmon');
			$ds_dangkymon 		= $this->db->get()->result_array();
			$ds_phieu 			= $this->laySoPhieuLopMon($dslopmon, $dotkhaosat);

			$chitiet_lopmon 	= array();
			foreach ($ds_dangkymon as $dkm) {
				if (!isset($chitiet_lopmon[$dkm['ma_lopmon']])) {
					$chitiet_lopmon[$dkm['ma_lopmon']] 	= array();
				}
				$dkm['sophieu'] 	= (isset($ds_phieu[$dkm['ma_lopmon']]['sophieu'])) ? $ds_phieu[$dkm['ma_lopmon']]['sophieu'] : 0;
				$dkm['dakhaosat'] 	= (isset($ds_phieu[$dkm['ma_lopmon']]['dakhaosat'])) ? $ds_phieu[$dkm['ma_lopmon']]['dakhaosat'] : 0;
				$chitiet_lopmon[$dkm['ma_lopmon']] 	= $dkm;
			}

			return $chitiet_lopmon;
		}

		public function laySoPhieuLopMon($dslopmon, $dotkhaosat){
			if (empty($dslopmon)) {
				return null;
			}

			$this->db->select('ma_lopmon, count(DISTINCT pht.ma_phieu) as sophieu, count(DISTINCT ctpht.ma_phieu) as dakhaosat');
			$this->db->from('tbl_dangkymon dkm');
			$this->db->join('tbl_phieukhaosat_hoctap pht', 'dkm.ma_dkm = pht.ma_dkm', 'left');
			$this->db->join('tbl_chitietphieu_hoctap ctpht', 'pht.ma_phieu = ctpht.ma_phieu', 'left');
			$this->db->where_in('ma_lopmon', $dslopmon);
			$this->db->where('ma_dotkhaosat', $dotkhaosat);
			$this->db->group_by('ma_lopmon');
			$ds_phieu	 		= $this->db->get()->result_array();

			$chitiet_lopmon 	= array();
			foreach ($ds_phieu as $dkm) {
				$chitiet_lopmon[$dkm['ma_lopmon']] 	= $dkm;
			}

			return $chitiet_lopmon;
		}

		public function setMocKhaoSatLopMon($ma_lopmon, $mockhaosat){
			$update 			= array(
				'ngaykhaosat' 	=> $mockhaosat
			);
			$this->db->where_in('ma_lopmon', $ma_lopmon);
			$this->db->update('tbl_lopmon', $update);

			return $this->db->affected_rows();
		}


		public function setThoiGianSatLopMon($ma_lopmon, $nbdks, $nktks){
			$update 			= array(
				'ngaybatdau_khaosat'	=> $nbdks,
				'ngayketthuc_khaosat'	=> $nktks,
			);
			$this->db->where_in('ma_lopmon', $ma_lopmon);
			$this->db->update('tbl_lopmon', $update);

			return $this->db->affected_rows();
		}


		public function setMocKhaoSat($hinhthuc, $donvihocvu, $mockhaosat){
			$update 			= array(
				'ngaykhaosat' 	=> $mockhaosat
			);
			$where 				= array(
				'ma_donvihocvu'	=> $donvihocvu,
				'ma_hinhthuc' 	=> $hinhthuc,
			);

			$this->db->where($where);
			$this->db->update('tbl_lopmon', $update);

			return $this->db->affected_rows();
		}

		public function createSurveyForm($dslopmon, $ma_dotkhaosat){
			$time 				= time();
			$time_control 		= time();

			if (empty($dslopmon)) {
				return null;
			}

			$dsdkm 				= $this->getAllCourseRegistration($dslopmon, $ma_dotkhaosat);

			if (empty($dsdkm)) {
				return null;
			}

			foreach ($dsdkm as $key => $dkm) {
				$dkm['ma_phieu'] 		= $time . ($time_control++);
				$dkm['ma_dotkhaosat'] 	= $ma_dotkhaosat;
				$dsdkm[$key] 			= $dkm;
			}

			$this->db->insert_batch('tbl_phieukhaosat_hoctap', $dsdkm);
			return $this->db->affected_rows();
		}

		public function removeSurveyForm($dslopmon, $ma_dotkhaosat){
			if (empty($dslopmon)) {
				return null;
			}

			$dslopmon = implode("','", $dslopmon);

			$this->db->where('ma_dotkhaosat', $ma_dotkhaosat);
			$this->db->where("ma_dkm IN (SELECT ma_dkm FROM tbl_dangkymon WHERE ma_lopmon IN ('$dslopmon'))");
			$this->db->delete('tbl_phieukhaosat_hoctap');
			return $this->db->affected_rows();
		}


		public function getAllCourseRegistration($dslopmon, $ma_dotkhaosat = null){
			$this->db->select('dkm.ma_dkm');
			$this->db->from('tbl_dangkymon dkm');
			$this->db->where_in('ma_lopmon', $dslopmon);

			if ($ma_dotkhaosat != null) {
				$this->db->where("(ma_dkm NOT IN (SELECT ma_dkm FROM tbl_phieukhaosat_hoctap WHERE ma_dotkhaosat = $ma_dotkhaosat))");
			}

			return $this->db->get()->result_array();
		}

		public function getMaxMaDotKhaoSat(){
			$this->db->select('max(ma_dotkhaosat * 1) as max_madot');
			$result = $this->db->get('tbl_dotkhaosat')->row_array();
			return $result['max_madot'];
		}

		public function themDotKhaoSat($dotkhaosat){
			$this->db->insert('tbl_dotkhaosat', $dotkhaosat);
			return $this->db->affected_rows();
		}

		public function kiemTraDotKhaoSat($ma_khaosat, $donvihocvu){
			$where 				= array(
				'ma_donvihocvu' => $donvihocvu,
				'ma_khaosat' 	=> $ma_khaosat
			);

			$this->db->where($where);
			return $this->db->get('tbl_dotkhaosat')->row_array();
		}

		public function updateDotKhaoSat($ma_dotkhaosat, $data){
			$this->db->where('ma_dotkhaosat', $ma_dotkhaosat);
			$this->db->update('tbl_dotkhaosat', $data);

			return $this->db->affected_rows();
		}

		public function layKhaoSatHocTap(){
			$this->db->from('tbl_khaosat');
			$this->db->where('madm_loaikhaosat', 'khaosathoctap');
			
			return $this->db->get()->result_array();
		}

		public function khoaDotKhaoSat($makhoadot){
			$this->db->where('ma_dotkhaosat', $makhoadot);
			$this->db->update('tbl_dotkhaosat', array('madm_trangthai_dotkhaosat' => 0));

			return $this->db->affected_rows();
		}
	}

?>