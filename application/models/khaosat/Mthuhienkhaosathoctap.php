<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class Mthuhienkhaosathoctap extends MY_Model{
		function __construct(){
			parent::__construct();
		}

		public function layPhieuHocTapSinhVien($masv){
			$this->db->select('pht.*, dkm.ma_lopmon, ten_lopmon, ma_donvihocvu, ma_hinhthuc, ctpht.ma_phieu as phieuxong, ten_monhoc');
			$this->db->from('tbl_phieukhaosat_hoctap pht');
			$this->db->join('tbl_dangkymon dkm', 'pht.ma_dkm = dkm.ma_dkm', 'inner');
			$this->db->join('tbl_chitietphieu_hoctap ctpht', 'pht.ma_phieu = ctpht.ma_phieu', 'left');
			$this->db->join('tbl_lopmon lm', 'dkm.ma_lopmon = lm.ma_lopmon', 'inner');
			$this->db->join('tbl_monhoc mh', 'lm.ma_monhoc = mh.ma_monhoc', 'inner');
			$this->db->where('ma_sv', $masv);
			$this->db->where('(CURRENT_DATE() BETWEEN lm.ngaybatdau_khaosat AND lm.ngayketthuc_khaosat)');
			$this->db->group_by('pht.ma_phieu');
			$this->db->order_by('ten_monhoc');
			// $this->db->where('ctpht.ma_phieu IS NULL');
			return $this->db->get()->result_array();
		}

		public function layThongTinPhieu($maphieu){
			$this->db->select('lm.ma_lopmon as malopmon, ks.tieude_khaosat as tenkhaosat, lks.tendm_loaikhaosat as loaikhaosat, ten_monhoc as lopmon, DATE_FORMAT(ngaybd, "%d/%m/%Y") as ngaybatdau, DATE_FORMAT(ngaykt, "%d/%m/%Y") as ngayketthuc, lm.ma_donvihocvu as kyhoc, ks.ma_hinhthuc as hinhthuc, ngaykhaosat as ngayks, ngaybatdau_khaosat, ngayketthuc_khaosat, DATE_FORMAT(ngaybatdau_khaosat, "%d/%m/%Y") as nbdks, DATE_FORMAT(ngayketthuc_khaosat, "%d/%m/%Y") as nktks');
			$this->db->where('ma_phieu', $maphieu);
			$this->db->from('tbl_phieukhaosat_hoctap pht');
			$this->db->join('tbl_dotkhaosat dks', 'pht.ma_dotkhaosat = dks.ma_dotkhaosat', 'inner');
			$this->db->join('tbl_khaosat ks', 'dks.ma_khaosat = ks.ma_khaosat', 'inner');
			$this->db->join('dm_loaikhaosat lks', 'ks.madm_loaikhaosat = lks.madm_loaikhaosat', 'inner');
			$this->db->join('tbl_dangkymon dkm', 'pht.ma_dkm = dkm.ma_dkm', 'inner');
			$this->db->join('tbl_lopmon lm', 'dkm.ma_lopmon = lm.ma_lopmon', 'inner');
			$this->db->join('tbl_monhoc mh', 'lm.ma_monhoc = mh.ma_monhoc', 'inner');
			$thongtin 			= $this->db->get()->row_array();
			$thongtin['canbo'] 	= $this->layGiangVienLopMon($thongtin['malopmon']);

			return $thongtin;
		}

		public function layGiangVienLopMon($ma_lopmon){
			$this->db->select('hodem_cb, ten_cb, sotietday');
			$this->db->where('ma_lopmon', $ma_lopmon);
			$this->db->from('tbl_canbo_lopmon cblm');
			$this->db->join('tbl_canbo cb', 'cblm.ma_cb = cb.ma_cb', 'inner');
			$this->db->order_by('sotietday', 'desc');
			return $this->db->get()->result_array();
		}

		public function layChiTietPhieu($maphieu){
			$this->db->select('ma_cauhoi, ma_dapan, noidung_dapan');
			$this->db->where('ma_phieu', $maphieu);
			return $this->db->get('tbl_chitietphieu_hoctap')->result_array();
		}

		public function layCauHoiPhieu($maphieu){
			$this->db->select('nch.*, dks.ma_khaosat');
			$this->db->from('tbl_phieukhaosat_hoctap pht');
			$this->db->where('pht.ma_phieu', $maphieu);
			$this->db->join('tbl_dotkhaosat dks', 'pht.ma_dotkhaosat = dks.ma_dotkhaosat', 'inner');
			$this->db->join('tbl_nhomcauhoi nch', 'dks.ma_khaosat = nch.ma_khaosat', 'inner');

			$dsnhomcauhoi 		= $this->db->get()->result_array();
			if (empty($dsnhomcauhoi)) {
				return null;
			}
			$ma_khaosat 		= $dsnhomcauhoi[0]['ma_khaosat'];
			$ma_nhomcauhoi 		= array_column($dsnhomcauhoi, 'ma_nhomcauhoi');

			$dscauhoi 			= $this->layCauHoiNhomCauHoi($ma_nhomcauhoi);

			$cauhoi 			= array();
			foreach ($dscauhoi as $ch) {
				if (!isset($cauhoi[$ch['ma_nhomcauhoi']])) {
					$cauhoi[$ch['ma_nhomcauhoi']] 	= array();
				}
				$cauhoi[$ch['ma_nhomcauhoi']][] 	= $ch;
			}

			$chuanhoanhom 		= array();
			foreach ($dsnhomcauhoi as $n) {
				if (isset($cauhoi[$n['ma_nhomcauhoi']])) {
					$n['cauhoi'] = $cauhoi[$n['ma_nhomcauhoi']];
				}
				$chuanhoanhom[$n['ma_nhomcauhoi']] 		= $n;
			}
			return array(
				'nhom' 			=> $dsnhomcauhoi,
				'chuanhoa' 		=> $chuanhoanhom,
				'ma_khaosat' 	=> $ma_khaosat,
			);
		}

		public function layCauHoiNhomCauHoi($dsnhom){
			$this->db->where_in('ma_nhomcauhoi', $dsnhom);
			$this->db->from('tbl_cauhoi ch');
			$dscauhoi 			= $this->db->get()->result_array();
			$ma_cauhoi 			= array_column($dscauhoi, 'ma_cauhoi');
			$cauhoidapan 		= $this->layDapDanCauHoi($ma_cauhoi);

			$chuanhoacauhoi 	= array();

			foreach ($dscauhoi as $ch) {
				if (isset($cauhoidapan[$ch['ma_cauhoi']])) {
					$ch['da'] 		= $cauhoidapan[$ch['ma_cauhoi']];
				}
				$chuanhoacauhoi[$ch['ma_cauhoi']] 	= $ch;
			}

			return $chuanhoacauhoi;
		}

		public function layDapDanCauHoi($dscauhoi){
			$this->db->where_in('ma_cauhoi', $dscauhoi);
			$this->db->from('tbl_dapan da');
			$dsdapan 			= $this->db->get()->result_array();

			$chuanhoadapan 		= array();

			foreach ($dsdapan as $da) {
				if (!isset($chuanhoadapan[$da['ma_cauhoi']])) {
					$chuanhoadapan[$da['ma_cauhoi']] 	= array();
				}
				$chuanhoadapan[$da['ma_cauhoi']][] 		= $da;
			}

			return $chuanhoadapan;
		}

		public function savePhieu($maphieu, $chitiet){
			$this->db->trans_begin();
			$this->deleteChiTietPhieu($maphieu);
			$this->db->insert_batch('tbl_chitietphieu_hoctap', $chitiet);
			$row_insert 		= $this->db->affected_rows();

			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return 0;
			} else {
				$this->db->trans_commit();

				$this->db->where('ma_phieu', $maphieu);
				if ($row_insert) {
					$this->db->update('tbl_phieukhaosat_hoctap', array('thoigian_khaosat' => date('H:i:s d/m/Y')));
				}

				return $this->db->affected_rows();
			}

			return 1;
		}

		private function deleteChiTietPhieu($maphieu){
			$this->db->where('ma_phieu', $maphieu);
			$this->db->delete('tbl_chitietphieu_hoctap');
			return $this->db->affected_rows();
		}

		public function getDateAvailable($maphieu){
			$this->db->select('ngaybatdau_khaosat, ngayketthuc_khaosat');
			$this->db->from('tbl_phieukhaosat_hoctap pht');;
			$this->db->join('tbl_dangkymon dkm', 'pht.ma_dkm = dkm.ma_dkm', 'inner');
			$this->db->join('tbl_lopmon lm', 'dkm.ma_lopmon = lm.ma_lopmon', 'inner');
			$this->db->where('ma_phieu', $maphieu);
			return $this->db->get()->row_array();
		}
	}

?>