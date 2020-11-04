<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class Ckhoahoc extends MY_Controller {
		public function __construct(){
            parent::__construct();
            $this->load->model('hethong/Mkhoahoc');
		}
		public function index(){
            $action         = $this->input->post('action');
            switch ($action) {
                case 'getdlkhoa':
                    $this->getdlkhoa();
                    break;
                default:
                    # code...
                    break;
            }
            $macb = $this->_session['ma_canbo'];
            $arr_nam[] = date("Y");
            $arr_nam[] = date("Y") + 1;
            $dv_nganh = $this->Mkhoahoc->get_nganh_dv($macb);
            $ma_khoahoc = NULL;
            $chk_khoahoc = array();
            $lop_khoahoc = $this->Mkhoahoc->get_lop_khoahoc();
            foreach($lop_khoahoc as $kh){
                $chk_khoahoc[$kh['ma_khoahoc']] = 'isset';
            }
            $ds_khoahoc = $this->Mkhoahoc->get_khoahoc($ma_khoahoc,$macb);
            $action = $this->input->post('action');
            if($action =='them_khoahoc'){
                $this->them_khoahoc();
            }
            if($action =='xoa_khoahoc'){
                $ma_khoahoc = $this->input->post('ma_khoahoc');
                $this->Mkhoahoc->delete_khoahoc($ma_khoahoc);
                echo json_encode($ma_khoahoc);
                exit();
            }
            if($action =='capnhat_khoahoc'){
                $this->capnhat_khoahoc();
            }
            $ds_ctdt            = $this->Mkhoahoc->layChuongTrinhDaoTao($macb);
			$temp = array(
                'template'      => 'hethong/Vkhoahoc',
                'data'          => array(
                    'nganh'         => $dv_nganh,
                    'namhoc'        => $arr_nam,
                    'khoahoc'       => $ds_khoahoc, 
                    'chk_khoahoc'   => $chk_khoahoc,
                    'ds_ctdt'       => $ds_ctdt,
                )
            );
    		$this->load->view('layout/Vcontent', $temp);
        }
        public function them_khoahoc(){
            $ma_ctdt = $this->input->post('ma_ctdt');
            $namhoc = $this->input->post('namhoc');
            if($ma_ctdt !="" && $namhoc !=""){
                $khoahoc = array(
                    'ma_khoahoc'    => time(),
                    'namhoc'        => $namhoc,
                    'ngaytao'       => date('Y-m-d'),
                    'ma_ctdt'       => $ma_ctdt
                );
                $row = $this->Mkhoahoc->them_khoahoc($khoahoc);
                if($row >0){
                    $khoahoc['ten_ctdt'] = $this->input->post('ten_ctdt');
                }
            }
            $khoahoc['ngaytao']     = date('d/m/Y');
            echo json_encode($khoahoc);
            exit();
        }
        public function getdlkhoa(){
            $macb = NULL;
            $ma_khoahoc = $this->input->post('makhoahoc');
            $dl_khoahoc =  $this->Mkhoahoc->get_khoahoc($ma_khoahoc,$macb);
            echo json_encode($dl_khoahoc);
            exit();
        }
        public function capnhat_khoahoc(){
            $ma_khoahoc = $this->input->post('ma_khoahoc');
            $namhoc = $this->input->post('namhoc');
            $ma_ctdt = $this->input->post('ma_ctdt');
            if($ma_ctdt !="" && $namhoc !=""){
                $data = array(
                    'namhoc'     => $namhoc,
                    'ma_ctdt'    => $ma_ctdt
                );
                
                $this->Mkhoahoc->capnhat_khoahoc($ma_khoahoc,$data);
                $khoahoc = $this->Mkhoahoc->get_khoahoc($ma_khoahoc);
                $khoahoc[0]['ten_ctdt']  = $this->input->post('ten_ctdt');
            }
            echo json_encode($khoahoc);
            exit();
        }
	}
