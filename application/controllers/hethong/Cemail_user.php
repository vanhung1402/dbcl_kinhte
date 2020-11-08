<?php
	class Cemail_user extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('hethong/Mcapmatkhau');
		}
		public function index(){
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			$action	= $this->input->post('action');
            $user = $this->session->userdata('user');
			switch ($action) {
				case 'doimatkhau':
					$this->doiEmail($user);
					break;
				
				default:
					# code...
					break;
			}
			if($this->input->get('id')){
				$token = $this->Mcapmatkhau->get_token($this->input->get('id'));
				if(!empty($token)){
					$time_live = 1*60;
					$time_present = time();
					if(($time_present - $token['time_token']) < $time_live){
						setMessage('success', 'Cập nhật Email thành công.');
						return redirect(base_url('email_user'), 'refresh');
					}else{
						setMessage('error', 'Cập nhật Email thất bại.');
						return redirect(base_url('email_user'), 'refresh');
					}
					/* $this->Mcapmatkhau->update_email(); */
				}
				else{
					return redirect(base_url('email_user'), 'refresh');
				}
			}
            $em = $this->Mcapmatkhau->get_email($user['ma_sv']);
			$email = '';
            if(!empty($em['email'])){
                $email = $em['email'];
            }
            $temp['data']['email']    = $email;
			$temp['template'] = 'hethong/Vemail_user';
    		$this->load->view('layout/Vcontent', $temp);
		}
		private function doiEmail($user){
			$token_before = $this->Mcapmatkhau->get_token_latest($user['ma_sv']);
			$time_live = 24*60*60;
			$time_present = time();
			if(($time_present - $token_before['time_token']) > $time_live){
				$email = $this->input->post('email_new');
				$token = array(
					'ma_sv'			=> $user['ma_sv'],
					'token'			=> $user['ma_sv'].time(),
					'email'			=> $email,
					'time_token'	=> time(),
				);
				$this->Mcapmatkhau->insert_token_email($token);
				$content = base_url().'email_user?id='.$token['token'];
				$this->email($email,$content);
			}
			else{
				$handoi = $time_live - ($time_present - $token_before['time_token']);
				setMessage('error','Chưa hết hạn cập nhật mật khẩu. Cập lại sau '.gmdate('H',$handoi).' Giờ '.gmdate('i',$handoi).' phút');
				return redirect(base_url('email_user'), 'refresh');
			}
            /* $row = $this->Mlogin->doiEmail($user['ma_sv'],$email);
            if($row > 0){
                setMessage('success', 'Cập nhật email thành công.');
                return redirect(base_url().'email_user','refresh');
            } */
		}
		function email($email_request,$content){
			$this->load->library('Phpmailer_lib');
			$mail = $this->phpmailer_lib->load();
			
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
			$mail->addAddress($email_request);
			$mail->Subject = 'Xác thực email';
			$mail->isHTML(true);
			$mailContent = "<a href='".$content."'>Bạn click vào đây để xác thực</a>";
			$mail->Body = $mailContent;
			if(!$mail->send()){
				/* echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo; */
			}else{
				/* $message = "<div><strong class='text-success'>Mật khẩu đã được gửi qua email</strong><br><span class='text-danger'>".$email_request."</span></div>";		
				$this->session->set_flashdata('rq',$message); */
				setMessage('success','Bạn vào email để xác thực');
				return redirect(base_url().'email_user', 'refresh');
			}
		}
	}

?>