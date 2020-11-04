<?php

class Cthemmon_ctdt extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('hethong/Mthemmon_ctdt');
        $this->load->model('hethong/Mlop_hocphan');
    }

    public function index()
    {
        $ds_ctdt = $this->Mthemmon_ctdt->get_ds_ctdt($this->_session['ma_canbo']);
        $action = $this->input->post('action');
        if($action == 'get_mon_ctdt'){
            $this->get_mon_ctdt();
        }
        $temp['data']['ctdt_chk']='';
        if($this->input->post('save')){
            $addlist=json_decode($this->input->post('addlist'),true);
            $dellist=json_decode($this->input->post('dellist'),true);
            $ma_ctdt= $this->input->post('ctdt');
            $chk=$this->Mthemmon_ctdt->check_ctdt($ma_ctdt);
            if(empty($chk)){
                $dsmon_ctdt = $this->Mthemmon_ctdt->get_mon_in_ctdt($ma_ctdt);
                $dsmon_ctdt = array_column($dsmon_ctdt, 'ma_monhoc');

                $temp['data']['ctdt_chk']=$this->input->post('ctdt');
                $idmax=$this->Mthemmon_ctdt->genid();
                if($idmax==NULL){
                    $idmax=0;
                }
                $insert_mon_ctdt= array();
                
                for($i=0;$i<count($addlist);$i++){
                    if (!in_array($addlist[$i], $dsmon_ctdt)) {
                        $insert_mon_ctdt[] = array(
                            'ma_mon_ctdt'=> $idmax,
                            'ma_monhoc'  => $addlist[$i],
                            'ma_ctdt'    => $ma_ctdt,  
                        );
                        
                        $idmax++;
                    }
                }
                $this->Mthemmon_ctdt->change_mon_ctdt($insert_mon_ctdt,$dellist);
            }
            else{
                return;
            }
        }
        if($this->input->get('id')){
            $mon_in_ctdt = $this->Mthemmon_ctdt->get_mon_in_ctdt($this->input->get('id'));
            $donvi = $this->Mlop_hocphan->get_donvi($this->_session['ma_canbo']);
            $tt_ctdt = $this->Mthemmon_ctdt->get_tt_ctdt($this->input->get('id'));
            $data = array(
                'mon_ctdt'  => $mon_in_ctdt,
                'donvi'     => $donvi['ten_donvi'],
                'tt_ctdt'   => $tt_ctdt[0],
                'url'       => base_url(),
            );
            $this->parser->parse('hethong/Vin_dsmon_ctdt',$data);
            exit();
        }
        $temp['data']['ds_ctdt'] =$ds_ctdt;
        $temp['template'] = 'hethong/Vthemmon_ctdt';
        $this->load->view('layout/Vcontent', $temp);
    }
    public function get_mon_ctdt(){
        $ma_ctdt = $this->input->post('ma_ctdt');
        $data= array();
        if($ma_ctdt){
            $mon_in_ctdt = $this->Mthemmon_ctdt->get_mon_in_ctdt($ma_ctdt);
            $data = array(
                'mon_in_ctdt'    => $mon_in_ctdt,
                'monhoc'         => $this->Mthemmon_ctdt->get_monhoc($ma_ctdt),
            );
        }
        $chk=$this->Mthemmon_ctdt->check_ctdt($ma_ctdt);
        if(empty($chk)){
            $data['check_ctdt']=0;
        }else{
            $data['check_ctdt']=1;
			/* $data['check_ctdt']=0; */
        }
        echo json_encode($data);
        exit();
    }
}