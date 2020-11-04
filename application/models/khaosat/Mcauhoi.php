<?php

	class Mcauhoi extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		public function getTopic($ma_khaosat){
			$this->db->where('ma_khaosat', $ma_khaosat);
			$this->db->order_by('ma_nhomcha');
			return $this->db->get('tbl_nhomcauhoi')->result_array();
		}

		public function getQuestionOfTopic($topic){
			$this->db->where('ma_nhomcauhoi', $topic);
			$this->db->order_by('thutu_cauhoi');
			$cauhoi 		= $this->db->get('tbl_cauhoi')->result_array();
			$dapan 			= $this->getAnswerOfTopic($topic);

			$map_dapan 		= array();

			foreach ($dapan as $da) {
				if (!isset($map_dapan[$da['ma_cauhoi']])) {
					$map_dapan[$da['ma_cauhoi']] 	= array();
				}
				$map_dapan[$da['ma_cauhoi']][] 		= $da;
			}

			foreach ($cauhoi as $key => $ch) {
				if (isset($map_dapan[$ch['ma_cauhoi']])) {
					$cauhoi[$key]['da'] 				= $map_dapan[$ch['ma_cauhoi']];
				}
			}

			return $cauhoi;
		}

		public function getAnswerOfTopic($topic){
			$this->db->select('da.*');
			$this->db->where('ma_nhomcauhoi', $topic);
			$this->db->from('tbl_cauhoi ch');
			$this->db->join('tbl_dapan da', 'ch.ma_cauhoi = da.ma_cauhoi', 'inner');
			$this->db->order_by('thutu_cauhoi, thutu_dapan');
			return $this->db->get()->result_array();
		}

		public function insertBatchQuestion($question){
			$this->db->insert_batch('tbl_cauhoi', $question);
			return $this->db->affected_rows();
		}

		public function insertBatchAnswer($answer){
			$this->db->insert_batch('tbl_dapan', $answer);
			return $this->db->affected_rows();
		}

		public function updateBatchQuestion($question){
			$this->db->update_batch('tbl_cauhoi', $question, 'ma_cauhoi');
			return $this->db->affected_rows();
		}

		public function updateBatchAnswer($answer){
			$this->db->update_batch('tbl_dapan', $answer, 'ma_dapan');
			return $this->db->affected_rows();
		}

		public function deleteQuestionNotIn($topic, $question_keep){
			$this->db->where('ma_nhomcauhoi', $topic);
			if (!empty($question_keep)) {
				$this->db->where_not_in('ma_cauhoi', $question_keep);
			}
			$this->db->delete('tbl_cauhoi');
			return $this->db->affected_rows();
		}

		public function deleteAnswerNotIn($topic, $answer_keep){
			$this->db->where("ma_cauhoi IN (SELECT ma_cauhoi FROM tbl_cauhoi WHERE ma_nhomcauhoi LIKE '$topic')");
			if (!empty($answer_keep)) {
				$this->db->where_not_in('ma_dapan', $answer_keep);
			}
			$this->db->delete('tbl_dapan');
			return $this->db->affected_rows();
		}
	}

?>