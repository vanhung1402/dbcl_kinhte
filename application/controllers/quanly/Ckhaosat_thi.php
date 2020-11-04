<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Ckhaosat extends CI_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('quanly/Mkhaosat');
		}

		public function index(){
			$action 				= $this->input->post('action');
			switch ($action) {
                case 'xoa_ks':
                    $this->xoa_ks();
					break;
                case 'them_ks':
                    $this->them_ks();
                    break;
				default:
					break;
            }
            $data = array(
                'title'         => 'Quản lý loại khảo sát',
                'list_ks'       => $this->Mkhaosat->get_ks(),
                'list_loaiks'   => $this->Mkhaosat->get_loaiks(),
            );
			$temp['data'] 			= $data;
			$temp['template'] 		= 'quanly/Vkhaosat';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function xoa_ks(){
            $ma_ks = $this->input->post('id');
            $trangthai_xoa = $this->Mkhaosat->xoa_ks($ma_ks);
            echo json_decode($trangthai_xoa);
            exit();
        }
        
        private function them_ks(){
            $ma = time();
            $ks_moi = array(
                'ma_khaosat'        => $ma,
                'tieude_khaosat'    => $this->input->post('tieude'),
                'noidung_khaosat'   => $this->input->post('noidung'),
                'ghichu_khaosat'    => $this->input->post('ghichu'),
                'madm_loaikhaosat'  => $this->input->post('loai')
            );
            $trangthai = $this->Mkhaosat->them_ks($ks_moi);
            echo json_decode($ma);
            exit();
        }
	}

?>