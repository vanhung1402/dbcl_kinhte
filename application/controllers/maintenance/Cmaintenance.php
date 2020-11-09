<?php

	/**
	 * summary
	 */
	class Cmaintenance extends CI_Controller{
	    /**
	     * summary
	     */
	    public function __construct(){
	        parent::__construct();
	    }

	    public function index(){
	    	$data['url'] 		= base_url();
	    	$this->parser->parse('maintenance/index', $data);
	    }
	}

?>