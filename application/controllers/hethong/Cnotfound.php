<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class Cnotfound extends CI_Controller{
		function __construct(){
			parent::__construct();
		}

		public function index(){
        	$this->output->set_status_header('404');
			$data 	= array(
				'url' 	=> base_url()
			);
    		$this->parser->parse('hethong/Vnotfound', $data);
		}
	}

?>