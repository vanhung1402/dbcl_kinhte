<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');
	class Mchitietkhaosathoctap extends MY_Model{
		function __construct(){
			parent::__construct();
		}

		public function layThongTinLopMon($ma_lopmon, $ma_dotkhaosat){
			$this->db->select('lm.ma_lopmon, ten_lopmon, ma_donvihocvu, ma_hinhthuc, DATE_FORMAT(ngaybd, "%d/%m/%Y") as nbd, DATE_FORMAT(ngaykt, "%d/%m/%Y") as nkt, DATE_FORMAT(ngaybatdau_khaosat, "%d/%m/%Y") as ngaybdks, DATE_FORMAT(ngayketthuc_khaosat, "%d/%m/%Y") as ngayktks, ten_monhoc, UPPER(ten_donvi) as donvi');
			$this->db->from('tbl_lopmon lm');
			$this->db->where('lm.ma_lopmon', $ma_lopmon);
			$this->db->join('tbl_monhoc mh', 'lm.ma_monhoc = mh.ma_monhoc', 'inner');
			$this->db->join('tbl_lopmon_monctdt lmmctdt', 'lm.ma_lopmon = lmmctdt.ma_lopmon', 'inner');
			$this->db->join('tbl_mon_ctdt mctdt', 'lmmctdt.ma_mon_ctdt = mctdt.ma_mon_ctdt', 'inner');
			$this->db->join('tbl_ctdt ctdt', 'mctdt.ma_ctdt = ctdt.ma_ctdt', 'inner');
			$this->db->join('dm_nganh n', 'ctdt.madm_nganh = n.madm_nganh', 'inner');
			$this->db->join('tbl_donvi dv', 'n.ma_donvi = dv.ma_donvi', 'inner');

			$thongtin 						= $this->db->get()->row_array();

			$canbo_lopmon 					= $this->layGiangVienLopMon($ma_lopmon);

			$thongtin['canbo'] 				= array();
			if ($canbo_lopmon) {
				foreach ($canbo_lopmon as $cb) {
					$thongtin['canbo'][] 	= $cb['hodem_cb'] . ' ' . $cb['ten_cb'];
				}
			}

			$thongtin['canbo'] 				= implode(' | ', $thongtin['canbo']);

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

		/*public function laySinhVienLopMon($ma_lopmon, $ma_dotkhaosat){
			$this->db->select('sv.*, l.ten_lop, sv.ma_lop, sv.gioitinh_sv, DATE_FORMAT(ngaysinh_sv, "%d/%m/%Y") as ngaysinh, pht.ma_phieu, pht.thoigian_khaosat');
			$this->db->from('tbl_dangkymon dkm');
			$this->db->join('tbl_phieukhaosat_hoctap pht', 'dkm.ma_dkm = pht.ma_dkm', 'left');
			$this->db->join('tbl_sinhvien sv', 'dkm.ma_sv = sv.ma_sv', 'inner');
			$this->db->join('tbl_lop l', 'sv.ma_lop = l.ma_lop', 'inner');

			$this->db->where('dkm.ma_lopmon', $ma_lopmon);
			$this->db->where("(pht.ma_dotkhaosat = $ma_dotkhaosat OR pht.ma_dotkhaosat IS NULL)");
			$this->db->group_by('dkm.ma_dkm');
			$this->db->order_by('ten_sv');
			$this->db->get()->result_array();
			pr($this->db->last_query());
		}*/

		public function laySinhVienLopMon($ma_lopmon){
			$this->db->select('sv.*, l.ten_lop, sv.ma_lop, sv.gioitinh_sv, DATE_FORMAT(ngaysinh_sv, "%d/%m/%Y") as ngaysinh, dkm.ma_dkm');
			$this->db->from('tbl_dangkymon dkm');
			$this->db->where('dkm.ma_lopmon', $ma_lopmon);
			$this->db->join('tbl_sinhvien sv', 'dkm.ma_sv = sv.ma_sv', 'inner');
			$this->db->join('tbl_lop l', 'sv.ma_lop = l.ma_lop', 'inner');
			$this->db->order_by('ten_sv');

			return $this->db->get()->result_array();
		}

		public function laySinhVienKhaoSatLopMon($ma_lopmon, $ma_dotkhaosat){
			$this->db->select('dkm.ma_dkm, ma_phieu, thoigian_khaosat');
			$this->db->from('tbl_dangkymon dkm');
			$this->db->join('tbl_phieukhaosat_hoctap pht', 'dkm.ma_dkm = pht.ma_dkm', 'innert');
			$this->db->where('dkm.ma_lopmon', $ma_lopmon);
			$this->db->where('pht.ma_dotkhaosat', $ma_dotkhaosat);

			return $this->db->get()->result_array();
		}
	}

?>