<?php
class Cdonvihocvu extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->Model('hethong/Mdonvihocvu');
        $this->load->Model('hethong/Mtaolopmon');
    }
    public function index(){
        $action = $this->input->post('action');
        switch($action){
            case "them_dvhv": 
                $this->them_donvihocvu();break;
            case "xoa_dvhv": 
                $this->xoa_donvihocvu($this->input->post('ma_dvhv'));break;
            case "getdl": 
                $dulieu_dvhv = $this->Mdonvihocvu->get_dvhv_ma($this->input->post('madvhv'));
                echo json_encode($dulieu_dvhv);
                exit();break;
            case "capnhat_dvhv": 
                $this->capnhat_dvhv();
        }
        $dvhv_apply = $this->Mdonvihocvu->get_dvhv_apply();
        $chk_dvhv = array();
        foreach($dvhv_apply as $dvhv){
            $chk_dvhv[$dvhv['ma_donvihocvu']] = 'isset';
        }
        $temp['data']= array(
            'ds_dvhv'   => $this->Mtaolopmon->get_dvhv(),
            'nam'       => range(2010,date('Y')+1),
            'chk_dvhv'  => $chk_dvhv
        );
        $temp['template'] = 'hethong/Vdonvihocvu';
        $this->load->view('layout/Vcontent', $temp);
    }
    public function them_donvihocvu(){
        $namhoc = $this->input->post('namhoc');
        $kyhoc = $this->input->post('kyhoc');
        $this->check_ky($namhoc,$kyhoc);
        $add_dvhv = array(
            'ma_donvihocvu' => $kyhoc.'-'.$namhoc.':'.($namhoc+1),
            'namhoc'        => $namhoc,
            'kyhoc'         => $kyhoc
        );
        $row = $this->Mdonvihocvu->insert_donvihocvu($add_dvhv);
        if($row >0){
            $data['row'] = $row;
            $data['content'] = $add_dvhv;
        }
        echo json_encode($data);
        exit();
    }
    public function xoa_donvihocvu($ma_dvhv){
        $row = $this->Mdonvihocvu->delete_dvhv($ma_dvhv);
        echo $row;
        exit();
    }
    public function capnhat_dvhv(){
        $namhoc = $this->input->post('namhoc');
        $kyhoc  = $this->input->post('kyhoc');
        $this->check_ky($namhoc,$kyhoc);
        $up_dvhv = array(
            'ma_donvihocvu' => $kyhoc.'-'.$namhoc.':'.($namhoc+1),
            'namhoc'        => $namhoc,
            'kyhoc'         => $kyhoc
        );
        $row =  $this->Mdonvihocvu->update_donvihocvu($up_dvhv,$this->input->post('madvhv'));
        $data['ckh'] = $row;
        $data['dulieu'] =$up_dvhv;
        echo json_encode($data);
        exit();
    }
    public function check_ky($namhoc,$kyhoc){
        if($namhoc =='' || $kyhoc ==''){
            exit();
        }
        $check_ky = $this->Mdonvihocvu->get_ky_theonam($namhoc);
        $data =array();
        foreach($check_ky as $ky){
            if($ky['kyhoc'] == $kyhoc){
                $data['row'] = '0';
                $data['content'] = $kyhoc;
                echo json_encode($data);
                exit();
            }
        }
    }
}