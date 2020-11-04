<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class Cchude extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('khaosat/Mchude');
		}

		public function index(){
			$ma_khaosat 			= $this->input->get('khaosat');
			$action 				= $this->input->post('action');

			switch ($action) {
				case 'load-topic':
					$this->loadTopic($ma_khaosat);
					break;
				case 'save-topic':
					$this->saveTopic($ma_khaosat);
					break;
				default:
					# code...
					break;
			}

			$data = array(
				'ma_khaosat' 	=> $ma_khaosat,
			);

			$temp['data'] 			= $data;
			$temp['template'] 		= 'khaosat/Vchude';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function loadTopic($ma_khaosat){
			$topic = $this->Mchude->getTopic($ma_khaosat);
			echo json_encode($topic);
			exit();
		}

		private function saveTopic($ma_khaosat){
			$save 					= json_decode($this->input->post('save'), true);
			$new 					= json_decode($this->input->post('new'), true);
			$del 					= json_decode($this->input->post('del'), true);

			$topic_insert 			= array();
			$topic_update 			= array();
			$topic_delete 			= array();

			foreach ($save as $topic) {
				if (in_array($topic['ma_nhomcauhoi'], $new)) {
					$topic_insert[] = $topic;
				} else if (!in_array($topic['ma_nhomcauhoi'], $del)) {
					$topic_update[] = $topic;
				}
			}

			$row 					= 0;
			if (count($topic_insert) != 0) {
				$row 		 		+= $this->Mchude->insertBatchTopic($topic_insert);
			}
			if (count($topic_update) != 0) {
				$row 				+= $this->Mchude->updateBatchTopic($topic_update);
			}
			if (count($del) != 0) {
				$row		 		+= $this->Mchude->deleteMultipleTopic($del);
			}

			if ($row > 0) {
				setMessage('success', 'Đã lưu các chủ đề thành công!');	
				// redirect(base_url() . 'chude?khaosat=' . $ma_khaosat, 'refresh');
			}

			echo json_encode($row);
			exit();
		}
	}

?>