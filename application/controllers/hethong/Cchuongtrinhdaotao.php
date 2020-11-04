<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class Cchuongtrinhdaotao extends MY_Controller {
		public function __construct(){
            parent::__construct();
            $this->load->model('hethong/Mchuongtrinhdaotao');
		}
		public function index(){
			$macb 		= $this->_session['ma_canbo'];
			$quyen 		= $this->_session['quyen'];
			$trinhdo 	= $this->Mchuongtrinhdaotao->get_trinhdo();
			$hedaotao 	= $this->Mchuongtrinhdaotao->get_hedaotao();
			$nganh   	= $this->Mchuongtrinhdaotao->get_nganh_dv($macb, $quyen);
			$ds_ctdt 	= $this->Mchuongtrinhdaotao->get_ctdt($macb, $quyen);
			$action 	= $this->input->post('action');

			switch ($action) {
				case 'them_ctdt':
					$this->them_chuongtrinhdaotao();
					exit();
					break;
				case 'capnhat_ctdt':
					$this->capnhat_chuongtrinhdaotao($this->input->post('ma_ctdt'));
					exit();
					break;
				case 'xoa_ctdt':
					$row = $this->Mchuongtrinhdaotao->delete_chuongtrinhdaotao($this->input->post('ma_ctdt'));
					echo json_encode($row);
					exit();
					break;
				case 'getdl':
					$this->getdl_ctdt();
					exit();
					break;
				
				default:
					# code...
					break;
			}

			if($this->input->get('id')){
				$this->Mchuongtrinhdaotao->delete_chuongtrinhdaotao($this->input->get('id'));
				header('location:' . base_url() . 'ctdt');
			}
			$temp = array(
                'template'		=> 'hethong/Vchuongtrinhdaotao',
                'data'          => array(
					 'trinhdo' => $trinhdo,
					 'hedaotao'=> $hedaotao,
					 'nganh'   => $nganh,
					 'nam'	   => range(2010,date('Y')+1),
					 'ds_ctdt' => $ds_ctdt,
                )
			);
    		$this->load->view('layout/Vcontent', $temp);
		}
		public function them_chuongtrinhdaotao(){
			$ma_hedaotao = $this->input->post('hedaotao');
			$ma_trinhdo  = $this->input->post('trinhdo');
			$ma_nganh 	 = $this->input->post('nganh');
			$nam 	  	 = $this->input->post('nam');
			if($ma_hedaotao != '' && $ma_trinhdo !='' && $ma_nganh !='' && $nam !=''){
				$ma_ctdt = 'ctdt_' . $ma_hedaotao . '_' . $ma_trinhdo . '_' . $ma_nganh . '_' . $nam;
				$ctdt = array(
					'ma_ctdt'			=> $ma_ctdt,
					'madm_hedaotao'  	=> 	$ma_hedaotao,
					'madm_trinhdo'		=> 	$ma_trinhdo,
					'madm_nganh' 		=>  $ma_nganh,
					'nam'  				=>  $nam,
				);

				$this->Mchuongtrinhdaotao->insert_ctdt($ctdt);
				echo json_encode($this->Mchuongtrinhdaotao->get_ctdt_ma($ma_ctdt));
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
				$row = $this->Mchuongtrinhdaotao->update_ctdt($ctdt, $ma_ctdt);
				$dl_ctdt = $this->Mchuongtrinhdaotao->get_ctdt_ma($ma_ctdt);
				echo json_encode($dl_ctdt);
				// header('location:' . base_url() . 'ctdt');
			}
			exit();
		}
		public function getdl_ctdt(){
			$dl_ctdt = $this->Mchuongtrinhdaotao->get_dl_ctdt($this->input->post('ma_ctdt'));
			echo json_encode($dl_ctdt);
			exit();
		}
	}
