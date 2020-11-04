<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class Cchitietkhaosathoctap extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('khaosat/Mchitietkhaosathoctap');
		}

		public function index(){
			$temp['data'] 			= $this->layDuLieu();
			$temp['template'] 		= 'khaosat/Vchitietkhaosathoctap';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function layDuLieu(){
			$ma_lopmon 				= $this->input->get('lopmon');
			$ma_dotkhaosat 			= $this->input->get('dot');	

			$thongtin_lopmon 		= $this->Mchitietkhaosathoctap->layThongTinLopMon($ma_lopmon, $ma_dotkhaosat);

			$dssinhvien_lopmon 		= $this->Mchitietkhaosathoctap->laySinhVienLopMon($ma_lopmon);
			$dskhaosat_lopmon 		= $this->Mchitietkhaosathoctap->laySinhVienKhaoSatLopMon($ma_lopmon, $ma_dotkhaosat);
			$dskhaosat_lopmon 		= handingKeyArray($dskhaosat_lopmon, 'ma_dkm');

			// $ds_sinhvien 			= $this->Mchitietkhaosathoctap->laySinhVienLopMon($ma_lopmon, $ma_dotkhaosat);

			return array(
				'url' 				=> base_url(),
				'chuaks' 			=> array(),
				'chuacophieu' 		=> array(),
				'ma_lopmon' 		=> $ma_lopmon,
				'ma_dotkhaosat' 	=> $ma_dotkhaosat,
				'ttlm' 				=> $thongtin_lopmon,
				'dssinhvien' 		=> $dssinhvien_lopmon,
				'dskhaosat' 		=> $dskhaosat_lopmon,
			);
		}

		public function inChiTiet(){
			$data 					= $this->layDuLieu();
			$this->parser->parse('khaosat/Vinchitietkhaosathoctap', $data);
		}
	}

?>