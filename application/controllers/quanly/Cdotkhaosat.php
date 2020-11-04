<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Cdotkhaosat extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('quanly/Mdotkhaosat');
		}

		public function index(){
            $action = $this->input->post('action');
			switch ($action) {
                case 'filter':
                    $this->filter();
					break;
                case 'them_dotks':
                    $this->them_dotks();
                    break;
                case 'xoa_dotks':
                    $this->xoa_dotks();
                    break;
				default:
					break;
            }
            $dvhv = $this->input->get('dvhv');
            $data = array(
                'title'         => 'Quản lý loại khảo sát',
                'list_ks'       => $this->Mdotkhaosat->get_ks(),
                'list_loaiks'   => $this->Mdotkhaosat->get_loaiks(),
                'list_dotks'    => $this->Mdotkhaosat->get_dotks($dvhv),
                'list_dvhv'     => $this->Mdotkhaosat->get_dvhv(),
                'ma_dvhv'       => $dvhv
            );
			$temp['data'] 			= $data;
            $temp['template'] 		= 'quanly/Vdotkhaosat';
    		$this->load->view('layout/Vcontent', $temp);
		}
        
        private function filter(){
            $dvhv = $this->input->get('dvhv');
            $list_dvhv = $this->Mdotkhaosat->get_dotks($dvhv);
            echo json_encode($list_dvhv);
            exit();
        }

        private function them_dotks(){
            $thoigian_ks    = $this->input->post('thoigian_ks');
            $thoigian_ks    = explode(" - ", $thoigian_ks);
            if (DateTime::createFromFormat('d/m/Y', $thoigian_ks[0]) == FALSE
            && DateTime::createFromFormat('d/m/Y', $thoigian_ks[1]) == FALSE
            ) {
                echo "error date";
            }else{
                $new_dotks = array(
                    'ma_dotkhaosat' => time(),
                    'thoigianbd'    => DateTime::createFromFormat('d/m/Y', $thoigian_ks[0])->format('Y-m-d'),
                    'thoigiankt'    => DateTime::createFromFormat('d/m/Y', $thoigian_ks[1])->format('Y-m-d'),
                    'ma_donvihocvu' => $this->input->post('add_dvhv'),
                    'ma_khaosat'    => $this->input->post('loai'),
                );
                if($this->Mdotkhaosat->them_dotks($new_dotks))
                {
                    return "thanhcong";
                }
                else{
                    return "thatbai";
                }
            }
            exit();
        }
        
        private function xoa_dotks(){
            $id = $this->input->post('id');
            if($this->Mdotkhaosat->xoa_dotks($id) != -1)
            {
                echo "xoa_thanhcong";
            }
            else
            {
                echo "xoa_thatbai";
            }
            exit();
        }

	}

?>