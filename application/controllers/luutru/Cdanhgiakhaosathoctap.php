<?php

	/**
	 * 
	 */
	class Cdanhgiakhaosathoctap extends MY_Controller{
		function __construct(){
			parent::__construct();
		}

		public function index(){
			$dot 				= $this->input->get('dot');
			$monhoc 			= $this->input->get('monhoc');
			$canbo 				= $this->input->get('canbo');

			$data 				= $this->layThongTinChung($dot, $monhoc, $canbo);
			$data['url'] 		= base_url();
			$this->parser->parse('luutru/Vdanhgiakhaosathoctap', $data);
		}

		private function layThongTinChung($dot, $monhoc = null, $canbo = null){
			$filePath 				= './DATA/dotkhaosat/' . $dot . '/danhgia.json';
			$json 					= file_get_contents($filePath);
			$data 					= json_decode($json, true);
			
			if ($monhoc && $canbo) {
				$data['canbomon'] 	= array(
					$canbo 	=> array(
						$monhoc 	=> $data['canbomon'][$canbo][$monhoc],
					),
				);
			}

			return $data;
		}
	}

?>