<?php 
	$user 						= $this->session->userdata('user');
	$quyen 						= $user['quyen'];
	$data['quyen'] 				= $user['quyen'];
	$data['ma_canbo']			= $user['ma_canbo'];
	$data['username']			= $user['username'];
	
	$data_header 				= array(
		'title' 	=> isset($data['title']) ? $data['title'] : 'Hệ thống Đảm bảo chất lượng Trường Đại học Mở Hà Nội',
		'url' 		=> base_url(),
		'menu' 		=> layMenuQuyen($quyen),
		'ten' 		=> $user['ten'],
	);

	$data_footer 				= array(
		'url' 		=> base_url(),
		'message' 	=> getMessage(),
	);

	$data['url']  				= base_url();
	$data['csrf_token_name'] 	= $this->security->get_csrf_token_name();
	$data['csrf_token'] 		= $this->security->get_csrf_hash();
	$this->parser->parse('layout/Vheader', $data_header);
	$this->parser->parse($template, $data);
	$this->parser->parse('layout/Vfooter', $data_footer);

?>