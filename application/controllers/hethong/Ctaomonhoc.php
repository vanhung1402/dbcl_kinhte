<?php

class Ctaomonhoc extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('hethong/Mtaomonhoc');
    }

    public function index()
    {
        $dsmon = $this->Mtaomonhoc->get_dsmon();
        $klmon = $this->Mtaomonhoc->get_khoiluong();
        $action = $this->input->post('action');
        if($action == 'them_monhoc'){
            $this->them_monhoc();   
        }
        if($action == 'capnhat_monhoc'){
            $this->update_monhoc();   
        }
        if($action == 'delete_monhoc'){
            $this->delete_monhoc();   
        }
        $kllt = array();
        $klth = array();
        foreach ($klmon as $value) {
            if ($value['ma_hinhthucmon'] == 'LT') {
                $kllt[$value['ma_monhoc']] = $value['khoiluong'];
            }
            if ($value['ma_hinhthucmon'] == 'TH') {
                $klth[$value['ma_monhoc']] = $value['khoiluong'];
            }
        }
        $mon_ctdt = $this->Mtaomonhoc->mon_ctdt();
        $check_mon_ctdt = array();
        foreach($mon_ctdt as $mc){
            $check_mon_ctdt[$mc['ma_monhoc']] = 'isset';
        }

        $temp['data'] = array(
            'kllt'      => $kllt,
            'klth'      => $klth,
            'dsmonhoc'  => $dsmon,
            'chk_mon'   => $check_mon_ctdt
        );
        $temp['template'] = 'hethong/Vtaomonhoc';
        $this->load->view('layout/Vcontent', $temp);
    }
    public function them_monhoc(){
        $mamh = $this->Mtaomonhoc->genid();
        if($mamh[0]['newid']!=NULL){
            $id=$mamh[0]['newid'];
        }else{
            $id=1;
        }
        $kllt = $this->input->post('kllt');
        $klth = $this->input->post('klth');
        $data_mh = array(
            'ma_monhoc'             => $id,
            'ten_monhoc'            => $this->input->post('tmh'),
            'ten_viettat_monhoc'    => $this->input->post('tvt'),
            'donvitinh'             => 'TC',
            'tongkhoiluong'         => $kllt + $klth,
        );
        $data_chitiet_mh[0] = array(
            'ma_monhoc'             => $id,
            'ma_hinhthucmon'        => 'LT',
            'khoiluong'             => $kllt
        );
        $data_chitiet_mh[1] = array(
            'ma_monhoc'             => $id,
            'ma_hinhthucmon'        => 'TH',
            'khoiluong'             => $klth
        );
        $this->Mtaomonhoc->insert_monhoc($data_mh);
        $this->Mtaomonhoc->insert_chtiet_monhoc($data_chitiet_mh);
        $data_mh['kllt'] = $kllt;
        $data_mh['klth'] = $klth;
        echo json_encode($data_mh);
        exit();
    }
    public function update_monhoc(){
        $mamh = $this->input->post('idmh');
        $kllt = $this->input->post('kllt');
        $klth = $this->input->post('klth');
        $data_mh = array(
            'ten_monhoc'            => $this->input->post('tmh'),
            'ten_viettat_monhoc'    => $this->input->post('tvt'),
            'tongkhoiluong'         => $kllt + $klth,
        );
        $data_chitiet_mh[0] = array(
            'ma_monhoc'             => $mamh,
            'ma_hinhthucmon'        => 'LT',
            'khoiluong'             => $kllt
        );
        $data_chitiet_mh[1] = array(
            'ma_monhoc'             => $mamh,
            'ma_hinhthucmon'        => 'TH',
            'khoiluong'             => $klth
        );
        $this->Mtaomonhoc->update_monhoc($data_mh,$mamh);
        $this->Mtaomonhoc->update_chitiet_monhoc($data_chitiet_mh, $mamh);
        $data_mh['ma_monhoc'] = $mamh;
        $data_mh['kllt'] = $kllt;
        $data_mh['klth'] = $klth;
        echo json_encode($data_mh);
        exit();
    }
    public function delete_monhoc(){
        echo $this->Mtaomonhoc->delete_monhoc($this->input->post('id'));
        exit();
    }
}