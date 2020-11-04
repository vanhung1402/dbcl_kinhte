<?php

	/**
	 * 
	 */
	class Cchitietphieuhoctap extends MY_Controller{
		function __construct(){
			parent::__construct();
		}

		public function index(){
			$maphieu 			= $this->input->get('maphieu');
			$lopmon 			= $this->input->get('lopmon');
			$canbo 	 	 		= $this->input->get('canbo');
			$monhoc 	 	 	= $this->input->get('monhoc');
			$masv 		 	 	= $this->input->get('masv');
			$dot 	 	 		= $this->input->get('dot');


			if ($maphieu) {

			}else if ($lopmon) {

			}else if ($canbo && $monhoc){
				$data 				= $this->layTheoCanBoMonHoc($canbo, $monhoc, $dot);
			}else if ($masv) {

			}else{
				$data 				= $this->layTheoDot($dot);
			}

			$this->parser->parse('luutru/Vchitietphieuhoctap', $data);
		}

		private function layTheoCanBoMonHoc($canbo, $monhoc, $dot){
			$filePath 				= './DATA/dotkhaosat/' . $dot . '/phieu.json';
			$json 					= file_get_contents($filePath);
			$data 					= json_decode($json, true);

			$ttphieu 				= array();
			foreach ($data['ttphieu'] as $p) {
				if ($p['ma_monhoc'] == $monhoc && isset($p['cblm'][$canbo])) {
					$ttphieu[] 		= $p;
				}
			}

			$data['ttphieu'] 		= $ttphieu;

			return $data;
		}

		private function layTheoDot($dot){
			$filePath 				= './DATA/dotkhaosat/' . $dot . '/phieu.json';
			$json 					= file_get_contents($filePath);
			$data 					= json_decode($json, true);

			return $data;
		}
	}


?>