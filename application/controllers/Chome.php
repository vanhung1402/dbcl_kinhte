<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class Chome extends MY_Controller {
		public function __construct(){
			parent::__construct();
			$this->load->model('hethong/Mhethong');
		}
		public function index(){
			$dshocvu 				= $this->Mhethong->layDonViHocVu();
			$data 					= array(
				'dvhv' 				=> $dshocvu[0]['ma_donvihocvu'],
			);
			
			if ($this->_session['quyen'] == 'sinhvien') {
				$data['sinhvien'] 	= $this->layThongTinSinhVien($dshocvu[0]['ma_donvihocvu']);
			}else{
				$data['canbo'] 		= $this->layThongTinCanBo($dshocvu[0]['ma_donvihocvu']);
			}
			$temp['data'] 			= $data;
			$temp['template'] 		= 'hethong/Vhome';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function layThongTinSinhVien($dvhv){
			$thongtincanhan 		= $this->Mhethong->layThongTinSinhVien($this->_session['ma_sv']);
			$khaosat 				= $this->Mhethong->layThongTinKhaoSat($this->_session['ma_sv'], $dvhv);
			
			return array(
				'tt' 				=> $thongtincanhan,
				'ks' 				=> $khaosat,
			);
		}

		private function layThongTinCanBo($dvhv){
			$thongtincanhan 		= $this->Mhethong->layThongTinCanBo($this->_session['ma_canbo']);

			return array(
				'tt' 				=> $thongtincanhan,
			);
		}
	}
