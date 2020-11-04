<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class chuongtrinhdaotao extends MY_Controller {
		public function __construct(){
            parent::__construct();
            $this->load->model('hethong/Mchuongtrinhdaotao');
		}
		public function index(){
			$macb = $this->_session['ma_canbo'];
			$trinhdo = $this->Mchuongtrinhdaotao->get_trinhdo();
			$hedaotao = $this->Mchuongtrinhdaotao->get_hedaotao();
			$nganh   = $this->Mchuongtrinhdaotao->get_nganh_dv($macb);
			$ds_ctdt = $this->Mchuongtrinhdaotao->get_ctdt($macb);
			$chk_ctdt =[];
			$ctdt_apdung = $this->Mchuongtrinhdaotao->get_mon_ctdt();
			foreach($ctdt_apdung as $ctdt){
				$chk_ctdt[$ctdt['ma_ctdt']] = 'isset';
			}
			$action = $this->input->post('action');
			if($action == 'getdl'){
				$this->getdl_ctdt();
			}
			if($action == 'them_ctdt'){
				$this->them_chuongtrinhdaotao();
			}
			if($action == 'capnhat_ctdt'){
				$this->capnhat_chuongtrinhdaotao($this->input->post('ma_ctdt'));
			}
			if($action == 'xoa_ctdt'){
				$rows =  $this->Mchuongtrinhdaotao->delete_chuongtrinhdaotao($this->input->post('ma_ctdt'));
				echo json_encode();
				exit();
			}
			$temp = [
                'template'		=> 'hethong/Vchuongtrinhdaotao',
                'data'          => array(
					 'trinhdo' => $trinhdo,
					 'hedaotao'=> $hedaotao,
					 'nganh'   => $nganh,
					 'nam'	   => range(2010,date('Y')+1),
					 'ds_ctdt' => $ds_ctdt,
					 'chk_ctdt'=> $chk_ctdt,
                )
            ];
    		$this->load->view('layout/Vcontent', $temp);
		}
		public function them_chuongtrinhdaotao(){
			$ma_hedaotao = $this->input->post('hedaotao');
			$ma_trinhdo  = $this->input->post('trinhdo');
			$ma_nganh 	 = $this->input->post('nganh');
			$nam 	  	 = $this->input->post('nam');
			if($ma_hedaotao != '' && $ma_trinhdo !='' && $ma_nganh !='' && $nam !=''){
				$id_max = $this->Mchuongtrinhdaotao->get_id_max()['0']['newid'];
				if($id_max == ''){
					$id_max = 0;
				}
				$ctdt = array(
					'ma_ctdt'			=> 	$id_max,
					'madm_hedaotao'  	=> 	$ma_hedaotao,
					'madm_trinhdo'		=> 	$ma_trinhdo,
					'madm_nganh' 		=>  $ma_nganh,
					'nam'  				=>  $nam,
				);
				$this->Mchuongtrinhdaotao->insert_ctdt($ctdt);
				$ctdt_new = $this->Mchuongtrinhdaotao->get_ctdt_ma($ctdt['ma_ctdt']);
				echo json_encode($ctdt_new);
				exit();	
			}
		} 
		public function capnhat_chuongtrinhdaotao($ma_ctdt){
			$ma_hedaotao = $this->input->post('hedaotao');
			$ma_trinhdo  = $this->input->post('trinhdo');
			$ma_nganh 	 = $this->input->post('nganh');
			$nam 	  	 = $this->input->post('nam');
			if($ma_hedaotao != '' && $ma_trinhdo !='' && $ma_nganh !='' && $nam !=''){
				$ctdt = array(
					'madm_hedaotao'  	=> 	$ma_hedaotao,
					'madm_trinhdo'		=> 	$ma_trinhdo,
					'madm_nganh' 		=>  $ma_nganh,
					'nam'  				=>  $nam,
				);
				$this->Mchuongtrinhdaotao->update_ctdt($ctdt,$ma_ctdt);
				$ctdt_cn = $this->Mchuongtrinhdaotao->get_ctdt_ma($ma_ctdt);
				echo json_encode($ctdt_cn);
				exit();	
			}
		}
		public function getdl_ctdt(){
			$dl_ctdt = $this->Mchuongtrinhdaotao->get_dl_ctdt($this->input->post('ma_ctdt'));
			echo json_encode($dl_ctdt);
			exit();
		}
	}
