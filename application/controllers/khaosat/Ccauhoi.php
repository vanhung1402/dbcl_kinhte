<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class Ccauhoi extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('khaosat/Mcauhoi');
		}

		public function index(){
			$ma_khaosat 			= $this->input->get('khaosat');
			$action 				= $this->input->post('action');

			switch ($action) {
				case 'load-topic':
					$this->loadTopic($ma_khaosat);
					break;
				case 'load-topic-question':
					$this->loadTopicQuestion();
					break;
				case 'save-topic-question':
					$this->saveTopicQuestion();
					break;
				default:
					break;
			}

			$data 					= array(
				'ma_khaosat' 	=> $ma_khaosat,
			);

			$temp['data'] 			= $data;
			$temp['template'] 		= 'khaosat/Vcauhoi';
    		$this->load->view('layout/Vcontent', $temp);
		}

		private function loadTopic($ma_khaosat){
			$topic = $this->Mcauhoi->getTopic($ma_khaosat);
			echo json_encode($topic);
			exit();
		}

		private function loadTopicQuestion(){
			$topic 					= $this->input->post('topic');
			$list_question 			= $this->Mcauhoi->getQuestionOfTopic($topic);
			$answer 				= array();

			echo json_encode($list_question);
			exit();
		}

		private function saveTopicQuestion(){
			$topic 					= $this->input->post('topic');
			$list_question_current 	= $this->Mcauhoi->getQuestionOfTopic($topic);
			$topic_question			= json_decode($this->input->post('question'), true);
			$question 				= array_column($topic_question, 'cauhoi');
			$answer_question 		= array_column($topic_question, 'dapan');
			$answer 				= array();

			foreach ($answer_question as $qs) {
				$answer 			= array_merge($answer, $qs);
			}

			$question_current 		= array_column($list_question_current, 'ma_cauhoi');
			$answer_current 		= array();
			$question_keep 			= array_column($question, 'ma_cauhoi');
			$answer_keep 			= array_column($answer, 'ma_dapan');

			foreach ($list_question_current as $qs) {
				$answer_current 	= array_merge($answer_current, $qs['da']);
			}
			$answer_current 		= array_column($answer_current, 'ma_dapan');

			$question_insert 		= array();
			$question_update 		= array();
			$answer_insert	 		= array();
			$answer_update 			= array();

			foreach ($question as $qs) {
				if (in_array($qs['ma_cauhoi'], $question_current)) {
					$question_update[] 	= $qs;
				}else{
					$question_insert[] 	= $qs;
				}
			}

			foreach ($answer as $as) {
				if (in_array($as['ma_dapan'], $answer_current)) {
					$answer_update[] 	= $as;
				}else{
					$answer_insert[] 	= $as;
				}
			}

			$row 						= 0;
			if (count($question_insert) > 0) {
				$row 				+= $this->Mcauhoi->insertBatchQuestion($question_insert);
			}

			if (count($answer_insert) > 0) {
				$row				+= $this->Mcauhoi->insertBatchAnswer($answer_insert);
			}

			if (count($question_update) > 0) {
				$row 				+= $this->Mcauhoi->updateBatchQuestion($question_update);
			}

			if (count($answer_update) > 0) {
				$row				+= $this->Mcauhoi->updateBatchAnswer($answer_update);
			}
			$row 					+= $this->Mcauhoi->deleteAnswerNotIn($topic, $answer_keep);
			$row 					+= $this->Mcauhoi->deleteQuestionNotIn($topic, $question_keep);


			echo json_encode($row);
			exit();
		}
	}

?>