<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class Capmatkhau extends CI_Controller{
		protected $__msg;
		function __construct(){
			parent::__construct();
			$this->load->model('hethong/Mcapmatkhau');
			$this->__msg = array();
		}
        public function index(){
			$rq= $this->session->flashdata('rq');
			if($this->input->post('caplai_mk')){
				$rq = $this->xacthuc_sinhvien();
			}
			$data 		= array(
				'rq'	=> $rq,
				'url' 	=> base_url(),
				'msg' 	=> $this->__msg,
				'csrf_token_name' 	=> $this->security->get_csrf_token_name(),
				'csrf_token' 		=> $this->security->get_csrf_hash()
			);

    		$this->parser->parse('hethong/Vcapmatkhau', $data);
		}
		public function xacthuc_sinhvien(){
			$ma_sv = trim($this->input->post('masv'));
			$email = trim($this->input->post('email'));
			$message='';
			if($ma_sv != "" && $email != ""){
				$sv = $this->Mcapmatkhau->xacthuc_sinhvien($ma_sv,$email);
				if($sv != []){
					$pass_new = mt_rand(100000, 999999);
					$row = $this->Mcapmatkhau->reset_matkhau($sv['ma_sv'],$pass_new);
					if($row > 0){
						$this->email($sv['email'],$pass_new);
					}
				}else{
					$message="<div class='text-danger'>Mã sinh viên hoặc email của bạn không chính xác</div>";
					$this->session->set_flashdata('rq',$message);
					return redirect(base_url().'caplaimatkhau','refresh');
				}
			}
		}
		function email($email_request,$content){
			// thiết lập cấu hình $config
			$this->load->library('Phpmailer_lib');
        	// PHPMailer object
			$mail = $this->phpmailer_lib->load();
			
			// SMTP configuration
			$mail->isSMTP();
			$mail->Host     = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'jackcr27072000@gmail.com';
			$mail->Password = 'jack27072000';
			$mail->SMTPSecure = 'ssl';
			$mail->Port     = 465;
			$mail->CharSet = 'UTF-8';
			
			$mail->setFrom('jackcr27072000@gmail.com','Jack');
			$mail->addReplyTo('jackcr27072000@gmail.com');
			
			// Add a recipient
			$mail->addAddress($email_request);
			
			// Add cc or bcc 
			/* $mail->addCC('cc@example.com');
			$mail->addBCC('bcc@example.com'); */
			
			// Email subject
			$mail->Subject = 'Cấp lại mật khẩu tài khoản khảo sát';
			
			// Set email format to HTML
			$mail->isHTML(true);
			
			// Email body content
			$mailContent = "<h1>Tổ Phát triển FFC</h1>
				<p>Mật khẩu mới của bạn là: </p>".$content;
			$mail->Body = $mailContent;
			
			// Send email
			if(!$mail->send()){
				/* echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo; */
			}else{
				$message = "<div><strong class='text-success'>Mật khẩu đã được gửi qua email</strong><br><span class='text-danger'>".$email_request."</span></div>";		
				$this->session->set_flashdata('rq',$message);
				return redirect(base_url().'caplaimatkhau', 'refresh');
			}
		}
}
