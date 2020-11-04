<?php
class Canbo_mon extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->Model('hethong/Mcanbo_mon');
    }
    public function index(){
        if($this->input->get('idcb')){
            $thongtin_cb = $this->Mcanbo_mon->get_thongtin_cb($this->input->get('idcb'));
            $mon_cb      = $this->Mcanbo_mon->get_mon_cb($this->input->get('idcb'));    
            $arr_mon_cb = array();
            for($i=0;$i<count($mon_cb);$i++){
                $arr_mon_cb[$mon_cb[$i]['ma_monhoc']] = $mon_cb[$i]['ten_monhoc']; 
            }
            $ds_monhoc   = $this->Mcanbo_mon->get_monhoc();
            $chuoimon = "";
            if($mon_cb!=null)
			{
				foreach ($mon_cb as $key => $value) {
					$chuoimon.=$value['ma_monhoc'].",";
				}
				$chuoimon = rtrim($chuoimon,',');
            }
        }
        if($this->input->post('save-change')){
            $ma_cb  = $this->input->get('idcb');
            $mangmoi = $this->input->post('canbomonhoc[]');
            $chuoimoncu = $this->input->post('chuoimon');
            $mangcu = array();
            $mangcu = preg_split('/,/',$chuoimoncu);
            if($mangmoi === ""){
                $del_mon_cb = $mangmoi;
            }
            else{
                $del_mon_cb = array_diff($mangcu,$mangmoi);
            }
            $add_mon_cb = array_diff($mangmoi,$mangcu);
            if($del_mon_cb != array()){
                $this->Mcanbo_mon->delete_mon_canbo($del_mon_cb,$ma_cb);
            }
            if($add_mon_cb != array()){
                foreach($add_mon_cb as $ma_mh){
                    $insert_mon_cb[] = array(
                        'ma_monhoc' => $ma_mh,
                        'ma_canbo'  => $ma_cb,
                    );
                }
                $this->Mcanbo_mon->insert_mon_canbo($insert_mon_cb);
            }
            header('location:'. base_url().'canbo_mon?idcb='.$ma_cb);
        }

        $ds_canbo = $this->Mcanbo_mon->get_ds_canbo($this->input->get('idcb'));
        
        $temp['data']= array(
            'tt_cb'     => $thongtin_cb,
            'mon_cb'    => $arr_mon_cb,   
            'ds_monhoc' => $ds_monhoc,   
            'chuoimon'  => $chuoimon,
            'ds_canbo'  => $ds_canbo,
        );
        $temp['template'] = 'hethong/Vcanbo_mon';
        $this->load->view('layout/Vcontent', $temp);
    }
}