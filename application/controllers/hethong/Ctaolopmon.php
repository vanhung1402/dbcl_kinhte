<?php
class Ctaolopmon extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->Model('hethong/Mtaolopmon');
        $this->load->Model('hethong/Mthemmon_ctdt');
    }
    public function index(){
        $action         = $this->input->post('action');
        switch ($action) {
            case 'lay-monctdt':
                $this->get_mon_ctdt();
                break;
            case 'get_canbo_mon':
                $this->get_canbo_mon();
                break;
            case 'them_lopmon':
                $this->them_lopmon();
                break;
            case 'load-dslopmon':
                $dvhv   = $this->input->post('dvhv'); 
                echo json_encode($this->Mtaolopmon->loadDanhSachLopMon($dvhv));
                exit();
                break;
            default:
                # code...
                break;
        }
        $ds_ctdt = $this->Mthemmon_ctdt->get_ds_ctdt($this->_session['ma_canbo']);
        $temp['data']= array(
            'ds_ctdt'   => $ds_ctdt,
            'ds_dvhv'   => $this->Mtaolopmon->get_dvhv()  
        );
        $temp['template'] = 'hethong/Vtaolopmon';
        $this->load->view('layout/Vcontent', $temp);
    }
    public function loadDanhSachLopMon($dvhv){

    }

    public function get_mon_ctdt(){
        $ma_ctdt = $this->input->post('ma_ctdt');
        $ds_mon_ctdt = $this->Mthemmon_ctdt->get_mon_in_ctdt($ma_ctdt);
        echo json_encode($ds_mon_ctdt);
        exit();
    }
    public function get_canbo_mon(){
        $ma_monhoc = explode('|',$this->input->post('ma_monhoc'));
        $ma_monhoc = $ma_monhoc[0];
        $data = $this->Mtaolopmon->get_canbo_mon($ma_monhoc);
        echo json_encode($data);
        exit();
    }
    public function them_lopmon(){
        $postData = $this->input->post('inp');
        $ma_monhoc = explode('|',$postData['ma_monhoc']);
        $lopmon_new = array(
            'ma_lopmon'             => 'LM'.$postData['ma_dvhv'].time().rand(100,999),
            'ten_lopmon'            => $postData['tenlop'],
            'ngaybd'                => implode('-', array_reverse(explode('/', $postData['ngay_bd']))),
            'ngaykt'                => implode('-', array_reverse(explode('/', $postData['ngay_kt']))),
            'ngaykhaosat'           => implode('-', array_reverse(explode('/', $postData['ngay_kt']))),
            'ma_canbo_tao'          => $this->_session['ma_canbo'],
            'ma_canbo_capnhat'      => $this->_session['ma_canbo'],
            'ma_monhoc'             => $ma_monhoc[0],
            'madm_trangthai_lopmon' => 'dukien',
            'ma_donvihocvu'         => $postData['ma_dvhv'],
            'ma_hinhthuc'           => $postData['hinhthuc'],
        );
        $rows = $this->Mtaolopmon->insert_lopmon($lopmon_new);
        $id_max = $this->Mtaolopmon->get_max_id();
        $id_max = $id_max['maxid'];
        if(!$id_max){
            $id_max = 0;
        }
        $canbo_lopmon = array(
            'ma_cb_lm' => $id_max,
            'ma_cb'    => $postData['ma_canbo'],
            'ma_lopmon'=> $lopmon_new['ma_lopmon'],
            'sotietday'=> $postData['so_tiet'],
        );
        $lopmon_monctdt = array(
            'ma_lopmon'    => $lopmon_new['ma_lopmon'],
            'ma_mon_ctdt'  => $ma_monhoc[1],
        );
        $this->Mtaolopmon->insert_canbo_lopmon($canbo_lopmon);
        $this->Mtaolopmon->insert_lopmon_monctdt($lopmon_monctdt); 
        if ($rows) {
            echo json_encode($lopmon_new);
        }else{
            echo json_encode($rows);
        }
        exit();
    }

}