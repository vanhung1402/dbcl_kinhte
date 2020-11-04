<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class MY_Controller extends CI_Controller {
		protected $_session;

		public function __construct(){
			parent::__construct();
			$this->load->model('hethong/Mhethong');



			$this->_session 			= $this->session->userdata('user');

			if (empty($this->_session)) {
				redirect('login', 'refresh');
				exit();
			} else if ($this->_session['quyen'] != 'admin') {
				if (!$this->_session['trangthai']) {
					redirect('doimatkhau', 'refresh');
				}
	            $uri 					= $this->uri->uri_string();
	            $link_for_all 			= array(
	            	'home', 'logout', ''
	            );

	            if (!in_array($uri, $link_for_all)) {
	            	$quyen_chuc_nang 	= $this->Mhethong->checkQuyen($uri, $this->_session['quyen']);

	            	if (!$quyen_chuc_nang) {
	            		redirect('notfound', 'refresh');
	            		exit();
	            	}
	            }

				if($this->input->post()){
					$regex					= "/(delete)|(drop)|(empty)|(update)|(select)|(script)/";
					$post					= strtolower(implode(' ',$this->input->post()));
					if(preg_match($regex, $post)){	  
						echo "No permission!";
						exit();
					}
				}
	        }
		}
	}
